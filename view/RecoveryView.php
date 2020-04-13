<?php

class RecoveryView extends BaseView
{
	$private link;

	function __construct($link)
	{
		$this->link = $link;
		parent::__construct("Camagru: Password Recovery");
	}

	protected function makeBody()
	{
		$action = BASE . "/recovery/$this->link";
		$this->body = <<< EOT
<div class="wrapper">
	<div class="container">
		<form class="form" action="$action" method="POST">
			<input type="password" name="password" required pattern="$this->pattern" placeholder="Password(min 6)">
			<br/>
			<input type="password" name="password2" required pattern="$this->pattern" placeholder="Re-renter Password">
			<br/>
			<button type="submit" name="recovery_hide">Change</button>
			<br/>
			<button class="forgot" onclick='location.href="login"'>
				Back to login
			</button>
			<br/>
		</form>
	</div>
</div>
EOT;
	}
}
