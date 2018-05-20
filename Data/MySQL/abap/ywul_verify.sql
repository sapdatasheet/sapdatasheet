-- Verify for Target Object Name
--   Result: should be empty
select * from abap.ywul
  where OBJ_TYPE = ''
     or obj_name = ''
  limit 1000
;

delete from abap.ywul
  where OBJ_TYPE = ''
     or obj_name = ''
;

-- Verify for DOMA - Domain
--   Result: should be empty

select * from abap.ywul
  where OBJ_TYPE = 'DOMA'
    AND OBJ_NAME NOT IN (
      SELECT DOMNAME FROM abap.dd01l
    )
;

-- Verify for DTEL - Data Element
--   Result: should be empty

select * from abap.ywul
  where OBJ_TYPE = 'DTEL'
    AND OBJ_NAME NOT IN (
      SELECT rollname FROM abap.dd04l
    )
;

-- Verify for VIEW - View
--   Result: should be empty

select * from abap.ywul
  where OBJ_TYPE = 'VIEW'
    AND OBJ_NAME NOT IN (
      select VIEWNAME from abap.dd25l where viewname <> ''
    )
;

-- Verify for SQLT - Table Cluster/Pool
--   Result: should be empty

select * from abap.ywul
  where OBJ_TYPE = 'SQLT'
    AND OBJ_NAME NOT IN (
      select SQLTAB from abap.dd06l
    )
;


-- Verify for TABL - Table
--   Result: should be empty

select * from abap.ywul
  where OBJ_TYPE = 'TABL'
    AND OBJ_NAME NOT IN (
      select TABNAME from abap.dd02l
    )
;

-- Some Y-table found
delete  from abap.ywul
  where OBJ_TYPE = 'TABL'
    AND OBJ_NAME NOT IN (
      select TABNAME from abap.dd02l
    )
;

-- Verify for SHLP - Search Help
--   Result: should be empty

select * from abap.ywul
  where OBJ_TYPE = 'SHLP'
    AND OBJ_NAME NOT IN (
      select SHLPNAME from abap.dd30l
    )
;


-- Verify for CLAS/INTF - Class or Interface
--   Result: should be empty

select * from abap.ywul
  where OBJ_TYPE in ('CLAS', 'INTF')
    AND OBJ_NAME NOT IN (
      select CLSNAME from abap.seoclass
    )
;

select * from abap.ywul
  where SRC_OBJ_TYPE in ('CLAS', 'INTF')
    AND SRC_OBJ_NAME NOT IN (
      select CLSNAME from abap.seoclass
    )
;

delete from abap.ywul
  where OBJ_TYPE in ('CLAS', 'INTF')
    AND OBJ_NAME NOT IN (
      select CLSNAME from abap.seoclass
    )
;


-- Verify for FUNC - Function Module
--   Result: should be empty

select * from abap.ywul
  where OBJ_TYPE = 'FUNC'
    AND OBJ_NAME NOT IN (
      select FUNCNAME from abap.tfdir
    )
;

-- Some Y-function found

delete from abap.ywul
  where OBJ_TYPE = 'FUNC'
    AND OBJ_NAME NOT IN (
      select FUNCNAME from abap.tfdir
    )
;


-- Verify for PROG - Program
--   Result: should be empty

select * from abap.ywul
  where OBJ_TYPE = 'PROG'
    AND OBJ_NAME NOT IN (
      select progname from abap.yreposrcmeta
    )
;

-- Some Y-program found

delete from abap.ywul
  where OBJ_TYPE = 'PROG'
    AND OBJ_NAME NOT IN (
      select progname from abap.yreposrcmeta
    )
;


-- Verify for TRAN - Transaction Code
--   Result: should be empty

select * from abap.ywul
  where OBJ_TYPE = 'TRAN'
    AND OBJ_NAME NOT IN (
      select TCODE from abap.tstc
    )
;

-- No target object type - CUS0 - IMG Activity
-- No target object type - MSAG - Message Class
-- No target object type - DEVC - Package
-- No target object type - BMFR - Application Component

select * from abap.ywul
  where OBJ_TYPE = 'CUS0'
;

select * from abap.ywul
  where OBJ_TYPE = 'MSAG'
;

select * from abap.ywul
  where OBJ_TYPE = 'DEVC'
;

select * from abap.ywul
  where OBJ_TYPE = 'BMFR'
;
