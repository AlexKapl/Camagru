<?php

class User
{
	private $_login;
	private $_email;
	private $_db;
	private $_db_save;
	private $_db_login;
	private $_db_email;

	public function __construct($login, $db) {
		$this->_login = $login;
		$this->_db = $db;
		$this->_db_save = $db->prepare("INSERT INTO `user` (`login`, `email`, `password`)
										VALUES(?, ?, ?)");
		$this->_db_login = $db->prepare("SELECT * FROM `user` WHERE `login` = ?");
		$this->_db_email = $db->prepare("SELECT * FROM `user` WHERE `email` = ?");
	}

	private function _get_user_data($sql, $params) {
		if (isset($params))
			return $sql->execute($params);
		else
			return $sql->execute();
	}

	private function _check_user_login() {
		if ($this->_get_user_data($this->_db_login, [$this->_login])) {
			return ($this->_db_login->fetch());
		} else
			return (FALSE);
	}

	private function _check_user_email() {
		if ($this->_get_user_data($this->_db_email,
			isset($this->_email) ? [$this->_email] : [$this->_login])) {
			return ($this->_db_email->fetch());
		}
		else
			return (FALSE);
	}

	private function _check_user_password($user, $password) {
		if (password_verify($password, $user['password'])) {
			$this->_email = $user['email'];
			return (TRUE);
		}
		else
			return ('<div class="error">Wrong password!</div><hr/>');
	}

	public function check_user_signing_up($email, $password) {
		$this->_email = $email;
		if ($this->_check_user_login())
			return ('<div class="error">This login is already used!</div><hr/>');
		else if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
			return ('<div class="error">Invalid email!</div><hr/>');
		else if ($this->_check_user_email())
			return ('<div class="error">This email is already used!</div><hr/>');
		else {
			$password = password_hash($password, PASSWORD_DEFAULT);
			$this->_get_user_data($this->_db_save, [$this->_login, $email, $password]);
			return (TRUE);
		}
	}

	public function check_user_exist($password) {
		if (($user = $this->_check_user_login()) !== FALSE) {
			return ($this->_check_user_password($user, $password));
		} else if (($user = $this->_check_user_email()) !== FALSE) {
			return ($this->_check_user_password($user, $password));
		} else
			return ('<div class="error">Login not found!</div><hr/>');
	}

	public function setEmail($email) {
		$this->_email = $email;
	}

	public function __destruct() {
		// TODO: Implement __destruct() method.
	}
}
