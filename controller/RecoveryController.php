<?php

class RecoveryController extends BaseController
{
	private $link;

	function __construct($args, $db)
	{
		parent::__construct($this, $db, $args[0]);
		$this->link = args[0];
	}

	private function hackerResponse($value='')
	{
		$this->setError('Wrong recovery link!<br/>Nice try, little hacker ;)');
		header('Location: '.BASE.'/login');
		exit (0);
	}

	public function handleRequest()
	{
		$user = new User($db);

		if (isset($_POST['recovery_hide'])) {
			$ret = $user->user_password_recovery($_POST['password'], $_POST['password2'], $this->link);
			if ($ret[0] === TRUE) {
				$this->setMessage('You successfully changed your password')
				header('Location: '.BASE.'/login');
				exit (0);
			} else if ($ret[1] === TRUE) {
				$this->hackerResponse();
			} else {
				$this->setError("Passwords doesn't match!");
			}
		} else if ($user->user_check_link($this->link) === FALSE)
			$this->hackerResponse();

		echo $this->view->createView();
	}
}
