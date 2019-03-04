<?php

class LoginView extends BaseView
{
	private $pattern = "(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*";

	function __construct()
	{
		parent::__construct("Camagru");
	}

	protected function makeBody()
	{
		$this->body = <<< EOT
<div class="wrapper">
	<div class="container">
		<form class="form" action="login" method="POST">
			<input type="text" name="login" required pattern="[\w\d]{6,}" placeholder="Login(min 6)">
			<br/>
			<input type="password" name="password" required pattern="$this->pattern" placeholder="Password(min 6)">
			<br/>
			<button name="do_login">LogIn</button>
			<br/>
			<button class="signup" onclick='location.href="signup"'>Register</button>
			<br/>
			<button class="forgot" onclick='location.href="forgot"'>Forgot password?</button>
			<br/>
		</form>
	</div>
</div>
EOT;
	}
}
