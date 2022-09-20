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
        $busIdFromTransfer = $busIdToTransfer = $transferId = null;
        
        if($this->_is('with_transfer')){

            $transferId = $this->_get('transferId');
            
            if (isset($_SESSION[$this->defaultStore]) && count($_SESSION[$this->defaultStore]) > 0 && $this->isBusReady() == true) {
                $pickupId = $this->_get('pickup_id');
                $returnId = $this->_get('return_id');
                $isReturn = $this->_get('is_return');

                $busIdToTransfer =  isset($params['bus_id_to']) && (int) $params['bus_id_to'] > 0 ? $params['bus_id_to'] : null;
                $busIdFromTransfer =  isset($params['bus_id_from']) && (int) $params['bus_id_from'] > 0 ? $params['bus_id_from'] : null;

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
        }
        else{
            
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
