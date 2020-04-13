<?php

class SignupController extends BaseController
{

	function __construct($args, $db)
	{
		parent::__construct($this, $db);
	}

	public function handleRequest()
	{
		if (isset($_POST['sign_up'])) {
			require_once(ROOT . '/model/User.php');
			$user = new User($this->db, $_POST['login']);

			if ($user->user_sign_up($_POST['email'], $_POST['password']) === TRUE) {
				$this->setMessage(
					'You are successfully signed up!<br/>
					Activation letter was sent on your email<br/>
					Please, follow instructions in it'
				);
				header('Location: login');
				exit (0);
			}
		}

		echo $this->view->createView();
	}
}
