<?php

class LoginView extends BaseView
{
	private $pattern = "(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*";

	function __construct()
	{
		parent::__construct("Camagru: Forgot Password");
	}

	protected function makeBody()
	{
		$this->body = <<< EOT
<div class="wrapper">
	<div class="container">
		<form class="form" action="forgot" method="POST">
			<input type="email" name="email" required placeholder="Email">
			<br/>
			<button type="submit" name="forgot">Send</button>
			<br/>
			<button class="forgot" onclick='location.href="login"'>Back to login</button>
			<br/>
		</form>
	</div>
</div>
EOT;
	}
}
