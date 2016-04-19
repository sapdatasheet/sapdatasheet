-- ABAP_DB_TABLE_FUNC.TFDIR_PGMNA(...)
DROP   INDEX tlfdir_pname ON abap.tfdir;
CREATE INDEX tlfdir_pname ON abap.tfdir (pname);

-- ABAP_DB_TABLE_HIER.DF14L_Child(...)
DROP   INDEX df14l_ps_posid on abap.df14l;
CREATE INDEX df14l_ps_posid on abap.df14l(ps_posid);

-- ABAP_DB_TABLE_HIER.TADIR_Child(...)
DROP   INDEX tadir_devclass on abap.tadir;
CREATE INDEX tadir_devclass on abap.tadir(devclass);

-- ABAP_DB_TABLE_HIER.TDEVC_COMPONENT(...)
DROP   INDEX tdevc_dlvunit on abap.tdevc;
CREATE INDEX tdevc_dlvunit on abap.tdevc(dlvunit);

-- ABAP_DB_TABLE_HIER.TDEVC_DEVCLASS(...)
DROP   INDEX tdevc_component on abap.tdevc;
CREATE INDEX tdevc_component on abap.tdevc(component);

-- SEO (Class & Interface)
DROP   INDEX seometarel_refclsname on abap.seometarel;
CREATE INDEX seometarel_refclsname on abap.seometarel(refclsname);

-- ABAP_DB_TABLE_TABL.DD02L_List(...)
DROP   INDEX tdevc_tabclass on abap.dd02l;
CREATE INDEX tdevc_tabclass on abap.dd02l(tabclass);

-- ABAP_DB_TABLE_TABL.DD02L_SQLTAB(...)
DROP   INDEX tdevc_sqltab on abap.dd02l;
CREATE INDEX tdevc_sqltab on abap.dd02l(sqltab);

-- ABAP_DB_TABLE_TABL.DD17S_FIELDNAME(...)
DROP   INDEX dd17s_fieldname on abap.dd17s;
CREATE INDEX dd17s_fieldname on abap.dd17s(sqltab, fieldname);

-- ABAP_DB_TABLE_TRAN.TSTC_PGMNA(...)
DROP   INDEX tstc_pgmna on abap.tstc;
CREATE INDEX tstc_pgmna on abap.tstc(pgmna);

-- ABAP_DB_TABLE_TRAN.TSTCT_ALL(...)
DROP   INDEX tstct_tcode on abap.tstct;
CREATE INDEX tstct_tcode on abap.tstct(tcode);

-- ABAP_DB_TABLE_VIEW.DM25L(...)
DROP   INDEX dm25l_viewname on abap.dm25l;
CREATE INDEX dm25l_viewname on abap.dm25l(viewname);

-- ABAP Where Using List (WIL)
-- 1900.656 sec = 32 min
DROP   INDEX ywul_target on abap.ywul;
CREATE INDEX ywul_target on abap.ywul(obj_type, obj_name, src_obj_type);

