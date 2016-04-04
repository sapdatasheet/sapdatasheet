-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tran_data`()
BEGIN

  delete from abapanalytics.tran;
  insert into abapanalytics.tran (tcode)
    select tcode from abap.tstc;  

  call tran_data_hira();
  call tran_data_param();
  call tran_data_param_parse();
  call tran_data_view();

END