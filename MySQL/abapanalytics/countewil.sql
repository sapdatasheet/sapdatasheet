drop table abapanalytics.wilcounter;

CREATE TABLE abapanalytics.`wilcounter` (
  `OBJ_TYPE` varchar(4) COLLATE utf8_bin NOT NULL,
  `OBJ_NAME` varchar(40) COLLATE utf8_bin NOT NULL,
  `SRC_OBJ_TYPE` varchar(4) COLLATE utf8_bin NOT NULL,
  `COUNTER` int(11) DEFAULT NULL,
  PRIMARY KEY (`OBJ_TYPE`,`OBJ_NAME`,`SRC_OBJ_TYPE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='ABAP Where Using List Counter';

-- Runtime: 61 sec
insert into abapanalytics.wilcounter
select OBJ_TYPE, OBJ_NAME, SRC_OBJ_TYPE, count(SRC_OBJ_NAME) as COUNTER
  from abap.ywul
  group by OBJ_TYPE, OBJ_NAME, SRC_OBJ_TYPE;

/*
SELECT distinct obj_type FROM abapanalytics.wilcounter;

DOMA
DTEL
VIEW
TABL
SHLP
INTF
CLAS
FUNC
PROG
TRAN

CX_E
DIAL
ECAT
ECTD
ENHO
ENHS
ENQU
LDBA
MCOB
METH
PINF
SCP2
SHI3
SOBJ
SQSC
SUSO
SXSD
TTYP
TYPE
UENO
WAPA
WEBI

*/
