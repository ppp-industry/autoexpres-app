<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjTicketBus extends pjAppModel {

    protected $table = 'tickets_buses';
    protected $schema = array(
        array('name' => 'bus_id', 'type' => 'int', ),
        array('name' => 'ticket_id', 'type' => 'int',),
    );

    public static function factory($attr = array()) {
        return new pjTicketBus($attr);
    }


}

?>