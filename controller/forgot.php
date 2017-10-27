<?php

if (isset($_POST['forgot'])) {
	require_once(ROOT . '/model/User.php');
	$user = new User(NULL, $db);
	$_SESSION['Message'] = $user->user_password_forgot($_POST['email']);
}

require(ROOT . '/view/forgot.html');
$_SESSION['Message'] = NULL;
