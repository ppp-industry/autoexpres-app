<?php
function vd($var){
    
    
    echo '<pre>';
    echo var_dump($var);
    exit();

}

if (!headers_sent()) {
    session_name('BusSchedule');
    @session_start();
}
if (isset($_GET["reporting"]) && $_GET["reporting"] == '0') {
    $_SESSION["error_reporting"] = '0';
} else if (isset($_GET["reporting"]) && $_GET["reporting"] == '1') {
    $_SESSION["error_reporting"] = '1';
}

//if (isset($_SESSION["error_reporting"]) && $_SESSION["error_reporting"] == '1') {
//    ini_set("display_errors", "On");
//    error_reporting(E_ALL ^ E_DEPRECATED);
//} else {
    error_reporting(0);
//}

//if(isset($_GET['action']) == 'pjActionConfirmLiqPay' || preg_match('/api\/payment\/confirmLiqPay/', $_SERVER['REQUEST_URI'])){
//    file_put_contents('post.data', var_export($_POST, true));
//}

header("Content-type: text/html; charset=utf-8");
if (!defined("ROOT_PATH")) {
    define("ROOT_PATH", dirname(__FILE__) . '/');
}
require_once ROOT_PATH . 'ext/dotenv/install.php';
require ROOT_PATH . 'app/config/options.inc.php';
require_once PJ_FRAMEWORK_PATH . 'pjAutoloader.class.php';
require ROOT_PATH . 'core/Router.php';
require_once PJ_FRAMEWORK_PATH . 'pjObserver.class.php';

pjAutoloader::register();
Router::run(); 

$pjObserver = pjObserver::factory();
$pjObserver->init();

?>