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
class pjApiRoutes extends pjApi {

    public function afterFilter() {
       
    }



    public function pjActionIndex() {
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
//        $this->setAjax(true);
////        
////        
//        $pjCityModel = pjCityModel::factory();
//
//        $dataCities = [];
//        $cities = $pjCityModel
//                ->reset()
//                ->select('t1.*, t2.content as name')
//                ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale=1", 'left outer')
//                ->where('is_ukraine = 0')
//                ->orderBy("t2.content ASC")
//                ->findAll()
//                ->getData();
//        
//        
//        foreach($cities as &$city){
//            if($city['name']){
//                $dataCities[$city['name']] = $city;
//            }
//        }
//        unset($cities);
//        
//        
//        $citiesGroupByCountry = [
//            'AT' => [],
//            'LU' => [],
//            'NL' => [],
//            'PL' => [],
//            'FR' => [],
//            'BE' => [],
//            'DE' => [],
//            'IT' => [],
//            'PL' => [],
//            'CZ' => [],
//            'SK' => [],
//            'CH' => [],
//            'MC' => [],
//            'SL' => [],
//            'ES' => [],
//        ];
//        
//        $files = [
//            'world_cities_array',
//            'world_cities_array_2',
//            'world_cities_array_3',
//            'world_cities_array_4',
//            'world_cities_array_5',
//            'world_cities_array_6'
//        ];
//        
//    foreach($files as $file){
//        require_once $file.'.php';
//
//        foreach($cities_array as &$cityItem){
//            
//            if(in_array($cityItem['country'], ['PL','FR','BE','DE','IT','PL','CZ','SK','SL']) && isset($cityItem['city'])){
//                if(!is_array($citiesGroupByCountry[$cityItem['country']])){
//                    $citiesGroupByCountry[$cityItem['country']] = [];
//                }
//                
//                $citiesGroupByCountry[$cityItem['country']][] = &$cityItem['city'];
//            }
//        }
//        
//        unset($cities_array);   
//    }
//        
//    foreach($citiesGroupByCountry as $countryAlpha2 => &$cities){
//        foreach($cities as $cityItem){
//            
//            if(isset($dataCities[$cityItem])){
//                $orderByCountry = 4;
//                
//                switch($countryAlpha2){
//                    case 'DE':
//                        $orderByCountry = 1;
//                        break;
//                    case 'FR':
//                        $orderByCountry = 2;
//                        break;
//                    case 'BE':
//                        $orderByCountry = 3;
//                        break;
//                    default:
//                        $orderByCountry = 4;
//                    
//                }
//                
//                $pjCityModel->reset()->where('id', $dataCities[$cityItem]['id'])->limit(1)->modifyAll([
//                    'order_by_country' => $orderByCountry,
//                    'country_alpha' => $countryAlpha2,
//                ]);
//            }
//            
//        }
//    }
    
//    vd($counter);
//    exit();
//        $routeModel = pjRouteModel::factory();
//        $routeCity = pjRouteCityModel::factory();
//        
//        $cities = $pjCityModel
//                ->reset()
//                ->select(" t1.*,t2.content as name")
//                ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale=3", 'INNER')
//                ->where('is_ukraine = 0 and order_by_country is not null and country_alpha is not null')
//                ->findAll()
//                ->getData();
        
//        vd($cities);
        
//        $ids = $dataCities = [];
//        foreach($cities as &$cityItem){
//            $dataCities[$cityItem['name']] = $cityItem;
//            $ids[] = $cityItem['id'];
//        }
//        
//        
//        
//        $routes = $routeModel
//                ->select(" t1.*,t2.content as city")
//                ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.id AND t2.field='from' AND t2.locale=3", 'INNER')
//                ->where('is_international = 1 and order_by_country is null')
//                ->findAll()
//                ->getData();
//        
////        vd($routes);
//        
//        
//        $cnt = 0;
//        foreach($routes as &$routeItem){
//            if(isset($dataCities[$routeItem['city']])){
////                $cnt++;
//                $routeModel->reset()->where('id', $routeItem['id'])->limit(1)->modifyAll([
//                    'order_by_country' => $dataCities[$routeItem['city']]['order_by_country'] + 4
//                ]);
//            }   
//        }
//        vd($cnt);
        
        
//        vd($dataCities);
        
        
//        $routeDetails = pjRouteDetailModel::factory()->whereIn('to_location_id',$ids)->findAll()->getData();
////        vd($routeDetails);
//        foreach($routeDetails as $routeItem){
//            
//            
//            if($dataCities[$routeItem['to_location_id']]){
//                $routeModel->reset()->where('id', $routeItem['route_id'])->limit(1)->modifyAll([
//                    'order_by_country' => $dataCities[$routeItem['to_location_id']]['order_by_country']
//                ]);
//            }
//        }
//        vd(array_column($cities,'id'));
        
        

    }
    
    
    public function pjActionInternational() {
        
        $data = [];
        
        $data['from'] = pjRouteModel::factory()
                    ->select(" t1.*, t2.content as title, t3.content as `from`, t4.content as `to`")
                    ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->join('pjMultiLang', "t3.model='pjRoute' AND t3.foreign_id=t1.id AND t3.field='from' AND t3.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->join('pjMultiLang', "t4.model='pjRoute' AND t4.foreign_id=t1.id AND t4.field='to' AND t4.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->where('is_international = 1 and order_by_country < 5')
                    ->orderBy('order_by_country ASC')
                    ->findAll()
                    ->getData();
        
        $data['to'] = pjRouteModel::factory()
                    ->select(" t1.*, t2.content as title, t3.content as `from`, t4.content as `to`")
                    ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->join('pjMultiLang', "t3.model='pjRoute' AND t3.foreign_id=t1.id AND t3.field='from' AND t3.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->join('pjMultiLang', "t4.model='pjRoute' AND t4.foreign_id=t1.id AND t4.field='to' AND t4.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->where('is_international = 1 and order_by_country > 4')
                    ->orderBy('order_by_country ASC')
                    ->findAll()
                    ->getData();
        
        pjAppController::jsonResponse($data);
        exit();
        
    }
    
}
