<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style/style.css">
	<title>Camagru</title>
</head>
<body>
<header>
	<nav class="container">
		<div class="logo">
			<img class="max" src="../images/logo1.png">
		</div>
		<div class="nav-toggle"><span></span></div>
		<ul id="menu">
			<li>
				<a href="http://localhost:8080/profile">User Profile</a>
			</li>
			<li>
				<a href="http://localhost:8080/logout"><img src="../images/logout-24.gif"></a>
			</li>
		</ul>
	</nav>
</header>
<?= $_SESSION['Message'] ?>
<div class="wrapper">
	<div class="container">
		<div class="post_list">
			<article id="post-1" class="post">
				<div class="post-image"><a href=""><img class="max"
														src="https://html5book.ru/wp-content/uploads/2016/05/rasskaz_slovar_rodnoy_prirodi.jpg"></a>
				</div>
				<div class="post-content">
					WTF IS THIS??<br/>
					<br/>
					<div class="post-footer">
						<div class="post-social">
							<a href="" target="_blank"><i class="fa fa-facebook"></i></a>
							<a href="" target="_blank"><i class="fa fa-twitter"></i></a>
							<a href="" target="_blank"><i class="fa fa-pinterest"></i></a>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>
</div>
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
<script>
	document.getElementsByClassName('nav-toggle')[0].onclick = function () {
		document.getElementById('menu').classList.toggle('active');
	}
</script>
</body>
</html>