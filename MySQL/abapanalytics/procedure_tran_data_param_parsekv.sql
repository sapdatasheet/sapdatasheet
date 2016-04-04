-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tran_data_param_parsekv`(
  IN i_tcode varchar(20),
  IN i_param varchar(254)
)
BEGIN
-- Parse key=value paire for a transaction code, examples
--  VIEWNAME=V_AD03PHP;UPDATE=X;
--  VCLDIR-VCLNAME=ARCH_CLASS;UPDATE=X;
--  ARCH_TXT-OBJECT=PS_PROJECT;RADIO_FIRST=X

  DECLARE v_level  int;
  DECLARE v_p1     VARCHAR(254);
  DECLARE v_p2     VARCHAR(254);
  DECLARE v_pos    int;             -- Position of sub-string
  DECLARE v_dummy  int;

  set v_level = 1;
  set v_p1 = i_param;

  while length(v_p1) > 0 do
    set v_pos = position(';' in v_p1);
    if v_pos > 0 then

--    This is not the last key-value pair
--    a. Parse current value
      set v_p2 = substr(v_p1, 1, v_pos - 1);
      if length(v_p2) > 0 then
        call abapanalytics.tran_data_param_parsekvu(i_tcode, v_p2, v_level);
	  end if;

--    b. Call next level
      set v_level = v_level + 1; 
      set v_p1 = substr(v_p1, v_pos + 1);

    else
--    This is the last key-value pair
      if length(v_p1) > 0 then
        call abapanalytics.tran_data_param_parsekvu(i_tcode, v_p1, v_level);
      end if;
      set v_p1 = '';
    end if;
  end while;

END