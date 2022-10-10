<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjApi extends pjFront {

    public function __construct() {
        self::allowCORS();
    }

}

?>