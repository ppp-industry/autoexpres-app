<?php
require_once __DIR__ . '/Loader.php';
require_once __DIR__ . '/Retriever.php';
require_once __DIR__ . '/functions.php';;

//app.pavluks-trans.com
(new Loader)->load((isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] === 'app.pavluks-trans.com') ? '.env.prod' : '.env');
