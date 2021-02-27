<?php
require_once('../config/config.php');

try {
    $pdo = new PDO("mysql:host=" . SERVER_NAME . ";dbname=" . DB_NAME, USER_NAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    echo 'Connected failed: ' . $e->getMessage();
    die();
}

$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `users` (
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` datetime DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS `lists` (
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `created_at` datetime DEFAULT NOW(),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `tasks` (
	`id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `list_id` INT UNSIGNED NOT NULL,
    `completed` BOOLEAN DEFAULT 0,
    `position` INT DEFAULT 1,
    `created_at` datetime DEFAULT NOW(),
    `completed_at` datetime,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    FOREIGN KEY (`list_id`) REFERENCES `lists` (`id`) ON DELETE CASCADE
);
SQL;

try {
    $pdo->exec($sql);
    echo 'Success';
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
echo PHP_EOL;



