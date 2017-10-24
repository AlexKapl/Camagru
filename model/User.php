<?php

class User
{
	private $_db;
	private $_login;
	private $_email;
	private $_password;
	private $_db_login;
	private $_db_email;

	public function __construct($login, $db) {
//		if (isset($login))
			$this->_login = $login;
//		else
//			$this->_login = $_SESSION['login'];
		$this->_db = $db;
		$this->_db_login = $db->prepare("SELECT * FROM `user` WHERE `login` = ?");
		$this->_db_email = $db->prepare("SELECT * FROM `user` WHERE `email` = ?");
	}

	private function _get_user_data($sql, $params) {
		if (isset($params))
			return $sql->execute($params);
		else
			return $sql->execute();
	}

	public function check_user_login() {
		if ($this->_get_user_data($this->_db_login, [$this->_login]))
			return (TRUE);
		else
			return (FALSE);
	}

	public function check_user_email() {
		if ($this->_get_user_data($this->_db_email,
			isset($this->_email) ? [$this->_email] : [$this->_login]))
			return (TRUE);
		else
			return (FALSE);
	}

	public function check_user_password() {
		return (TRUE);
	}

	public function check_user_exist() {
		if ($this->check_user_login() !== FALSE) {
			return (TRUE);
		} else if ($this->check_user_email(NULL) !== FALSE) {
			return (TRUE);
		} else
			return (FALSE);
	}

	public function __destruct() {
		// TODO: Implement __destruct() method.
	}
}
