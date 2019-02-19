<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', __DIR__);
define('pattern', '(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*');
require_once(ROOT . '/model/Router.php');
require_once(ROOT . '/config/setup.php');

if (!isset($_SESSION['Message']))
	$_SESSION['Message'] = NULL;
$router = new Router();
$res = $router->route();
$controller = $res[0];
$header = $res[1];
if (isset($res[2]))
	$args = $res[2];
else
	$args = NULL;
if (file_exists($controller)) {
	require_once ($controller);
} else
	require_once ('404.html');
