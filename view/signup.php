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
	<form class="form" action="signup" method="POST">
		<?= $_SESSION['Message'] ?>
		<p>
			<input type="email" name="email" required placeholder="Email"
				   value="">
		</p>
		<p>
			<input type="text" name="login" required pattern="[\w\d]{6,}" placeholder="Login(min 6)">
		</p>
		<p>
			<input type="password" name="password" required pattern="<?=pattern?>" placeholder="password(min 6)">
		</p>
		<p>
			<button type="submit" name="sign_up">
				Register
			</button>
		</p>
	</form>
</div>
</body>
</html>
