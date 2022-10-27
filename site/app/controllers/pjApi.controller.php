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
        elseif(
            $action !== 'pjActionGetLocations' 
            && 
            (
                $controller !== 'pjApiCities' 
                && 
                $action !== 'pjActionIndex'
            ) 
            && 
            (
                $controller !== 'pjApiBuses' 
                && 
                $action !== 'pjActionIndex'
            )
            && 
            (
                $controller !== 'pjApiPayment' 
                && 
                (
                    $action !== 'pjActionConfirmLiqPay'
                    ||
                    $action !== 'pjActionThankYou'
                )
            )
        )
        {
            header("HTTP/1.1 403 Forbidden");
            exit;
        }
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
    
    protected function checkStore(){
        $model = pjDbSessionDataModel::factory();
        $model->where('storage_key', $this->defaultStore)->limit(1);

        $res = $model->findAll()->getData();
        if(empty($res)){
            return false;
        }
        else{
            $storage = $res[0];
            $storage['data'] = unserialize($storage['data']);
            return count($storage['data']) > 0;            
        }
    }
    
    protected function _get($key) {
        $model = pjDbSessionDataModel::factory();
        $model->where('storage_key', $this->defaultStore)->limit(1);

        $res = $model->findAll()->getData();
        if(empty($res)){
            return false;
        }
        else{
            $storage = $res[0];
            $storage['data'] = unserialize($storage['data']);
            return isset($storage['data'][$key]) ? $storage['data'][$key] : false;            
        }
    }
    
    protected function _is($key) {
        
        $model = pjDbSessionDataModel::factory();
        $model->where('storage_key', $this->defaultStore)->limit(1);

        $res = $model->findAll()->getData();
        if(empty($res)){
            
            return false;
        }
        else{
            $storage = $res[0];
            $storage['data'] = unserialize($storage['data']);
            return isset($storage['data'][$key]);   
        }   
    }

    protected function _set($key, $value) {
        $model = pjDbSessionDataModel::factory();
        $model->where('storage_key', $this->defaultStore)->limit(1);

        $res = $model->findAll()->getData();
        
        if(empty($res)){
            
            $model->setAttributes([
                'storage_key' => $this->defaultStore,
                'data' => serialize([
                    $key => $value
                ])
            ])->insert();            
        }   
        
        else{
            $storage = $res[0];
            $storage['data'] = unserialize($storage['data']);
            $storage['data'][$key] = $value;
            $storage['data'] = serialize($storage['data']);
            
            $model->reset()->setAttributes(['id' => $storage['id']])->modify($storage);
        }
    }
    protected function _getStore(){
        $model = pjDbSessionDataModel::factory();
        $model->where('storage_key', $this->defaultStore)->limit(1);
        $res = $model->findAll()->getData();
        
        if(!empty($res)){
            return $res[0];
        } 
        return null;
    }
    
    protected function _remove($key) {
        $model = pjDbSessionDataModel::factory();
        $model->where('storage_key', $this->defaultStore)->limit(1);
        $res = $model->findAll()->getData();
        
        if(!empty($res)){
             $storage = $res[0];
            $storage['data'] = unserialize($storage['data']);
            
            if(isset($storage['data'][$key])){
                unset($storage['data'][$key]);
            }
            
            $storage['data'] = serialize($storage['data']);       
            $model->reset()->setAttributes(['id' => $storage['id']])->modify($storage);
                    
        } 
    }
}

?>