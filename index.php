<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/model/Router.php');
require_once ROOT . '/config/setup.php';

$router = new Router();
$res = $router->route();
$controller = $res[0];
if (isset($res[1]))
	$args = $res[1];
if (file_exists($controller)) {
	require_once ($controller);
} else
	require_once ('404.html');
