-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `abaptran_data_hira`()
BEGIN
-- abapanalytics.abaptran-package     -->  abap.tadir-devclass    abap.tdevc-devclass
-- abapanalytics.abaptran-packagens   -->  abap.tdevc-namespace
-- abapanalytics.abaptran-packagep    -->  abap.tdevc-parentcl
-- abapanalytics.abaptran-applfctr    -->  abap.tdevc-component   abap.df14l-FCTR_ID
-- abapanalytics.abaptran-applposid   -->  abap.df14l-ps_posid    
-- abapanalytics.abaptran-softcomp    -->  abap.tdevc-dlvunit

  DECLARE loop_tran_done INT DEFAULT FALSE;
  DECLARE v_tcode       VARCHAR(20);
  DECLARE v_package     VARCHAR(30);
  DECLARE v_packagens   VARCHAR(10);
  DECLARE v_packagep    VARCHAR(30);
  DECLARE v_applfctr    VARCHAR(20);
  DECLARE v_applposid   VARCHAR(24);
  DECLARE v_softcomp    VARCHAR(30);
  DECLARE c_tran        CURSOR FOR SELECT tcode FROM abapanalytics.abaptran;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET loop_tran_done = TRUE;

  -- Clear the existing hierarchy value
  update abapanalytics.abaptran set 
    softcomp   = null, 
    applposid  = null, applfctr   = null,
    package    = null, packagens  = null, packagep  = null;

  -- Load the hierarchy info
  OPEN c_tran;
  loop_tran:LOOP
    set loop_tran_done = false;
    fetch c_tran into v_tcode;
    IF loop_tran_done = TRUE THEN
        LEAVE loop_tran;
    END IF;

    set v_package = null;
    set v_packagens = null;
    set v_packagep = null;
    set v_applfctr = null;
    set v_applposid = null;
    set v_softcomp = null;

    select trim(devclass) into v_package 
      from abap.tadir 
      where pgmid    = 'R3TR'
        and object   = 'TRAN'
        and obj_name = v_tcode;
    if length(v_package) > 0 then
      update abapanalytics.abaptran set package = v_package where tcode = v_tcode;

      select trim(dlvunit), trim(component), trim(namespace), trim(parentcl)
        into v_softcomp, v_applfctr, v_packagens, v_packagep
        from abap.tdevc
        where devclass = v_package;
      if length(v_softcomp) > 0 then
        update abapanalytics.abaptran set softcomp = v_softcomp where tcode = v_tcode;
      end if;
      if length(v_packagens) > 0 then
        update abapanalytics.abaptran set packagens = v_packagens where tcode = v_tcode;
      end if;
      if length(v_packagep) > 0 then
        update abapanalytics.abaptran set packagep = v_packagep where tcode = v_tcode;
      end if;

      -- Start Application-Component
      -- If we can get Application-Component from TDEVC table
      if length(v_applfctr) > 0 then
        update abapanalytics.abaptran set applfctr = v_applfctr where tcode = v_tcode;

        select trim(ps_posid) into v_applposid 
          from abap.df14l 
          where fctr_id = v_applfctr;
        if length(v_applposid) > 0 then
          update abapanalytics.abaptran set applposid = v_applposid where tcode = v_tcode;
		end if;
       -- If we can NOT get Application-Component from TDEVC table, use the Parent Package
      else
        if length(v_packagep) > 0 then
          select trim(component), trim(parentcl)
            into v_applfctr, v_packagep
            from abap.tdevc
            where devclass = v_packagep;

          if length(v_applfctr) > 0 then
            update abapanalytics.abaptran set applfctr = v_applfctr where tcode = v_tcode;

            select trim(ps_posid) into v_applposid 
              from abap.df14l 
              where fctr_id = v_applfctr;
            if length(v_applposid) > 0 then
              update abapanalytics.abaptran set applposid = v_applposid where tcode = v_tcode;
		    end if;
		  end if;
        end if;
      end if;
      -- End Application-Component
    end if;
  end loop;
  CLOSE c_tran;

  call abapanalytics.debug_msg('tran_data_hira() ended');

END