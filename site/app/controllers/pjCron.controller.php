<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}
        ini_set("display_errors", "On");
        error_reporting(E_ALL ^ E_DEPRECATED);

class pjCron extends pjAppController {
    
    private $mailer;
//    private $option_arr;
    private $messagesAndSubjects;
    
    public function __construct() {
        parent::__construct();
        $this->setMailer();   
//        $this->setOptionArr();
        $this->setMessagesAndSubjects();
    }
    
    

    public function pjActionIndex() {
        
        
        
        
        $tokens = self::getData($this->option_arr, $v, PJ_SALT, $this->getLocaleId());
        $pjMultiLangModel = pjMultiLangModel::factory();
        $tokens = self::getData($this->option_arr, $v, PJ_SALT, $this->getLocaleId());
        
        $locale_id = $this->getLocaleId();
        
        
        $admin_email_payment_message = $pjMultiLangModel->reset()->select('t1.*')
                            ->where('t1.model', 'pjOption')
                            ->where('t1.locale', $locale_id)
                            ->where('t1.field', 'o_admin_email_payment_message')
                            ->limit(0, 1)
                            ->findAll()->getData();
            
        
        vd($admin_email_payment_message);
        
        
        
        
        $admin_email_payment_subject = $pjMultiLangModel->reset()->select('t1.*')
                            ->where('t1.model', 'pjOption')
                            ->where('t1.locale', $locale_id)
                            ->where('t1.field', 'o_admin_email_payment_subject')
                            ->limit(0, 1)
                            ->findAll()->getData();
        
        
        
        $adminMessage = str_replace($tokens['search'], $tokens['replace'], $admin_email_payment_message[0]['content']);
        $adminMessage = pjUtil::textToHtml($adminMessage);
        $subject = $admin_email_payment_subject[0]['content'];
        
        
           $message = Swift_Message::newInstance()
                                    ->setFrom('pavluk@pavluks-trans.com')
                                    ->setCharset('UTF-8')
                                    ->setSubject($subject)
                                    ->setBody($adminMessage)
                                    ->setTo('Sarued1957@teleworm.us');
            

        
        
        
        $this->setLayout('pjActionEmpty');

        $option_arr = $this->option_arr;
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
    
    private function hundlerMailItem($mail){
        $localeId = $this->getLocaleId();
        
        $bookinDataArr = $this->getBookingData($mail['booking_id']);
        $res = null;        
        
        $tokens = self::getData($this->option_arr, $bookinDataArr, PJ_SALT, $localeId);

        switch($mail['type']){
            case pjBookingMail::TYPE_CONFIRM:
            case pjBookingMail::TYPE_PAYMENT:
                $res = $this->hundleConfirmMail($bookinDataArr,$tokens,$mail);
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
  
        
        
        foreach($mails as $k => $mail){
            $res = $fields = null;
            
            try{
                $res = $this->hundlerMailItem($mail);
                
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
    
    private function hundleConfirmMail($booking_arr,$tokens,$mail){                      
        
        $messageText = str_replace($tokens['search'], $tokens['replace'], $this->messagesAndSubjects['lang_message_confirm'][0]['content']);
        $message = Swift_Message::newInstance()
                                    ->setFrom('pavluk@pavluks-trans.com')
                                    ->setCharset('UTF-8')
                                    ->setSubject($this->messagesAndSubjects['lang_subject_confirm'][0]['content'])
                                    ->setBody($messageText)
                                    ->setTo($booking_arr['c_email']);
        
       
        $res = false;
        
        if($res = $this->mailer->send($message, $failures)){
//            $this->sendEmailToAdmin($tokens,$mail);
        }
            
        return $res;
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
    
    private function getMails($pjBookingMailModel,$status){
        return  $pjBookingMailModel->where('status',$status)
                                    ->limit(20)
                                    ->findAll()
                                    ->getData();
    }
    
    private function sendEmailToAdmin($booking_arr,$tokens,$mail){

        
        if ($this->option_arr['o_admin_email_confirmation'] == 1){
            $adminMessage = $subject = null;
            
            if($mail['type'] == pjBookingMail::TYPE_CONFIRM){
                $adminMessage = str_replace($tokens['search'], $tokens['replace'], $this->messagesAndSubjects['admin_email_confirmation_message'][0]['content']);
                $adminMessage = pjUtil::textToHtml($adminMessage);
                $subject = $this->messagesAndSubjects['admin_email_confirmation_subject'][0]['content'];
                
            }
            elseif($mail['type'] == pjBookingMail::TYPE_PAYMENT){
                $adminMessage = str_replace($tokens['search'], $tokens['replace'], $this->messagesAndSubjects['admin_email_payment_message'][0]['content']);
                $adminMessage = pjUtil::textToHtml($adminMessage);
                $subject = $this->messagesAndSubjects['admin_email_payment_subject'][0]['content'];
            }
            
            $message = Swift_Message::newInstance()
                            ->setFrom('pavluk@pavluks-trans.com')
                            ->setCharset('UTF-8')
                            ->setSubject($subject)
                            ->setBody($adminMessage)
                            ->setTo('Havoccon1936@rhyta.com');
            
            $this->mailer->send($message, $failures);
            
        }
        
    }
    
    
    private function setMailer(){
        require_once ROOT_PATH . 'core/libs/swift_mailer/lib/swift_required.php';

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
        
        $this->mailer = Swift_Mailer::newInstance($transport);
        
        
    }
    
    private function setMessagesAndSubjects(){
        $locale_id = $this->getLocaleId();
        
        $lang_message_payment = $this->getMultiLangRecord($locale_id, 'o_email_payment_message');
        $lang_subject_payment = $this->getMultiLangRecord($locale_id, 'o_email_payment_subject');
        $lang_message_confirm = $this->getMultiLangRecord($locale_id, 'o_email_confirmation_message');
        $lang_subject_confirm = $this->getMultiLangRecord($locale_id, 'o_email_confirmation_subject');
        $lang_message_cancel = $this->getMultiLangRecord($locale_id, 'o_email_cancel_message');
        $lang_subject_cancel = $this->getMultiLangRecord($locale_id, 'o_email_cancel_subject');
        $admin_email_payment_message = $this->getMultiLangRecord($locale_id, 'o_admin_email_payment_message');
        $admin_email_payment_subject = $this->getMultiLangRecord($locale_id, 'o_admin_email_payment_subject');
        $admin_email_confirmation_message = $this->getMultiLangRecord($locale_id, 'o_admin_email_confirmation_message');
        $admin_email_confirmation_subject = $this->getMultiLangRecord($locale_id, 'o_admin_email_confirmation_subject');
        
        
        $this->messagesAndSubjects = [
            'lang_message_payment' => $lang_message_payment,
            'lang_subject_payment' => $lang_subject_payment,
            'lang_message_confirm' => $lang_message_confirm,
            'lang_subject_confirm' => $lang_subject_confirm,
            'lang_message_cancel' => $lang_message_cancel,
            'lang_subject_cancel' => $lang_subject_cancel,
            'admin_email_payment_message' => $admin_email_payment_message,
            'admin_email_payment_subject' => $admin_email_payment_subject,
            'admin_email_confirmation_message' => $admin_email_confirmation_message,
            'admin_email_confirmation_subject' => $admin_email_confirmation_subject,
        ];
        
    }
    
    
    private function getMultiLangRecord($locale_id,$key){
        return pjMultiLangModel::factory()->reset()
                                    ->select('t1.*')
                                    ->where('t1.model', 'pjOption')
                                    ->where('t1.locale', $locale_id)
                                    ->where('t1.field', $key)
                                    ->limit(0, 1)
                                    ->findAll()
                                    ->getData();
        
    }
    
    
    
}

?>