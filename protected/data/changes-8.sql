USE `fashion`;

ALTER TABLE `filters` ADD `seller_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `seller_profile` MODIFY `seller_type` enum('business','private') COLLATE utf8_bin NOT NULL DEFAULT 'private';