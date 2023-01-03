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
class pjApiTickets extends pjApi {

    public function afterFilter() {
       
    }
    public function pjActionToday() {
        
        $params = Router::getParams();
        $date = strtotime('tomorrow');
        $fromId = $toId = null;
        
        ini_set("display_errors", "On");
        error_reporting(E_ALL ^ E_DEPRECATED);
       
        if(isset($params['from'],$params['to'])){
            $busList = [];
            
            $date = date('Y-m-d',$date);
            $routeModel = pjRouteModel::factory();
            $routeCityModel = pjRouteCityModel::factory();
            $busModel = pjBusModel::factory();
            
            $routes = $routeModel
                    ->select(" t1.*,t2.content as `title`,t3.content as `from`,t4.content as `to`")
                    ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.id AND t2.field='title' ", 'INNER')
                    ->join('pjMultiLang', "t3.model='pjRoute' AND t3.foreign_id=t1.id AND t3.field='from' ", 'INNER')
                    ->join('pjMultiLang', "t4.model='pjRoute' AND t4.foreign_id=t1.id AND t4.field='to' ", 'INNER')
                    ->where('t3.content',$params['from'])
                    ->where('t4.content',$params['to'])
                    ->where('t2.locale = t3.locale')
                    ->groupBy('id')
                    ->findAll()
                    ->getData();
            
            $routes = null;
            
            
            
            if(is_array($routes) && count($routes)){
            
                foreach ($routes as &$route){
                    $bookedData = $bookingPeriod = array();
                    $cities = $routeCityModel->where('route_id',$route['id'])
                                            ->orderBy('`order`')
                                            ->findAll()
                                            ->getData();
            
                    $fromCityId = array_shift($cities);
                    $toCityId = array_pop($cities);

                    $busIds = $busModel->getBusIdsByRoutes($date,$route,true);

                    $fromId = $fromCityId['city_id'];
                    $toId = $toCityId['city_id'];
                    
                    if(empty($busIds)){
                        $busIds = $busModel->getBusIds($date,$fromId,$toId);
                    }   
                    
                    if(count($busIds)){
                        $busList = $this->getBusList($fromId,$toId, $busIds, $bookingPeriod, $bookedData, $date, 'F');
                    }
                }
            }
            else{
                
                $bookedData = $bookingPeriod = array();
                $from = pjMultiLangModel::factory()
                                        ->where('`model` = \'pjCity\'')
                                        ->where('`field` = \'name\'')
                                        ->where('content LIKE', "%{$params['from']}%")
                                        ->limit(1,0)
                                        ->findAll()
                                        ->getData();;
//                                        
                $to = pjMultiLangModel::factory()
                                        ->where('`model` = \'pjCity\'')
                                        ->where('`field` = \'name\'')
                                        ->where('content LIKE', "%{$params['to']}%")
                                        ->limit(1,0)
                                        ->findAll()
                                        ->getData();;
//                
                $fromId = $from[0]['foreign_id'];
                $toId = $to[0]['foreign_id'];
                
                $busIds = $busModel->getBusIds($date,$fromId,$toId);
                $busList = $this->getBusList($fromId,$toId, $busIds, $bookingPeriod, $bookedData, $date, 'F');
            }
            
//           через трансферы 
            if(empty($busList) && $fromId && $toId){

                $params = Router::getParams();
                $this->setAjax(true);

                $pjCityModel = pjCityModel::factory();
                $pjRouteDetailModel = pjRouteDetailModel::factory();
                $withTransferSeparated = $withTransfer = [];
                $localeId = $this->getLocaleId();

                $joinCondition = "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $localeId . "'";

                $where = "t1.id IN(SELECT TRD.to_location_id FROM `{$pjRouteDetailModel->getTable()}` AS TRD WHERE TRD.from_location_id={pickupId})";
                

                $locationArrPickup = $pjCityModel
                        ->reset()
                        ->select('t1.*, t2.content as name')
                        ->join('pjMultiLang', $joinCondition, 'left outer')
                        ->where(str_replace('{pickupId}', $fromId, $where))
                        ->orderBy("t2.content ASC")
                        ->findAll()
                        ->getData();
                
                
//                vd($locationArrPickup);


                $inserted = array_column($locationArrPickup, 'id');
                $inserted[] = $fromId;

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
                
                $withTransferIds = [];

                foreach($withTransfer as $transferCity => $locations ){
                    $withTransferSeparated[$transferCity] = array_values(
                        array_filter($locations, function($item) use (&$inserted){
                            if(!in_array($item['id'], $inserted)){
                                return true;
                            }
                            else{
                                return false;
                            }
                        })
                    );

                    $withTransferIds[$transferCity] = array_column($withTransferSeparated[$transferCity], 'id');

                    if(empty($withTransferSeparated[$transferCity])){
                        unset($withTransferSeparated[$transferCity],$withTransferIds[$transferCity]);
                    }       
                    
                }
                
                
                $busIdArr = $busModel->getBusIds($date,$fromId,$toId, false,$withTransferIds);
                $bookedData = $bookingPeriod = array();
                $busList = $this->getBusList($fromId,$toId, $busIdArr, $bookingPeriod, $bookedData, $date, 'F');

                
            }
                
            pjAppController::jsonResponse($busList);
            exit();    
                 
        }        

    }
    
}
