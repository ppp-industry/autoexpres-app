<?php

/**
 * Description of ApiPayment
 *
 * @author alexp
 */
class pjApiPayment extends pjApi {

    public function afterFilter() {}
    
    
    
    public function pjActionCheckPayment(){
        
        ini_set("display_errors", "On");
        error_reporting(E_ALL ^ E_DEPRECATED);
        $host = $_SERVER['HTTP_HOST'];
        
        $id = $_GET['id'];
        
        $pjBookingModelPayment = pjBookingPaymentModel::factory();
        
//        vd($pjBookingModelPayment);
        $pjBookingModel = pjBookingModel::factory();
        $res = $pjBookingModelPayment->where('booking_id',$id)->findAll()->getData();
        $status = null;
        
        if(empty($res)){
            $status = 404;
        }
        else{
            if($res[0]['status'] == 'paid'){
                
                $status = 200;
                $arr = $pjBookingModel->reset()->select('t1.*, t2.departure_time, t2.arrival_time, t3.content as route_title, t4.content as from_location, t5.content as to_location')->join('pjBus', "t2.id=t1.bus_id", 'left outer')->join('pjMultiLang', "t3.model='pjRoute' AND t3.foreign_id=t2.route_id AND t3.field='title' AND t3.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjMultiLang', "t4.model='pjCity' AND t4.foreign_id=t1.pickup_id AND t4.field='name' AND t4.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjMultiLang', "t5.model='pjCity' AND t5.foreign_id=t1.return_id AND t5.field='name' AND t5.locale='" . $this->getLocaleId() . "'", 'left outer')->find($id)->getData();
                $tickets = pjBookingTicketModel::factory()->join('pjMultiLang', "t2.model='pjTicket' AND t2.foreign_id=t1.ticket_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjTicket', "t3.id=t1.ticket_id", 'left')->select('t1.*, t2.content as title')->where('booking_id', $arr ['id'])->findAll()->getData();
                $arr ['tickets'] = $tickets;
                
                pjFrontEnd::pjActionConfirmSend($this->option_arr, $arr, PJ_SALT, 'confirm');
            }
            else{
                $status = 100;
            }
        }
        
        $returnUrl = $this->_get('back_url') . '?status=' . $status;
        pjUtil::redirect($returnUrl);
    }
    
    
      public function pjActionGetPaymentForm() {
        ini_set("display_errors", "On");
        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $host = $_SERVER['HTTP_HOST'];
        $key = $_GET['key'];
        
        $arr = pjBookingModel::factory()
                        ->select('t1.*')
                        ->find($_GET['booking_id'])->getData();
        
               
        
      if(isset($_GET['return_url'])){
        $this->_set('back_url', $_GET['return_url']);  
      }
        
        
        $notifyUrl = $host . '/api/payment/confirmLiqPay?key=' . $key;

        $response = '';
        

        
        $returnUrl = 'http://' . $host. '/api/payment/checkPayment?key=' . $key . '&id=' . $arr['id'];
        
        if($arr['payment_method'] == 'cash'){
            
            $this->setPaidStatus($_GET['booking_id']);
            pjUtil::redirect($returnUrl);
        } 
        

        if (!empty($arr['back_id'])) {
            $back_arr = pjBookingModel::factory()
                            ->select('t1.*')
                            ->find($arr['back_id'])->getData();
            $arr['deposit'] += $back_arr['deposit'];
        }

        $getLiqPayParams = function($arr,$currency,$returnUrl) use ($notifyUrl){
            return array(
                'name' => 'bsLiqPay',
                'id' => $arr['id'],
//                'business' => $liqPayAdress,
                'item_name' => __('front_label_bus_schedule', true, false),
                'custom' => $arr['id'],
                'amount' => number_format($arr['deposit'], 2, '.', ''),
                'currency_code' => $currency,
                'return' => $returnUrl,

                'target' => '_self',

                'notify_url' => PJ_INSTALL_URL . 'index.php?controller=pjFrontEnd&action=pjActionConfirmLiqPay',
                'target' => '_self',

            );
        };


        switch ($arr['payment_method']) {

            case 'liqpay':
                $params = $getLiqPayParams($arr,$this->option_arr['o_currency'],$returnUrl);

                $response = $this->requestAction(array('controller' => 'pjLiqPay', 'action' => 'pjActionForm', 'params' => $params));

                break;
            case 'gpay':
                $params = $getLiqPayParams($arr,$this->option_arr['o_currency'],$returnUrl);
                $params['paytypes'] = 'gpay';
                $response = $this->requestAction(array('controller' => 'pjLiqPay', 'action' => 'pjActionForm', 'params' => $params));


                break;
            case 'apay':
                $params = $getLiqPayParams($arr,$this->option_arr['o_currency'],$returnUrl);
                $params['paytypes'] = 'apay';
                $response = $this->requestAction(array('controller' => 'pjLiqPay', 'action' => 'pjActionForm', 'params' => $params));


                break;

        }

        echo $response;
        exit();
        
    }
    
    
    public function pjActionConfirmLiqPay() {
        $this->setAjax(true);
        
        file_put_contents('post.data', var_export($_POST, true));

        if (pjObject::getPlugin('pjLiqPay') === NULL) {
            $this->log('LiqPay plugin not installed');
            exit;
        }

        $params = array(
            'order_id' => @$booking_arr['id'],
            'liqpay_address' => $this->option_arr['o_liqpay_address'],
            'deposit' => @$booking_arr['deposit'],
            'currency' => $this->option_arr['o_currency'],
            'key' => md5($this->option_arr['private_key'] . PJ_SALT)
        );

        $response = $this->requestAction(array('controller' => 'pjLiqPay', 'action' => 'pjActionConfirm', 'params' => $params), array('return'));

        $pjBookingModel = pjBookingModel::factory();
        $booking_arr = $pjBookingModel
                ->select('t1.*, t2.departure_time, t2.arrival_time, t3.content as route_title, t4.content as from_location, t5.content as to_location')
                ->join('pjBus', "t2.id=t1.bus_id", 'left outer')
                ->join('pjMultiLang', "t3.model='pjRoute' AND t3.foreign_id=t2.route_id AND t3.field='title' AND t3.locale='" . $this->getLocaleId() . "'", 'left outer')
                ->join('pjMultiLang', "t4.model='pjCity' AND t4.foreign_id=t1.pickup_id AND t4.field='name' AND t4.locale='" . $this->getLocaleId() . "'", 'left outer')
                ->join('pjMultiLang', "t5.model='pjCity' AND t5.foreign_id=t1.return_id AND t5.field='name' AND t5.locale='" . $this->getLocaleId() . "'", 'left outer')
                ->find($response['order_id'])
                ->getData();

        $booking_arr['tickets'] = pjBookingTicketModel::factory()
                ->join('pjMultiLang', "t2.model='pjTicket' AND t2.foreign_id=t1.ticket_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                ->join('pjTicket', "t3.id=t1.ticket_id", 'left')
                ->select('t1.*, t2.content as title')
                ->where('booking_id', $booking_arr['id'])
                ->findAll()
                ->getData();

        if (count($booking_arr) == 0) {
            $this->log('No such booking');
            pjUtil::redirect($this->option_arr['o_thank_you_page']);
        }
        if (!empty($booking_arr['back_id'])) {
            $back_arr = pjBookingModel::factory()
                            ->select('t1.*')
                            ->find($booking_arr['back_id'])->getData();
            $booking_arr['deposit'] += $back_arr['deposit'];
        }

        if ($response !== FALSE && $response['status'] === 'OK') {
            $this->log('Booking confirmed');
            $pjBookingModel->reset()->setAttributes(array('id' => $response['order_id']))->modify(array(
                'status' => $this->option_arr['o_payment_status'],
                'txn_id' => $response['payment_id'],
                'processed_on' => ':NOW()'
            ));


            if (!empty($booking_arr['back_id'])) {
                $pjBookingModel->reset()->setAttributes(array('id' => $booking_arr['back_id']))->modify(array(
                    'status' => $this->option_arr['o_payment_status'],
                    'txn_id' => $response['transaction_id'],
                    'processed_on' => ':NOW()'
                ));
            }


            $message_text = '<h3>$_POST</h3>';

            foreach ($_POST as $key => $value) {

                $message_text .= $key . ' => ' . $value;
                $message_text .= '<br>';
            }


            //Set message data
            $set_message = array(
                'to' => 'marck@i.ua',
                'subject' => 'ligpay debug',
                'message' => $message_text,
                'headers' => "MIME-Version: 1.0\r\n" . "Content-type: text/html; charset=utf-8\r\n" . "From: <admin@mail.com>\r\n",
            );

            $this->setPaidStatus($response['order_id']);

            pjFrontEnd::pjActionConfirmSend($this->option_arr, $booking_arr, PJ_SALT, 'payment');
        } elseif (!$response) {
            $this->log('LiqPay authorization failed');
        } else {
            $this->log('Booking not confirmed');
        }
        pjUtil::redirect($this->option_arr['o_thank_you_page']);
    }
    
    private function setPaidStatus($bookingId){
        pjBookingPaymentModel::factory()
                    ->where('booking_id',$bookingId )
                    ->modifyAll(array('status' => 'paid'));
    }

}
