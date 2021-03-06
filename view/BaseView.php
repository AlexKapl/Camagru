<?php

abstract class BaseView
{
	protected $styles = [];
	protected $scripts = [];

	protected $header = "";
	protected $title = "";
	protected $menu = "";
	protected $body = "";
	protected $footer = "";

	protected $pattern = "(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*";


	abstract protected function makeBody();

	public function __construct($title)
	{
		$this->title = $title;
		$this->styles = ["style", "forms"];
	}

	// Page rendering
	public function createView()
	{
		$this->makeHeader();
		$this->makeBody();
		$this->makeFooter();

		$view = $this->header;
		if (isset($_SESSION['Message'])) {
			$view .= $_SESSION['Message'];
			unset($_SESSION['Message']);
		}
		$view .= $this->body . $this->footer;

		return ($view);
	}

	protected function makeHeader()
	{
		$logo = BASE . '/images/logo1.png';
		$styles = "";
		foreach ($this->styles as $style) {
			$link = BASE . "/style/$style";
			$styles .= "\t<link rel=\"stylesheet\" href=\"$link.css\">\n";
		}
		$scripts = "";
		foreach ($this->scripts as $script) {
			$link = BASE . "/scripts/$script";
			$scripts .= "\t<script src=\"$link.js\"></script>\n";
		}
		$this->header = <<< EOT
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>$this->title</title>
$styles
$scripts
</head>
<body>
<header>
	<nav class="container">
		<div class="logo">
			<img class="max" src="$logo">
		</div>
	$this->menu
	</nav>
</header>

EOT;
	}

	protected function makeFooter()
	{
		$links = "";
		foreach (["facebook", "linkedin-3", "instagram"] as $media) {
			$link = BASE . "/images/$media";
			$format = '<a title="%s" href="" target="_blank"><img src="%s-24.gif"></a>';
			$links .= sprintf("\t\t\t\t".$format."\n", $media, $link);
		}
		$this->footer = <<< EOT
<footer>
	<div class="container">
		<div class="footer-col">
			<span>Camagru © 2019</span>
		</div>
		<div class="footer-col">
			<div class="social-bar-wrap">
$links
			</div>
		</div>
		<div class="footer-col">
			<a href="mailto:akaplyar@student.unit.ua">Contact us</a>
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
EOT;
	}

}
