-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tran_data_param_parse`()
BEGIN
-- See: https://code.google.com/p/sapdatasheet/wiki/ABAPTRANAnalytics

  DECLARE loop_tran_done INT DEFAULT FALSE;
  DECLARE v_tcode  VARCHAR(20);
  DECLARE v_param  VARCHAR(254);
  DECLARE v_p1     VARCHAR(254);
  DECLARE v_p2     VARCHAR(254);
  DECLARE v_ppos   int;             -- Position of sub-string
  DECLARE v_dummy  int;
  DECLARE c_tran  CURSOR FOR select tcode, param from abaprep.tran where param is not null;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET loop_tran_done = TRUE;

  -- Clear the existing param parsed value
  update abaprep.tran 
    set calledtcode    = null, variant        = null,
        calledprogname = null, calledclass    = null, calledmethod   = null,
        key1           = null, value1         = null,
        key2           = null, value2         = null,
        key3           = null, value3         = null,
        key4           = null, value4         = null,
        key5           = null, value5         = null,
        key6           = null, value6         = null,
        debug          = null;

  -- Parse the Param value one by one
  OPEN c_tran;
  loop_tran:LOOP
    set loop_tran_done = false;
    fetch c_tran into v_tcode, v_param;
    IF loop_tran_done = TRUE THEN
        LEAVE loop_tran;
    END IF;

    if v_param like '/*%' or v_param like '/N%' then
--    /*SM34
--    /*SM34 VIEWNAME=VADSPC_USR_PROF;UPDATE=X;
--    /*SM34 VIEWNAME=VADSPC_USR_PROF;UPDATE=X
--    /NSNUM TNRO-OBJECT=CAJO_DOC3
      set v_p1 = substr(v_param, 3);
      set v_ppos = position(' ' in v_p1);
      if v_ppos = 0 then
        update abaprep.tran set calledtcode = left(v_p1, 20) where tcode = v_tcode;
      else
        update abaprep.tran set calledtcode = left(left(v_p1, v_ppos - 1), 20) where tcode = v_tcode;
		set v_p1 = substr(v_p1, v_ppos);
--      TODO - Parse the string 'aaa=bbb;ccc=ddd'
        update abaprep.tran set debug = v_p1 where tcode = v_tcode;
        call tran_data_param_parsekv(v_tcode, v_p1);
	  end if;

    elseif v_param like '@%' then
--    @MC94 T108-VAR1
--    @@FB50 FB50_L
	  set v_p1 = substr(v_param, 2);
      if v_p1 like '@%' then
	    set v_p1 = substr(v_p1, 2);
      end if;

      set v_ppos = position(' ' in v_p1);
      if v_ppos = 0 then
        update abaprep.tran set calledtcode = left(v_p1, 20) where tcode = v_tcode;
      else
        update abaprep.tran set calledtcode = left(left(v_p1, v_ppos - 1), 20) where tcode = v_tcode;
		set v_p1 = trim(substr(v_p1, v_ppos));
        if length(v_p1) > 0 then
          update abaprep.tran set variant = left(v_p1, 14) where tcode = v_tcode;
        end if;
	  end if;

    elseif v_param like 'CLASS=%' then
--    CLASS=CL_UDM_WL_CONTROLLERMETHOD=SHOW_WL
--    CLASS=METHOD=
      set v_p1 = substr(v_param, 7);               -- Delete 'CLASS='
      set v_ppos = position('METHOD=' in v_p1);
      if v_ppos > 0 then
--      Class
        set v_p2 = substr(v_p1, 1, v_ppos - 1);
        if length(v_p2) > 0 then
		  update abaprep.tran set calledclass = left(v_p2, 30) where tcode = v_tcode;
		end if;
--      Method
        set v_p2 = substr(v_p1, v_ppos);           -- Delete Class name
        set v_p2 = substr(v_p2, 8);                -- Delete 'METHOD='
        if length(v_p2) > 0 then
		  update abaprep.tran set calledmethod = left(v_p2, 61) where tcode = v_tcode;
		end if;
	  end if;

	elseif v_param like 'PROGRAM=%' then
--    PROGRAM=SAPLKE_HDB_TKEHACCCLASS=LCL_MAINMETHOD=RUN
      set v_p1 = substr(v_param, 9);               -- Delete 'PROGRAM='
      set v_ppos = position('CLASS=' in v_p1);
      if v_ppos > 0 then

--      Program
        set v_p2 = substr(v_p1, 1, v_ppos - 1);
        if length(v_p2) > 0 then
		  update abaprep.tran set calledprogname = left(v_p2, 40) where tcode = v_tcode;
		end if;

--      Class
        set v_p2 = substr(v_p1, v_ppos);           -- Delete Program name
        set v_p2 = substr(v_p2, 7);                -- Delete 'CLASS='
        set v_ppos = position('METHOD=' in v_p2);
        if v_ppos > 0 then
          set v_p1 = substr(v_p2, 1, v_ppos - 1);
		  if length(v_p1) > 0 then
            update abaprep.tran set calledclass = left(v_p1, 30) where tcode = v_tcode;
          end if;

--        Method
          set v_p2 = substr(v_p2, v_ppos);           -- Delete Class name
          set v_p2 = substr(v_p2, 8);                -- Delete 'METHOD='
          if length(v_p2) > 0 then
		    update abaprep.tran set calledmethod = left(v_p2, 61) where tcode = v_tcode;
          end if;
        end if;
      end if;

    else
--    para1=value1;para2=value2
--    variant
      if position('=' in v_param) > 0 then
--      TODO - Parse key-value
        call tran_data_param_parsekv(v_tcode, v_param);
      else
        update abaprep.tran set variant = left(v_param, 14) where tcode = v_tcode;
      end if;
    end if;

  end loop;
  CLOSE c_tran;

  call abaprep.debug_msg('tran_data_param_parse() ended');
END