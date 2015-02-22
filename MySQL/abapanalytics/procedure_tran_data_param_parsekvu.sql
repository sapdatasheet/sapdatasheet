-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tran_data_param_parsekvu`(
  IN i_kvu_tcode  varchar(20),
  IN i_kvu_param  varchar(254),   -- Example: aaa=bbb
  IN i_kvu_level  int
)
BEGIN
-- Update Key and Value

  DECLARE v_kvu_pos    int;             -- Position of sub-string
  DECLARE v_kvu_key    VARCHAR(132);
  DECLARE v_kvu_value  VARCHAR(50);

-- call debug_msg(concat('KVU Parameter: i_kvu_tcode = ', i_kvu_tcode));
-- call debug_msg(concat('KVU Parameter: i_kvu_param = ', i_kvu_param));
-- call debug_msg(concat('KVU Parameter: i_kvu_level = ', i_kvu_level));

  if length(i_kvu_param) > 0 then
    set v_kvu_pos = position('=' in i_kvu_param);
    if v_kvu_pos > 0 then
      set v_kvu_key = left(substr(i_kvu_param, 1, v_kvu_pos - 1), 132);
      set v_kvu_value = left(substr(i_kvu_param, v_kvu_pos + 1), 50);
--    call debug_msg(concat('KVU Variable: v_kvu_key = ', v_kvu_key));
--    call debug_msg(concat('KVU Variable: v_kvu_value = ', v_kvu_value));

      case i_kvu_level 
        when 1 then
--       call debug_msg('Update 1');
         update tran set key1 = v_kvu_key, value1 = v_kvu_value where tcode = i_kvu_tcode;
        when 2 then
--       call debug_msg('Update 2');
         update tran set key2 = v_kvu_key, value2 = v_kvu_value where tcode = i_kvu_tcode;
        when 3 then
--       call debug_msg('Update 3');
         update tran set key3 = v_kvu_key, value3 = v_kvu_value where tcode = i_kvu_tcode;
        when 4 then
--       call debug_msg('Update 4');
         update tran set key4 = v_kvu_key, value4 = v_kvu_value where tcode = i_kvu_tcode;
        when 5 then
--       call debug_msg('Update 5');
         update tran set key5 = v_kvu_key, value5 = v_kvu_value where tcode = i_kvu_tcode;
        when 6 then
--       call debug_msg('Update 6');
         update tran set key6 = v_kvu_key, value6 = v_kvu_value where tcode = i_kvu_tcode;
        when 7 then
--       call debug_msg('Update 7');
         update tran set key7 = v_kvu_key, value7 = v_kvu_value where tcode = i_kvu_tcode;
        else
         call debug_msg(concat('TCode contains more than 7 parameters: ', i_kvu_tcode));
	  end case;
    end if;
  end if;

END