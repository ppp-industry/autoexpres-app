<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjBusStopModel extends pjAppModel {

    protected $primaryKey = 'id';
    protected $table = 'bus_stops';
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'address', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'location_id', 'type' => 'int', 'default' => ':NULL')
    );
    
    public $i18n = ['name','address'];

    public static function factory($attr = array()) {
        return new pjBusStopModel($attr);
    }


}

?>