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
class pjApiBooking extends pjFront {

    public function afterFilter() {
        
    }

    public function pjActionGetRoundtripPrice() {

        $params = Router::getParams();
        $ticketPriceArr = $returnTicketPriceArr = null;
        $subTotal = 0;
        $ret = [
            'total' => 0
        ];
        $busIdFromTransfer = $busIdToTransfer = $transferId = null;

        if ($this->_is('with_transfer')) {

            $transferId = $this->_get('transferId');

            if (isset($_SESSION[$this->defaultStore]) && count($_SESSION[$this->defaultStore]) > 0 && $this->isBusReady() == true) {
                $pickupId = $this->_get('pickup_id');
                $returnId = $this->_get('return_id');
                $isReturn = $this->_get('is_return');

                $busIdToTransfer = isset($params['bus_id_to']) && (int) $params['bus_id_to'] > 0 ? $params['bus_id_to'] : null;
                $busIdFromTransfer = isset($params['bus_id_from']) && (int) $params['bus_id_from'] > 0 ? $params['bus_id_from'] : null;

                $pjPriceModel = pjPriceModel::factory();

                if ($busIdToTransfer) {
                    $ticketPriceArr = $pjPriceModel->getTicketPrice($busIdToTransfer, $pickupId, $transferId, $params, $this->option_arr, $this->getLocaleId(), 'F');

                    $ret['total'] += $ret['total_to'] = $ticketPriceArr['total'];
                    $ret['total_to_format'] = $ticketPriceArr['total_format'];
                }

                if ($busIdFromTransfer) {
                    $ticketPriceArr = $pjPriceModel->getTicketPrice($busIdFromTransfer, $transferId, $returnId, $params, $this->option_arr, $this->getLocaleId(), 'F');

                    $ret['total'] += $ret['total_from'] = $ticketPriceArr['total'];
                    $ret['total_from_format'] = $ticketPriceArr['total_format'];
                }

                $ret['total_format'] = pjUtil::formatCurrencySign(number_format($ret['total'], 2), $this->option_arr['o_currency']);
            }
        } else {

            if (isset($_SESSION[$this->defaultStore]) && count($_SESSION[$this->defaultStore]) > 0 && $this->isBusReady() == true) {
                $pickupId = $this->_get('pickup_id');
                $returnId = $this->_get('return_id');
                $isReturn = $this->_get('is_return');

                $busId = isset($params['bus_id']) && (int) $params['bus_id'] > 0 ? $params['bus_id'] : 0;
                $returnBusId = isset($params['return_bus_id']) && (int) $params['return_bus_id'] > 0 ? $params['return_bus_id'] : 0;

                $pjPriceModel = pjPriceModel::factory();

                if ($busId > 0) {
                    $ticketPriceArr = $pjPriceModel->getTicketPrice($busId, $pickupId, $returnId, $params, $this->option_arr, $this->getLocaleId(), 'F');
                }

                if ($returnBusId > 0 && $isReturn == "T") {
                    $returnTicketPriceArr = $pjPriceModel->getTicketPrice($returnBusId, $returnId, $pickupId, $params, $this->option_arr, $this->getLocaleId(), 'T');
                }
            }

            if ($ticketPriceArr) {
                $subTotal += $ticketPriceArr['sub_total'];
            }

            if ($returnTicketPriceArr) {
                $subTotal += $returnTicketPriceArr['sub_total'];
            }

            if ($subTotal) {
                $subTotal = pjUtil::formatCurrencySign(number_format($subTotal, 2), $this->option_arr['o_currency'], '', false);
            }

            $ret['total'] = $subTotal;
        }

        pjAppController::jsonResponse($ret);
    }

    public function pjActionSaveTickets() {

        $this->setAjax(true);
        $resp = array();
        $resp['code'] = 200;
        $this->_set('booked_data', $_POST);
        pjAppController::jsonResponse($resp);
    }

    public function pjActionSaveForm() {
        if (!isset($_SESSION[$this->defaultForm]) || count($_SESSION[$this->defaultForm]) === 0) {
            $_SESSION[$this->defaultForm] = array();
        }
        if (isset($_POST['step_checkout'])) {
            $_SESSION[$this->defaultForm] = $_POST;
        }

        $resp = array('code' => 200);
        pjAppController::jsonResponse($resp);
    }

