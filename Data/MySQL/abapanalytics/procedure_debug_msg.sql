-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `debug_msg`(i_msg VARCHAR(255))
BEGIN
  select concat("** ", i_msg) AS '** DEBUG:';
END