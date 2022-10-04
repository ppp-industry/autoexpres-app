<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

/** 
 * 
 * TODO ПЕРЕРАБОТАТЬ МЕХАНИЗМ РАБОТЫ ТАКИМ ОБРАЗОМ, ЧТОБЫ МОЖНО БЫЛО искать маршрутки с пересадками, 
 * тоесть если города недоступны напрямую, искать маршруты в которых есть точка А или Б 
 * 
 * **/
/**
 * Description of pjApiCities
 *
 * @author alexp
 */
class pjApiCities extends pjFront {
    
    
    public function pjActionIndex(){
        
        $pjCityModel = pjCityModel::factory();
        $pjRouteDetailModel = pjRouteDetailModel::factory();
        
        $from_location_arr = $pjCityModel
				->reset()
				->select('t1.*, t2.content as name')
				->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
				->where("t1.id IN(SELECT TRD.from_location_id FROM `".$pjRouteDetailModel->getTable()."` AS TRD)")
				->orderBy("t2.content ASC")
				->findAll()
				->getData();
				
        $to_location_arr = $pjCityModel
                ->reset()
                ->select('t1.*, t2.content as name')
                ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='".$this->getLocaleId()."'", 'left outer')
                ->where("t1.id IN(SELECT TRD.to_location_id FROM `".$pjRouteDetailModel->getTable()."` AS TRD)")
                ->orderBy("t2.content ASC")
                ->findAll()
                ->getData();
        $resp = [
            'from' => $from_location_arr,
            'to' => $to_location_arr,
        ];             
                        
        pjAppController::jsonResponse($resp);
        
    }
    
    public function pjActionGetLocations() {
        $needTransfer = function($cityId,$cities){
            return !in_array($cityId, $cities);
        };
        
        $params = Router::getParams();
        $this->setAjax(true);

        $pjCityModel = pjCityModel::factory();
        $pjRouteDetailModel = pjRouteDetailModel::factory();
        $location_arr = [];
        $locationArrReturn = $locationArrPickup = [];
        
        if (isset($params['pickup_id'])) {
            
            $withTransferSeparated = $withTransfer = [];
            
            $localeId = $this->getLocaleId();
            
            $joinCondition = "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $localeId . "'";
            
            $where = '';
            if (!empty($params['pickup_id'])) {
                $where = "t1.id IN(SELECT TRD.to_location_id FROM `{$pjRouteDetailModel->getTable()}` AS TRD WHERE TRD.from_location_id={pickupId})";
            }
            
            $locationArrPickup = $pjCityModel
                    ->reset()
                    ->select('t1.*, t2.content as name')
                    ->join('pjMultiLang', $joinCondition, 'left outer')
                    ->where(str_replace('{pickupId}', $params['pickup_id'], $where))
                    ->orderBy("t2.content ASC")
                    ->findAll()
                    ->getData();
            
            $inserted = array_column($locationArrPickup, 'id');
            $inserted[] = $params['pickup_id'];
            
            foreach ($locationArrPickup as &$location){
                $withTransfer[$location['id']] = $pjCityModel
                    ->reset()
                    ->select('t1.*, t2.content as name')
                    ->join('pjMultiLang', $joinCondition, 'left outer')
                    ->where(str_replace('{pickupId}', $location['id'], $where))
                    ->orderBy("t2.content ASC")
                    ->findAll()
                    ->getData();
            
            }
            
            foreach($withTransfer as $transferCity => $locations ){
                $withTransferSeparated[$transferCity] = array_values(
                    array_filter($locations, function($item) use (&$inserted){
                        if(!in_array($item['id'], $inserted)){
                            $inserted[] = $item['id'];
                            return true;
                        }
                        else{
                            return false;
                        }
                    })
                );
                
                
                if(empty($withTransferSeparated[$transferCity])){
                    unset($withTransferSeparated[$transferCity]);
                }
                
            }
            
//            $withTransferSeparated
            
            
            
            $location_arr['locations'] = $locationArrPickup;
            $location_arr['transfer'] = $withTransferSeparated;
            
            
        }
        
        pjAppController::jsonResponse($location_arr);
        
        
//        if (isset($params['return_id'])) {
//            $where = '';
//            if (!empty($params['return_id'])) {
//                $where = "WHERE TRD.to_location_id=" . $params['return_id'];
//            }
//            $locationArrReturn = $pjCityModel
//                    ->reset()
//                    ->select('t1.*, t2.content as name')
//                    ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
//                    ->where("t1.id IN(SELECT TRD.from_location_id FROM `" . $pjRouteDetailModel->getTable() . "` AS TRD $where)")
//                    ->orderBy("t2.content ASC")
//                    ->findAll()
//                    ->getData();
//        }
//
//        if(
//            isset($params['pickup_id'],$params['return_id']) 
//            && 
//            (
//                isset($params['with_transfer']) 
//                && 
//                $params['with_transfer'] == '1'
//            )
//            &&
//            $needTransfer(
//                $params['pickup_id'], 
//                array_column(
//                    $locationArrPickup, 
//                    'id'
//                )
//            )
//        ){
//            
//            $citiIdsPickup = array_column($locationArrPickup,'id');
//            $citiIdsReturn = array_column($locationArrReturn,'id');
//            $intersect = array_intersect($citiIdsPickup, $citiIdsReturn);
//            
//            $transferArr = array_filter($locationArrPickup,function($element) use (&$intersect){
//                return in_array($element['id'], $intersect);
//            });
//            
//            $values = array_values($transferArr);
//            $transferArr = array_combine(
//                    range(0, count($values) - 1), 
//                $values
//            );
//            
//            $this->_set('with_transfer', 1);
//            
//            $location_arr = [
//                'locations' => $locationArrReturn,
//                'transfer' => $transferArr
//            ];   
//        }
//        else{
//            $location_arr = [
//                'locations' => $locationArrPickup ? $locationArrPickup : ($locationArrReturn ? $locationArrReturn : [])
//            ];
//        }
//        
//        pjAppController::jsonResponse($location_arr);
    }
    
}
