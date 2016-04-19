-- Create Table

CREATE TABLE `abapdevc` (
  `DEVCLASS` varchar(30) COLLATE utf8_bin NOT NULL,
  `KORRFLAG` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `NAMESPACE` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `CREATED_ON` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `PACKAGE_KIND` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `IS_ENHANCEABLE` varchar(1) COLLATE utf8_bin DEFAULT NULL,
  `SWITCH_ID` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `DLVUNIT` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `COMPONENT` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `PARENTCL` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `SOFTCOMP_P1` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `SOFTCOMP_P2` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `SOFTCOMP_P3` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `SOFTCOMP_P4` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `SOFTCOMP_P5` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `SOFTCOMP_P6` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `SOFTCOMP_P7` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `SOFTCOMP_P8` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `SOFTCOMP_P9` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `APPLCOMP_P1` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `APPLCOMP_P2` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `APPLCOMP_P3` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `APPLCOMP_P4` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `APPLCOMP_P5` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `APPLCOMP_P6` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `APPLCOMP_P7` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `APPLCOMP_P8` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `APPLCOMP_P9` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `DEVCLASS_P1` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `DEVCLASS_P2` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `DEVCLASS_P3` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `DEVCLASS_P4` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `DEVCLASS_P5` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `DEVCLASS_P6` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `DEVCLASS_P7` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `DEVCLASS_P8` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `DEVCLASS_P9` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`DEVCLASS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


-- Initial Table Data

insert into abapanalytics.abapdevc(
  DEVCLASS, KORRFLAG, NAMESPACE, CREATED_ON, PACKAGE_KIND, IS_ENHANCEABLE, SWITCH_ID, DLVUNIT, COMPONENT, PARENTCL)
  select DEVCLASS, KORRFLAG, NAMESPACE, CREATED_ON, PACKAGE_KIND, IS_ENHANCEABLE, SWITCH_ID, DLVUNIT, COMPONENT, PARENTCL
  from abap.tdevc
  where dlvunit <> 'LOCAL'
;

UPDATE abapanalytics.abapdevc
  set DLVUNIT = null
  where length(trim(DLVUNIT)) < 1
;

UPDATE abapanalytics.abapdevc
  set COMPONENT = null
  where length(trim(COMPONENT)) < 1
;

UPDATE abapanalytics.abapdevc
  set PARENTCL = null
  where length(trim(PARENTCL)) < 1
;


-- Clmb up on Package Tree

update abapanalytics.abapdevc a
  left join abap.tdevc b on a.parentcl = b.devclass
  set a.SOFTCOMP_p1 = b.DLVUNIT,
      a.APPLCOMP_P1 = b.COMPONENT,
      a.devclass_p1 = b.PARENTCL
;

update abapanalytics.abapdevc a
  left join abap.tdevc b on a.devclass_p1 = b.devclass
  set a.SOFTCOMP_p2 = b.DLVUNIT,
      a.APPLCOMP_P2 = b.COMPONENT,
      a.devclass_p2 = b.PARENTCL
;

update abapanalytics.abapdevc a
  left join abap.tdevc b on a.devclass_p2 = b.devclass
  set a.SOFTCOMP_p3 = b.DLVUNIT,
      a.APPLCOMP_P3 = b.COMPONENT,
      a.devclass_p3 = b.PARENTCL
;

update abapanalytics.abapdevc a
  left join abap.tdevc b on a.devclass_p3 = b.devclass
  set a.SOFTCOMP_p4 = b.DLVUNIT,
      a.APPLCOMP_P4 = b.COMPONENT,
      a.devclass_p4 = b.PARENTCL
;

update abapanalytics.abapdevc a
  left join abap.tdevc b on a.devclass_p4 = b.devclass
  set a.SOFTCOMP_p5 = b.DLVUNIT,
      a.APPLCOMP_P5 = b.COMPONENT,
      a.devclass_p5 = b.PARENTCL
;

update abapanalytics.abapdevc a
  left join abap.tdevc b on a.devclass_p5 = b.devclass
  set a.SOFTCOMP_p6 = b.DLVUNIT,
      a.APPLCOMP_P6 = b.COMPONENT,
      a.devclass_p6 = b.PARENTCL
;

update abapanalytics.abapdevc a
  left join abap.tdevc b on a.devclass_p6 = b.devclass
  set a.SOFTCOMP_p7 = b.DLVUNIT,
      a.APPLCOMP_P7 = b.COMPONENT,
      a.devclass_p7 = b.PARENTCL
;

update abapanalytics.abapdevc a
  left join abap.tdevc b on a.devclass_p7 = b.devclass
  set a.SOFTCOMP_p8 = b.DLVUNIT,
      a.APPLCOMP_P8 = b.COMPONENT,
      a.devclass_p8 = b.PARENTCL
;

update abapanalytics.abapdevc a
  left join abap.tdevc b on a.devclass_p8 = b.devclass
  set a.SOFTCOMP_p9 = b.DLVUNIT,
      a.APPLCOMP_P9 = b.COMPONENT,
      a.devclass_p9 = b.PARENTCL
;

-- Clear Data

UPDATE abapanalytics.abapdevc
  set APPLCOMP_P1 = null
  where length(trim(APPLCOMP_P1)) < 1
;

UPDATE abapanalytics.abapdevc
  set APPLCOMP_P2 = null
  where length(trim(APPLCOMP_P2)) < 1
;

UPDATE abapanalytics.abapdevc
  set APPLCOMP_P3 = null
  where length(trim(APPLCOMP_P3)) < 1
;

UPDATE abapanalytics.abapdevc
  set APPLCOMP_P4 = null
  where length(trim(APPLCOMP_P4)) < 1
;

UPDATE abapanalytics.abapdevc
  set APPLCOMP_P5 = null
  where length(trim(APPLCOMP_P5)) < 1
;

UPDATE abapanalytics.abapdevc
  set APPLCOMP_P6 = null
  where length(trim(APPLCOMP_P6)) < 1
;

UPDATE abapanalytics.abapdevc
  set APPLCOMP_P7 = null
  where length(trim(APPLCOMP_P7)) < 1
;

UPDATE abapanalytics.abapdevc
  set APPLCOMP_P8 = null
  where length(trim(APPLCOMP_P8)) < 1
;

UPDATE abapanalytics.abapdevc
  set APPLCOMP_P9 = null
  where length(trim(APPLCOMP_P9)) < 1
;

UPDATE abapanalytics.abapdevc
  set DEVCLASS_P1 = null
  where length(trim(DEVCLASS_P1)) < 1
;

UPDATE abapanalytics.abapdevc
  set DEVCLASS_P2 = null
  where length(trim(DEVCLASS_P2)) < 1
;

UPDATE abapanalytics.abapdevc
  set DEVCLASS_P3 = null
  where length(trim(DEVCLASS_P3)) < 1
;

UPDATE abapanalytics.abapdevc
  set DEVCLASS_P4 = null
  where length(trim(DEVCLASS_P4)) < 1
;

UPDATE abapanalytics.abapdevc
  set DEVCLASS_P5 = null
  where length(trim(DEVCLASS_P5)) < 1
;

UPDATE abapanalytics.abapdevc
  set DEVCLASS_P6 = null
  where length(trim(DEVCLASS_P6)) < 1
;

UPDATE abapanalytics.abapdevc
  set DEVCLASS_P7 = null
  where length(trim(DEVCLASS_P7)) < 1
;

UPDATE abapanalytics.abapdevc
  set DEVCLASS_P8 = null
  where length(trim(DEVCLASS_P8)) < 1
;

UPDATE abapanalytics.abapdevc
  set DEVCLASS_P9 = null
  where length(trim(DEVCLASS_P9)) < 1
;



