<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjDbSessionDataModel extends pjAppModel {

    public $data;
    protected $primaryKey = 'id';
    protected $table = 'db_session_data';
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'storage_key', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'data', 'type' => 'varchar', 'default' => ':NULL'),
    );

    public static function factory($attr = array()) {
        return new pjDbSessionDataModel($attr);
    }

    public function beforeSave($method) {
        if (is_array($this->data)) {

            $this->data = serialize($this->data);
        }
        return true;
    }

//    public function set(){
//        
//    }
//    
//    public function get(){
//        
//    }
//    
}

?>