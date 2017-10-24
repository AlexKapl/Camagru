<?php
require_once '../config/setup.php';
require_once '../model/User.php';

if (isset($_POST['register'])) {
	$user = new User($_POST['login']);
	if ($user->check_user_exist($db) === TRUE)
		echo '<div style="color: red" "; margin-left: 0px; margin:auto;>This login is already used!</div><hr/>';
	else {
		$user->login = $_POST['login'];
		$user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		echo '<div style="color: greenyellow" ">You registered !</div><hr/>';
		header('Location: login.php');
	}
}
