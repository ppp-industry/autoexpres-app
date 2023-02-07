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
class pjApiBuses extends pjApi {

    public function afterFilter(){}
            
            
    public function pjActionIndex(){
        
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $localeId = $this->getLocaleId();
        $isUkr = isset($_GET['is_ukr']) ? ($_GET['is_ukr'] == '1') : false;
        $pjRouteCityModel = pjRouteCityModel::factory();
        
        
        $pjBusModel = pjBusModel::factory()
                    ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.route_id AND t2.field='title' AND t2.locale='{$localeId}'", 'left outer')
                    ->join('pjRoute', "t3.id = t1.route_id", 'inner')
                    ->where('is_international',$isUkr ? 0 : 1)
                    ->groupBy('t1.id')
                    ->select('t1.*,t2.content,t3.country_alpha');
                    
        if(!$isUkr){
            $pjBusModel->orderBy('order_by_country');
        }
                    
        
        $total = $pjBusModel->findCount()->getData();
        
        $rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 50;
        $pages = ceil($total / $rowCount);
        $page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
        $offset = ((int) $page - 1) * $rowCount;
        if ($page > $pages) {
            $page = $pages;
        }
        
        $data = $pjBusModel->select(" t1.*, t2.content AS route,t3.country_alpha")->limit($rowCount, $offset)->findAll()->getData();

        
         foreach($data as &$busItem){
                $busItem['locations'] = $pjRouteCityModel->reset()
                    ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.city_id AND t2.field='name' AND t2.locale='{$localeId}'", 'left outer')
                    ->join('pjBusLocation', "(t3.bus_id='" . $busItem ['id'] . "' AND t3.location_id=t1.city_id", 'inner')
                    ->select("t1.*, t2.content as name, t3.departure_time, t3.arrival_time")
                    ->where('t1.route_id', $busItem ['route_id'])
                    ->orderBy("`order` ASC")
                    ->findAll()
                    ->getData();
        }
        
        
        
        pjAppController::jsonResponse($data);
        
    }
    
