<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="../style/style.css">
	<link rel="stylesheet" href="../style/login.css">
	<style>
		form {
			width: 25%;
			height: 15%;
		}

		button {
			margin-top: 20px;
			width: 35%;
			height: auto;
			background-color: black;
			font-size: 18px;
		}
	</style>
</head>
<body>
<form class="form" action="login" method="POST">
	<?= $_SESSION['Message'] ?>
	<p>
		<input type="text" name="login" required pattern="[\w\d]{6,}" placeholder="Login(min 6)">
	</p>
	<p>
		<input type="password" name="password" required pattern="<?=pattern?>" placeholder="Password(min 6)">
	</p>
	<p>
		<button name="do_login">
			LogIn
		</button>
	</p>
	<p>
		<button class="signup" onclick='location.href="signup"'>
			Register
		</button>
	</p>
	<p>
		<button class="signup" onclick='location.href="forgot"'>
			Forgot password?
		</button>
	</p>
</form>
</body>
</html>
