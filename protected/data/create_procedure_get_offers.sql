USE `fashion`;
DROP procedure IF EXISTS `get_offers`;

DELIMITER $$
USE `fashion`$$
CREATE PROCEDURE `get_offers`(_key VARCHAR(10), _value INT(11))
  BEGIN
    -- create temp table
    --
    CREATE TEMPORARY TABLE `temp_t` (`product_id` int(11) NOT NULL);

    -- fill temp table
    --
    INSERT INTO `temp_t` (`product_id`)
      SELECT DISTINCT `product_id`
      FROM `fashion`.`order_item`
      WHERE(`order_item`.`status` = 'paid'); -- only sold products

    -- get offers
    --
    IF _key = 'seller' THEN
      SELECT *
      FROM `fashion`.`offers`
      WHERE (`product_id` NOT IN (SELECT * FROM `temp_t`)
             AND `seller_id` = _value)
      ORDER BY `offers`.`id` DESC;

    ELSEIF _key = 'buyer' THEN
      SELECT *
      FROM `fashion`.`offers`
      WHERE (`product_id` NOT IN (SELECT * FROM `temp_t`)
             AND (`confirm` = 0 OR `confirm` = 1)
             AND `user_id` = _value)
      ORDER BY `offers`.`id` DESC;

    ELSEIF _key = 'unused' THEN
      SELECT *
      FROM `fashion`.`offers`
      WHERE (`product_id` NOT IN (SELECT * FROM `temp_t`)
             AND `confirm` = 1
             AND `user_id` = _value)
      ORDER BY `offers`.`id` DESC;
    END IF;

    -- drop temp table
    DROP TEMPORARY TABLE IF EXISTS `temp_t`;
  END$$

DELIMITER ;