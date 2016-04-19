-- Create Table

CREATE TABLE `abaptran` (
  `TCODE` varchar(20) COLLATE utf8_bin NOT NULL COMMENT 'Transaction Code',
  `SOFTCOMP` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Software Component',
  `APPLPOSID` varchar(24) COLLATE utf8_bin DEFAULT NULL COMMENT 'Application component - PS_POSID, Human readable format',
  `APPLFCTR` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT 'Application component - FCTR_ID, Technical ID',
  `PACKAGE` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Package',
  `PACKAGENS` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT 'Package name space',
  `PACKAGEP` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Package parent',
  `PROGNAME` varchar(40) COLLATE utf8_bin DEFAULT NULL COMMENT 'ABAP Program name',
  `DYPNO` int(11) DEFAULT NULL COMMENT 'ABAP Program Dynpro number',
  `PARAM` varchar(254) COLLATE utf8_bin DEFAULT NULL COMMENT 'TCode Parameter',
  `CALLEDTCODE` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT 'Called transaction code (if exist)',
  `VARIANT` varchar(14) COLLATE utf8_bin DEFAULT NULL COMMENT 'Variant',
  `CALLEDPROGNAME` varchar(40) COLLATE utf8_bin DEFAULT NULL COMMENT 'Called Program',
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
  PRIMARY KEY (`TCODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Transaction Code';


-- Prepare Data
CALL `abapanalytics`.`abaptran_data`();

-- Clean Data
-- Clear Local System T-Codes
DELETE FROM abapanalytics.abaptran
  WHERE SOFTCOMP = 'LOCAL';

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

