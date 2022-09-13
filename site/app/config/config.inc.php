<?php
if (!defined("PJ_HOST")) define("PJ_HOST", env('MARIADB_HOST','db'));
if (!defined("PJ_USER")) define("PJ_USER", env('MARIADB_USER'));
if (!defined("PJ_PASS")) define("PJ_PASS", env('MARIADB_PASSWORD'));
if (!defined("PJ_DB")) define("PJ_DB", env('MARIADB_DATABASE'));
if (!defined("PJ_PREFIX")) define("PJ_PREFIX", env('MARIADB_PREFIX',''));

if (!defined("PJ_INSTALL_FOLDER")) define("PJ_INSTALL_FOLDER", "");
if (!defined("PJ_INSTALL_PATH")) define("PJ_INSTALL_PATH", "/home/lfgbyisb/ticket.autoexpres.kiev.ua/");
if (!defined("PJ_INSTALL_URL")) define("PJ_INSTALL_URL", "http://localhost/");
if (!defined("PJ_SALT")) define("PJ_SALT", "B47A515O");
if (!defined("PJ_INSTALLATION")) define("PJ_INSTALLATION", "1.1111111111111E+28");
?>