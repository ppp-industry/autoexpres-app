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
        ini_set("display_errors", "On");
        error_reporting(E_ALL ^ E_DEPRECATED);
        $this->setAjax(true);
        
        
        $pjCityModel = pjCityModel::factory();

        $cities = $pjCityModel
                ->reset()
                ->select('t1.*, t2.content as name')
                ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale=1", 'left outer')
                ->where('is_ukraine = 0')
                ->orderBy("t2.content ASC")
                ->findAll()
                ->getData();
        
        $citiesGroupByCountry = [
            'AT' => [],
            'LU' => [],
            'NL' => [],
            'PL' => [],
            'FR' => [],
            'BE' => [],
            'DE' => [],
            'IT' => [],
            'PL' => [],
            'CZ' => [],
            'SK' => [],
            'CH' => [],
            'MC' => [],
            'SL' => [],
            'ES' => [],
        ];
        
        $files = [
            'world_cities_array',
            'world_cities_array_2',
            'world_cities_array_3',
            'world_cities_array_4',
            'world_cities_array_5',
            'world_cities_array_6'
        ];
        
    foreach($files as $file){
        require_once $file.'.php';

        foreach($cities_array as &$cityItem){
            if(in_array($cityItem['country'], ['PL','FR','BE','DE','IT','PL','CZ','SK','SL'])){
                $citiesGroupByCountry[$cityItem['country']][] = &$cityItem;
            }
        }
        
        unset($cities_array);
        
    }
        
        
        
//        vd($cities_array);
        vd($citiesGroupByCountry);
        
//        /echo __DIR__;
        exit();

    }
}
