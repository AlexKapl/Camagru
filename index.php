<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Constants definition
define('ROOT', __DIR__);
define('BASE', 'http://localhost/camagru');
define('pattern', '(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*');
require_once(ROOT . '/model/Router.php');
require_once(ROOT . '/config/setup.php');

// Messages controlling
function setSessionMessage($type, $msg) {
	$_SESSION['Message'] = "<div class=\"$type\">$msg</div><hr/>";
}

function setMessage($msg) {
	if (!empty($msg))
		setSessionMessage("msg", $msg);
}

function setError($msg) {
	if (!empty($msg))
		setSessionMessage("error", $msg);
}

if (!isset($_SESSION['Message']))
	$_SESSION['Message'] = NULL;

// Routes parsing and controller calling
$router = new Router();
$res = $router->route();
print_r($res);
// $controller = $res[0];
// $header = $res[1];
// $args = isset($res[2]) ? $res[2] : NULL;

// if (file_exists($controller)) {
// 	require_once ($controller);
// } else {
// 	require_once ('404.html');
// }
