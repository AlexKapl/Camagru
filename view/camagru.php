<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Camagru</title>
	<link rel="stylesheet" href="../style/style.css">
</head>
<body>
<header>
    <div class="container header">
		<div class="logo">
		</div>
		<div class="menu">
			<ul class="menu">
				<li>
					main
				</li>
				<li>
					user
				</li>
				<li>
					<a href="http://localhost:8080/logout">logout</a>
				</li>
			</ul>
		</div>
	</div>
</header>
<?= $_SESSION['Message'] ?>
<div class="content">
	Lorem ipsum dolor amend
</div>
<footer>
	<div class="container footer">
		<p>
			Lorem ipsum dolor amend
		</p>
	</div>
</footer>
</body>
</html>