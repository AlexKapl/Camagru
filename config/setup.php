<?php
require('database.php');

session_start();
try {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage() . "\n";
	exit (1);
}

try {
	$db->query(
		"CREATE TABLE IF NOT EXISTS `user`(
		`id` INT NOT NULL AUTO_INCREMENT,
		`login` VARCHAR(30) NOT NULL,
		`password` VARCHAR(255) NOT NULL,
		`email` VARCHAR(255) NOT NULL,
		`link` VARCHAR(300) NOT NULL UNIQUE,
		`status` ENUM('0', '1') DEFAULT '0',
		PRIMARY KEY (`id`))"
	);
} catch (PDOException $e) {
	echo "Can't create table: " . $e->getMessage() . "\n";
	exit (1);
}
