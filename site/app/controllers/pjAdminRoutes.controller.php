<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjAdminRoutes extends pjAdmin {

    public function pjActionCreate() {
//        ini_set("display_errors", "On");
//       error_reporting(E_ALL ^ E_DEPRECATED);

        $this->checkLogin();

        if ($this->isAdmin() || $this->isEditor()) {
            if (isset($_POST['route_create'])) {
                $pjMultiLangModel = pjMultiLangModel::factory();
                $id = pjRouteModel::factory($_POST)->insert()->getInsertId();
                if ($id !== false && (int) $id > 0) {
                    if (isset($_POST['i18n'])) {
                        $pjMultiLangModel->saveMultiLang($_POST['i18n'], $id, 'pjRoute', 'data');
                    }
                    if (isset($_POST['index_arr']) && $_POST['index_arr'] != '') {
                        $index_arr = explode("|", $_POST['index_arr']);

                        $pjRouteCityModel = pjRouteCityModel::factory();
                        
                        $from = $to = null;
                        
                        foreach ($index_arr as $k => $index) {
                            if (isset($_POST['city_id_' . $index]) && (int) $_POST['city_id_' . $index] > 0) {
                                $city_id = $_POST['city_id_' . $index];
                                $data = array();
                                $data['route_id'] = $id;
                                $data['city_id'] = $city_id;
                                $data['order'] = $k + 1;
                                $pjRouteCityModel->reset()->setAttributes($data)->insert();

                                if ($k == 0) {
                                    $from = $city_id;
                                    $i18n_arr = $pjMultiLangModel->reset()->getMultiLang($city_id, 'pjCity');
                                    $i18n_arr = pjUtil::changeLangField($i18n_arr, 'from', 'name');
                                    $pjMultiLangModel->reset()->saveMultiLang($i18n_arr, $id, 'pjRoute', 'data');
                                }
                                if ($k == count($index_arr) - 1) {
                                    
                                    $to = $city_id;
                                    $i18n_arr = $pjMultiLangModel->reset()->getMultiLang($city_id, 'pjCity');
                                    $i18n_arr = pjUtil::changeLangField($i18n_arr, 'to', 'name');
                                    $pjMultiLangModel->reset()->saveMultiLang($i18n_arr, $id, 'pjRoute', 'data');
                                }
                            }
                        }
                        
                        if($from || $to){
                            $this->checkIsInternational($from, $to, $id);
                        }
                    }
                    pjRouteModel::factory()->updateRouteDetail($id);

                    $err = 'AR03';
                } else {
                    $err = 'AR04';
                }
                
                
                if (isset($_POST['bus_stops'])){
                        
                    foreach($_POST['bus_stops'] as $cityId => $busIdsString){
                        if(empty($busIdsString))  {
                            continue;;
                        }

                        foreach(explode(',', $busIdsString) as $busId){
                            $pjRouteCityBusStopModel->reset()->setAttributes([
                                'city_id' => $cityId,
                                'route_id' => $id,
                                'bus_stop_id' => $busId
                            ])->insert();
                        }
                    }
                }

                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminRoutes&action=pjActionIndex&err=$err");
            } 
            else {
                $routes = [];
                if(isset($_GET['id'])){
                    
                    $routes = pjRouteModel::factory()->where('t1.id != ' . $_GET['id'])
                        ->select("t1.*, t2.content as title")
                        ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->findAll()->getData();
                
                }
                else{
                    
                    $routes = pjRouteModel::factory()
                        ->select("t1.*, t2.content as title")
                        ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->findAll()->getData();
                
                }
                
                $this->set('routes', $routes);
                
                $this->setLocales();

                if (isset($_GET['id'])) {
                    $direction = 'ASC';
                    if ($_GET['type'] == 'reverse') {
                        $direction = 'DESC';
                    }
                    $city_id_arr = pjRouteCityModel::factory()->getCity($_GET['id'], $direction);
                    $this->set('city_id_arr', $city_id_arr);
                }

                $city_arr = pjCityModel::factory()
                        ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                        ->select('t1.*, t2.content as name')
                        ->where('status', 'T')
                        ->orderBy("name ASC")
                        ->findAll()
                        ->getData();
                $this->set('city_arr', $city_arr);

                $this->appendJs('chosen.jquery.js', PJ_THIRD_PARTY_PATH . 'chosen/');
                $this->appendCss('chosen.css', PJ_THIRD_PARTY_PATH . 'chosen/');
                
                $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
                $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
                $this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
                $this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
                $this->appendJs('pjAdminRoutes.js');
                $this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
            }
        } else {
            $this->set('status', 2);
        }
    }

    public function pjActionDeleteRoute() {
        $this->setAjax(true);

        if ($this->isXHR()) {
            $response = array();

            if (pjRouteModel::factory()->setAttributes(array('id' => $_GET['id']))->erase()->getAffectedRows() == 1) {
                pjMultiLangModel::factory()->where('model', 'pjRoute')->where('foreign_id', $_GET['id'])->eraseAll();
                pjRouteDetailModel::factory()->where('route_id', $_GET['id'])->eraseAll();
                pjRouteCityModel::factory()->where('route_id', $_GET['id'])->eraseAll();

                $response['code'] = 200;
            } else {
                $response['code'] = 100;
            }

            pjAppController::jsonResponse($response);
        }
        exit;
    }

    public function pjActionDeleteRouteBulk() {
        $this->setAjax(true);

        if ($this->isXHR()) {
            if (isset($_POST['record']) && count($_POST['record']) > 0) {
                pjRouteModel::factory()->whereIn('id', $_POST['record'])->eraseAll();
                pjMultiLangModel::factory()->where('model', 'pjRoute')->whereIn('foreign_id', $_POST['record'])->eraseAll();
                pjRouteDetailModel::factory()->whereIn('route_id', $_POST['record'])->eraseAll();
                pjRouteCityModel::factory()->whereIn('route_id', $_POST['record'])->eraseAll();
            }
        }
        exit;
    }

    public function pjActionExportRoute() {
        $this->checkLogin();

        if (isset($_POST['record']) && is_array($_POST['record'])) {
            $arr = pjRouteModel::factory()->select('t1.id, t2.content as title')
                            ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                            ->whereIn('id', $_POST['record'])->findAll()->getData();
            $csv = new pjCSV();
            $csv
                    ->setHeader(true)
                    ->setName("Routes-" . time() . ".csv")
                    ->process($arr)
                    ->download();
        }
        exit;
    }

    public function pjActionGetRoute() {
        $this->setAjax(true);

        if ($this->isXHR()) {
            $pjRouteModel = pjRouteModel::factory()
                    ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->join('pjMultiLang', "t3.model='pjRoute' AND t3.foreign_id=t1.id AND t3.field='from' AND t3.locale='" . $this->getLocaleId() . "'", 'left outer')
                    ->join('pjMultiLang', "t4.model='pjRoute' AND t4.foreign_id=t1.id AND t4.field='to' AND t4.locale='" . $this->getLocaleId() . "'", 'left outer');

            if (isset($_GET['q']) && !empty($_GET['q'])) {
                $q = pjObject::escapeString($_GET['q']);
                $pjRouteModel->where('t2.content LIKE', "%$q%");
            }

            if (isset($_GET['status']) && !empty($_GET['status']) && in_array($_GET['status'], array('T', 'F'))) {
                $pjRouteModel->where('t1.status', $_GET['status']);
            }

            $column = 'title';
            $direction = 'ASC';
            if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC'))) {
                $column = $_GET['column'];
                $direction = strtoupper($_GET['direction']);
            }

            $total = $pjRouteModel->findCount()->getData();
            $rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
            $pages = ceil($total / $rowCount);
            $page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
            $offset = ((int) $page - 1) * $rowCount;
            if ($page > $pages) {
                $page = $pages;
            }

            $data = $pjRouteModel
                    ->select(" t1.id, t1.status, t2.content as title, t3.content as `from`, t4.content as `to`")
                    ->orderBy("$column $direction")
                    ->limit($rowCount, $offset)
                    ->findAll()
                    ->getData();

            pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
        }
        exit;
    }

    public function pjActionIndex() {
        $this->checkLogin();

        if ($this->isAdmin() || $this->isEditor()) {
            $this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
            $this->appendJs('pjAdminRoutes.js');
            $this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
        } else {
            $this->set('status', 2);
        }
    }

    public function pjActionSaveRoute() {
        $this->setAjax(true);

        if ($this->isXHR()) {
            $pjRouteModel = pjRouteModel::factory();
            if (!in_array($_POST['column'], $pjRouteModel->i18n)) {
                $value = $_POST['value'];

                $pjRouteModel->where('id', $_GET['id'])->limit(1)->modifyAll(array($_POST['column'] => $value));
            } else {
                pjMultiLangModel::factory()->updateMultiLang(array($this->getLocaleId() => array($_POST['column'] => $_POST['value'])), $_GET['id'], 'pjRoute', 'data');
            }
        }
        exit;
    }

    public function pjActionUpdate() {
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $this->checkLogin();

        if ($this->isAdmin() || $this->isEditor()) {

            $pjRouteCityBusStopModel = pjRouteCityBusStopModel::factory();
            $busStops = $pjRouteCityBusStopModel->where('route_id',$_POST['id'])->findAll()->getData();;
            
            
            if (isset($_POST['route_update'])) {
                $pjMultiLangModel = pjMultiLangModel::factory();
                $pjRouteModel = pjRouteModel::factory();
                
                $arr = $pjRouteModel->find($_POST['id'])->getData();
                if (empty($arr)) {
                    pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminRoutes&action=pjActionIndex&err=AR08");
                }

                $pjRouteModel->reset()->where('id', $_POST['id'])->limit(1)->modifyAll($_POST);
//                echo __LINE__;exit();
                if(isset($_POST['back_id']) && !empty($_POST['back_id'])){
                    
                    $cities = array_unique(array_column($busStops, 'city_id'));
                    $backBusStops = $pjRouteCityBusStopModel->reset()->whereIn('city_id',$cities)->where('route_id',$_POST['back_id'])->findAll()->getData();
                    
                    if(empty($backBusStops)){
                        foreach($busStops as $busStop){
                            $pjRouteCityBusStopModel->reset()->setAttributes([
                                'city_id' => $busStop['city_id'],
                                'route_id' => $_POST['back_id'],
                                'bus_stop_id' => $busStop['bus_stop_id']
                            ])->insert();
                        }
                    }
                }
                
                if (isset($_POST['i18n'])) {
                    $pjMultiLangModel->updateMultiLang($_POST['i18n'], $_POST['id'], 'pjRoute', 'data');
                }
                
                if (!isset($_POST['has_bookings'])) {
                    
                    $pjRouteCityModel = pjRouteCityModel::factory();
                    $pjRouteCityModel->where('route_id', $_POST['id'])->eraseAll();
                    if (isset($_POST['index_arr']) && $_POST['index_arr'] != '') {
                        $index_arr = explode("|", $_POST['index_arr']);
                        $from = $to = null;

                        foreach ($index_arr as $k => $index) {
                            if (isset($_POST['city_id_' . $index]) && (int) $_POST['city_id_' . $index] > 0) {
                                $city_id = $_POST['city_id_' . $index];
                                $data = array();
                                $data['route_id'] = $_POST['id'];
                                $data['city_id'] = $city_id;
                                $data['order'] = $k + 1;
                                $pjRouteCityModel->reset()->setAttributes($data)->insert();
                                if ($k == 0) {
                                    $from = $city_id;
                                    $i18n_arr = $pjMultiLangModel->reset()->getMultiLang($city_id, 'pjCity');
                                    $i18n_arr = pjUtil::changeLangField($i18n_arr, 'from', 'name');
                                    $pjMultiLangModel->reset()->updateMultiLang($i18n_arr, $_POST['id'], 'pjRoute', 'data');
                                }
                                if ($k == (count($index_arr) - 1)) {
                                    $to = $city_id;
                                    $i18n_arr = $pjMultiLangModel->reset()->getMultiLang($city_id, 'pjCity');
                                    $i18n_arr = pjUtil::changeLangField($i18n_arr, 'to', 'name');
                                    $pjMultiLangModel->reset()->updateMultiLang($i18n_arr, $_POST['id'], 'pjRoute', 'data');
                                }
                            }
                        }            
                        
                        if($from || $to){   
                            $this->checkIsInternational($from, $to, $_POST['id']);
                        }
                    }
                    $pjRouteModel->updateRouteDetail($_POST['id']);
                    $pjRouteModel->updateBusTime($_POST['id']);
                    $pjRouteModel->updateBusPrice($_POST['id']);
                }

                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminRoutes&action=pjActionUpdate&id=" . $_POST['id'] . "&err=AR01");
            } 
            else {
                $pjRouteModel = pjRouteModel::factory();
                $routes = $pjRouteModel->where('t1.id != ' . $_GET['id'])
                        ->select("t1.*, t2.content as title")
                        ->join('pjMultiLang', "t2.model='pjRoute' AND t2.foreign_id=t1.id AND t2.field='title' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')->findAll()->getData();
                
                $this->set('routes', $routes);
                
                $pjMultiLangModel = pjMultiLangModel::factory();

                $arr = pjRouteModel::factory()->find($_GET['id'])->getData();

                if (count($arr) === 0) {
                    pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminRoutes&action=pjActionIndex&err=AR08");
                }
                $arr['i18n'] = $pjMultiLangModel->getMultiLang($arr['id'], 'pjRoute');
                $arr['city'] = pjRouteCityModel::factory()->getCity($arr['id'], 'ASC');
                
                
                
                $mapBusStops = [];
                foreach($busStops as $busStop){
                    if(!isset($mapBusStops[$busStop['city_id']])){
                        $mapBusStops[$busStop['city_id']] = [];
                    }
                    
                    $mapBusStops[$busStop['city_id']][] = $busStop['bus_stop_id'];    
                }
                
                $arr['mapBusStops'] = $mapBusStops;
                
                $this->setLocales();
                
                $this->set('arr', $arr);

                $city_arr = pjCityModel::factory()
                        ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                        ->select('t1.*, t2.content as name')
                        ->where('status', 'T')
                        ->orderBy("name ASC")
                        ->findAll()
                        ->getData();
                $this->set('city_arr', $city_arr);

                $cnt_bookings = pjBookingModel::factory()
                        ->where("t1.bus_id IN (SELECT TB.id FROM `" . pjBusModel::factory()->getTable() . "` AS TB WHERE TB.route_id = " . $_GET['id'] . ")")
                        ->findCount()
                        ->getData();
                $this->set('cnt_bookings', $cnt_bookings);

                $this->appendJs('chosen.jquery.js', PJ_THIRD_PARTY_PATH . 'chosen/');
                $this->appendCss('chosen.css', PJ_THIRD_PARTY_PATH . 'chosen/');
                
                $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
                $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
                $this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
                $this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
                $this->appendJs('pjAdminRoutes.js');
                $this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
            }
        } 
        else {
            $this->set('status', 2);
        }
    }
    
    
    public function pjActionGetBusStopsByCity(){
        $city = $_GET['city'];
        $route = $_GET['route'];
        $this->setAjax(true);
        
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $pjBusStopModel = pjBusStopModel::factory();
        $pjBusStopModel->where('location_id',$city);
        $pjBusStopModel->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.location_id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer');
        $pjBusStopModel->select('t1.*,t2.content as city');
            
        $data = $pjBusStopModel->findAll()->getData();
        
        $cityBusStops = pjRouteCityBusStopModel::factory()->where('route_id',$route)->where('city_id',$city)->findAll()->getData();
        
        $this->set('busStops',$data);
        $this->set('cityBusStops',array_column($cityBusStops, 'bus_stop_id'));
//        $this->set('busStops',$data);

    }

    
    public function pjActionSetBusStopsByCity(){

        if (isset($_POST['bus_stops'])){
            $pjRouteCityBusStopModel = pjRouteCityBusStopModel::factory();
            
            $pjRouteCityBusStopModel->reset()->where('city_id',$_POST['city'])->where('route_id',$_POST['route'])->eraseAll();            
              
            $back = null;
            $pjRouteModel = pjRouteModel::factory();
            $arr = $pjRouteModel->find($_POST['route'])->getData();
            
            
            foreach(explode(',', $_POST['bus_stops']) as $busId){
                
                $pjRouteCityBusStopModel->reset()->setAttributes([
                    'city_id' => $_POST['city'],
                    'route_id' => $_POST['route'],
                    'bus_stop_id' => $busId
                ])->insert();
                
                
                if(isset($arr['back_id'])){
                    
                    $pjRouteCityBusStopModel->reset()->setAttributes([
                        'city_id' => $_POST['city'],
                        'route_id' => $arr['back_id'],
                        'bus_stop_id' => $busId
                    ])->insert();
                    
                }
            }
        }
    }
    
    
    private function checkIsInternational($from,$to,$id) {

        $fromModel = pjCityModel::factory()->find($from)->getData();
        $toModel = pjCityModel::factory()->find($to)->getData();

        if ($fromModel['is_ukraine'] == 0 || $toModel['is_ukraine'] == 0) {
            $update = [
                'is_international' => 1,  
            ];
            
            if ($fromModel['is_ukraine'] == 0) {
                $update['country_alpha'] = $fromModel['country_alpha'];
                switch ($fromModel['country_alpha']) {
                    case 'DE':
                        $update['order_by_country'] = 5;
                        break;
                    case 'FR':
                        $update['order_by_country'] = 6;
                        break;
                    case 'BE':
                        $update['order_by_country'] = 7;
                        break;
                    default:
                        $update['order_by_country'] = 8;
                }
            } 
            else {
                $update['country_alpha'] = $toModel['country_alpha'];
                switch ($toModel['country_alpha']) {
                    case 'DE':
                        $update['order_by_country'] = 1;
                        break;
                    case 'FR':
                        $update['order_by_country'] = 2;
                        break;
                    case 'BE':
                        $update['order_by_country'] = 3;
                        break;
                    default:
                        $update['order_by_country'] = 4;
                }
            }

            pjRouteModel::factory()->where('id', $id)->modifyAll($update);
        }
    }

}

?>