<?php

require ("../config/setup.php");

class User
{
	private $_login;
	private $_email;
	private $_password;

	public function __construct($login) {
		if (isset($login))
			$this->_login = $login;
		else
			$this->_login = $_SESSION['login'];
	}

	public function check_user_exist($db) {
		$exist = "Select * FROM `user` WHERE `login` = :login OR `email` = :email";
		$db->prepare($exist);
		return (FALSE);
	}

	public function __destruct() {
		// TODO: Implement __destruct() method.
	}
}
