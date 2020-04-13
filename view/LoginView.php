<?php

class LoginView extends BaseView
{
	function __construct()
	{
		parent::__construct("Camagru: Login");
	}

	protected function makeBody()
	{
		$action = BASE.'/login';
		$this->body = <<< EOT
<div class="wrapper">
	<div class="container">
		<form class="form" action="$action" method="POST">
			<input type="text" name="login" required pattern="[\w\d]{6,}" placeholder="Login(min 6)">
			<br/>
			<input type="password" name="password" required pattern="$this->pattern" placeholder="Password(min 6)">
			<br/>
			<button name="do_login">Log In</button>
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
