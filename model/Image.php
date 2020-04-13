<?php

class Image
{

	public function __construct($db, $login=NULL) {
		$this->db = $db;
		$this->_login = $login;
		$this->_db_new_user = $db->prepare("INSERT INTO `image` (`login`, `email`, `password`, `link`) VALUES(?, ?, ?, ?)");
		$this->_db_login = $db->prepare("SELECT * FROM `user` WHERE `login` = ?");
		$this->_db_email = $db->prepare("SELECT * FROM `user` WHERE `email` = ?");
		$this->_db_link = $db->prepare("SELECT * FROM `user` WHERE `link` = ?");
	}
}
