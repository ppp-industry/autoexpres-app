<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}


/**
 * Description of pjApiCities
 *
 * @author alexp
 */
class pjApiBooking extends pjApi {

    public function afterFilter() {
       
    }


    public function pjActionSaveBooking() {
        
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
        
        if (!isset($_POST['step_checkout'])) {
            exit();
        }
        
        $localeId = $this->getLocaleId();
        
        
        function makePayment($form,$id,$payment,$status){
            $payment_data = array();
            $payment_data['booking_id'] = $id;
            $payment_data['payment_method'] = $payment;
            $payment_data['payment_type'] = 'online';
            $payment_data['amount'] = $form['deposit'];
            $payment_data['status'] = $status;

            pjBookingPaymentModel::factory()->setAttributes($payment_data)->insert();

        }
        
        function getBus($bus_id_end,$localeId){
            return pjBusModel::factory()->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" .$localeId  . "'", 'left outer')
                                                    ->join('pjBusType', "t3.id=t1.bus_type_id", 'left')
                                                    ->select('t1.*, t3.seats_map, t2.content as route')
                                                    ->find($bus_id_end)
                                                    ->getData();
            
        }
        
        function locationArrHundler(&$location_pair,&$location_arr){
            
            for ($i = 0; $i < count($location_arr); $i++) {
                $j = $i + 1;
                if ($j < count($location_arr)) {
                    $location_pair [] = $location_arr [$i] ['city_id'] . '-' . $location_arr [$j] ['city_id'];
                }
            }
        }
        
        function locationPairHundler(&$booked_data,&$location_pair,&$ticket_arr,&$id){
            $pjBookingSeatModel = pjBookingSeatModel::factory();

            $seat_id_arr = isset($booked_data ['selected_seats']) ? explode("|", $booked_data ['selected_seats']) : [];

            foreach ($location_pair as $pair) {
                $_arr = explode("-", $pair);
                $k = 0;
                foreach ($ticket_arr as $j => $v) {
                    if (isset($booked_data ['ticket_cnt_' . $v ['ticket_id']]) && $booked_data ['ticket_cnt_' . $v ['ticket_id']] > 0) {
                        $qty = $booked_data ['ticket_cnt_' . $v ['ticket_id']];
                        if ($qty > 0) {
                            for ($i = 1; $i <= $qty; $i++) {
                                $data = array();
                                $data ['booking_id'] = $id;
                                $data ['seat_id'] = isset($seat_id_arr [$k]) ? $seat_id_arr [$k] : null;
                                $data ['ticket_id'] = $v ['ticket_id'];

                                $data ['start_location_id'] = $_arr [0];
                                $data ['end_location_id'] = $_arr [1];
                                $data ['is_return'] = 'F';

                                $pjBookingSeatModel->reset()->setAttributes($data)->insert();

                                $k++;
                            }
                        }
                    }
                }
            }
        }
        
        function getTicketArr($bus,$start,$end){
            return pjPriceModel::factory()->select("t1.*")
                                          ->where('t1.bus_id', $bus)
                                          ->where('t1.from_location_id', $start)
                                          ->where('t1.to_location_id', $end)
                                          ->where('is_return = "F"')
                                          ->findAll()
                                          ->getData();
            
        }
        
        function hundleTicketArr(&$ticket_arr,&$pjBookingTicketModel,&$booked_data,&$id){
            
            $pjBookingTicketModel = pjBookingTicketModel::factory();           
            foreach ($ticket_arr as $k => $v) {
                if (isset($booked_data ['ticket_cnt_' . $v ['ticket_id']]) && $booked_data ['ticket_cnt_' . $v ['ticket_id']] > 0) {
                    $data = array();
                    $data ['booking_id'] = $id;
                    $data ['ticket_id'] = $v ['ticket_id'];
                    $data ['qty'] = $booked_data ['ticket_cnt_' . $v ['ticket_id']];
                    $data ['amount'] = $data ['qty'] * $v ['price'];
                    $data ['is_return'] = 'F';
//                         создаем билет 
                    $pjBookingTicketModel->reset()->setAttributes($data)->insert();
                }
            }            
        }
        
         
            
        $STORE = $this->_getStore();
        $FORM = $_POST;

        $booked_data = $this->_get('booked_data');// isset($STORE ['booked_data']) ? $STORE ['booked_data'] : [];

        $return_bus_id = isset ( $booked_data ['return_bus_id'] ) ? $booked_data ['return_bus_id'] : 0;

        $transferId = false;

        $bookingPeriod = array();
            
        if ($this->_is('booking_period')) {
            $bookingPeriod = $this->_get('booking_period');
        }

        if (isset($booked_data['transfer_id'])) {
            $transferId = $booked_data['transfer_id'];
        }


        $pjBookingModel = pjBookingModel::factory();
        $pjBusLocationModel = pjBusLocationModel::factory();

            
            
        $return_bus_id_start = isset($booked_data ['return_bus_id_start']) ? $booked_data ['return_bus_id_start'] : 0;
        $return_bus_id_end = isset($booked_data ['return_bus_id_end']) ? $booked_data ['return_bus_id_end'] : 0;

        $pickup_id = $this->_get('pickup_id');
        $return_id = $this->_get('return_id');
        $is_return = $this->_get('is_return');

        $data = array();
        $data ['uuid'] = time();
        $data ['ip'] = pjUtil::getClientIp();
        $data ['pickup_id'] = $pickup_id;
        $data ['return_id'] = $return_id;
        $data ['is_return'] = $is_return;
        $data ['status'] = $this->option_arr ['o_booking_status'];

        $data ['booking_date'] = pjUtil::formatDate($this->_get('date'), $this->option_arr ['o_date_format']);
        if ($is_return == 'T') {
            $data ['return_date'] = pjUtil::formatDate($this->_get('return_date'), $this->option_arr ['o_date_format']);
        }
        $data ['booking_datetime'] = $data ['booking_date'];
        $payment = 'none';
            
        if (isset($FORM ['payment_method'])) {
            if ($FORM ['payment_method'] && $FORM ['payment_method'] == pjBookingPaymentModel::METHOD_CARD) {
                $data ['cc_exp'] = $FORM ['cc_exp_year'] . '-' . $FORM ['cc_exp_month'];
            }

            if ($FORM ['payment_method']) {
                $payment = $FORM ['payment_method'];
            }
        }


        $pjCityModel = pjCityModel::factory();

        $pickup_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($pickup_id)->getData();
        $return_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($return_id)->getData();


        $from_location = $pickup_location ['name'];
        $to_location = $return_location ['name'];

            
            if($transferId){
                
                $transfer_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($transferId)->getData();
                $trans_location = $transfer_location ['name'];
                
                $data['transfer_id'] = $transferId;
                $data['with_transfer'] = 1;
                
                $bus_id_start = $booked_data ['bus_id_start'];
                $bus_id_end = $booked_data ['bus_id_end'];
                
                $depart_arrive_start = $depart_arrive_end = '';

                $bus_arr_start = getBus($bus_id_start,$localeId);
                $bus_arr_end = getBus($bus_id_end,$localeId);
             
                if (!empty($bus_arr_start ['departure_time']) && !empty($bus_arr_end ['arrival_time'])) {
                    $depart_arrive_start = pjUtil::formatTime($bus_arr_start ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']) . ' - ' . pjUtil::formatTime($bus_arr_start ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                    $depart_arrive_end = pjUtil::formatTime($bus_arr_end ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']) . ' - ' . pjUtil::formatTime($bus_arr_end ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                }
                
                
                $data ['bus_id'] = $bus_id_start;
                $data ['bus_end'] = $bus_id_end;
                
//                vd($bookingPeriod);
                if (isset($bookingPeriod[$bus_id_start],$bookingPeriod[$bus_id_end])) {
                    
                    $data ['booking_datetime'] = $bookingPeriod[$bus_id_start]['departure_time'];
                    $data ['stop_datetime'] = $bookingPeriod[$bus_id_end] ['arrival_time'];
                }
                
             
                $bus_time_arr = array();
                
                
                $_arr = $pjBusLocationModel->where('bus_id', $bus_id_start)->where("location_id", $pickup_id)->limit(1)->findAll()->getData();
                if (count($_arr) > 0) {
                    $bus_time_arr [] = pjUtil::formatTime($_arr [0] ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']);
                    $data ['booking_datetime'] .= ' ' . $_arr [0] ['departure_time'];
                }
                
                $_arr = $pjBusLocationModel->reset()->where('bus_id', $bus_id_start)->where("location_id", $transferId)->limit(1)->findAll()->getData();
                if (count($_arr) > 0) {
                    $bus_time_arr [] = pjUtil::formatTime($_arr [0] ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                }
                
                $_arr = $pjBusLocationModel->reset()->where('bus_id', $bus_id_end)->where("location_id", $transferId)->limit(1)->findAll()->getData();
                if (count($_arr) > 0) {
                    $bus_time_arr [] = pjUtil::formatTime($_arr [0] ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']);
                }
                
                $_arr = $pjBusLocationModel->reset()->where('bus_id', $bus_id_end)->where("location_id", $return_id)->limit(1)->findAll()->getData();
                if (count($_arr) > 0) {
                    $bus_time_arr [] = pjUtil::formatTime($_arr [0] ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                }
                
                $data ['booking_time'] = join(" - ", $bus_time_arr);
                
//                vd($bus_arr_start);
                $data ['booking_route'] = $bus_arr_start ['route'] . ', ' . $depart_arrive_start . ' з ' . $from_location . ' до' .$trans_location . ' ' ;
                $data ['booking_route'] .= ', ' . $bus_arr_end ['route'] . ', ' . $depart_arrive_end. ' з ' . $trans_location . ' до' .$to_location ;;

                $id = $pjBookingModel->setAttributes(array_merge($FORM, $data))->insert()->getInsertId();
                
                
                
                if($payment === pjBookingPaymentModel::METHOD_CASH){
                    pjBookingMail::makeModel($id, pjBookingMail::TYPE_CONFIRM);
                }
                
                makePayment($FORM,$id,$payment, pjBookingPaymentModel::STATUS_PAID);
                
                
                if ($id !== false && (int) $id > 0) {
                  
                    if ($is_return == 'T' && $return_bus_id_start && $return_bus_id_end) {
                        
                        
                        
                        $child_bus_arr = getBus($return_bus_id_start, $localeId);
                        $child_bus_arr_end = getBus($return_bus_id_end, $localeId);
                                

                        if (!empty($child_bus_arr ['departure_time']) && !empty($child_bus_arr_end ['arrival_time'])) {
                            $depart_arrive_start = pjUtil::formatTime($child_bus_arr ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']) . ' - ' . pjUtil::formatTime($child_bus_arr ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                            $depart_arrive_end = pjUtil::formatTime($child_bus_arr_end ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']) . ' - ' . pjUtil::formatTime($child_bus_arr_end ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                        }
                        
                        $bt_arr = array();
                        
                        
                        $_arr = $pjBusLocationModel->where('bus_id', $child_bus_arr ['id'])->where("location_id", $return_id)->limit(1)->findAll()->getData();
                       
                        if (count($_arr) > 0) {
                            $bt_arr [] = pjUtil::formatTime($_arr [0] ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']);
                            $data ['booking_datetime'] .= ' ' . $_arr [0] ['departure_time'];
                        }

                        $_arr = $pjBusLocationModel->reset()->where('bus_id', $child_bus_arr ['id'])->where("location_id", $transferId)->limit(1)->findAll()->getData();
                        if (count($_arr) > 0) {
                            $bt_arr [] = pjUtil::formatTime($_arr [0] ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                        }
                        
                        $_arr = $pjBusLocationModel->reset()->where('bus_id', $child_bus_arr_end ['id'])->where("location_id", $pickup_id)->limit(1)->findAll()->getData();
                        if (count($_arr) > 0) {
                            $bt_arr [] = pjUtil::formatTime($_arr [0] ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                        }

                        
                        
                        $data ['booking_time'] = join(" - ", $bt_arr);

                        $data ['booking_route'] = $child_bus_arr ['route'] . ', ' . $depart_arrive_start . '<br/>';
                        $data ['booking_route'] .= __('front_from', true, false) . ' ' . $to_location . ' ' . __('front_to', true, false) . ' ' . $from_location;
                        $data ['booking_date'] = pjUtil::formatDate($this->_get('return_date'), $this->option_arr ['o_date_format']);
                       
                        
                        if (isset($bookingPeriod[$return_bus_id_start],$bookingPeriod[$return_bus_id_end])) {
                            $data ['booking_datetime'] = $STORE ['booking_period'] [$return_bus_id_start] ['departure_time'];
                            $data ['stop_datetime'] = $STORE ['booking_period'] [$return_bus_id_end] ['arrival_time'];
                        }
                        
                        
                        unset($data ['return_date'],$data ['is_return']);
                       

                        $data ['bus_id'] = $return_bus_id_start;
                        $data ['bus_end'] = $return_bus_id_end;
                        $data ['uuid'] = time() + 1;
                        $data ['pickup_id'] = $return_id;
                        $data ['return_id'] = $pickup_id;
                        $data ['sub_total'] = $FORM ['return_sub_total'];
                        $data ['tax'] = $FORM ['return_tax'];
                        $data ['total'] = $FORM ['return_total'];
                        $data ['deposit'] = $FORM ['return_deposit'];

                        $back_insert_id = $pjBookingModel->reset()->setAttributes(array_merge($FORM, $data))->insert()->getInsertId();
                        if ($back_insert_id !== false && (int) $back_insert_id > 0) {
                            
                            $pjBookingModel->reset()->set('id', $id)->modify(array(
                                'back_id' => $back_insert_id,
                            ));

                            $pjBookingModel->reset()->set('id', $back_insert_id)->modify(array(
                                'back_id' => $id
                            ));
                        }
                    }
                    
                    
                    
                    $ticket_arr_start = getTicketArr($bus_id_start,$pickup_id,$transferId);
                    $ticket_arr_end = getTicketArr($bus_id_end,$transferId,$return_id);
                    
                    
                    $ticket_arr = array_merge($ticket_arr_start,$ticket_arr_end);

                    $location_arr_start = pjRouteCityModel::factory()->getLocations($bus_arr_start ['route_id'], $pickup_id, $transferId);
                    $location_arr_end = pjRouteCityModel::factory()->getLocations($bus_arr_end ['route_id'], $transferId, $return_id);
                    $location_arr = array_merge($location_arr_start,$location_arr_end);
                    
                    
                    $location_pair = array();
                    
                    
                    $pjBookingTicketModel = pjBookingTicketModel::factory();
                    
                    hundleTicketArr($ticket_arr, $pjBookingTicketModel, $booked_data,$id);
                    locationArrHundler($location_pair,$location_arr);
                    locationPairHundler($booked_data,$location_pair,$ticket_arr,$id);

                    $json = array(
                        'code' => 200,
                        'text' => '',
                        'booking_id' => $id,
                        'payment' => $payment
                    );
                } 
                else {
                    $json = array(
                        'code' => 100,
                        'text' => ''
                    );
                }        
                
            }
            else{
                
                $bus_id = $booked_data ['bus_id'];
                
                $depart_arrive = '';

                $bus_arr = getBus($bus_id,$localeId);
                
                if (!empty($bus_arr ['departure_time']) && !empty($bus_arr ['arrival_time'])) {
                    $depart_arrive = pjUtil::formatTime($bus_arr ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']) . ' - ' . pjUtil::formatTime($bus_arr ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                }
                
                
                $data ['bus_id'] = $bus_id;
                
                if (isset($bookingPeriod[$bus_id])) {
                    $data ['booking_datetime'] = $bookingPeriod[$bus_id]['departure_time'];
                    $data ['stop_datetime'] = $bookingPeriod[$bus_id] ['arrival_time'];
                }
                
                $bus_time_arr = array();
                
                
                $_arr = $pjBusLocationModel->reset()->where('bus_id', $bus_id)->where("location_id", $pickup_id)->limit(1)->findAll()->getData();
                if (count($_arr) > 0) {
                    $bus_time_arr [] = pjUtil::formatTime($_arr [0] ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']);
                    $data ['booking_datetime'] .= ' ' . $_arr [0] ['departure_time'];
                }
                
                $_arr = $pjBusLocationModel->reset()->where('bus_id', $bus_id)->where("location_id", $return_id)->limit(1)->findAll()->getData();
                if (count($_arr) > 0) {
                    $bus_time_arr [] = pjUtil::formatTime($_arr [0] ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                }
                
                
                $data ['booking_time'] = join(" - ", $bus_time_arr);
                $data ['booking_route'] = $bus_arr ['route'] . ', ' . $depart_arrive;
                $data ['booking_route'] .= __('front_from', true, false) . ' ' . $from_location . ' ' . __('front_to', true, false) . ' ' . $to_location;

                $id = $pjBookingModel->setAttributes(array_merge($FORM, $data))->insert()->getInsertId();
                if($payment === pjBookingPaymentModel::METHOD_CASH){
                    pjBookingMail::makeModel($id, pjBookingMail::TYPE_CONFIRM);
                }
                
                makePayment($FORM,$id,$payment, pjBookingPaymentModel::STATUS_PAID);
                
                if ($id !== false && (int) $id > 0) {
                    
                    if ($is_return == 'T') {
                        
                        $child_bus_arr = getBus($return_bus_id, $localeId);
                                

                        if (!empty($child_bus_arr ['departure_time']) && !empty($child_bus_arr ['arrival_time'])) {
                            $depart_arrive = pjUtil::formatTime($child_bus_arr ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']) . ' - ' . pjUtil::formatTime($child_bus_arr ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                        }
                        
                        $bt_arr = array();
                        
                        
                        $_arr = $pjBusLocationModel->where('bus_id', $child_bus_arr ['id'])->where("location_id", $return_id)->limit(1)->findAll()->getData();
                       
                        if (count($_arr) > 0) {
                            $bt_arr [] = pjUtil::formatTime($_arr [0] ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']);
                            $data ['booking_datetime'] .= ' ' . $_arr [0] ['departure_time'];
                        }

                        $_arr = $pjBusLocationModel->reset()->where('bus_id', $child_bus_arr ['id'])->where("location_id", $pickup_id)->limit(1)->findAll()->getData();
                        if (count($_arr) > 0) {
                            $bt_arr [] = pjUtil::formatTime($_arr [0] ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                        }
                        
                        
                        
                        $data ['booking_time'] = join(" - ", $bt_arr);

                        $data ['booking_route'] = $child_bus_arr ['route'] . ', ' . $depart_arrive . '<br/>';
                        $data ['booking_route'] .= __('front_from', true, false) . ' ' . $to_location . ' ' . __('front_to', true, false) . ' ' . $from_location;
                        $data ['booking_date'] = pjUtil::formatDate($this->_get('return_date'), $this->option_arr ['o_date_format']);
                       
                        
                        if (isset($bookingPeriod[$return_bus_id])) {
                            $data ['booking_datetime'] = $STORE ['booking_period'] [$return_bus_id] ['departure_time'];
                            $data ['stop_datetime'] = $STORE ['booking_period'] [$return_bus_id] ['arrival_time'];
                        }
                        
                        
                        unset($data ['return_date']);
                        unset($data ['is_return']);

                        $data ['bus_id'] = $return_bus_id;
                        $data ['uuid'] = time() + 1;
                        $data ['pickup_id'] = $return_id;
                        $data ['return_id'] = $pickup_id;
                        $data ['sub_total'] = $FORM ['return_sub_total'];
                        $data ['tax'] = $FORM ['return_tax'];
                        $data ['total'] = $FORM ['return_total'];
                        $data ['deposit'] = $FORM ['return_deposit'];

                        $back_insert_id = $pjBookingModel->reset()->setAttributes(array_merge($FORM, $data))->insert()->getInsertId();
                        if ($back_insert_id !== false && (int) $back_insert_id > 0) {
                            
                            $pjBookingModel->reset()->set('id', $id)->modify(array(
                                'back_id' => $back_insert_id
                            ));

                            $pjBookingModel->reset()->set('id', $back_insert_id)->modify(array(
                                'back_id' => $id
                            ));
                            
                            
                        }
                    }
                    
                    
                    
                    $ticket_arr = getTicketArr($bus_id,$pickup_id,$return_id);

                    $location_arr = pjRouteCityModel::factory()->getLocations($bus_arr ['route_id'], $pickup_id, $return_id);
                    
                    $location_pair = array();
                    
                    $pjBookingTicketModel = pjBookingTicketModel::factory();
                    
                    hundleTicketArr($ticket_arr, $pjBookingTicketModel, $booked_data,$id);
                    locationArrHundler($location_pair,$location_arr);
                    locationPairHundler($booked_data,$location_pair,$ticket_arr,$id); 
                    
                    $json = array(
                        'code' => 200,
                        'text' => '',
                        'booking_id' => $id,
                        'payment' => $payment
                    );
                } 
                else {
                    $json = array(
                        'code' => 100,
                        'text' => ''
                    );
                }
            }            
            
            pjAppController::jsonResponse($json);

    }

    public function pjActionCheckout() {
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);


    $this->setAjax(true);

    $this->_set('booked_data', $_POST);

    $filter = function($key, &$arr) {
        if (isset($arr[$key])) {
            $arr[$key] = strip_tags($arr[$key]);
        }
    };

    $checkDate = function(&$end, &$start, &$time) {
        if ($end < $start) {

            $end += (86400 * ceil(($start - $end) / 86400));
            $time = date('Y-m-d H:i:s', $end);
        }
    };

    $calcDuration = function($end, $start) {

        $durationInSeconds = $end - $start;

        $days = floor($durationInSeconds / 86400);
        $hoursMod = $durationInSeconds - ($days * 86400);
        $hours = floor($hoursMod / 3600);
        $minutsMod = $hoursMod % 3600;
        $minuts = floor($minutsMod / 60);
        $duration = '';
        $localeId = $this->getLocaleId();


        switch ($localeId) {
            case 1:
                $duration = ($days ? $days . 'D ' : '') . $hours . 'H ' . $minuts . 'M';
                break;
            case 2:
                $duration = ($days ? $days . 'Д ' : '') . $hours . 'Ч ' . $minuts . 'М';
                break;
            case 3:
                $duration = ($days ? $days . 'Д ' : '') . $hours . 'Г ' . $minuts . 'Хв';
                break;
        }

        return [
            $durationInSeconds,
            $duration
        ];
    };

    $res = [];

    if ($this->checkStore() && $this->isBusReady() == true) {

        $bookedData = $_POST;

        $transferId = false;

        if (isset($bookedData['transfer_id'])) {
            $transferId = $bookedData['transfer_id'];
        }

        $pickupId = $this->_get('pickup_id');
        $returnId = $this->_get('return_id');
        $isReturn = $this->_get('is_return');

        $date = $this->_get('date');

        $pjBusLocationModel = pjBusLocationModel::factory();

        $pjCityModel = pjCityModel::factory();

        $pickup_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($pickupId)->getData();
        $return_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($returnId)->getData();


        $from_location = $pickup_location['name'];
        $to_location = $return_location['name'];

        if ($transferId) {
            $res['summary'] = [];

            $transfer_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($transferId)->getData();

            $res['transfer_location'] = $transfer_location['name'];


            $duration_start = $duration_end = $arrival_time_end = $departure_time_end = $departure_time_start = $_departure_time = $arrival_time_start = $_arrival_time = $duration = $_duration = NULL;
            $busIdStart = $bookedData['bus_id_start'];
            $busIEnd = $bookedData['bus_id_end'];

            $pickup_arr = $pjBusLocationModel->reset()->where('bus_id', $busIdStart)->where("location_id", $pickupId)->limit(1)->findAll()->getData();
            $transfer_arr = $pjBusLocationModel->reset()->where('bus_id', $busIdStart)->whereIn("location_id", $transferId)->limit(1)->findAll()->getData();
            $return_arr = $pjBusLocationModel->reset()->where('bus_id', $busIEnd)->where("location_id", $returnId)->limit(1)->findAll()->getData();

            if (!empty($pickup_arr) && !empty($transfer_arr)) {



                $departure_time_start = $date . ' ' . pjUtil::formatTime($pickup_arr[0]['departure_time'], 'H:i:s', $this->option_arr['o_time_format']);
                $arrival_time_start = $date . ' ' . pjUtil::formatTime($transfer_arr[0]['arrival_time'], 'H:i:s', $this->option_arr['o_time_format']);
            }

            if (!empty($return_arr) && !empty($transfer_arr)) {
//                                                echo __LINE__;exit();
//                        vd($busIdStart);
                $departure_time_end = $date . ' ' . pjUtil::formatTime($transfer_arr[0]['departure_time'], 'H:i:s', $this->option_arr['o_time_format']);
                $arrival_time_end = $date . ' ' . pjUtil::formatTime($return_arr[0]['arrival_time'], 'H:i:s', $this->option_arr['o_time_format']);
            }

            if (isset($departure_time_start, $arrival_time_start, $departure_time_end, $arrival_time_end)) {

                $departure_time_start_timestamp = strtotime($departure_time_start);
                $arrival_time_start_timestamp = strtotime($arrival_time_start);
                $departure_time_end_timestamp = strtotime($departure_time_end);
                $arrival_time_end_timestamp = strtotime($arrival_time_end);

                $checkDate($arrival_time_start_timestamp, $departure_time_start_timestamp, $arrival_time_start);
                $checkDate($departure_time_end_timestamp, $arrival_time_start_timestamp, $departure_time_end);
                $checkDate($arrival_time_end_timestamp, $departure_time_end_timestamp, $arrival_time_end);

                list($duration_start_seconds, $duration_start) = $calcDuration($arrival_time_start_timestamp, $departure_time_start_timestamp);
                list($duration_end_seconds, $duration_end) = $calcDuration($arrival_time_end_timestamp, $departure_time_end_timestamp);
                list($duration_total_seconds, $duration_total) = $calcDuration($arrival_time_end_timestamp, $departure_time_start_timestamp);
            }

            $pjBusModel = pjBusModel::factory();
            $bus_arr_start = $pjBusModel
                    ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->select("t1.*, t2.content as route_title")
                    ->find($busIdStart)
                    ->getData();

            $bus_arr_end = $pjBusModel
                    ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->select("t1.*, t2.content as route_title")
                    ->find($busIEnd)
                    ->getData();

            $bus_arr_start['departure_time'] = $departure_time_start;
            $bus_arr_start['arrival_time'] = $arrival_time_start;
            $bus_arr_start['duration'] = $duration_start;
            $bus_arr_start['duration_seconds'] = $duration_start_seconds;


            $bus_arr_end['departure_time'] = $departure_time_end;
            $bus_arr_end['arrival_time'] = $arrival_time_end;
            $bus_arr_end['duration'] = $duration_end;
            $bus_arr_end['duration_seconds'] = $duration_end_seconds;


            $res['bus_arr_start'] = $bus_arr_start;
            $res['bus_arr_end'] = $bus_arr_end;

            $pjPriceModel = pjPriceModel::factory();

            $ticket_price_arr_start = $pjPriceModel->getTicketPrice($busIdStart, $pickupId, $transferId, $bookedData, $this->option_arr, $this->getLocaleId(), 'F');
            $ticket_price_arr_end = $pjPriceModel->getTicketPrice($busIEnd, $transferId, $returnId, $bookedData, $this->option_arr, $this->getLocaleId(), 'F');



            $filter('sub_total_format', $ticket_price_arr_start);
            $filter('tax_format', $ticket_price_arr_start);
            $filter('total_format', $ticket_price_arr_start);
            $filter('deposit_format', $ticket_price_arr_start);

            $filter('sub_total_format', $ticket_price_arr_end);
            $filter('tax_format', $ticket_price_arr_end);
            $filter('total_format', $ticket_price_arr_end);
            $filter('deposit_format', $ticket_price_arr_end);

            $res['ticket_arr_start'] = $ticket_price_arr_start['ticket_arr'];
            $res['price_arr_start'] = $ticket_price_arr_start;

            $res['ticket_arr_end'] = $ticket_price_arr_end['ticket_arr'];
            $res['price_arr_end'] = $ticket_price_arr_end;



            $res['summary']['duraion'] = $duration_total;
            $res['summary']['duraion_seconds'] = $duration_total_seconds;

            $res['summary']['total'] = $ticket_price_arr_start['total'] + $ticket_price_arr_end['total'];
            $res['summary']['sub_total'] = $ticket_price_arr_start['sub_total'] + $ticket_price_arr_end['sub_total'];
            $res['summary']['deposit'] = $ticket_price_arr_start['deposit'] + $ticket_price_arr_end['deposit'];
            $res['summary']['tax'] = $ticket_price_arr_start['tax'] + $ticket_price_arr_end['tax'];

            if ($isReturn == "T") {


                $returnBusIdStart = $bookedData['return_bus_id_start'];
                $returnBusIEnd = $bookedData['return_bus_id_end'];
//                    

                $duration_start = $duration_end = $arrival_time_end = $departure_time_end = $departure_time_start = $_departure_time = $arrival_time_start = $_arrival_time = $duration = $_duration = NULL;
                $busIdStart = $bookedData['bus_id_start'];
                $busIEnd = $bookedData['bus_id_end'];

                $pickup_arr = $pjBusLocationModel->reset()->where('bus_id', $returnBusIdStart)->where("location_id", $returnId)->limit(1)->findAll()->getData();
                $transfer_arr = $pjBusLocationModel->reset()->where('bus_id', $returnBusIEnd)->whereIn("location_id", $transferId)->limit(1)->findAll()->getData();
                $return_arr = $pjBusLocationModel->reset()->where('bus_id', $returnBusIdStart)->where("location_id", $pickupId)->limit(1)->findAll()->getData();



                if (!empty($pickup_arr) && !empty($transfer_arr)) {

                    $departure_time_start = $date . ' ' . pjUtil::formatTime($pickup_arr[0]['departure_time'], 'H:i:s', $this->option_arr['o_time_format']);
                    $arrival_time_start = $date . ' ' . pjUtil::formatTime($transfer_arr[0]['arrival_time'], 'H:i:s', $this->option_arr['o_time_format']);
                }

                if (!empty($return_arr) && !empty($transfer_arr)) {
                    $departure_time_end = $date . ' ' . pjUtil::formatTime($transfer_arr[0]['departure_time'], 'H:i:s', $this->option_arr['o_time_format']);
                    $arrival_time_end = $date . ' ' . pjUtil::formatTime($return_arr[0]['arrival_time'], 'H:i:s', $this->option_arr['o_time_format']);
                }

                if (isset($departure_time_start, $arrival_time_start, $departure_time_end, $arrival_time_end)) {

                    $departure_time_start_timestamp = strtotime($departure_time_start);
                    $arrival_time_start_timestamp = strtotime($arrival_time_start);
                    $departure_time_end_timestamp = strtotime($departure_time_end);
                    $arrival_time_end_timestamp = strtotime($arrival_time_end);

                    $checkDate($arrival_time_start_timestamp, $departure_time_start_timestamp, $arrival_time_start);
                    $checkDate($departure_time_end_timestamp, $arrival_time_start_timestamp, $departure_time_end);
                    $checkDate($arrival_time_end_timestamp, $departure_time_end_timestamp, $arrival_time_end);

                    list($duration_start_seconds, $duration_start) = $calcDuration($arrival_time_start_timestamp, $departure_time_start_timestamp);
                    list($duration_end_seconds, $duration_end) = $calcDuration($arrival_time_end_timestamp, $departure_time_end_timestamp);
                    list($duration_total_seconds, $duration_total) = $calcDuration($arrival_time_end_timestamp, $departure_time_start_timestamp);
                }


                $return_ticket_price_arr_start = $pjPriceModel->getTicketPrice($returnBusIdStart, $returnId, $transferId, $bookedData, $this->option_arr, $this->getLocaleId(), 'T');
                $return_ticket_price_arr_end = $pjPriceModel->getTicketPrice($returnBusIEnd, $transferId, $pickupId, $bookedData, $this->option_arr, $this->getLocaleId(), 'T');


                $filter('sub_total_format', $return_ticket_price_arr_start);
                $filter('tax_format', $return_ticket_price_arr_start);
                $filter('total_format', $return_ticket_price_arr_start);
                $filter('deposit_format', $return_ticket_price_arr_start);

                $filter('sub_total_format', $return_ticket_price_arr_end);
                $filter('tax_format', $return_ticket_price_arr_end);
                $filter('total_format', $return_ticket_price_arr_end);
                $filter('deposit_format', $return_ticket_price_arr_end);

                $res['return_ticket_arr_start'] = $return_ticket_price_arr_start['ticket_arr'];
                $res['return_price_arr_start'] = $return_ticket_price_arr_start;

                $res['return_ticket_arr_end'] = $return_ticket_price_arr_end['ticket_arr'];
                $res['return_price_arr_end'] = $return_ticket_price_arr_end;

                $pjBusModel = pjBusModel::factory();
                $return_bus_arr_start = $pjBusModel
                        ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                        ->select("t1.*, t2.content as route_title")
                        ->find($returnBusIdStart)
                        ->getData();

                $return_bus_arr_end = $pjBusModel
                        ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                        ->select("t1.*, t2.content as route_title")
                        ->find($returnBusIEnd)
                        ->getData();

                $return_bus_arr_start['departure_time'] = $departure_time_start;
                $return_bus_arr_start['arrival_time'] = $arrival_time_start;
                $return_bus_arr_start['duration'] = $duration_start;
                $return_bus_arr_start['duration_seconds'] = $duration_start_seconds;


                $return_bus_arr_end['departure_time'] = $departure_time_end;
                $return_bus_arr_end['arrival_time'] = $arrival_time_end;
                $return_bus_arr_end['duration'] = $duration_end;
                $return_bus_arr_end['duration_seconds'] = $duration_end_seconds;


                $res['return_bus_arr_start'] = $return_bus_arr_start;
                $res['return_bus_arr_end'] = $return_bus_arr_end;

                $res['summary']['return_total'] = $return_ticket_price_arr_start['total'] + $return_ticket_price_arr_end['total'];
                $res['summary']['return_sub_total'] = $return_ticket_price_arr_start['sub_total'] + $return_ticket_price_arr_end['sub_total'];
                $res['summary']['return_deposit'] = $return_ticket_price_arr_start['deposit'] + $return_ticket_price_arr_end['deposit'];
                $res['summary']['return_tax'] = $return_ticket_price_arr_start['tax'] + $return_ticket_price_arr_end['tax'];


                $res['is_return'] = $isReturn;
            }
        } 
        else {

            $bus_id = $bookedData['bus_id'];

            $pickup_arr = $pjBusLocationModel->where('bus_id', $bus_id)->where("location_id", $pickupId)->limit(1)->findAll()->getData();
            $return_arr = $pjBusLocationModel->reset()->where('bus_id', $bus_id)->where("location_id", $returnId)->limit(1)->findAll()->getData();


            $departure_time = $_departure_time = $arrival_time = $_arrival_time = $duration = $_duration = NULL;

            if (!empty($pickup_arr)) {
                $departure_time = pjUtil::formatTime($pickup_arr[0]['departure_time'], 'H:i:s', $this->option_arr['o_time_format']);
            }
            if (!empty($return_arr)) {
                $arrival_time = pjUtil::formatTime($return_arr[0]['arrival_time'], 'H:i:s', $this->option_arr['o_time_format']);
            }

            if (!empty($pickup_arr) && !empty($return_arr)) {
                $duration_arr = pjUtil::calDuration($pickup_arr[0]['departure_time'], $return_arr[0]['arrival_time']);
                $hour_str = $duration_arr['hours'] . ' ' . ($duration_arr['hours'] != 1 ? strtolower(__('front_hours', true, false)) : strtolower(__('front_hour', true, false)));
                $minute_str = $duration_arr['minutes'] > 0 ? ($duration_arr['minutes'] . ' ' . ($duration_arr['minutes'] != 1 ? strtolower(__('front_minutes', true, false)) : strtolower(__('front_minute', true, false))) ) : '';
                $duration = $hour_str . ' ' . $minute_str;
            }

            $pjBusModel = pjBusModel::factory();
            $bus_arr = $pjBusModel
                    ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->select("t1.*, t2.content as route_title")
                    ->find($bus_id)
                    ->getData();


            $bus_arr['departure_time'] = $departure_time;
            $bus_arr['arrival_time'] = $arrival_time;
            $bus_arr['duration'] = $duration;

            $pjPriceModel = pjPriceModel::factory();

            $ticket_price_arr = $pjPriceModel->getTicketPrice($bus_id, $pickupId, $returnId, $bookedData, $this->option_arr, $this->getLocaleId(), 'F');

            $filter('sub_total_format', $ticket_price_arr);
            $filter('tax_format', $ticket_price_arr);
            $filter('total_format', $ticket_price_arr);
            $filter('deposit_format', $ticket_price_arr);


            $res['bus_arr'] = $bus_arr;
            $res['ticket_arr'] = $ticket_price_arr['ticket_arr'];
            $res['price_arr'] = $ticket_price_arr;

            if ($isReturn == "T") {


                $return_bus_id = $bookedData['return_bus_id'];
                $return_ticket_price_arr = $pjPriceModel->getTicketPrice($return_bus_id, $returnId, $pickupId, $bookedData, $this->option_arr, $this->getLocaleId(), 'T');

                $res['return_ticket_arr'] = $return_ticket_price_arr['ticket_arr'];
                $res['return_price_arr'] = $return_ticket_price_arr;

                $_bus_arr = $pjBusModel
                        ->reset()
                        ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                        ->select("t1.*, t2.content as route_title")
                        ->find($return_bus_id)
                        ->getData();

                $_pickup_arr = $pjBusLocationModel->reset()->where('bus_id', $return_bus_id)->where("location_id", $returnId)->limit(1)->findAll()->getData();
                $_return_arr = $pjBusLocationModel->reset()->where('bus_id', $return_bus_id)->where("location_id", $pickupId)->limit(1)->findAll()->getData();

                if (!empty($_pickup_arr)) {
                    $_departure_time = pjUtil::formatTime($_pickup_arr[0]['departure_time'], 'H:i:s', $this->option_arr['o_time_format']);
                }
                if (!empty($_return_arr)) {
                    $_arrival_time = pjUtil::formatTime($_return_arr[0]['arrival_time'], 'H:i:s', $this->option_arr['o_time_format']);
                }
                if (!empty($_pickup_arr) && !empty($_return_arr)) {
                    $_duration_arr = pjUtil::calDuration($_pickup_arr[0]['departure_time'], $_return_arr[0]['arrival_time']);

                    $_hour_str = $_duration_arr['hours'] . ' ' . ($_duration_arr['hours'] != 1 ? strtolower(__('front_hours', true, false)) : strtolower(__('front_hour', true, false)));
                    $_minute_str = $_duration_arr['minutes'] > 0 ? ($_duration_arr['minutes'] . ' ' . ($_duration_arr['minutes'] != 1 ? strtolower(__('front_minutes', true, false)) : strtolower(__('front_minute', true, false))) ) : '';
                    $_duration = $_hour_str . ' ' . $_minute_str;
                }

                $_bus_arr['departure_time'] = $_departure_time;
                $_bus_arr['arrival_time'] = $_arrival_time;
                $_bus_arr['duration'] = $_duration;

                $_pickup_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($returnId)->getData();
                $_return_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($pickupId)->getData();
                $_from_location = $_pickup_location['name'];
                $_to_location = $_return_location['name'];

                $res['is_return'] = $isReturn;
                $res['return_from_location'] = $_from_location;
                $res['return_to_location'] = $_to_location;
                $res['return_bus_arr'] = $_bus_arr;
            }

            $pjSeatModel = pjSeatModel::factory();

            $selected_seat_arr = $pjSeatModel->whereIn('t1.id', explode("|", $bookedData['selected_seats']))->findAll()->getDataPair('id', 'name');
            $return_selected_seat_arr = (isset($bookedData['return_selected_seats']) && !empty($bookedData['return_selected_seats'])) ? $pjSeatModel->reset()->whereIn('t1.id', explode("|", $bookedData['return_selected_seats']))->findAll()->getDataPair('id', 'name') : array();



            $res['selected_seat_arr'] = $selected_seat_arr;
            $res['return_selected_seat_arr'] = $return_selected_seat_arr;
        }

        $country_arr = pjCountryModel::factory()
                        ->select('t1.id, t2.content AS country_title')
                        ->join('pjMultiLang', "t2.model='pjCountry' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                        ->orderBy('`country_title` ASC')->findAll()->getData();


        $terms_conditions = pjMultiLangModel::factory()->select('t1.*')
                        ->where('t1.model', 'pjOption')
                        ->where('t1.locale', $this->getLocaleId())
                        ->where('t1.field', 'o_terms')
                            ->limit(0, 1)
                            ->findAll()->getData();

            $res['from_location'] = $from_location;
            $res['to_location'] = $to_location;
            $res['country_arr'] = $country_arr;
            $res['terms_conditions'] = $terms_conditions[0]['content'];
            $res['status'] = 'OK';
        } else {
            $res['status'] = 'ERR';
        }

        pjAppController::jsonResponse($res);
    }

}
