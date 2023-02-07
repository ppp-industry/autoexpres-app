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
    
    
    
    public function getBusIdsThroughManualTransfer($pickup_id, $return_id,&$transferIds) {      
//        echo __LINE__;exit();
//        vd($transferIds);
        
        $res = $this
                ->reset()
                ->select("
                    t1.bus_id,
                    t1.transfer_bus_id,
                    t1.city_id as transfer_location,
                    t2.location_id as start_location,
                    t2.departure_time,
                    t3.location_id as end_location,
                    t3.arrival_time
                ")
                ->join('pjBusLocation', "t1.bus_id = t2.bus_id", 'LEFT')
                ->join('pjBusLocation', "t1.transfer_bus_id = t3.bus_id", 'LEFT')
                ->where("t1.city_id = {$transferIds} and t2.location_id = {$pickup_id} and t3.location_id = {$return_id}")
                ->findAll()
                ->getData();
                
        if( count($res) > 0){
            
            $toBusIds = array_column($res, 'bus_id');
            $fromBusIds = array_column($res, 'transfer_bus_id');

            return [
                'transferIds' =>[
                    $transferIds => [
                        'to' => $toBusIds,
                        'from' => $fromBusIds,
                    ]
                ]
            ];
        }
        return null;
    }
    
    

}
