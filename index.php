<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Constants definition
define('ROOT', __DIR__);
define('BASE', 'http://localhost/camagru');
require_once(ROOT . '/model/Router.php');
require_once(ROOT . '/config/setup.php');
require_once(ROOT . '/controller/BaseController.php');
require_once(ROOT . '/view/BaseView.php');

// Routes parsing and controller calling
$router = new Router();
$router->route();
