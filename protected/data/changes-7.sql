USE `fashion`;

ALTER TABLE `seller_profile` ADD `billing_address` VARCHAR(255) NOT NULL DEFAULT '',
ADD `billing_address2` VARCHAR(255) NOT NULL DEFAULT '',
ADD `billing_city` VARCHAR(255) NOT NULL DEFAULT '',
ADD `billing_state` VARCHAR(255) NOT NULL DEFAULT '',
ADD `billing_zip` VARCHAR(255) NOT NULL DEFAULT '',
ADD `billing_country_id` INT(11) NOT NULL DEFAULT 1,
ADD `billing_first_name` VARCHAR(255) NOT NULL DEFAULT '',
ADD `billing_surname` VARCHAR(255) NOT NULL DEFAULT '',
ADD `bank_first_name` VARCHAR(255) NOT NULL DEFAULT '',
ADD `bank_surname` VARCHAR(255) NOT NULL DEFAULT '',
ADD `bank_iban` VARCHAR(255) NOT NULL DEFAULT '',
ADD `bank_swift_bik` VARCHAR(255) NOT NULL DEFAULT '';

ALTER TABLE `shipping_address` ADD `first_name` VARCHAR(255) NOT NULL DEFAULT '',
ADD `surname` VARCHAR(255) NOT NULL DEFAULT '';

ALTER TABLE `seller_profile`
    ADD KEY `billing_country_id` (`billing_country_id`);
ALTER TABLE `seller_profile`
    ADD CONSTRAINT `seller_profile_ibfk_country` FOREIGN KEY (`billing_country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;