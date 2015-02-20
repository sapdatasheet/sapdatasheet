-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tran_data_hira`()
BEGIN
-- abaprep.tran-devclass    -->  abap.tadir-devclass    abap.tdevc-devclass
-- abaprep.tran-devclassns  -->  abap.tdevc-namespace
-- abaprep.tran-devclassp   -->  abap.tdevc-parentcl
-- abaprep.tran-applfctr    -->  abap.tdevc-component   abap.df14l-FCTR_ID
-- abaprep.tran-applposid   -->  abap.df14l-ps_posid    
-- abaprep.tran-softcomp    -->  abap.tdevc-dlvunit



END