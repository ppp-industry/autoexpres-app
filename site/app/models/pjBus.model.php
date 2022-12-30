<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjBusModel extends pjAppModel {

    protected $primaryKey = 'id';
    protected $table = 'buses';
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'route_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'bus_type_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'start_date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'end_date', 'type' => 'date', 'default' => ':NULL'),
        array('name' => 'departure_time', 'type' => 'time', 'default' => ':NULL'),
        array('name' => 'arrival_time', 'type' => 'time', 'default' => ':NULL'),
        array('name' => 'recurring', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'set_seats_count', 'type' => 'enum', 'default' => 'F'),
        array('name' => 'discount', 'type' => 'decimal', 'default' => '0')
    );

    public static function factory($attr = array()) {
        return new pjBusModel($attr);
    }

    public function getBusIdsByRoutes($date,$routes,$returnObjects = false){
        $res = null;
        $day_of_week = strtolower(date('l', strtotime($date)));
        $currentTime = new \DateTime();
        $departure_time = date('Y-m-d H:i', strtotime($currentTime->format('Y-m-d H:i') . '+2hours'));

        $query = $this
                ->reset()
                ->where("(t1.start_date <= '$date' AND '$date' <= t1.end_date) AND (t1.recurring LIKE '%$day_of_week%') AND t1.id NOT IN (SELECT TSD.bus_id FROM `" . pjBusDateModel::factory()->getTable() . "` AS TSD WHERE TSD.`date` = '$date')");
                
        if(is_array($routes) && count($routes)){
            $query->whereIn('route_id',$routes);
        }
        else{
            $query->where('route_id',$routes);
        }
        
        if ($date == $currentTime->format('Y-m-d')) {
           $query->where("STR_TO_DATE(CONCAT('{$currentTime->format('Y-m-d')}', ' ', t1.departure_time), '%Y-%m-%d %H:%i:%s') >= '$departure_time'");
        }
        
        if($returnObjects){
            $res = $query->findAll()->getData(); 
        }
        else{
            $res = $query->findAll()->getDataPair(null, 'id');
        }
        
        
        return $res;
        
        
        
    }
    
    public function getBusIds($date, $pickup_id, $return_id, $isReturn = false, &$transferIds = null,$returnObjects = false) {        
        
        $res = null;
        $day_of_week = strtolower(date('l', strtotime($date)));
        $currentTime = new \DateTime();
        $departure_time = date('Y-m-d H:i', strtotime($currentTime->format('Y-m-d H:i') . '+2hours'));

        $query = $this
                ->reset()
                ->where("(t1.start_date <= '$date' AND '$date' <= t1.end_date) AND (t1.recurring LIKE '%$day_of_week%') AND t1.id NOT IN (SELECT TSD.bus_id FROM `" . pjBusDateModel::factory()->getTable() . "` AS TSD WHERE TSD.`date` = '$date')")
                ->where("t1.route_id IN(SELECT TRD.route_id FROM `" . pjRouteDetailModel::factory()->getTable() . "` AS TRD WHERE TRD.from_location_id = $pickup_id AND TRD.to_location_id = $return_id)");
        
        if (!$isReturn && $date == $currentTime->format('Y-m-d')) {
           $query->where("STR_TO_DATE(CONCAT('{$currentTime->format('Y-m-d')}', ' ', t1.departure_time), '%Y-%m-%d %H:%i:%s') >= '$departure_time'");
        }

        if($returnObjects){
            $res = $query->findAll()->getData(); 
        }
        else{
            $res = $query->findAll()->getDataPair(null, 'id');
        }
        
//        Вычесляем transferID 
        if (empty($res) && $transferIds) {

            $dateCondition = null;
            
            if (!$isReturn && $date == $currentTime->format('Y-m-d')) {
                $dateCondition = "STR_TO_DATE(CONCAT('{$currentTime->format('Y-m-d')}', ' ', t1.departure_time), '%Y-%m-%d %H:%i:%s') >= '$departure_time'";
            }

            $innerConditionFromTransfer = $innerConditionToTransfer = null;
            $totalTo = $totalFrom = $tIds = [];
            
            foreach($transferIds as $transferCity => &$cities){
                if(in_array($pickup_id, $cities) || in_array($return_id, $cities)){
//                    $reccurringCondition = "(t1.start_date <= '$date' AND '$date' <= t1.end_date) AND (t1.recurring LIKE '%$day_of_week%') AND t1.id NOT IN (SELECT TSD.bus_id FROM `" . pjBusDateModel::factory()->getTable() . "` AS TSD WHERE TSD.`date` = '$date')";
                    
                    $queryToTransferCity = $this
                        ->reset()
                        ->where("(t1.start_date <= '$date' AND '$date' <= t1.end_date) AND (t1.recurring LIKE '%$day_of_week%') AND t1.id NOT IN (SELECT TSD.bus_id FROM `" . pjBusDateModel::factory()->getTable() . "` AS TSD WHERE TSD.`date` = '$date')")
                        ->where("t1.route_id IN(SELECT TRD.route_id FROM `" . pjRouteDetailModel::factory()->getTable() . "` AS TRD WHERE TRD.from_location_id = $pickup_id AND TRD.to_location_id = $transferCity)");
                   
                    if ($dateCondition) {
                        $queryToTransferCity->where($dateCondition);
                    }
                    
                    $resTo = $queryToTransferCity->findAll()->getData();
                    
                    $queryFromTransferCity = $this
                        ->reset()
                        ->where("(t1.start_date <= '$date' AND '$date' <= t1.end_date) AND (t1.recurring LIKE '%$day_of_week%') AND t1.id NOT IN (SELECT TSD.bus_id FROM `" . pjBusDateModel::factory()->getTable() . "` AS TSD WHERE TSD.`date` = '$date')")
                        ->where("t1.route_id IN(SELECT TRD.route_id FROM `" . pjRouteDetailModel::factory()->getTable() . "` AS TRD WHERE TRD.from_location_id = $transferCity AND TRD.to_location_id = $return_id)");
                    
                    if ($dateCondition) {
                        $queryFromTransferCity->where($dateCondition);
                    }
                    
                    $resFrom = $queryFromTransferCity->findAll()->getData(); 
                    $keysFrom = $keysTo = $availableBuses =  [];
                   
                    foreach($resTo as $toItem){
                       
                        $dateTmp = $date;
                        $departureTime = $dateTmp . ' ' . $toItem['departure_time'];
                        $arrivalTime = $dateTmp . ' ' . $toItem['arrival_time'];
                        $departureTimeTimestamp = strtotime($departureTime);
                        $arrivalTimeTimestamp = strtotime($arrivalTime);
                        
                        if($arrivalTimeTimestamp < $departureTimeTimestamp){
                            $arrivalTimeTimestamp += 86400;
                            $dateTmp = date('Y-m-d',strtotime($dateTmp . '+24hours'));
                        }
                        
                        $availableBuses[$toItem['id']] = [
                            'arrivalTime' => date('Y-m-d H:i', $arrivalTimeTimestamp)
                        ];
                        
                        foreach($resFrom as $fromItem){
                            
                            $departureTime = $dateTmp . ' ' . $fromItem['departure_time'];
                            $departureTimeTimestamp = strtotime($departureTime);
                            
                            if($arrivalTimeTimestamp > $departureTimeTimestamp){
                                $departureTimeTimestamp += 86400;
                            }
                            
                            $difference = $departureTimeTimestamp - $arrivalTimeTimestamp;
                            
                            if($difference < 7200){
                                $availableBuses[$toItem['id']][] = [
                                    'id' => $fromItem['id'],
                                    'departureTime' => date('Y-m-d H:i',$departureTimeTimestamp),
                                ];
                                
                                $keysFrom[] = $fromItem['id'];
                            }
                        }   
                        
                        if(count($availableBuses[$toItem['id']]) > 1){
                            $keysTo[] = $toItem['id'];
                        }  
                    }
                    
                    $diff = $keysTo;
                    
                    if(empty($totalTo)){
                        $diff = $keysTo;
                    }
                    else{
                        $diff = array_diff($totalTo, $keysTo);;
                    }
                  
                    $totalTo = array_merge($diff,$totalTo);
                    $tmpTo = $diff;
                    
                    
                    $diff = $keysFrom;
                    if(empty($totalFrom)){
                        $diff = $keysFrom;
                    }
                    else{
                        $diff = array_diff($totalFrom, $keysFrom);;
                    }
                    
                    $totalFrom = array_merge($diff,$totalFrom);
                    $tmpFrom = $diff;
                    
                    if(!empty($tmpFrom) && !empty($tmpTo)){
                        
                        $tIds[$transferCity] = [];
                        $tIds[$transferCity]['to'] = $tmpTo;
                        $tIds[$transferCity]['from'] = $tmpFrom;
                    }        
                }
            }
            
            if(!empty($tIds)){
                return [
                    'transferIds' => $tIds
                ];
            }
            else {
                return null;
            }
            
        }
        return $res;
    }
}

?>
