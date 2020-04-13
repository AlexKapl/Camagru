<?php

class LoginController extends BaseController
{

	function __construct($args, $db)
	{
		parent::__construct($this, $db);
	}

	public function handleRequest()
	{
		if (isset($_SESSION['login'])) {
			header('Location: /camagru');
			exit (0);
		} else if (isset($_POST['do_login'])) {
			$login = $_POST['login'];
			$user = new User($this->db, $login);

			if ($user->user_login($_POST['password']) == TRUE) {
				$_SESSION['login'] = $login;
				$this->setMessage("Welcome back, $login!");
				header('Location: '.BASE.'/camagru');
				exit (0);
			}
		}

		echo $this->view->createView();
	}
}
