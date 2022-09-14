<?php

/**
 * Description of Router
 *
 * @author alexp
 */
class Router {

    private static $instance;
    private $action;
    private $controller;
    private $params = array();

    private function __construct() {}

    protected function __clone() {}

    public function __wakeup() {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function run() {
        $instance = self::getInstance();

        $instance->setDataAboutRoute();
    }

    private static function init() {
        self::$instance = new self();
    }

    public static function getController() {
        return self::getInstance()->getProperty('controller');
    }

    public static function getParams() {
        return self::getInstance()->getProperty('params');
    }

    public function getProperty($property) {
        return isset($this->$property) ? $this->$property : null;
    }

    private static function getInstance() {
        if (!self::$instance) {
            self::init();
        }

        return self::$instance;
    }

    public function setDataAboutRoute() {
        $url = $_SERVER['REQUEST_URI'];

        if (preg_match('/^(\/(en|uk|ru))?\/api\//', $url)) {

            if(preg_match('/(en|uk|ru)/', $url,$matches)){
                $lang = $matches[0];
                
                $langToId = [
                    'uk' => 3,
                    'ru' => 2,
                    'en' => 1
                ];
                
                if(isset($langToId[$lang])){
                    $_SESSION['admin_locale_id'] = $langToId[$lang];
                }
                
            }
            
            $url = preg_replace('/^(\/(en|uk|ru))?\/api\//', '', $url);

            $data = explode('/', $url);

            if (count($data) === 3 && preg_match('/\w+\/\w+\/\d+/', $url)) {
                $this->controller = $this->params['controller'] = 'pjApi' . ucfirst($data[0]);
                $this->action = $this->params['action'] = 'pjAction' . ucfirst($data[1]);
                $this->params['id'] = $data[2];
            } elseif (count($data) == 2 && preg_match('/\w+\/\d+/', $url)) {
                $this->controller = $this->params['controller'] = 'pjApi' . ucfirst($data[0]);
                $this->params['id'] = $data[1];

                switch ($_SERVER['REQUEST_METHOD']) {
                    case 'PUT':
                        $this->action = $this->params['action'] = 'pjActionUpdate';
                        break;
                    case 'PATCH':
                        $this->action = $this->params['action'] = 'pjActionUpdate';
                        break;
                    case 'DELETE':
                        $this->action = $this->params['action'] = 'pjActionDelete';
                        break;
                }
            } elseif (count($data) == 1 && preg_match('/\w+/', $url) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->controller = $this->params['controller'] = 'pjApi' . ucfirst($data[0]);
                $this->action = $this->params['action'] = 'pjActionCreate';
            } elseif (count($data) == 1 && preg_match('/\w+/', $url) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                $this->controller = $this->params['controller'] = 'pjApi' . ucfirst($data[0]);
                $this->action = $this->params['action'] = 'pjActionIndex';
            }
        } elseif (strpos($url, 'controller') !== false) {
            $queryStr = parse_url($url, PHP_URL_QUERY);
            $queryData = [];
            parse_str($queryStr, $queryData);

            $this->controller = $queryData['controller'];


            if (isset($queryData['action'])) {
                $this->action = $queryData['action'];
            }

            $this->params = $queryData;
        } else {
            header("HTTP/1.1 301 Moved Permanently");
            pjUtil::redirect(PJ_INSTALL_URL . basename($_SERVER['PHP_SELF']) . "?controller=pjAdmin&action=pjActionIndex");
        }
    }

}
