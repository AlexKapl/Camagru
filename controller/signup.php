<?php
if (isset($_POST['sign_up'])) {
	require_once(ROOT . '/model/User.php');
	$user = new User($_POST['login'], $db);
	if ($user->check_user_exist($db) === TRUE)
		echo '<div style="color: red" "; margin-left: 0px; margin:auto;>This login is already used!</div><hr/>';
	else {
		$user->login = $_POST['login'];
		$user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		echo '<div style="color: greenyellow" ">You registered !</div><hr/>';
		header('Location: login.php');
	}
}
require(ROOT . '/view/signup.php');
