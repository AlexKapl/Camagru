<?php

class SignupView extends BaseView
{
	function __construct()
	{
		parent::__construct("Camagru: Sign Up");
	}

	protected function makeBody()
	{
		$this->body = <<< EOT
<div class="wrapper">
	<div class="container">
		<form class="form" action="signup" method="POST">
			<input type="email" name="email" required placeholder="Email">
			<br/>
			<input type="text" name="login" required pattern="[\w\d]{6,}" placeholder="Login(min 6)">
			<br/>
			<input type="password" name="password" required pattern="$this->pattern" placeholder="Password(min 6)">
			<br/>
			<button type="submit" name="sign_up">Register</button>
			<br/>
			<button class="forgot" onclick='location.href="login"'>Back to login</button>
		</form>
	</div>
</div>
EOT;
	}
}
