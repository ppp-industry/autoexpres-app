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
        
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
       
        if(isset($params['from'],$params['to'])){
            $busList = [];
            
            $date = date('Y-m-d');
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
            

//            vd($routes);
            //                $busModel->where('route_id',$route['id']); 
            
            foreach ($routes as &$route){
                $bookedData = $bookingPeriod = array();
                
                $cities = $routeCityModel->where('route_id',$route['id'])
                                        ->orderBy('`order`')
                                        ->findAll()
                                        ->getData();
//                
                $fromCityId = array_shift($cities);
                $toCityId = array_pop($cities);
                
                
                $busIdsArr = $busModel->getBusIds($date,$fromCityId['city_id'],$toCityId['city_id']);
//                echo __LINE__;exit();
                if(!empty($busIdsArr)){
                    $busList = $this->getBusList($fromCityId['city_id'],$toCityId['city_id'], $busIdsArr, $bookingPeriod, $bookedData, $date, 'F');
                }
                
            }   
                
                
            pjAppController::jsonResponse($busList);
            exit();    
                 
        }        

    }
    
}
