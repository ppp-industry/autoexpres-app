<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjCron extends pjAppController {

    public function pjActionIndex() {
        $this->setLayout('pjActionEmpty');

        $option_arr = pjOptionModel::factory()->getPairs($this->getForeignId());
        $pjBookingModel = pjBookingModel::factory();
        $arr = $pjBookingModel
                ->select('t1.*, t2.departure_time, t2.arrival_time, t3.content as route_title, t4.content as from_location, t5.content as to_location')
                ->join('pjBus', "t2.id=t1.bus_id", 'left outer')
                ->join('pjMultiLang', "t3.model='pjRoute' AND t3.foreign_id=t2.route_id AND t3.field='title' AND t3.locale='" . $this->getLocaleId() . "'", 'left outer')
                ->join('pjMultiLang', "t4.model='pjCity' AND t4.foreign_id=t1.pickup_id AND t4.field='name' AND t4.locale='" . $this->getLocaleId() . "'", 'left outer')
                ->join('pjMultiLang', "t5.model='pjCity' AND t5.foreign_id=t1.return_id AND t5.field='name' AND t5.locale='" . $this->getLocaleId() . "'", 'left outer')
                ->where('status', 'pending')
                ->where('is_sent', 'F')
                ->where("(UNIX_TIMESTAMP(t1.created) < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL " . $option_arr['o_min_hour'] . " MINUTE)))")
                ->findAll()
                ->getData();
        $pjBookingTicketModel = pjBookingTicketModel::factory();
        $pjPriceModel = pjPriceModel::factory();
        $pjMultiLangModel = pjMultiLangModel::factory();

        $Email = new pjEmail();
        if ($option_arr['o_send_email'] == 'smtp') {
            $Email
                    ->setTransport('smtp')
                    ->setSmtpHost($option_arr['o_smtp_host'])
                    ->setSmtpPort($option_arr['o_smtp_port'])
                    ->setSmtpUser($option_arr['o_smtp_user'])
                    ->setSmtpPass($option_arr['o_smtp_pass'])
            ;
        }
        $Email->setContentType('text/html');

        $lang_message = $pjMultiLangModel->reset()->select('t1.*')
                        ->where('t1.model', 'pjOption')
                        ->where('t1.locale', $this->getLocaleId())
                        ->where('t1.field', 'o_email_notify_message')
                        ->limit(0, 1)
                        ->findAll()->getData();
        $lang_subject = $pjMultiLangModel->reset()->select('t1.*')
                        ->where('t1.model', 'pjOption')
                        ->where('t1.locale', $this->getLocaleId())
                        ->where('t1.field', 'o_email_notify_subject')
                        ->limit(0, 1)
                        ->findAll()->getData();

        $admin_email = self::getAdminEmail();
        foreach ($arr as $k => $v) {
            $v['tickets'] = $pjBookingTicketModel
                    ->reset()
                    ->join('pjMultiLang', "t2.model='pjTicket' AND t2.foreign_id=t1.ticket_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->join('pjTicket', "t3.id=t1.ticket_id", 'left')
                    ->select('t1.*, t2.content as title, (SELECT TP.price FROM `' . $pjPriceModel->getTable() . '` AS TP WHERE TP.ticket_id = t1.ticket_id AND TP.bus_id = ' . $v['bus_id'] . ' AND TP.from_location_id = ' . $v['pickup_id'] . ' AND TP.to_location_id= ' . $v['return_id'] . ') as price')
                    ->where('booking_id', $v['id'])
                    ->findAll()
                    ->getData();

            $tokens = self::getData($option_arr, $v, PJ_SALT, $this->getLocaleId());
            $message = str_replace($tokens['search'], $tokens['replace'], $lang_message[0]['content']);

            if ($option_arr['o_email_notify'] == 1) {
                if (count($lang_message) === 1 && count($lang_subject) === 1) {
                    $Email
                            ->setTo($v['c_email'])
                            ->setFrom($admin_email)
                            ->setSubject($lang_subject[0]['content'])
                            ->send(pjUtil::textToHtml($message));
                    $pjBookingModel->reset()->where('id', $v['id'])->limit(1)->modifyAll(array('is_sent' => 'T'));
                }
            }
        }
        __('lblCronJobCompleted');
        exit;
    }
    
    
    public function  pjActionMailError(){
        ini_set("display_errors", "On");
        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $pjBookingMailModel =  pjBookingMail::factory();   
        $mails = $this->getMails($pjBookingMailModel, pjBookingMail::STATUS_ERROR);
        
        $this->hundlerMails($mails, function(&$fields,$mail,$ex) use (&$pjBookingMailModel){
            $mail['attempt_count']++;
            if($mail['attempt_count'] > 4){
                 $pjBookingMailModel->reset()->where('booking_id', $mail['id'])->eraseAll();
            }
            else{
                $fields = ['attempt_count' => $mail['attempt_count'],'status' => pjBookingMail::STATUS_ERROR,'error_message' => $ex->getMessage()];
            }
             
        }, $pjBookingMailModel);
       
        exit();
    }
    
    
    public function  pjActionMail(){
        ini_set("display_errors", "On");
        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $pjBookingMailModel =  pjBookingMail::factory();        
        $mails = $this->getMails($pjBookingMailModel, pjBookingMail::STATUS_NEW);
                
        $this->hundlerMails($mails, function(&$fields,$mail,$ex){
             $fileds = ['status' => pjBookingMail::STATUS_ERROR,'error_message' => $ex->getMessage()];
        }, $pjBookingMailModel);

       
        exit();
    }
    
    private function hundlerMailItem(
        $mail,
        $mailer,
        $langMessageConfirm,
        $langSubjectConfirm,
        $langMessageCancel,
        $langSubjectCancel
    ){
        $localeId = $this->getLocaleId();
        
        $arr = $this->getBookingData($mail['booking_id']);
        $res = null;        
        $tokens = self::getData($this->option_arr, $arr, PJ_SALT, $localeId);

        switch($mail['type']){
            case pjBookingMail::TYPE_CONFIRM:
            case pjBookingMail::TYPE_PAYMENT:
                $res = $this->hundleConfirmMail($mailer, $arr,$tokens,$langMessageConfirm,$langSubjectConfirm);
                break;
            case pjBookingMail::TYPE_CANCEL:
                $res = $this->hundleCanselMail($mailer, $arr,$tokens,$langMessageCancel,$langSubjectCancel);
                break;
        }
        
        return $res;
    }
    
    private function hundlerMails(
            array &$mails,
            Callable $errorHundler,
            &$pjBookingMailModel
    ){
//        
        list( 
            $langMessagePayment,
            $langSubjectPayment,
            $langMessageConfirm,
            $langSubjectConfirm,
            $langMessageCancel,
            $langSubjectCancel
        ) = $this->getMessagesAndSubjects();
        
        $mailer = $this->getMailer();
        $locale_id = $this->getLocaleId();
        
        foreach($mails as $k => $mail){
            $res = $fields = null;
            
            try{
                $res = $this->hundlerMailItem(
                    $mail,
                    $mailer,
                    $langMessageConfirm,
                    $langSubjectConfirm,
                    $langMessageCancel,
                    $langSubjectCancel,
                    $langMessagePayment,
                    $langSubjectPayment
                );
                
                if($res){
                    $fields = ['status' => pjBookingMail::STATUS_CLOSE];
                }
            }
            catch (Exception  $ex){
                $errorHundler($fields,$mail,$ex);   
            }
            
            if($fields){
                $pjBookingMailModel
                        ->reset()
                        ->where('id', $mail['id'])
                        ->limit(1)
                        ->modifyAll($fields);
            }
            
        }
    }
    
    private function hundleConfirmMail($mailer,$booking_arr,$tokens,$lang_message,$lang_subject){
                                
        $messageText = str_replace($tokens['search'], $tokens['replace'], $lang_message[0]['content']);
        $message = Swift_Message::newInstance()
                                    ->setFrom('pavluk@pavluks-trans.com')
                                    ->setCharset('UTF-8')
                                    ->setSubject($lang_subject[0]['content'])
                                    ->setBody($messageText)
                                    ->setTo($booking_arr['c_email']);
            
        return $mailer->send($message, $failures);
                                
                                
    }
    
    private function hundleCanselMail($mailer,$booking_arr,$tokens,$lang_message,$lang_subject){
        
    }
    
    private function hundlePaymentMail($mailer,$booking_arr,$tokens,$lang_message,$lang_subject){
//        $messageText = str_replace($tokens['search'], $tokens['replace'], $lang_message[0]['content']);
//        $message = Swift_Message::newInstance()
//                                    ->setFrom($this->option_arr['o_smtp_user'])
//                                    ->setCharset('UTF-8')
//                                    ->setSubject($lang_subject[0]['content'])
//                                    ->setBody($messageText)
//                                    ->setTo($booking_arr['c_email']);
//            
//        return $mailer->send($message, $failures);
    }
    
    
    private function getMessagesAndSubjects(){
        $locale_id = $this->getLocaleId();
        
        
        $pjMultiLangModel = pjMultiLangModel::factory();
        $lang_message_payment = $pjMultiLangModel->reset()
                                                ->select('t1.*')
                                                ->where('t1.model', 'pjOption')
                                                ->where('t1.locale', $locale_id)
                                                ->where('t1.field', 'o_email_payment_message')
                                                ->limit(0, 1)
                                                ->findAll()
                                                ->getData();
        
        $lang_subject_payment = $pjMultiLangModel->reset()
                                                ->select('t1.*')
                                                ->where('t1.model', 'pjOption')
                                                ->where('t1.locale', $locale_id)
                                                ->where('t1.field', 'o_email_payment_subject')
                                                ->limit(0, 1)
                                                ->findAll()
                                                ->getData();
        
        
        $lang_message_confirm = $pjMultiLangModel->reset()
                                                ->select('t1.*')
                                                ->where('t1.model', 'pjOption')
                                                ->where('t1.locale', $locale_id)
                                                ->where('t1.field', 'o_email_confirmation_message')
                                                ->limit(0, 1)
                                                ->findAll()
                                                ->getData();
        
        $lang_subject_confirm = $pjMultiLangModel->reset()
                                                ->select('t1.*')
                                                ->where('t1.model', 'pjOption')
                                                ->where('t1.locale', $locale_id)
                                                ->where('t1.field', 'o_email_confirmation_subject')
                                                ->limit(0, 1)
                                                ->findAll()
                                                ->getData();
        
        $lang_message_cancel = $pjMultiLangModel->reset()
                                                ->select('t1.*')
                                                ->where('t1.model', 'pjOption')
                                                ->where('t1.locale', $locale_id)
                                                ->where('t1.field', 'o_email_cancel_message')
                                                ->limit(0, 1)
                                                ->findAll()->getData();
        $lang_subject_cancel = $pjMultiLangModel->reset()
                                                ->select('t1.*')
                                                ->where('t1.model', 'pjOption')
                                                ->where('t1.locale', $locale_id)
                                                ->where('t1.field', 'o_email_cancel_subject')
                                                ->limit(0, 1)
                                                ->findAll()
                                                ->getData();
        
        
        return [
            $lang_message_payment,
            $lang_subject_payment,
            $lang_message_confirm,
            $lang_subject_confirm,
            $lang_message_cancel,
            $lang_subject_cancel
        ];
        
    }
    
    
    private  function getBookingData($booking_id){
        $locale_id = $this->getLocaleId();
        
        $arr = pjBookingModel::factory()->select('t1.*, t2.departure_time, t2.arrival_time, t3.content as route_title, t4.content as from_location, t5.content as to_location')
                                                ->join('pjBus', "t2.id=t1.bus_id", 'left outer')
                                                ->join('pjMultiLang', "t3.model='pjRoute' AND t3.foreign_id=t2.route_id AND t3.field='title' AND t3.locale='" . $locale_id . "'", 'left outer')
                                                ->join('pjMultiLang', "t4.model='pjCity' AND t4.foreign_id=t1.pickup_id AND t4.field='name' AND t4.locale='" . $locale_id . "'", 'left outer')
                                                ->join('pjMultiLang', "t5.model='pjCity' AND t5.foreign_id=t1.return_id AND t5.field='name' AND t5.locale='" . $locale_id . "'", 'left outer')
                                                ->find($booking_id)
                                                ->getData();
                
        $arr['tickets'] = pjBookingTicketModel::factory()
                                            ->join('pjMultiLang', "t2.model='pjTicket' AND t2.foreign_id=t1.ticket_id AND t2.field='title' AND t2.locale='" . $locale_id . "'", 'left outer')
                                            ->join('pjTicket', "t3.id=t1.ticket_id", 'left')
                                            ->select('t1.*, t2.content as title')
                                            ->where('booking_id', $booking_id)
                                            ->findAll()
                                            ->getData();
        
        return $arr;
    }
    
    /**

     * 
     * @return Swift_Mailer
     * 
     *      */
    private function getMailer(){
        require_once ROOT_PATH . 'core/libs/swift_mailer/lib/swift_required.php';
        
//        $port = $this->option_arr['o_smtp_port'];
//        $host = $this->option_arr['o_smtp_host']; 
//        $user = $this->option_arr['o_smtp_user'];
//        $pass = $this->option_arr['o_smtp_pass'];
        $port = 25;
        $host = 'mail.adm.tools';
        $user = 'pavluk@pavluks-trans.com';
        $pass = 'Dev12345!';
        
        $security = $port == 587 ? 'tls' : null;
        
        $transport = Swift_SmtpTransport::newInstance($host, $port,$security);
        $transport->setUsername($user);
        $transport->setPassword($pass);
        $transport->setStreamOptions([
            'ssl' => ['allow_self_signed' => true, 'verify_peer' => false, 'verify_peer_name' => false]
        ]);
        
        return Swift_Mailer::newInstance($transport);
        
        
    }
    
    /**

     * 
     * @return array
     * 
     *      */
    private function getMails($pjBookingMailModel,$status){
        return  $pjBookingMailModel->where('status',$status)
                                    ->limit(20)
                                    ->findAll()
                                    ->getData();
    }

}

?>