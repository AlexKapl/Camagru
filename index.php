<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/model/Router.php');
require_once(ROOT . '/model/User.php');
require_once ROOT . '/config/setup.php';

$router = new Router($db);
$router->route();
