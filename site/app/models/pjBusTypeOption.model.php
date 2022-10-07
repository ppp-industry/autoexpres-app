<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjBusTypeOptionModel extends pjAppModel {

    protected $primaryKey = 'id';
    protected $table = 'bus_types_options';
    protected $schema = array(
        array('name' => 'id', 'type' => 'int','default' => ':NULL'),
        array('name' => 'option_id', 'type' => 'int','default' => ':NULL'),
        array('name' => 'bus_type_id', 'type' => 'int','default' => ':NULL'),
    );

    public static function factory($attr = array()) {
        return new pjBusTypeOptionModel($attr);
    }

}

?>
