<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjCityModel extends pjAppModel {

    protected $primaryKey = 'id';
    protected $table = 'cities';
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'enum', 'default' => 'T'),
        array('name' => 'is_ukraine', 'type' => 'smallint', 'default' => 0)
    );
    public $i18n = array('name');

    public static function factory($attr = array()) {
        return new pjCityModel($attr);
    }

}

?>