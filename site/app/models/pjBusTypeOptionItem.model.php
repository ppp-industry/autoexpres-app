<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjBusTypeOptionItemModel extends pjAppModel {

    protected $primaryKey = 'id';
    protected $table = 'bus_types_options_items';
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'name', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'svg_source', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'order', 'type' => 'int', 'default' => ':NULL')
    );

    public static function factory($attr = array()) {
        return new pjBusTypeOptionItemModel($attr);
    }

}

?>
