<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjApi extends pjFront {
    
    private $storageData,$storageId;

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
                $controller !== 'pjApiRoutes' 
                && 
                $action !== 'pjActionInternational'
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
//            header("HTTP/1.1 403 Forbidden");
//            exit;
        }
        
        
        $this->initStorage();
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
        return count($this->storageData) > 0;
    }
    
    protected function _get($key) {  
        return isset($this->storageData[$key]) ? $this->storageData[$key] : false;
        
    }
    
    protected function _is($key) {
        return isset($this->storageData[$key]);
    }

    protected function _set($key, $value) {
        
        $model = pjDbSessionDataModel::factory();
        
        $this->storageData[$key] = $value;
        
        if(is_null($this->storageId)){   
            $this->storageId = $model->setAttributes([
                'storage_key' => $this->defaultStore,
                'data' => serialize($this->storageData)
            ])->insert()->getInsertId();
        }
        else{
            $modify = [
                'data' => serialize($this->storageData)
            ];
            
            $model->reset()->setAttributes(['id' => $this->storageId])->modify($modify);
        }
    }
    protected function _getStore(){
        return $this->storageData;
    }
    
    protected function _remove($key) {
        
        if(isset($this->storageData[$key])){
            $model = pjDbSessionDataModel::factory();
            unset($this->storageData[$key]);
            
            $modify = [
                'data' => serialize($this->storageData)
            ];
            
            if($this->storageId){
                $model->reset()->setAttributes(['id' => $this->storageId])->modify($modify);
            }
            else{
                $modify['storage_key'] = $this->defaultStore;
                $this->storageId = $model->setAttributes($modify)->insert()->getInsertId();
            }
        }
        
    }
    
    protected function destroyStorage(){
        if($this->storageId){
            pjDbSessionDataModel::factory()->whereIn('id', $this->storageId)->eraseAll();
        }
    }


    private function initStorage(){
        $res = pjDbSessionDataModel::factory()->where('storage_key', $this->defaultStore)->findAll()->getData();
        
        if(!empty($res)){
            $this->storageData = unserialize($res[0]['data']);
            $this->storageId = $res[0]['id'];
        } 
        else{
            $this->storageData = [];
            $this->storageId = null;
        }     
    }
}

?>