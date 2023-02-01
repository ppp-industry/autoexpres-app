<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjBusTransferModel extends pjAppModel {

    protected $primaryKey = 'id';
    protected $table = 'transfer_buses';
    
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'bus_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'city_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'transfer_bus_id', 'type' => 'int', 'default' => ':NULL'),
    );

    public static function factory($attr = array()) {
        return new pjBusTransferModel($attr);
    }

}

?>