<?php
$error = NULL;
if (isset($_POST['sign_up'])) {
	require_once(ROOT . '/model/User.php');
	$user = new User($_POST['login'], $db);
	$valid = $user->check_user_signing_up($_POST['email'], $_POST['password']);
	if ($valid === TRUE) {
		$_SESSION['registered'] = TRUE;
		header('Location: login');
	} else {
		$error = $valid;
	}
}
require(ROOT . '/view/signup.php');
