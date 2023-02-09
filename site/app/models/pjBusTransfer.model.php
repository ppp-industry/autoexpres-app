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
    
    
    
    public function getBusIdsThroughManualTransfer($pickup_id, $return_id,&$transferIds,$date,$localeId) {      

        $bookingDate = pjUtil::formatDate($date,'Y-m-d');
        $dayOfWeek = date('l', strtotime($date));
//        vd($dayOfWeek);

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
                ->join('pjBus', "t4.id = t1.bus_id", 'INNER')
                ->join('pjBus', "t5.id = t1.transfer_bus_id", 'INNER')
                ->where("(t1.city_id = {$transferIds} and t2.location_id = {$pickup_id} and t3.location_id = {$return_id}) and (t5.`end_date` > '{$bookingDate}' and t4.`end_date` > '{$bookingDate}' ) and t4.recurring like '%{$dayOfWeek}%'")
                ->findAll()
                ->getData();
                
        if( count($res) > 0){
            
            $pjPriceModel = pjPriceModel::factory();
            
            
            $fromBusIds = $toBusIds = [];
            
            foreach ($res as $item){

                $resTo = $pjPriceModel->getTicketPrice($item['bus_id'], $pickup_id, $transferIds, [], $this->option_arr, $localeId, null);
                $resFrom = $pjPriceModel->getTicketPrice($item['transfer_bus_id'], $transferIds, $return_id, [], $this->option_arr, $localeId, null);
                
                if(count($resTo['ticket_arr']) > 0 && count($resFrom['ticket_arr']) > 0){
                    $toBusIds[] = $item['bus_id'];
                    $fromBusIds[] = $item['transfer_bus_id'];
                }
                
            }
            
            if(count($toBusIds) > 0 && count($fromBusIds) > 0){
                return [
                    'transferIds' =>[
                        $transferIds => [
                            'to' => $toBusIds,
                            'from' => $fromBusIds,
                        ]
                    ],
                    'isTransfer' => 1
                ];
            }
            
            
        }
        return null;
    }
    
    

}
