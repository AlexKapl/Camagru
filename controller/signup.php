<?php
require_once '../config/setup.php';
require_once '../Classes/User.php';

if (isset($_POST['register'])) {
	$user = new User($_POST['login']);
	if ($user->check_user_exist() === FALSE)
		echo '<div style="color: red" "; margin-left: 0px; margin:auto;>This login is already used!</div><hr/>';
	else {
		$user->login = $_POST['login'];
		$user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		echo '<div style="color: greenyellow" ">You registered !</div><hr/>';
		header('Location: login.php');
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
	<link rel="stylesheet" href="../style/style.css">
	<link rel="stylesheet" href="../style/login.css">
</head>
<body>
<div class="login lfield">
	<form class="form" action="signup.php" method="POST">
		<p>
			<input type="email" name="email" required placeholder="Email"
				   value="">
		</p>
		<p>
			<input type="text" name="login" required pattern="[\w\d]{6,}" placeholder="Login(min 6)"
				   value="">
		</p>
		<p>
			<input type="password" name="password" required pattern="[\w\d]{6,}" placeholder="password(min 6)"
				   value="">
		</p>
		<p>
			<button type="submit" name="register">
				Register
			</button>
		</p>
	</form>
</div>
</body>
</html>
