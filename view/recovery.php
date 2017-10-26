<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register</title>
	<link rel="stylesheet" href="../style/style.css">
	<link rel="stylesheet" href="../style/login.css">
</head>
<body>
<div class="login">
	<form class="form" action="<?='http://localhost:8080/recovery/' . $args?>" method="POST">
		<?= $_SESSION['Message'] ?>
		<p>
			<input type="password" name="password" required pattern="<?=pattern?>" placeholder="Password(min 6)">
		</p>
		<p>
			<input type="password" name="password2" required pattern="<?=pattern?>" placeholder="Re-renter Password">
		</p>
		<p>
			<button type="submit" name="recovery_hide">
				Change
			</button>
		</p>
		<p>
			<button class="forgot" onclick='location.href="Location: http://localhost:8080/login"'>
				Back to login
			</button>
		</p>
	</form>
</div>
</body>
</html>
