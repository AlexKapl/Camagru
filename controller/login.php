<?php
if (isset($_SESSION['login']))
	header('Location: camagru');
//$_POST['login'] = 'login';
//$_POST['do_login'] = 'yeap';
$error = NULL;
if (isset($_POST['do_login'])) {
	require_once(ROOT . '/model/User.php');
	$user = new User($_POST['login'], $db);
	$valid = $user->check_user_exist($_POST['password']);
	if ($valid === TRUE) {
			$_SESSION['login'] = $_POST['login'];
			header('Location: camagru');
	} else
		$error = $valid;
}
require(ROOT . '/view/login.php');
