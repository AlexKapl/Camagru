<?php
require_once(ROOT . '/model/User.php');
$user = new User(NULL, $db);
if (isset($_POST['recovery_hide'])) {
	if (($valid = $user->user_password_recovery($_POST['password'], $_POST['password2'])) === TRUE) {
		$_SESSION['Message'] = $valid;
		header('Location: http://localhost:8080/login');
		exit (0);
	} else {
		$_SESSION['Message'] = $valid;
		require(ROOT . '/view/recovery.php');
	}
} else if (($valid = $user->user_check_link($args)) === TRUE) {
	require(ROOT . '/view/recovery.php');
} else {
	$_SESSION['Message'] = $valid;
	header('Location: http://localhost:8080/login');
	exit (0);
}

