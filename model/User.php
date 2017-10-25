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
		if (isset($login))
			$this->_login = $login;
		$this->_db = $db;
		$this->_db_save = $db->prepare("INSERT INTO `user` (`login`, `email`, `password`, `link`)
										VALUES(?, ?, ?, ?)");
		$this->_db_login = $db->prepare("SELECT * FROM `user` WHERE `login` = ?");
		$this->_db_email = $db->prepare("SELECT * FROM `user` WHERE `email` = ?");
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
			$link = hash('whirlpool', $this->_email . time());
			$this->_execute_query($this->_db_save, [$this->_login, $email, $password, $link]);
			$this->_send_mail($link);
			return (TRUE);
		}
	}

	public function check_user_login($password) {
		if (($user = $this->_check_user_login()) !== FALSE) {
			return ($this->_check_user_password($user, $password));
		} else if (($user = $this->_check_user_email()) !== FALSE) {
			return ($this->_check_user_password($user, $password));
		} else
			return ('<div class="error">Login not found!</div><hr/>');
	}

	public function check_user_activation($link) {
		$user_link = $this->_db->prepare("SELECT * FROM `user` WHERE `link` = ?");
		if ($this->_execute_query($user_link, [$link])) {
			$user = $user_link->fetch();
			if ($user !== FALSE) {
				if ($user['status'] === '0') {
					$update = $this->_db->prepare("UPDATE `user` SET `status` = '1' WHERE `id` = ?");
					if ($this->_execute_query($update, [$user['id']])) {
						return ('<div class="msg">You successfully confirmed your registration!</div><hr/>');
					}
				} else {
					return ('<div class="error">
					You have already confirmed your registration, no need to repeat it!</div><hr/>');
				}
			}
		}
		return ('<div class="error">Wrong activation link!</div><hr/>');
	}

	private function _send_mail($link) {
		$mail_to = $this->_email;
		$from_name = 'Alexandr Kaplyar';
		$from_mail = 'akaplyar@student.unit.ua';
		$mail_subject = 'Camagru registration';
		$mail_message = "Hi $this->_login!<br/>Looks like you registered on my Camagru project<br/>";
		$mail_message .= "Please, confirm your registration by clicking the link below<br/>";
		$mail_message .= "http://localhost:8080" . "/activate/" . $link . "\r\n";
		$encoding = "utf-8";

		$subject_preferences = array(
			"input-charset" => $encoding,
			"output-charset" => $encoding,
			"line-length" => 76,
			"line-break-chars" => "\r\n"
		);
		$header = "Content-type: text/html; charset=" . $encoding . " \r\n";
		$header .= "From: " . $from_name . " <" . $from_mail . "> \r\n";
		$header .= "MIME-Version: 1.0 \r\n";
		$header .= "Content-Transfer-Encoding: 8bit \r\n";
		$header .= "Date: " . date("r (T)") . " \r\n";
		$header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

		mail($mail_to, $mail_subject, $mail_message, $header);
	}

	private function _execute_query($sql, $params) {
		if (isset($params))
			return $sql->execute($params);
		else
			return $sql->execute();
	}

	private function _check_user_login() {
		if ($this->_execute_query($this->_db_login, [$this->_login])) {
			return ($this->_db_login->fetch());
		} else
			return (FALSE);
	}

	private function _check_user_email() {
		if ($this->_execute_query($this->_db_email,
			isset($this->_email) ? [$this->_email] : [$this->_login])) {
			return ($this->_db_email->fetch());
		} else
			return (FALSE);
	}

	private function _check_user_password($user, $password) {
		if (password_verify($password, $user['password'])) {
			if ($user['status'] === '1') {
				$this->_email = $user['email'];
				return (TRUE);
			} else
				return ('<div class="error">Please, confirm your registration!</div><hr/>');
		} else
			return ('<div class="error">Wrong password!</div><hr/>');
	}

	public function setEmail($email) {
		$this->_email = $email;
	}

	public function __destruct() {
		// TODO: Implement __destruct() method.
	}
}
