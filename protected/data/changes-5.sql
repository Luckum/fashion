USE `fashion`;

ALTER TABLE `alerts` DROP FOREIGN KEY `alerts_ibfk_4`,  DROP FOREIGN KEY `alerts_ibfk_5`, DROP COLUMN `size_id`, DROP COLUMN `size_type_id`;
ALTER TABLE `alerts` ADD COLUMN `size_type` INT(10) UNSIGNED AFTER `subcategory_id`, ADD FOREIGN KEY (`size_type`) REFERENCES `size_chart`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;