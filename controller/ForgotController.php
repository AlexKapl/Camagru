<?php

class ForgotController extends BaseController
{

	function __construct($args, $db)
	{
		parent::__construct($this, $db);
	}

	public function handleRequest()
	{
		if (isset($_POST['forgot'])) {
			$user = new User($this->db);
			$user->user_password_forgot($_POST['email']);
		}

		echo $this->view->createView();
	}
}
