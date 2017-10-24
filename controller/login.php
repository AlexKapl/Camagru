<?php
if (isset($_SESSION['login']))
	header('Location: camagru');
//$_POST['login'] = 'login';
//$_POST['do_login'] = 'yeap';
$error = NULL;
if (isset($_SESSION['registered'])) {
	$error = '<div class="goodboy">You are successfully signed up!</div><hr/>';
//	unset($_SESSION['registered']);
}
if (isset($_POST['do_login'])) { //add mail confirmation
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
