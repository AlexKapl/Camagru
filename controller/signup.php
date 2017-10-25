<?php
if (isset($_POST['sign_up'])) {
	require_once(ROOT . '/model/User.php');
	$user = new User($_POST['login'], $db);
	$valid = $user->check_user_signing_up($_POST['email'], $_POST['password']);
	if ($valid === TRUE) {
		$_SESSION['Message'] = '<div class="msg">You are successfully signed up!<br/>
		Activation letter was sent on your email<br/>Please, follow instructions in it</div><hr/>';
		header('Location: login');
		exit (0);
	} else {
		$_SESSION['Message'] = $valid;
	}
}
require(ROOT . '/view/signup.php');
$_SESSION['Message'] = NULL;
