-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tran_data_view`()
BEGIN
-- Generate data for view, view cluster, and update flag

-- Clear exist values
  update abapanalytics.tran set calledview = null, calledviewc = null, updateflag = null;

-- Fill new values
  update abapanalytics.tran set calledview = left(trim(value1), 30) where upper(trim(key1)) = 'VIEWNAME';
  update abapanalytics.tran set calledview = left(trim(value2), 30) where upper(trim(key2)) = 'VIEWNAME';

  update abapanalytics.tran set calledviewc = left(trim(value1), 30) where upper(trim(key1)) = 'VCLDIR-VCLNAME';
  update abapanalytics.tran set calledviewc = left(trim(value2), 30) where upper(trim(key2)) = 'VCLDIR-VCLNAME';

  update abapanalytics.tran set updateflag = left(trim(value1), 1) where upper(trim(key1)) = 'UPDATE';
  update abapanalytics.tran set updateflag = left(trim(value2), 1) where upper(trim(key2)) = 'UPDATE';

END