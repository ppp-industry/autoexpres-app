<?php

if (!defined("ROOT_PATH")) {
    header("HTTP/1.1 403 Forbidden");
    exit;
}
class pjAdminBusTypeOptions extends pjAdmin {
    
    
    public function __construct($requireLogin = false) {
        parent::__construct($requireLogin);
    }
    

    public function pjActionCreate() {
        $this->checkLogin();

        if ($this->isAdmin() || $this->isEditor()) {
            
            if (isset($_POST['bus_type_create'])) {
                
                $pjBusTypeOptionItemModel = pjBusTypeOptionItemModel::factory();
                $localeId = $this->getLocaleId();
                $data = ['name' => $_POST['i18n'][$localeId]['name']];
                
                $id = $pjBusTypeOptionItemModel->setAttributes($data)->insert()->getInsertId();
                
                if ($id !== false && (int) $id > 0) {
                    if (isset($_POST['i18n'])) {
                        pjMultiLangModel::factory()->saveMultiLang($_POST['i18n'], $id, 'pjBusTypeOptionItemModel', 'data');
                    }
                    
                    if (isset($_FILES['photo'])) {
                        $data = [];
                        if ($_FILES['photo']['error'] == 0) {
                            if (is_writable('app/web/upload/buy_types_options')) {

                                $hash = md5(uniqid(rand(), true));
                                $imagePath = PJ_UPLOAD_PATH . 'buy_types_options/photo_' . $id . '_'  . $hash . '.svg';

                                if(move_uploaded_file($_FILES['photo']['tmp_name'], $imagePath)){
                                    $data['svg_source'] = $imagePath; 
                                }

                            } else {
                                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusTypeOptions&action=pjActionCreate&err=ABT11");
                            }
                        } else if ($_FILES['photo']['error'] != 4) {

                            pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusTypeOptions&action=pjActionCreate&err=ABT10");
                        }
                        
                        if(!empty($data) && $pjBusTypeOptionItemModel->reset()->find($id)->modify($data)->getAffectedRows() > 0){
                            pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusTypeOptions&action=pjActionIndex");
                        }   
                    }
                }

                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusTypeOptions&action=pjActionIndex");
                
            } 
            
            else {
                
                $locale_arr = pjLocaleModel::factory()->select('t1.*, t2.file')
                                ->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
                                ->where('t2.file IS NOT NULL')
                                ->orderBy('t1.sort ASC')->findAll()->getData();

                $lp_arr = array();
                foreach ($locale_arr as $item) {
                    $lp_arr[$item['id'] . "_"] = $item['file'];
                }
                
                $this->set('lp_arr', $locale_arr);
                $this->set('locale_str', pjAppController::jsonEncode($lp_arr));

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
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $this->setAjax(true);

        if ($this->isXHR()) {
            
            $pjBusTypeOptionModel = pjBusTypeOptionItemModel::factory();
                $value = $_POST['value'];

                $pjBusTypeOptionModel->where('id', $_GET['id'])->limit(1)->modifyAll(array($_POST['column'] => $value));
        }
        exit;
    }

    
    public function pjActionUpdateBusTypeOption(){
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
        
         $this->checkLogin();

        $params = $_POST;
        
       
        if ($this->isAdmin() || $this->isEditor()) {
            
            $pjBusTypeOptionItemModel = pjBusTypeOptionItemModel::factory();
            $pjMultiLangModel = pjMultiLangModel::factory();
            
            $arr = $pjBusTypeOptionItemModel->find(isset($params['id']) ? $params['id'] : $_GET['id'] )->getData();
            
            if (empty($arr)) {
                pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusTypeOptions&action=pjActionIndex");
            }
            
            if (isset($params['bus_type_option_update'])) {
                $data = [];
                
                if (isset($_FILES['photo'])) {
//                    echo __LINE__;exit();
                    
//                    vd($_FILES['photo']);
                    if ($_FILES['photo']['error'] == 0) {
                        if (is_writable('app/web/upload/buy_types_options')) {
                    
                            $hash = md5(uniqid(rand(), true));
                            $imagePath = PJ_UPLOAD_PATH . 'buy_types_options/photo_' . $params['id'] . '_' . $hash . '.svg';
                            
                            if(move_uploaded_file($_FILES['photo']['tmp_name'], $imagePath)){
                                $data['svg_source'] = $imagePath; 
                            }

                        } else {
                            
                            pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusTypeOptions&action=pjActionUpdateBusTypeOption&id=" . $params['id'] . "&err=ABT11");
                        }
                    } else if ($_FILES['photo']['error'] != 4) {
                      
                        pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusTypeOptions&action=pjActionUpdateBusTypeOption&id=" . $params['id'] . "&err=ABT10");
                    }
                }
                
                if (isset($params['i18n'])) {
                    pjMultiLangModel::factory()->updateMultiLang($params['i18n'], $params['id'], 'pjBusTypeOptionItemModel', 'data');
                    
                    $localeId = $this->getLocaleId();
                    $data['name'] = $_POST['i18n'][$localeId]['name'];    
                    
                }
                
                if($pjBusTypeOptionItemModel->reset()->find($params['id'])->modify($data)->getAffectedRows() > 0){
                    pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusTypeOptions&action=pjActionIndex");
                }
            }
            
            $arr['i18n'] = $pjMultiLangModel->getMultiLang($arr['id'], 'pjBusTypeOptionItemModel');
            $this->set('arr', $arr);
            
            
            $locale_arr = pjLocaleModel::factory()->select('t1.*, t2.file')
                              ->join('pjLocaleLanguage', 't2.iso=t1.language_iso', 'left')
                              ->where('t2.file IS NOT NULL')
                              ->orderBy('t1.sort ASC')->findAll()->getData();

            $lp_arr = array();
            foreach ($locale_arr as $item) {
                $lp_arr[$item['id'] . "_"] = $item['file'];
            }

            $this->set('lp_arr', $locale_arr);
            $this->set('locale_str', pjAppController::jsonEncode($lp_arr)); 
            
            $this->appendJs('jquery.validate.min.js', PJ_THIRD_PARTY_PATH . 'validate/');
            $this->appendJs('jquery.multilang.js', PJ_FRAMEWORK_LIBS_PATH . 'pj/js/');
            $this->appendJs('jquery.tipsy.js', PJ_THIRD_PARTY_PATH . 'tipsy/');
            $this->appendCss('jquery.tipsy.css', PJ_THIRD_PARTY_PATH . 'tipsy/');
            $this->appendJs('index.php?controller=pjAdmin&action=pjActionMessages', PJ_INSTALL_URL, true);
            
        }
        
    }
    
    public function pjActionDeleteBusTypeOption(){
//         ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $this->setAjax(true);

        if ($this->isXHR()) {
            $response = array();
            $pjBusTypeModel = pjBusTypeOptionItemModel::factory();
            $arr = $pjBusTypeModel->find($_GET['id'])->getData();
            if ($pjBusTypeModel->reset()->setAttributes(array('id' => $_GET['id']))->erase()->getAffectedRows() == 1) {
              
                pjMultiLangModel::factory()->where('model', 'pjBusTypeOptionItemModel')->where('foreign_id', $_GET['id'])->eraseAll();
                
                pjBusTypeOptionModel::factory()->where('option_id', $_GET['id'])->eraseAll();

                $response['code'] = 200;
            } else {
                $response['code'] = 100;
            }

            pjAppController::jsonResponse($response);
        }
        exit;
        
    }

    
    
    public function pjActionDeleteBusTypeOptionFile(){
//        ini_set("display_errors", "On");
//        error_reporting(E_ALL ^ E_DEPRECATED);
        
        $pjBusTypeOptionItemModel = pjBusTypeOptionItemModel::factory();
        $arr = $pjBusTypeOptionItemModel->find($_GET['id'])->getData();
     
        
        if(is_file($arr['svg_source']) && unlink($arr['svg_source'])){
            $db = pjRegistry::getInstance()->get('dbo');
            $db->query("UPDATE `{$pjBusTypeOptionItemModel->getTable()}` SET svg_source = NULL WHERE `id` = {$_GET['id']}");
        }
        
        pjUtil::redirect($_SERVER['PHP_SELF'] . "?controller=pjAdminBusTypeOptions&action=pjActionUpdateBusTypeOption&id=" . $_GET['id']);
        
    }
    
}
?>