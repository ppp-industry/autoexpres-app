<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjAdminBusStop extends pjAdmin {

    public function pjActionIndex() {
        
        
        $this->checkLogin();

        if ($this->isAdmin() || $this->isEditor()) {
            $this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
            $this->appendJs('pjAdminBusStop.js');
            $this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
        }
    }

    public function pjActionUpdate() {
        
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
        
         $this->checkLogin();

        $params = $_POST;
        
       
        if ($this->isAdmin() || $this->isEditor()) {
            
            $pjBusStopModel = pjBusStopModel::factory();
            $pjMultiLangModel = pjMultiLangModel::factory();
            
            $arr = $pjBusStopModel->find(isset($params['id']) ? $params['id'] : $_GET['id'] )->getData();
            
            if (empty($arr)) {
                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusStop&action=pjActionIndex");
            }
            
            if (isset($params['bus_stop_update'])) {
                
                if (isset($params['i18n'])) {
                    
                    pjMultiLangModel::factory()->updateMultiLang($params['i18n'], $params['id'], 'pjBusStopModel', 'data');
                    $localeId = $this->getLocaleId();
                
                    $pjBusStopModel->reset()->find($params['id'])->modify([
                        'location_id' => $_POST['location_id'],
                        'name' => $_POST['i18n'][$localeId]['name'],
                        'address' => $_POST['i18n'][$localeId]['address'],
                    ]);
                    
                    pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusStop&action=pjActionIndex");
                }
            }
            
            $arr['i18n'] = $pjMultiLangModel->getMultiLang($arr['id'], 'pjBusStopModel');
            
            $this->set('arr', $arr);
            
            $city_arr = pjCityModel::factory()
                        ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                        ->select('t1.*, t2.content as name')
                        ->where('status', 'T')
                        ->orderBy("name ASC")
                        ->findAll()
                        ->getData();
            $this->set('city_arr', $city_arr);


            $this->setLocales();

            $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
            $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
            $this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
            $this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
//                $this->appendJs('pjAdminBusTypes.js');
            $this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
        }
        
        
        
    }
    
    public function pjActionCreate(){
        $this->checkLogin();

        if ($this->isAdmin() || $this->isEditor()) {
            
            if (isset($_POST['bus_stop_create'])) {
                
//                vd($_POST);
                $pjBusTypeModel = pjBusStopModel::factory();
                $localeId = $this->getLocaleId();
                
                
                $id = $pjBusTypeModel->setAttributes([
                    'name' => $_POST['i18n'][$localeId]['name'],
                    'address' => $_POST['i18n'][$localeId]['address'],
                    'location_id' => $_POST['location_id'],
                        
                ])->insert()->getInsertId();
//                
                if ($id !== false && (int) $id > 0) {
                    if (isset($_POST['i18n'])) {
                        pjMultiLangModel::factory()->saveMultiLang($_POST['i18n'], $id, 'pjBusStopModel', 'data');
                    }
                }
//
                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusStop&action=pjActionIndex");
//                
            } 
            
            else {
                
                $city_arr = pjCityModel::factory()
                        ->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer')
                        ->select('t1.*, t2.content as name')
                        ->where('status', 'T')
                        ->orderBy("name ASC")
                        ->findAll()
                        ->getData();
                $this->set('city_arr', $city_arr);
                
                
                $this->setLocales();

                $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
                $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
                $this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
                $this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
//                $this->appendJs('pjAdminBusTypes.js');
                $this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
            }
        }
    }

    
    public function pjActionGetBusTops(){
        
        $this->setAjax(true);

        if ($this->isXHR()) {
            $pjBusStopModel = pjBusStopModel::factory();
//                    ->join('pjMultiLang', "t2.model='pjBusType' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer');

            if (isset($_GET['q']) && !empty($_GET['q'])) {
                $q = pjObject::escapeString($_GET['q']);
                $pjBusStopModel->where('name LIKE', "%$q%");
            }
            $pjBusStopModel->join('pjMultiLang', "t2.model='pjCity' AND t2.foreign_id=t1.location_id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer');
            $pjBusStopModel->select('t1.*,t2.content as city');
            
            $column = 'name';
            $direction = 'ASC';
            if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC'))) {
                $column = $_GET['column'];
                $direction = strtoupper($_GET['direction']);
            }

            $total = $pjBusStopModel->findCount()->getData();
            
            $rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
            $pages = ceil($total / $rowCount);
            $page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
            $offset = ((int) $page - 1) * $rowCount;
            if ($page > $pages) {
                $page = $pages;
            }

            $data = $pjBusStopModel->orderBy("$column $direction")->limit($rowCount, $offset)->findAll()->getData();

            pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
        }
        exit;
        
    }
    

}

?>