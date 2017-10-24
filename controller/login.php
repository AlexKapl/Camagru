<?php
require_once(ROOT . '/config/setup.php');

if (isset($_SESSION['user']))
	header("Location: Lobby.php");
require(ROOT . '/view/login.php');
if (isset($_POST['do_login'])) {
	$user = new User($_POST['login'], $db);
	if ($user->check_user_exist()) {
		if ($user->check_user_password()) {
			$_SESSION['login'] = $_POST['login'];
			header('Location: Lobby.php');
		} else
			echo '<div style="color: red" ">Wrong password!</div><hr/>';
	} else
		echo '<div style="color: red" ">Login not found!</div><hr/>';
}
