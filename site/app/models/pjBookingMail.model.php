<?php
if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjBookingMail extends pjAppModel {

    const TYPE_CONFIRM = 1;
    const TYPE_PAYMENT = 2;
    const TYPE_CANCEL = 3;
    
    const STATUS_NEW = 1;
    const STATUS_CLOSE = 2;
    const STATUS_ERROR = 3;
    
    
    protected $table = 'bookings_mails';
    protected $schema = array(
        array('name' => 'id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'booking_id', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'status', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'created_at', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'attempt_count', 'type' => 'int', 'default' => ':NULL'),
        array('name' => 'error_message', 'type' => 'varchar', 'default' => ':NULL'),
        array('name' => 'type', 'type' => 'int', 'default' => ':NULL'),
       
    );

    public static function factory($attr = array()) {
        return new pjBookingMail($attr);
    }
    
    
    public static function makeModel($booking_id,$type){
        return pjBookingMail::factory()->setAttributes([
            'booking_id' => $booking_id,
            'status' => self::STATUS_NEW,
            'type' => $type,
            'attempt_count' => 0,
            'created_at' => time(),

        ])->insert()->getInsertId();
    }

}

?>