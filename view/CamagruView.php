<?php

class CamagruView extends BaseView
{

	function __construct()
	{
		parent::__construct("Camagru");

		$profile = BASE . '/profile';
		$logout = BASE . '/logout';
		$logout_logo = BASE . '/images/logout-24.gif';
		$this->menu = <<<EOT
<div class="nav-toggle"><span></span></div>
<ul id="menu">
	<li>
		<a href="$profile">User Profile</a>
	</li>
	<li>
		<a href="$logout"><img src="$logout_logo"></a>
	</li>
</ul>
EOT;
	}

	protected function makeBody()
	{
		$this->body = <<< EOT
<div class="wrapper">
	<div class="container">
		<div class="post_list">
			<article id="post-1" class="post">
				<div class="post-image">
					<a href="">
						<img class="max"src="https://html5book.ru/wp-content/uploads/2016/05/rasskaz_slovar_rodnoy_prirodi.jpg">
					</a>
				</div>
				<div class="post-content">
					WTF IS THIS??<br/>
					<br/>
					<div class="post-footer">
						<div class="post-social">
							<a href="camera" target=""><i class="fa fa-facebook"></i></a>
							<a href="" target="_blank"><i class="fa fa-twitter"></i></a>
							<a href="" target="_blank"><i class="fa fa-pinterest"></i></a>
						</div>
					</div>
				</div>
			</article>
		</div>
	</div>
</div>
EOT;
	}
}
