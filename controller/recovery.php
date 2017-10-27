<?php
require_once(ROOT . '/model/User.php');
$user = new User(NULL, $db);
if (isset($_POST['recovery_hide'])) {
	$valid = $user->user_password_recovery($_POST['password'], $_POST['password2'], $args);
	if ($valid === TRUE) {
		$_SESSION['Message'] = '<div class="msg">You successfully changed your password</div><hr/>';
		header('Location: http://localhost:8080/login');
		exit (0);
	} else if ($valid === FALSE) {
		$_SESSION['Message'] = '<div class="error">Wrong recovery link!<br/>Nice try, little hacker ;)</div><hr/>';
		header('Location: http://localhost:8080/login');
		exit (0);
	} else {
		$_SESSION['Message'] = $valid;
		require(ROOT . '/view/recovery.html');
	}
} else if ($user->user_check_link($args) !== FALSE) {
	require(ROOT . '/view/recovery.html');
} else {
	$_SESSION['Message'] = '<div class="error">Wrong recovery link!<br/>Nice try, little hacker ;)</div><hr/>';
	header('Location: http://localhost:8080/login');
	exit (0);
}

