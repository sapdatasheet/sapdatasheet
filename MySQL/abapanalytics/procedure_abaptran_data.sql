-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `abaptran_data`()
BEGIN

  delete from abapanalytics.abaptran;
  insert into abapanalytics.abaptran (tcode)
    select tcode from abap.tstc;  

  call abapanalytics.abaptran_data_hira();
  call abapanalytics.abaptran_data_param();
  call abapanalytics.abaptran_data_param_parse();
  call abapanalytics.abaptran_data_view();

END