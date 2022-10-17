<?php
if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

/**
 * Description of pjRouteCityBusStop
 *
 * @author alexp
 */
class pjRouteCityBusStopModel extends pjAppModel {

    protected $primaryKey = 'id';
    protected $table = 'routes_cities_bus_stops';
    
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'route_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'city_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'bus_stop_id', 'type' => 'int', 'default' => ':NULL')
    );
    

    public static function factory($attr = array()) {
        return new pjRouteCityBusStopModel($attr);
    }


}

