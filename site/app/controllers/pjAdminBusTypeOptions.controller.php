<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

class pjAdminBusTypeOptions extends pjAdmin {

    public function pjActionCreate() {
        
        
        $this->checkLogin();

        if ($this->isAdmin() || $this->isEditor()) {
            
            
            if (isset($_POST['bus_type_create'])) {
                $pjBusTypeModel = pjBusTypeOptionItemModel::factory();
                

                $id = $pjBusTypeModel->setAttributes($_POST)->insert()->getInsertId();
                
                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusTypeOptions&action=pjActionIndex");
                
            } 
            
            else {


                $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
                $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
                $this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
                $this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
//                $this->appendJs('pjAdminBusTypes.js');
                $this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
            }
        }
        
        
        
        
    }
    
    public function pjActionGetBusTypeOptions(){
        $this->setAjax(true);

        if ($this->isXHR()) {
            $pjBusTypeOptionModel = pjBusTypeOptionItemModel::factory();
//                    ->join('pjMultiLang', "t2.model='pjBusType' AND t2.foreign_id=t1.id AND t2.field='name' AND t2.locale='" . $this->getLocaleId() . "'", 'left outer');

            if (isset($_GET['q']) && !empty($_GET['q'])) {
                $q = pjObject::escapeString($_GET['q']);
                $pjBusTypeOptionModel->where('name LIKE', "%$q%");
            }
            
            
//            if (isset($_GET['status']) && !empty($_GET['status']) && in_array($_GET['status'], array('T', 'F'))) {
//                $pjBusTypeOptionModel->where('t1.status', $_GET['status']);
//            }
            
            $column = 'name';
            $direction = 'ASC';
            if (isset($_GET['direction']) && isset($_GET['column']) && in_array(strtoupper($_GET['direction']), array('ASC', 'DESC'))) {
                $column = $_GET['column'];
                $direction = strtoupper($_GET['direction']);
            }

            $total = $pjBusTypeOptionModel->findCount()->getData();
            
            $rowCount = isset($_GET['rowCount']) && (int) $_GET['rowCount'] > 0 ? (int) $_GET['rowCount'] : 10;
            $pages = ceil($total / $rowCount);
            $page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? intval($_GET['page']) : 1;
            $offset = ((int) $page - 1) * $rowCount;
            if ($page > $pages) {
                $page = $pages;
            }

            $data = $pjBusTypeOptionModel->orderBy("$column $direction")->limit($rowCount, $offset)->findAll()->getData();

            pjAppController::jsonResponse(compact('data', 'total', 'pages', 'page', 'rowCount', 'column', 'direction'));
        }
        exit;
    }

    public function pjActionIndex() {
//        echo __LINE__;
        
        $this->checkLogin();

        if ($this->isAdmin() || $this->isEditor()) {
            $this->appendJs('jquery.datagrid.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
            $this->appendJs('pjAdminBusTypeOptions.js');
            $this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
        } else {
            $this->set('status', 2);
        }
    }

    public function pjActionSaveBusTypeOption() {
        ini_set("display_errors", "On");
        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $this->setAjax(true);

        if ($this->isXHR()) {
            
            $pjBusTypeOptionModel = pjBusTypeOptionItemModel::factory();
//            echo __LINE__;exit();
//            if (!in_array($_POST['column'], $pjBusTypeOptionModel->i18n)) {
                
//                echo __LINE__;exit();
                $value = $_POST['value'];
                
                

                $pjBusTypeOptionModel->where('id', $_GET['id'])->limit(1)->modifyAll(array($_POST['column'] => $value));
//            } else {
//                echo __LINE__;exit();
//                pjMultiLangModel::factory()->updateMultiLang(array($this->getLocaleId() => array($_POST['column'] => $_POST['value'])), $_GET['id'], 'pjBusType', 'data');
//            }
        }
        exit;
    }

    
    public function pjActionDeleteBusTypeOption(){
         ini_set("display_errors", "On");
        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $this->setAjax(true);

        if ($this->isXHR()) {
            $response = array();
            $pjBusTypeModel = pjBusTypeOptionItemModel::factory();
            $arr = $pjBusTypeModel->find($_GET['id'])->getData();
            if ($pjBusTypeModel->reset()->setAttributes(array('id' => $_GET['id']))->erase()->getAffectedRows() == 1) {
              
//                pjMultiLangModel::factory()->where('model', 'pjBusType')->where('foreign_id', $_GET['id'])->eraseAll();
                pjBusTypeOptionModel::factory()->where('option_id', $_GET['id'])->eraseAll();

                $response['code'] = 200;
            } else {
                $response['code'] = 100;
            }

            pjAppController::jsonResponse($response);
        }
        exit;
        
    }

    
}
?>