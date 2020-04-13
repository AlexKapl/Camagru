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

$main_tables = [
	"CREATE TABLE IF NOT EXISTS `users` (
		`id` INT NOT NULL AUTO_INCREMENT,
		`login` VARCHAR(30) NOT NULL,
		`password` VARCHAR(255) NOT NULL,
		`email` VARCHAR(255) NOT NULL,
		`link` VARCHAR(300) UNIQUE,
		`status` ENUM('0', '1') DEFAULT '0' NOT NULL,
		PRIMARY KEY (`id`)
	)",
	"CREATE TABLE IF NOT EXISTS `images` (
		`id` INT NOT NULL AUTO_INCREMENT,
		`user_id` INT NOT NULL,
		`likes` INT NOT NULL DEFAULT 0,
		`comments` INT NOT NULL DEFAULT 0,
		`private` ENUM('0', '1') DEFAULT '0' NOT NULL,
		PRIMARY KEY (`id`),
		CONSTRAINT `FK_image_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
	)",
	"CREATE TABLE IF NOT EXISTS `comments` (
		`id` INT NOT NULL AUTO_INCREMENT,
		`user_id` INT NOT NULL,
		`message` TEXT,
		PRIMARY KEY (`id`),
		CONSTRAINT `FK_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
	)",
];

$linking_tables = [
	"CREATE TABLE IF NOT EXISTS `likes` (
		`user_id` INT NOT NULL,
		`image_id` INT NOT NULL,
		PRIMARY KEY (`user_id`, `image_id`),
		CONSTRAINT `FK_like_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
		CONSTRAINT `FK_like_image_id` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
	)",
	"CREATE TABLE IF NOT EXISTS `image_comments` (
		`image_id` INT NOT NULL,
		`comment_id` INT NOT NULL,
		PRIMARY KEY (`image_id`, `comment_id`),
		CONSTRAINT `FK_img_comment_image_id` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
		CONSTRAINT `FK_img_comment_comment_id` FOREIGN KEY (`comment_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
	)",
];

$tables = array_merge($main_tables, $linking_tables);

foreach ($tables as $table) {
	try {
		$db->query($table);
	} catch (PDOException $e) {
		echo "Can't create table: " . $e->getMessage() . "\n";
		exit (1);
	}
}
