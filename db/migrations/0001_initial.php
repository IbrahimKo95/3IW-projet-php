<?php

var_dump($_ENV);

$databaseConnection = new PDO(
"mysql:host=mariadb;dbname=database;charset=utf8mb4",
"user",
"password"
);

$databaseConnection->query("
CREATE TABLE `users`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `firstname` VARCHAR(255) NOT NULL,
    `lastname` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL
);
CREATE TABLE `groups`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);
CREATE TABLE `users_groups`(
    `user_id` BIGINT UNSIGNED NOT NULL,
    `groups_id` BIGINT NOT NULL,
    `permission` BIGINT NOT NULL
);
ALTER TABLE
    `users_groups` ADD INDEX `users_groups_user_id_index`(`user_id`);
ALTER TABLE
    `users_groups` ADD INDEX `users_groups_groups_id_index`(`groups_id`);
CREATE TABLE `posted_photos`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT NOT NULL,
    `group_id` BIGINT NOT NULL,
    `photos` LONGBLOB NOT NULL,
    `label` VARCHAR(255) NULL,
    `visibility` VARCHAR(255) NOT NULL DEFAULT 'group',
    `token` VARCHAR(64) DEFAULT NULL
);
ALTER TABLE
    `posted_photos` ADD INDEX `posted_photos_user_id_index`(`user_id`);
ALTER TABLE
    `posted_photos` ADD INDEX `posted_photos_group_id_index`(`group_id`);
ALTER TABLE
    `users_groups` ADD CONSTRAINT `users_groups_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`);
ALTER TABLE
    `posted_photos` ADD CONSTRAINT `posted_photos_group_id_foreign` FOREIGN KEY(`group_id`) REFERENCES `groups`(`id`);
ALTER TABLE
    `posted_photos` ADD CONSTRAINT `posted_photos_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `users`(`id`);
ALTER TABLE
    `users_groups` ADD CONSTRAINT `users_groups_groups_id_foreign` FOREIGN KEY(`groups_id`) REFERENCES `groups`(`id`);
);
");
