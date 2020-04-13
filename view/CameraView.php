<?php

class CameraView extends BaseView
{

	function __construct()
	{
		parent::__construct("Camagru: Photo Page");

		$this->styles[] = 'camera';
		$this->scripts = ['camera'];
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
		<div class="video">
			<video id="video" width="640" height="480" autoplay></video>
			<canvas id="canvas" width="640" height="480"></canvas>
		</div>
		<button id="snap">Snap Photo</button>
		<div class="canvas">
			<canvas id="snap_canvas" width="640" height="480"></canvas>
		</div>
	</div>
</div>
EOT;
	}
}
