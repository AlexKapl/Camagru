<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="../style/style.css">
	<link rel="stylesheet" href="../style/login.css">
	<style>
		nav {
			text-align: center;
		}
	</style>
</head>
<body>
<header>
	<nav class="container">
		<div class="logo">
			<img class="max" src="../images/logo1.png">
		</div>
	</nav>
</header>
<form class="form" action="login" method="POST">
	<?= $_SESSION['Message'] ?>
	<input type="text" name="login" required pattern="[\w\d]{6,}" placeholder="Login(min 6)">
	<br/>
	<input type="password" name="password" required pattern="<?= pattern ?>" placeholder="Password(min 6)">
	<br/>
	<button name="do_login">LogIn</button>
	<br/>
	<button class="signup" onclick='location.href="signup"'>Register</button>
	<br/>
	<button class="signup" onclick='location.href="forgot"'>Forgot password?</button>
</form>
<footer>
	<div class="container">
		<div class="footer-col">
			<span>Camagru © 2017</span>
		</div>
		<div class="footer-col">
			<div class="social-bar-wrap">
				<a title="Facebook" href="" target="_blank"><img src="../images/facebook-24.gif"></a>
				<a title="LinkedIn" href="" target="_blank"><img src="../images/linkedin-24.gif"></a>
				<a title="Instagram" href="" target="_blank"><img src="../images/instagram-24.gif"></a>
			</div>
		</div>
		<div class="footer-col">
			<a href="mailto:admin@yoursite.ru">Contact us</a>
		</div>
	</div>
</footer>
</body>
</html>
