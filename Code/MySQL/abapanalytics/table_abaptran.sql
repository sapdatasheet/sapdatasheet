-- Create Table

CREATE TABLE `abaptran` (
  `TCODE` varchar(20) COLLATE utf8_bin NOT NULL COMMENT 'Transaction Code',
  `TCODENS` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT 'TCode Name Space, the left part of /xxx/',
  `PGMNA` varchar(40) COLLATE utf8_bin DEFAULT NULL COMMENT 'ABAP Program name',
  `DYPNO` int(11) DEFAULT NULL COMMENT 'ABAP Program Dynpro number',
  `SOFTCOMP` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Software Component',
  `SOFTCOMP_GROUP` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `APPLPOSID` varchar(24) COLLATE utf8_bin DEFAULT NULL COMMENT 'Application component - PS_POSID, Human readable format',
  `APPLFCTR` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT 'Application component - FCTR_ID, Technical ID',
  `PACKAGE` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Package',
  `PACKAGENS` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT 'Package name space',
  `PACKAGEP` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Package parent',
  `PARAM` varchar(254) COLLATE utf8_bin DEFAULT NULL COMMENT 'TCode Parameter',
  `CALLEDTCODE` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT 'Called transaction code (if exist)',
  `VARIANT` varchar(14) COLLATE utf8_bin DEFAULT NULL COMMENT 'Variant',
  `CALLEDPROGNAME` varchar(40) COLLATE utf8_bin DEFAULT NULL COMMENT 'Called Program, alwasy the same as PGMNA',
  `CALLEDCLASS` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Called Class',
  `CALLEDMETHOD` varchar(61) COLLATE utf8_bin DEFAULT NULL COMMENT 'Called Method',
  `CALLEDVIEW` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Called View',
  `CALLEDVIEWC` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Called View Cluster',
  `UPDATEFLAG` varchar(1) COLLATE utf8_bin DEFAULT NULL COMMENT 'Update or not',
  `KEY1` varchar(132) COLLATE utf8_bin DEFAULT NULL COMMENT 'Parameter transaction: Field name for parameter passing',
  `VALUE1` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT 'Parameter transaction: Value to be passed',
  `KEY2` varchar(132) COLLATE utf8_bin DEFAULT NULL,
  `VALUE2` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `KEY3` varchar(132) COLLATE utf8_bin DEFAULT NULL,
  `VALUE3` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `KEY4` varchar(132) COLLATE utf8_bin DEFAULT NULL,
  `VALUE4` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `KEY5` varchar(132) COLLATE utf8_bin DEFAULT NULL,
  `VALUE5` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `KEY6` varchar(132) COLLATE utf8_bin DEFAULT NULL,
  `VALUE6` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `KEY7` varchar(132) COLLATE utf8_bin DEFAULT NULL,
  `VALUE7` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `DEBUG` varchar(254) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID_LMAX` int(11) DEFAULT NULL,
  `PS_POSID_L1` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID_L2` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID_L3` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID_L4` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID_L5` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID_L6` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID_L7` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID_L8` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID_L9` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `FCTR_ID_L1` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `FCTR_ID_L2` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `FCTR_ID_L3` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `FCTR_ID_L4` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `FCTR_ID_L5` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `FCTR_ID_L6` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `FCTR_ID_L7` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `FCTR_ID_L8` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `FCTR_ID_L9` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`TCODE`),
  KEY `abaptran_pgmna` (`PGMNA`),
  KEY `abaptran_softcomp` (`SOFTCOMP`),
  KEY `abaptran_package` (`PACKAGE`),
  KEY `abaptran_packagep` (`PACKAGEP`),
  KEY `abaptran_calledtcode` (`CALLEDTCODE`),
  KEY `abaptran_calledview` (`CALLEDVIEW`),
  KEY `abaptran_calledviewc` (`CALLEDVIEWC`),
  KEY `abaptran_ps_posid_l1` (`PS_POSID_L1`),
  KEY `abaptran_fctr_id_l1` (`FCTR_ID_L1`),
  KEY `abaptran_fctr_id_l2` (`FCTR_ID_L2`),
  KEY `abaptran_fctr_id_l3` (`FCTR_ID_L3`),
  KEY `abaptran_fctr_id_l4` (`FCTR_ID_L4`),
  KEY `abaptran_fctr_id_l5` (`FCTR_ID_L5`),
  KEY `abaptran_fctr_id_l6` (`FCTR_ID_L6`),
  KEY `abaptran_fctr_id_l7` (`FCTR_ID_L7`),
  KEY `abaptran_fctr_id_l8` (`FCTR_ID_L8`),
  KEY `abaptran_fctr_id_l9` (`FCTR_ID_L9`),
  KEY `abaptran_tcodens` (`TCODENS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Transaction Code';

-- Prepare Data

delete from abapanalytics.abaptran;
insert into abapanalytics.abaptran (tcode, pgmna, dypno)
    select tcode, pgmna, dypno from abap.tstc;  

UPDATE abapanalytics.abaptran 
  SET DYPNO = null 
  WHERE DYPNO = 0
;

-- Clean Data - Clear Local System T-Codes
DELETE FROM abapanalytics.abaptran
  WHERE SOFTCOMP = 'LOCAL' OR SOFTCOMP = 'HOME'
;

-- TCode Name Space

update abapanalytics.abaptran
  set tcodens = left(tcode, (length(tcode) - length(substring_index(tcode, '/', -1))))
  where left(tcode) = '/'
;

update abapanalytics.abaptran
  set tcodens = null
  where length(trim(tcodens)) < 1
;
	
-- Hierarchy Data
-- abapanalytics.abaptran-package     -->  abap.tadir-devclass    abap.tdevc-devclass
-- abapanalytics.abaptran-packagens   -->  abap.tdevc-namespace
-- abapanalytics.abaptran-packagep    -->  abap.tdevc-parentcl
-- abapanalytics.abaptran-applfctr    -->  abap.tdevc-component   abap.df14l-FCTR_ID
-- abapanalytics.abaptran-applposid   -->  abap.df14l-ps_posid    
-- abapanalytics.abaptran-softcomp    -->  abap.tdevc-dlvunit
	
update abapanalytics.abaptran a
  left join abap.tadir b on a.tcode = b.obj_name and b.pgmid = 'R3TR' and b.object = 'TRAN'
  set a.package = trim(b.DEVCLASS)
;

DELETE FROM abapanalytics.abaptran
  where PACKAGE is null              -- Clear non-hierarchy data
;

update abapanalytics.abaptran a
  left join abap.tdevc b on a.package = b.devclass
  set a.packagens = trim(b.namespace),
      a.packagep = trim(b.parentcl),
      a.applfctr = trim(b.component),
      a.SOFTCOMP = trim(b.DLVUNIT)
;

DELETE from abapanalytics.abaptran
  where SOFTCOMP is null
;

-- Software Group: Merge all HR Software Components
UPDATE abapanalytics.abaptran
  SET SOFTCOMP_GROUP = SOFTCOMP
;

UPDATE abapanalytics.abaptran
  SET SOFTCOMP_GROUP = 'SAP_HR'
  WHERE SOFTCOMP_GROUP LIKE 'SAP_HR%'
;

UPDATE abapanalytics.abaptran
  SET SOFTCOMP_GROUP = 'EA-HR'
  WHERE SOFTCOMP_GROUP LIKE 'EA-HR%'
;

-- Parent Package
UPDATE abapanalytics.abaptran
  SET PACKAGEP = null
  WHERE length(trim(PACKAGEP)) < 1
;
  
update abapanalytics.abaptran a
  left join abap.tdevc b on a.packagep = b.devclass -- Use Parent Package if cannot find appl-component
  set a.applfctr = trim(b.component)
  where length(trim(applfctr)) < 1
;

update abapanalytics.abaptran a
  left join abap.df14l b on a.applfctr = b.FCTR_ID
  set a.applposid = trim(b.ps_posid)
;

DELETE FROM abapanalytics.abaptran
  where APPLPOSID is null
;

-- TCode Parameters

update abapanalytics.abaptran a
  left join abap.tstcp b on a.tcode = b.TCODE
  set a.PARAM = trim(b.PARAM)
;

update abapanalytics.abaptran
  set PARAM = null
  where length(trim(PARAM)) < 1
;

CALL `abapanalytics`.`abaptran_data_param_parse`();

-- Generate data for view, view cluster, and update flag

update abapanalytics.abaptran set calledview = left(trim(value1), 30) where upper(trim(key1)) = 'VIEWNAME';
update abapanalytics.abaptran set calledview = left(trim(value2), 30) where upper(trim(key2)) = 'VIEWNAME';

update abapanalytics.abaptran set calledviewc = left(trim(value1), 30) where upper(trim(key1)) = 'VCLDIR-VCLNAME';
update abapanalytics.abaptran set calledviewc = left(trim(value2), 30) where upper(trim(key2)) = 'VCLDIR-VCLNAME';

update abapanalytics.abaptran set updateflag = left(trim(value1), 1) where upper(trim(key1)) = 'UPDATE';
update abapanalytics.abaptran set updateflag = left(trim(value2), 1) where upper(trim(key2)) = 'UPDATE';

-- Fill in Application Components

UPDATE abapanalytics.abaptran a
  left join abapanalytics.abapbmfr b on a.APPLFCTR = b.FCTR_ID
  set a.PS_POSID_LMAX = b.PS_POSID_LMAX,
      a.PS_POSID_L1 = b.PS_POSID_L1,
      a.PS_POSID_L2 = b.PS_POSID_L2,
      a.PS_POSID_L3 = b.PS_POSID_L3,
      a.PS_POSID_L4 = b.PS_POSID_L4,
      a.PS_POSID_L5 = b.PS_POSID_L5,
      a.PS_POSID_L6 = b.PS_POSID_L6,
      a.PS_POSID_L7 = b.PS_POSID_L7,
      a.PS_POSID_L8 = b.PS_POSID_L8,
      a.PS_POSID_L9 = b.PS_POSID_L9,
      a.FCTR_ID_L1 = b.FCTR_ID_L1,
      a.FCTR_ID_L2 = b.FCTR_ID_L2,
      a.FCTR_ID_L3 = b.FCTR_ID_L3,
      a.FCTR_ID_L4 = b.FCTR_ID_L4,
      a.FCTR_ID_L5 = b.FCTR_ID_L5,
      a.FCTR_ID_L6 = b.FCTR_ID_L6,
      a.FCTR_ID_L7 = b.FCTR_ID_L7,
      a.FCTR_ID_L8 = b.FCTR_ID_L8,
      a.FCTR_ID_L9 = b.FCTR_ID_L9
;

-- Create Indexes, for Analytics

DROP   INDEX abaptran_tcodens on abapanalytics.abaptran;
CREATE INDEX abaptran_tcodens on abapanalytics.abaptran(tcodens);

DROP   INDEX abaptran_pgmna on abapanalytics.abaptran;
CREATE INDEX abaptran_pgmna on abapanalytics.abaptran(pgmna);

DROP   INDEX abaptran_softcomp on abapanalytics.abaptran;
CREATE INDEX abaptran_softcomp on abapanalytics.abaptran(softcomp);

DROP   INDEX abaptran_applposid on abapanalytics.abaptran;
CREATE INDEX abaptran_applposid on abapanalytics.abaptran(applposid);

DROP   INDEX abaptran_package on abapanalytics.abaptran;
CREATE INDEX abaptran_package on abapanalytics.abaptran(package);

DROP   INDEX abaptran_packagep on abapanalytics.abaptran;
CREATE INDEX abaptran_packagep on abapanalytics.abaptran(packagep);

DROP   INDEX abaptran_calledtcode on abapanalytics.abaptran;
CREATE INDEX abaptran_calledtcode on abapanalytics.abaptran(calledtcode);

DROP   INDEX abaptran_calledview on abapanalytics.abaptran;
CREATE INDEX abaptran_calledview on abapanalytics.abaptran(calledview);

DROP   INDEX abaptran_calledviewc on abapanalytics.abaptran;
CREATE INDEX abaptran_calledviewc on abapanalytics.abaptran(calledviewc);

DROP   INDEX abaptran_ps_posid_l1 on abapanalytics.abaptran;
CREATE INDEX abaptran_ps_posid_l1 on abapanalytics.abaptran(ps_posid_l1);

DROP   INDEX abaptran_ps_posid_l2 on abapanalytics.abaptran;
CREATE INDEX abaptran_ps_posid_l2 on abapanalytics.abaptran(ps_posid_l2);

DROP   INDEX abaptran_ps_posid_l3 on abapanalytics.abaptran;
CREATE INDEX abaptran_ps_posid_l3 on abapanalytics.abaptran(ps_posid_l3);

DROP   INDEX abaptran_ps_posid_l4 on abapanalytics.abaptran;
CREATE INDEX abaptran_ps_posid_l4 on abapanalytics.abaptran(ps_posid_l4);

DROP   INDEX abaptran_ps_posid_l5 on abapanalytics.abaptran;
CREATE INDEX abaptran_ps_posid_l5 on abapanalytics.abaptran(ps_posid_l5);

DROP   INDEX abaptran_ps_posid_l6 on abapanalytics.abaptran;
CREATE INDEX abaptran_ps_posid_l6 on abapanalytics.abaptran(ps_posid_l6);

DROP   INDEX abaptran_ps_posid_l7 on abapanalytics.abaptran;
CREATE INDEX abaptran_ps_posid_l7 on abapanalytics.abaptran(ps_posid_l7);

DROP   INDEX abaptran_fctr_id_l1 on abapanalytics.abaptran;
CREATE INDEX abaptran_fctr_id_l1 on abapanalytics.abaptran(fctr_id_l1);

DROP   INDEX abaptran_fctr_id_l2 on abapanalytics.abaptran;
CREATE INDEX abaptran_fctr_id_l2 on abapanalytics.abaptran(fctr_id_l2);

DROP   INDEX abaptran_fctr_id_l3 on abapanalytics.abaptran;
CREATE INDEX abaptran_fctr_id_l3 on abapanalytics.abaptran(fctr_id_l3);

DROP   INDEX abaptran_fctr_id_l4 on abapanalytics.abaptran;
CREATE INDEX abaptran_fctr_id_l4 on abapanalytics.abaptran(fctr_id_l4);

DROP   INDEX abaptran_fctr_id_l5 on abapanalytics.abaptran;
CREATE INDEX abaptran_fctr_id_l5 on abapanalytics.abaptran(fctr_id_l5);

DROP   INDEX abaptran_fctr_id_l6 on abapanalytics.abaptran;
CREATE INDEX abaptran_fctr_id_l6 on abapanalytics.abaptran(fctr_id_l6);

DROP   INDEX abaptran_fctr_id_l7 on abapanalytics.abaptran;
CREATE INDEX abaptran_fctr_id_l7 on abapanalytics.abaptran(fctr_id_l7);

DROP   INDEX abaptran_fctr_id_l8 on abapanalytics.abaptran;
CREATE INDEX abaptran_fctr_id_l8 on abapanalytics.abaptran(fctr_id_l8);

DROP   INDEX abaptran_fctr_id_l9 on abapanalytics.abaptran;
CREATE INDEX abaptran_fctr_id_l9 on abapanalytics.abaptran(fctr_id_l9);