    public function pjActionCheck() {
// переработать метод для работы с пересадками
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $params = Router::getParams();
        $localeId = $this->getLocaleId();

        $pjPriceModel = pjPriceModel::factory();
        $transferIds = null;
        $resp = [];
        $busIdArr = $returnBusIdArr = array();
        
        $pickupId = $params['pickup_id'];
        $returnId = $params['return_id'];
        
        $filter = function(&$busIdArr,$pickupId, $returnId, $localeId) use ($pjPriceModel){
            
            if(isset($busIdArr['transferIds'])){
                
                foreach($busIdArr['transferIds'] as $city => &$busess) {

                    foreach($busess['to'] as $key => &$busId){
                        $arr = $pjPriceModel->getTicketArr($busId, $pickupId, $returnId, $localeId);

                        if(empty($arr)){
                            continue;;
                        }

                        if (is_null($arr[0]['price'])) {
                            unset($busIdArr['transferIds'][$city]['to'][$key]);
                        }
                    }

                    foreach($busess['from'] as $key => &$busId){
                        $arr = $pjPriceModel->getTicketArr($busId, $pickupId, $returnId, $localeId);

                        if(empty($arr)){
                            continue;;
                        }

                        if (is_null($arr[0]['price'])) {
                            unset($busIdArr['transferIds'][$city]['from'][$key]);
                        }
                    }
                }
            }
            else{
                if($busIdArr){
                    foreach($busIdArr as $key => $busId){
                        $arr = $pjPriceModel->getTicketArr($busId, $pickupId, $returnId, $localeId);

                        if (is_null($arr[0]['price'])) {
                            unset($busIdArr[$key]);
                        }
                    }    
                }
            }  
        };
        
        if(isset($params['transfer_id'])){
            $transferIds = [
                $params['transfer_id'] => [$pickupId,$returnId]
            ];
        }
        else{
            if($this->_is('transferIds')){
                $transferIds = unserialize($this->_get('transferIds'));            
            }
        }
        
        if(strtotime('today midnight') > strtotime($params['date'])){
            $resp['code'] = 100;
            pjAppController::jsonResponse($resp);
        }
        
        if ($params['pickup_id'] != $params['return_id']) {
            $resp['code'] = 200;

            $pjBusModel = pjBusModel::factory();
            

            $date = pjUtil::formatDate($params['date'], $this->option_arr['o_date_format']);
            if (isset($params['final_check'])) {
                $date = pjUtil::formatDate($this->_get('date'), $this->option_arr['o_date_format']);
            }
           

            if (isset($params['is_return']) && $params['is_return'] == 'T') {

                $returnDate = pjUtil::formatDate($params['return_date'], $this->option_arr['o_date_format']);
             
                $busIdArr = $pjBusModel->getBusIds($date,$pickupId,$returnId, true,$transferIds);
                $returnBusIdArr = $pjBusModel->getBusIds($returnDate,$returnId,$pickupId, true,$transferIds);
                
                $filter($busIdArr,$pickupId, $returnId, $localeId);
                $filter($returnBusIdArr,$returnId, $pickupId, $localeId);
                
                
                if (empty($returnBusIdArr)) {
                    
                    $resp['code'] = 101;
                    if (!isset($params['final_check'])) {
                        if ($this->_is('return_bus_id_arr')) {
                            $this->_remove('return_bus_id_arr');
                        }
                    }
                    pjAppController::jsonResponse($resp);
                }
            } 
            else {
                
                $busIdArr = $pjBusModel->getBusIds($date, $pickupId, $returnId, false,$transferIds);
                
                $filter($busIdArr,$pickupId, $returnId, $localeId);
                
                if (empty($busIdArr)) {
                    
                    $busIdArr = pjBusTransferModel::factory()->getBusIdsThroughManualTransfer($pickupId, $returnId,$params['transfer_id']);
                }
                
                if (empty($busIdArr) || is_null($busIdArr) ) {
                    
                    $resp['code'] = 100;
                    if (!isset($params['final_check'])) {
                        if ($this->_is('bus_id_arr')) {
                            $this->_remove('bus_id_arr');
                        }
                    }
                    
                    
                    pjAppController::jsonResponse($resp);
                }
                
                if (!isset($params['final_check'])) {
                    if ($this->_is('return_bus_id_arr')) {
                        $this->_remove('return_bus_id_arr');
                    }
                    if ($this->_is('return_date')) {
                        $this->_remove('return_bus_id_arr');
                    }
                }
            }

            if (!isset($params['final_check'])) {
                
                $this->_set('pickup_id', $params['pickup_id']);
                $this->_set('return_id', $params['return_id']);
                $this->_set('bus_id_arr', $busIdArr);
                $this->_set('is_return', isset($params['is_return']) ? $params['is_return'] : false);
                $this->_set('date', $params['date']);
                
                if (isset($params['is_return']) && $params['is_return'] == 'T') {
                    $this->_set('return_bus_id_arr', $returnBusIdArr);
                    $this->_set('return_date', $params['return_date']);
                }
                
                if ($this->_is('booked_data')) {
                    $this->_remove('booked_data');
                }
                
                if ($this->_is('bus_id')) {
                    $this->_remove('bus_id');
                }                
                
                $resp['code'] = 200;
                pjAppController::jsonResponse($resp);
            } 
            else {
                $store = $this->_getStore();
                
                $availArr = $this->getBusAvailability($store['booked_data']['bus_id'], $store, $this->option_arr);
                
                $bookedSeatArr = $availArr['booked_seat_arr'];
                $seatIdArr = explode("|", $store['booked_data']['selected_seats']);
                $intersect = array_intersect($bookedSeatArr, $seatIdArr);
                if (!empty($intersect)) {
                    
                    $resp['code'] = 100;
                } else {
                    $resp['code'] = 200;
                }
                pjAppController::jsonResponse($resp);
            }
        }
        pjAppController::jsonResponse($resp);
    }
    
    public function pjActionSeats() {

//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $this->_set('2_passed', true);
        
        
        $returnBusList = $busList = [];
        
        if ($this->checkStore() && $this->isBusReady() == true) {
            $bookedData = $bookingPeriod = array();
            
            if ($this->_is('booking_period')) {
                $bookingPeriod = $this->_get('booking_period');
            }
            
            if ($this->_is('booked_data')) {
                $bookedData = $this->_get('booked_data');
            } 
            
            $pickupId = $this->_get('pickup_id');
            $returnId = $this->_get('return_id');

            if ($this->_is('bus_id_arr')) {
                
                $busIdArr = $this->_get('bus_id_arr');
                
//                vd($busIdArr);
                
                
                $date = $this->_get('date');
                $busList = $this->getBusList($pickupId, $returnId, $busIdArr, $bookingPeriod, $bookedData, $date, 'F');
            }
            if ($this->_is('return_bus_id_arr')) {
                $busIdArr = $this->_get('return_bus_id_arr');
                $date = $this->_get('return_date');
                $returnBusList = $this->getBusList($returnId,$pickupId, $busIdArr, $bookingPeriod, $bookedData, $date, 'T');
                $keys = array_keys($returnBusList);
                
                array_walk($keys, function(&$item){
                    $item .= '_return';
                });
                
                $busList += array_combine($keys, array_values($returnBusList));  
            }
        }
        
        pjAppController::jsonResponse($busList);
    }

}
