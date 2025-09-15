<?php

//     DIRECTORY_SEPARATOR konstantının dəyəri sleşdir. ( / )
defined('DS')        ? null : define('DS', DIRECTORY_SEPARATOR);

//     /laragon/www/REST-API
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'laragon'.DS.'www'.DS.'REST-API');

//     /laragon/www/REST-API/includes
defined('INCH_PATH') ? null : define('INCH_PATH', SITE_ROOT.DS.'includes');

//     /laragon/www/REST-API/core
defined('CORE_PATH') ? null : define('CORE_PATH', SITE_ROOT.DS.'core');


// echo CORE_PATH;

//      /laragon/www/REST-API/includes/config.php
require_once(INCH_PATH.DS."config.php");

//      /laragon/www/REST-API/core/post.php
require_once(CORE_PATH.DS."post.php");