    public function pjActionSaveBooking() {
        $this->setAjax(true);

        if ($this->isXHR()) {
            $STORE = @$_SESSION [$this->defaultStore];
            $FORM = @$_SESSION [$this->defaultForm];
            $booked_data = @$STORE ['booked_data'];

            $pjBookingModel = pjBookingModel::factory();

            $bus_id = $booked_data ['bus_id'];
            $return_bus_id = isset($booked_data ['return_bus_id']) ? $booked_data ['return_bus_id'] : 0;
            $pickup_id = $this->_get('pickup_id');
            $return_id = $this->_get('return_id');
            $is_return = $this->_get('is_return');

            $depart_arrive = '';

            $bus_arr = pjBusModel::factory()->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjBusType', "t3.id=t1.bus_type_id", 'left')->select('t1.*, t3.seats_map, t2.content as route')->find($bus_id)->getData();
            if (!empty($bus_arr ['departure_time']) && !empty($bus_arr ['arrival_time'])) {
                $depart_arrive = pjUtil::formatTime($bus_arr ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']) . ' - ' . pjUtil::formatTime($bus_arr ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
            }

            $pjCityModel = pjCityModel::factory();
            $pickup_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($pickup_id)->getData();
            $return_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($return_id)->getData();
            $from_location = $pickup_location ['name'];
            $to_location = $return_location ['name'];

            $data = array();
            $data ['bus_id'] = $bus_id;
            $data ['uuid'] = time();
            $data ['ip'] = pjUtil::getClientIp();
            $data ['booking_date'] = pjUtil::formatDate($this->_get('date'), $this->option_arr ['o_date_format']);
            if ($is_return == 'T') {
                $data ['return_date'] = pjUtil::formatDate($this->_get('return_date'), $this->option_arr ['o_date_format']);
            }
            $data ['booking_datetime'] = $data ['booking_date'];
            if (isset($STORE ['booking_period'] [$bus_id])) {
                $data ['booking_datetime'] = $STORE ['booking_period'] [$bus_id] ['departure_time'];
                $data ['stop_datetime'] = $STORE ['booking_period'] [$bus_id] ['arrival_time'];
            }
            $data ['status'] = $this->option_arr ['o_booking_status'];

            $payment = 'none';
            if (isset($FORM ['payment_method'])) {
                if ($FORM ['payment_method'] && $FORM ['payment_method'] == 'creditcard') {
                    $data ['cc_exp'] = $FORM ['cc_exp_year'] . '-' . $FORM ['cc_exp_month'];
                }

                if ($FORM ['payment_method']) {
                    $payment = $FORM ['payment_method'];
                }
            }

            $bt_arr = array();
            $pjBusLocationModel = pjBusLocationModel::factory();
            $_arr = $pjBusLocationModel->where('bus_id', $bus_id)->where("location_id", $pickup_id)->limit(1)->findAll()->getData();
            if (count($_arr) > 0) {
                $bt_arr [] = pjUtil::formatTime($_arr [0] ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']);
                $data ['booking_datetime'] .= ' ' . $_arr [0] ['departure_time'];
            }

            $_arr = $pjBusLocationModel->reset()->where('bus_id', $bus_id)->where("location_id", $return_id)->limit(1)->findAll()->getData();
            if (count($_arr) > 0) {
                $bt_arr [] = pjUtil::formatTime($_arr [0] ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
            }
            $data ['booking_time'] = join(" - ", $bt_arr);
            $data ['pickup_id'] = $pickup_id;
            $data ['return_id'] = $return_id;
            $data ['is_return'] = $is_return;
            $data ['booking_route'] = $bus_arr ['route'] . ', ' . $depart_arrive . '<br/>';

            $data ['booking_route'] .= __('front_from', true, false) . ' ' . $from_location . ' ' . __('front_to', true, false) . ' ' . $to_location;

            $id = $pjBookingModel->setAttributes(array_merge($FORM, $data))->insert()->getInsertId();

            if ($id !== false && (int) $id > 0) {
                $back_insert_id = 0;
                if ($is_return == 'T') {
                    $child_bus_arr = pjBusModel::factory()->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjBusType', "t3.id=t1.bus_type_id", 'left')->select('t1.*, t3.seats_map, t2.content as route')->find($return_bus_id)->getData();

                    if (!empty($child_bus_arr ['departure_time']) && !empty($child_bus_arr ['arrival_time'])) {
                        $depart_arrive = pjUtil::formatTime($child_bus_arr ['departure_time'], "H:i:s", $this->option_arr ['o_time_format']) . ' - ' . pjUtil::formatTime($child_bus_arr ['arrival_time'], "H:i:s", $this->option_arr ['o_time_format']);
                    }
                    $bt_arr = array();
                    $pjBusLocationModel = pjBusLocationModel::factory();
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
                    if (isset($STORE ['booking_period'] [$return_bus_id])) {
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

                $ticket_arr = pjPriceModel::factory()->select("t1.*")->where('t1.bus_id', $bus_id)->where('t1.from_location_id', $pickup_id)->where('t1.to_location_id', $return_id)->where('is_return = "F"')->findAll()->getData();

                $location_arr = pjRouteCityModel::factory()->getLocations($bus_arr ['route_id'], $pickup_id, $return_id);
                $location_pair = array();
                for ($i = 0; $i < count($location_arr); $i++) {
                    $j = $i + 1;
                    if ($j < count($location_arr)) {
                        $location_pair [] = $location_arr [$i] ['city_id'] . '-' . $location_arr [$j] ['city_id'];
                    }
                }
                $pjBookingTicketModel = pjBookingTicketModel::factory();
                foreach ($ticket_arr as $k => $v) {
                    if (isset($booked_data ['ticket_cnt_' . $v ['ticket_id']]) && $booked_data ['ticket_cnt_' . $v ['ticket_id']] > 0) {
                        $data = array();
                        $data ['booking_id'] = $id;
                        $data ['ticket_id'] = $v ['ticket_id'];
                        $data ['qty'] = $booked_data ['ticket_cnt_' . $v ['ticket_id']];
                        $data ['amount'] = $data ['qty'] * $v ['price'];
                        $data ['is_return'] = 'F';
                        $pjBookingTicketModel->reset()->setAttributes($data)->insert();
                    }
                }

                $pjBookingSeatModel = pjBookingSeatModel::factory();

                $seat_id_arr = explode("|", $booked_data ['selected_seats']);

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
                                    $data ['seat_id'] = $seat_id_arr [$k];
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

                if ($is_return == 'T') {
                    $ticket_arr = pjPriceModel::factory()->select("t1.*, t2.discount")->join('pjBus', 't1.bus_id = t2.id', 'left')->where('t1.bus_id', $return_bus_id)->where('t1.from_location_id', $return_id)->where('t1.to_location_id', $pickup_id)->where('is_return = "F"')->findAll()->getData();

                    $location_arr = pjRouteCityModel::factory()->getLocations($bus_arr ['route_id'], $pickup_id, $return_id);
                    $location_pair = array();
                    for ($i = 0; $i < count($location_arr); $i++) {
                        $j = $i + 1;
                        if ($j < count($location_arr)) {
                            $location_pair [] = $location_arr [$i] ['city_id'] . '-' . $location_arr [$j] ['city_id'];
                        }
                    }
                    $pjBookingTicketModel = pjBookingTicketModel::factory();
                    foreach ($ticket_arr as $k => $v) {
                        if (isset($booked_data ['return_ticket_cnt_' . $v ['ticket_id']]) && $booked_data ['return_ticket_cnt_' . $v ['ticket_id']] > 0) {
                            $price = $v ['price'] - ($v ['price'] * $v ['discount'] / 100);
                            $data = array();
                            $data ['booking_id'] = $back_insert_id;
                            $data ['ticket_id'] = $v ['ticket_id'];
                            $data ['qty'] = $booked_data ['return_ticket_cnt_' . $v ['ticket_id']];
                            $data ['amount'] = $data ['qty'] * $price;
                            $data ['is_return'] = 'T';
                            $pjBookingTicketModel->reset()->setAttributes($data)->insert();
                        }
                    }

                    $seat_id_arr = explode("|", $booked_data ['return_selected_seats']);
                    foreach ($location_pair as $pair) {
                        $_arr = explode("-", $pair);
                        $kk = 0;
                        foreach ($ticket_arr as $j => $v) {
                            if (isset($booked_data ['return_ticket_cnt_' . $v ['ticket_id']]) && $booked_data ['return_ticket_cnt_' . $v ['ticket_id']] > 0) {
                                $qty = $booked_data ['return_ticket_cnt_' . $v ['ticket_id']];
                                if ($qty > 0) {
                                    for ($i = 1; $i <= $qty; $i++) {
                                        $data = array();
                                        $data ['booking_id'] = $back_insert_id;
                                        $data ['seat_id'] = $seat_id_arr [$kk];
                                        $data ['ticket_id'] = $v ['ticket_id'];

                                        $data ['start_location_id'] = $_arr [1];
                                        $data ['end_location_id'] = $_arr [0];
                                        $data ['is_return'] = 'T';

                                        $pjBookingSeatModel->reset()->setAttributes($data)->insert();

                                        $kk++;
                                    }
                                }
                            }
                        }
                    }
                }

                $arr = $pjBookingModel->reset()->select('t1.*, t2.departure_time, t2.arrival_time, t3.content as route_title, t4.content as from_location, t5.content as to_location')->join('pjBus', "t2.id=t1.bus_id", 'left outer')->join('pjMultiLang', "t3.model='pjRoute' AND t3.foreign_id=t2.route_id AND t3.field='title' AND t3.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjMultiLang', "t4.model='pjCity' AND t4.foreign_id=t1.pickup_id AND t4.field='name' AND t4.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjMultiLang', "t5.model='pjCity' AND t5.foreign_id=t1.return_id AND t5.field='name' AND t5.locale='" . $this->getLocaleId() . "'", 'left outer')->find($id)->getData();

                $tickets = pjBookingTicketModel::factory()->join('pjMultiLang', "t2.model='pjTicket' AND t2.foreign_id=t1.ticket_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjTicket', "t3.id=t1.ticket_id", 'left')->select('t1.*, t2.content as title')->where('booking_id', $arr ['id'])->findAll()->getData();

                $arr ['tickets'] = $tickets;

                $payment_data = array();
                $payment_data ['booking_id'] = $arr ['id'];
                $payment_data ['payment_method'] = $payment;
                $payment_data ['payment_type'] = 'online';
                $payment_data ['amount'] = $arr ['deposit'];
                $payment_data ['status'] = 'notpaid';
                pjBookingPaymentModel::factory()->setAttributes($payment_data)->insert();

                pjFrontEnd::pjActionConfirmSend($this->option_arr, $arr, PJ_SALT, 'confirm');

                if ($is_return == 'T') {
                    $return_arr = $pjBookingModel->reset()->select('t1.*, t2.departure_time, t2.arrival_time, t3.content as route_title, t4.content as from_location, t5.content as to_location')->join('pjBus', "t2.id=t1.bus_id", 'left outer')->join('pjMultiLang', "t3.model='pjRoute' AND t3.foreign_id=t2.route_id AND t3.field='title' AND t3.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjMultiLang', "t4.model='pjCity' AND t4.foreign_id=t1.pickup_id AND t4.field='name' AND t4.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjMultiLang', "t5.model='pjCity' AND t5.foreign_id=t1.return_id AND t5.field='name' AND t5.locale='" . $this->getLocaleId() . "'", 'left outer')->find($arr ['back_id'])->getData();

                    $return_tickets = pjBookingTicketModel::factory()->join('pjMultiLang', "t2.model='pjTicket' AND t2.foreign_id=t1.ticket_id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->join('pjTicket', "t3.id=t1.ticket_id", 'left')->select('t1.*, t2.content as title')->where('booking_id', $arr ['back_id'])->findAll()->getData();

                    $return_arr ['tickets'] = $return_tickets;

                    pjFrontEnd::pjActionConfirmSend($this->option_arr, $return_arr, PJ_SALT, 'confirm');
                }

                unset($_SESSION [$this->defaultStore]);
                unset($_SESSION [$this->defaultForm]);
                unset($_SESSION [$this->defaultStep]);

                $json = array(
                    'code' => 200,
                    'text' => '',
                    'booking_id' => $id,
                    'payment' => $payment
                );
            } else {
                $json = array(
                    'code' => 100,
                    'text' => ''
                );
            }
            pjAppController::jsonResponse($json);
        }
    }

    public function pjActionCheckout() {
        if ($this->isXHR() || isset($_GET['_escaped_fragment_'])) {

            $transferId = $this->_get('transferId');

            $_SESSION[$this->defaultStep]['3_passed'] = true;

            if (isset($_SESSION[$this->defaultStore]) && count($_SESSION[$this->defaultStore]) > 0 && $this->isBusReady() == true) {
                $bookedData = $this->_get('booked_data');

                $pickupId = $this->_get('pickup_id');
                $returnId = $this->_get('return_id');
                $isReturn = $this->_get('is_return');
                $pjBusLocationModel = pjBusLocationModel::factory();
                
                if ($transferId) {
                    
                    $departure_time  = $_departure_time = $arrival_time = $_arrival_time = $duration = $_duration = NULL;
                    $busIdToTransfer =  $bookedData['bus_id_to'];
                    $busIdFromTransfer = $bookedData['bus_id_from'];
//                    
                    $transferArrTo = $pjBusLocationModel->reset()->where('bus_id', $busIdToTransfer)->where("location_id", $transferId)->limit(1)->findAll()->getData();
                    
                    
                    $transferArrFrom = $pjBusLocationModel->reset()->where('bus_id', $busIdFromTransfer)->where("location_id", $transferId)->limit(1)->findAll()->getData();
                    
                    
                    
                    
                    
//                    
//                    if (!empty($transferArrTo)) {
//                        $departure_time = pjUtil::formatTime($pickup_arr[0]['departure_time'], 'H:i:s', $this->option_arr['o_time_format']);
//                    }
//                    if (!empty($transferArrFrom)) {
//                        $arrival_time = pjUtil::formatTime($return_arr[0]['arrival_time'], 'H:i:s', $this->option_arr['o_time_format']);
//                    }
//  
//                    
                    
                }
                else {
                    
                    $pickup_arr = $pjBusLocationModel->where('bus_id', $bus_id)->where("location_id", $pickupId)->limit(1)->findAll()->getData();
                    $return_arr = $pjBusLocationModel->reset()->where('bus_id', $bus_id)->where("location_id", $returnId)->limit(1)->findAll()->getData();

                    $bus_id = $bookedData['bus_id'];
                    $departure_time  = $_departure_time = $arrival_time = $_arrival_time = $duration = $_duration = NULL;

                    
                    

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

                    $pjCityModel = pjCityModel::factory();
                    $pickup_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($pickupId)->getData();
                    $return_location = $pjCityModel->reset()->select('t1.*, t2.content as name')->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->find($returnId)->getData();
                    $from_location = $pickup_location['name'];
                    $to_location = $return_location['name'];

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

                    $this->set('from_location', $from_location);
                    $this->set('to_location', $to_location);
                    $this->set('bus_arr', $bus_arr);
                    $this->set('ticket_arr', $ticket_price_arr['ticket_arr']);
                    $this->set('price_arr', $ticket_price_arr);

                    if ($isReturn == "T") {
                        $return_bus_id = $bookedData['return_bus_id'];

                        $return_ticket_price_arr = $pjPriceModel->getTicketPrice($return_bus_id, $returnId, $pickupId, $bookedData, $this->option_arr, $this->getLocaleId(), 'T');

                        $this->set('return_ticket_arr', $return_ticket_price_arr['ticket_arr']);
                        $this->set('return_price_arr', $return_ticket_price_arr);

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

                        $this->set('is_return', $isReturn);
                        $this->set('return_from_location', $_from_location);
                        $this->set('return_to_location', $_to_location);
                        $this->set('return_bus_arr', $_bus_arr);
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

                    $pjSeatModel = pjSeatModel::factory();

                    $selected_seat_arr = $pjSeatModel->whereIn('t1.id', explode("|", $bookedData['selected_seats']))->findAll()->getDataPair('id', 'name');
                    $return_selected_seat_arr = (isset($bookedData['return_selected_seats']) && !empty($bookedData['return_selected_seats'])) ? $pjSeatModel->reset()->whereIn('t1.id', explode("|", $bookedData['return_selected_seats']))->findAll()->getDataPair('id', 'name') : array();




                    $this->set('selected_seat_arr', $selected_seat_arr);
                    $this->set('return_selected_seat_arr', $return_selected_seat_arr);


                    $this->set('country_arr', $country_arr);



                    $this->set('terms_conditions', $terms_conditions[0]['content']);

                    $this->set('status', 'OK');
                }
            } else {
                $this->set('status', 'ERR');
            }
        }
    }

}
