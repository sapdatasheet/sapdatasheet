-- Create Table

CREATE TABLE `abaptran` (
  `TCODE` varchar(20) COLLATE utf8_bin NOT NULL COMMENT 'Transaction Code',
  `SOFTCOMP` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Software Component',
  `APPLPOSIDTOP1` varchar(24) COLLATE utf8_bin DEFAULT NULL COMMENT 'Top 1 level of the Application Component',
  `APPLPOSIDTOP2` varchar(24) COLLATE utf8_bin DEFAULT NULL COMMENT 'Top 2 level of the Application Component',
  `APPLPOSIDTOP3` varchar(24) COLLATE utf8_bin DEFAULT NULL COMMENT 'Top 3 level of the Application Component',
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
  PRIMARY KEY (`TCODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Transaction Code';


-- Prepare Data
CALL `abapanalytics`.`abaptran_data`();

-- Clean Data
-- Clear Local System T-Codes
DELETE FROM abapanalytics.abaptran
  WHERE SOFTCOMP = 'LOCAL';

-- Set the APPLPOSIDTOP1 column
UPDATE abapanalytics.abaptran
  SET APPLPOSIDTOP1 = SUBSTRING_INDEX(applposid, '-', 1)
  WHERE applposid is not null;

-- Set the APPLPOSIDTOP2 column
UPDATE abapanalytics.abaptran
  SET APPLPOSIDTOP2 = SUBSTRING_INDEX(applposid, '-', 2)
  WHERE applposid is not null;

UPDATE abapanalytics.abaptran
  SET APPLPOSIDTOP2 = NULL
  WHERE APPLPOSIDTOP2 is not null 
    AND (length(APPLPOSIDTOP2)-length(replace(APPLPOSIDTOP2 ,'-',''))) <> 1;

-- Set the APPLPOSIDTOP3 column
UPDATE abapanalytics.abaptran
  SET APPLPOSIDTOP3 = SUBSTRING_INDEX(applposid, '-', 3)
  WHERE applposid is not null;

UPDATE abapanalytics.abaptran
  SET APPLPOSIDTOP3 = NULL
  WHERE APPLPOSIDTOP3 is not null 
    AND (length(APPLPOSIDTOP3)-length(replace(APPLPOSIDTOP3 ,'-',''))) <> 2;

