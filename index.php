<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/model/Router.php');
require_once ROOT . '/config/setup.php';

$router = new Router();
$controller = $router->route();
if ($controller) {
	require_once ($controller);
} else
	header('Location: 404');
