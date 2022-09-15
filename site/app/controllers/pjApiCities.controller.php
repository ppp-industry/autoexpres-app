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
class pjApiCities extends pjAppController {
    
    
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
        $params = Router::getParams();
        $location_arr = [];
        
        $this->setAjax(true);

        $pjCityModel = pjCityModel::factory();
        $pjRouteDetailModel = pjRouteDetailModel::factory();

        if (isset($params['pickup_id'])) {
            $where = '';
            if (!empty($params['pickup_id'])) {
                $where = "WHERE TRD.from_location_id=" . $params['pickup_id'];
            }
            $location_arr = $pjCityModel
                    ->reset()
                    ->select('t1.*, t2.content as name')
                    ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->where("t1.id IN(SELECT TRD.to_location_id FROM `" . $pjRouteDetailModel->getTable() . "` AS TRD $where)")
                    ->orderBy("t2.content ASC")
                    ->findAll()
                    ->getData();
        }
        
        
        if (isset($params['return_id'])) {
            $where = '';
            if (!empty($params['return_id'])) {
                $where = "WHERE TRD.to_location_id=" . $params['return_id'];
            }
            $location_arr = $pjCityModel
                    ->reset()
                    ->select('t1.*, t2.content as name')
                    ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->where("t1.id IN(SELECT TRD.from_location_id FROM `" . $pjRouteDetailModel->getTable() . "` AS TRD $where)")
                    ->orderBy("t2.content ASC")
                    ->findAll()
                    ->getData();
        }

        $this->set('location_arr', $location_arr);
        
        pjAppController::jsonResponse($location_arr);
    }
    
}
