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
	<form class="form" action="forgot" method="POST">
		<?= $_SESSION['Message'] ?>
		<p>
			<input type="email" name="email" required placeholder="Email"
				   value="">
		</p>
		<p>
			<button type="submit" name="forgot">
				Send
			</button>
		</p>
		<p>
			<button class="forgot" onclick='location.href="login"'>
				Back to login
			</button>
		</p>
	</form>
</div>
</body>
</html>
