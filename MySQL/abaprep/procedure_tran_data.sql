-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tran_data`()
BEGIN

  call tran_data_hira();
  call tran_data_param();
  call tran_data_param_parse();

END