
-- Verify for DOMA

select DISTINCT OBJ_TYPE from abap.ywul
  where SRC_OBJ_TYPE = 'DOMA'
;

select * from abap.ywul
  where SRC_OBJ_TYPE = 'DOMA'
    and OBJ_TYPE = 'DTEL'
    AND OBJ_NAME NOT IN (
      SELECT rollname FROM abap.dd04l
    )
;

-- Verify for Data Element

select DISTINCT OBJ_TYPE from abap.ywul
  where SRC_OBJ_TYPE = 'DTEL'
;

/*
CLAS -
DTEL -
ECAT
ECTD
ENHO
FUNC -
PINF
PROG -
SHLP -
SOBJ
SQSC
TABL -
TTYP
TYPE
UENO
VIEW -
WAPA
WEBI
*/

