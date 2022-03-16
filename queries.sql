ALTER TABLE `transactions` ADD `type` ENUM('W', 'V', 'B') NOT NULL DEFAULT 'V' AFTER `winner`;
ALTER TABLE `transactions` ADD `updated` DATETIME NULL DEFAULT NULL AFTER `created`;