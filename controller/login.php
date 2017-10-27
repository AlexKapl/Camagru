<?php
if (isset($_SESSION['login'])) {
	header('Location: camagru');
	exit (0);
}
if (isset($_POST['do_login'])) {
	require_once(ROOT . '/model/User.php');
	$user = new User($_POST['login'], $db);
	$valid = $user->check_user_login($_POST['password']);
	if ($valid === TRUE) {
		$_SESSION['login'] = $_POST['login'];
		$_SESSION['Message'] = '<div class="msg">Welcome back, ' . $_SESSION['login'] . '!</div><hr/>';
		header('Location: camagru');
		exit (0);
	} else {
		$_SESSION['Message'] = $valid;
	}
}
require(ROOT . '/view/login.html');
$_SESSION['Message'] = NULL;
