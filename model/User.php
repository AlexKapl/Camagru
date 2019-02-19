<?php

class User
{
	private $_login;
	private $_email;
	private $_db;
	private $_db_save;
	private $_db_login;
	private $_db_email;
	private $_db_link;

	public function __construct($login, $db) {
		if (isset($login))
			$this->_login = $login;
		$this->_db = $db;
		$this->_db_save = $db->prepare("INSERT INTO `user` (`login`, `email`, `password`, `link`)
										VALUES(?, ?, ?, ?)");
		$this->_db_login = $db->prepare("SELECT * FROM `user` WHERE `login` = ?");
		$this->_db_email = $db->prepare("SELECT * FROM `user` WHERE `email` = ?");
		$this->_db_link = $db->prepare("SELECT * FROM `user` WHERE `link` = ?");
	}

	public function check_user_signing_up($email, $password) {
		$this->_email = $email;
		if ($this->_check_user_login())
			return ('<div class="error">This login is already used!</div><hr/>');
		else if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
			return ('<div class="error">Invalid email!</div><hr/>');
		else if ($this->_check_user_email() !== FALSE)
			return ('<div class="error">This email is already used!</div><hr/>');
		else {
			$password = password_hash(hash('whirlpool', $password), PASSWORD_DEFAULT);
			$link = hash('whirlpool', hash('whirlpool', $this->_email . time()));
			$this->_execute_query($this->_db_save, [$this->_login, $email, $password, $link]);
			$mail_message = "Hi $this->_login!<br/>Looks like you registered on my Camagru project<br/>";
			$mail_message .= "Please, confirm your registration by clicking the link below<br/>";
			$mail_message .= "http://localhost:8080" . "/activate/" . $link . "\r\n";
			$mail_subject = 'Camagru registration';
			$this->_send_mail($mail_message, $mail_subject);
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
		if (($user = $this->user_check_link($link)) !== FALSE) {
			if ($user !== FALSE) {
				if ($user['status'] === '0') {
					$update = $this->_db->prepare("UPDATE `user` SET `status` = '1', `link` = NULL WHERE `id` = ?");
					if ($this->_execute_query($update, [$user['id']])) {
						return ('<div class="msg">You successfully confirmed your registration!</div><hr/>');
					}
				}
			}
		}
		return ('<div class="error">Wrong activation link!</div><hr/>');
	}

	public function user_check_link($link) {
		if (isset($link)) {
			if ($this->_execute_query($this->_db_link, [$link])) {
				if (($user = $this->_db_link->fetch()) !== FALSE) {
					return ($user);
				}
			}
		}
		return (FALSE);
	}

	public function user_password_recovery($password, $password2, $link) {
		if (($user = $this->user_check_link($link)) !== FALSE) {
			if (strcmp($password, $password2) === 0) {
				$update = $this->_db->prepare("UPDATE `user` SET `password` = ?, `link` = NULL WHERE `id` = ?");
				$password = password_hash(hash('whirlpool', $password), PASSWORD_DEFAULT);
				if ($this->_execute_query($update, [$password, $user['id']])) {
					return (TRUE);
				} else {
					return ('<div class="error">Something goes wrong, try again</div><hr/>');
				}
			} else {
				return ('<div class="error">Passwords didn\'t match!</div><hr/>');
			}
		}
		return (FALSE);
	}

	public function user_password_forgot($email) {
		$this->_email = $email;
		if (($user = $this->_check_user_email()) !== FALSE) {
			$link = hash('whirlpool', hash('whirlpool', $this->_email . time()));
			$update = $this->_db->prepare("UPDATE `user` SET `link` = ? WHERE `id` = ?");
			if ($this->_execute_query($update, [$link, $user['id']])) {
				$mail_message = "Hi $this->_login!<br/>Someone requested password recovery on my Camagru project.<br/>";
				$mail_message .= "If it was not you, just ignore this message.<br/>";
				$mail_message .= "Otherwise to continue clock the link below.<br/>";
				$mail_message .= "http://localhost:8080/recovery/" . $link . "\r\n";
				$mail_subject = 'Camagru password recovery';
				$this->_send_mail($mail_message, $mail_subject);
				return ('<div class="error">Recovery message has been sent to your email.<br/>
							If it did\'t come, try again</div><hr/>');
			}
		}
		return ('<div class="error">Email not found!</div><hr/>');
	}

	private function _send_mail($mail_message, $mail_subject) {
		$mail_to = $this->_email;
		$from_name = 'Alexandr Kaplyar';
		$from_mail = 'akaplyar@student.unit.ua';
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
		$param = isset($this->_email) ? [$this->_email] : [$this->_login];
		if ($this->_execute_query($this->_db_email, $param))
			return ($this->_db_email->fetch());
		else
			return (FALSE);
	}

	private function _check_user_password($user, $password) {
		if (password_verify(hash('whirlpool', $password), $user['password'])) {
			if ($user['status'] === '1') {
				$this->_email = $user['email'];
				return (TRUE);
			} else {
				return ('<div class="error">Please, confirm your registration!</div><hr/>');
			}
		} else {
			return ('<div class="error">Wrong password!</div><hr/>');
		}
	}

	public function setEmail($email) {
		$this->_email = $email;
	}

	public function __destruct() {
		// TODO: Implement __destruct() method.
	}
}
