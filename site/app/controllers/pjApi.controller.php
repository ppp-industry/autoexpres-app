<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjApi extends pjFront {

    public function __construct() {
        self::allowCORS();
        
        $action = Router::getAction();
        $controller = Router::getController();

        
        if(isset($_GET['key'])){
            $this->defaultStore .= '_' . $_GET['key'];
        }
        elseif($action !== 'pjActionGetLocations' && ($controller !== 'pjApiCities' && $action !== 'pjActionIndex')){
            header("HTTP/1.1 403 Forbidden");
            exit;
        }
//            
        
    }

    protected function generate_string($strength = 16) {
       
       $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        $this->defaultStore .= '_' . $random_string;
        
        return $random_string;
    }
}

?>