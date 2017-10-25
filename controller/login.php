<?php
if (isset($_SESSION['login'])) {
	header('Location: camagru');
}
if (isset($_POST['do_login'])) {
	require_once(ROOT . '/model/User.php');
	$user = new User($_POST['login'], $db);
	$valid = $user->check_user_login($_POST['password']);
	if ($valid === TRUE) {
			$_SESSION['login'] = $_POST['login'];
			header('Location: camagru');
	} else {
		$_SESSION['Message'] = $valid;
	}
}
require(ROOT . '/view/login.php');
$_SESSION['Message'] = NULL;
