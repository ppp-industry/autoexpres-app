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

    public function afterFilter(){}
	
    public function pjActionGetRoundtripPrice() {
        
        $params = Router::getParams();
        $ticketPriceArr = $returnTicketPriceArr = null;
        $subTotal = 0;
        $ret = [
            'total' => 0
        ];
        
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

        if($subTotal){
            $subTotal =  pjUtil::formatCurrencySign(number_format($subTotal, 2), $this->option_arr['o_currency'],'',false);
        }
        
        $ret['total'] = $subTotal;
        
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
//        echo __LINE__;exit();
        if (!isset($_SESSION[$this->defaultForm]) || count($_SESSION[$this->defaultForm]) === 0) {
            $_SESSION[$this->defaultForm] = array();
        }
        if (isset($_POST['step_checkout'])) {
            $_SESSION[$this->defaultForm] = $_POST;
        }

        $resp = array('code' => 200);
        pjAppController::jsonResponse($resp);
        
    }
    
}
