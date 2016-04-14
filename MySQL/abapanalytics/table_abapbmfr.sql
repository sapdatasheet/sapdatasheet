-- Create Table

CREATE TABLE `abapbmfr` (
  `FCTR_ID` varchar(20) COLLATE utf8_bin NOT NULL,
  `FSTDATE` varchar(8) COLLATE utf8_bin DEFAULT NULL,
  `FSTTIME` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `RELE` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID_LMAX` int(11) DEFAULT NULL COMMENT 'Max Level of the PS_POSID',
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
  PRIMARY KEY (`FCTR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Application Component Table';

--
-- Table Data
--

-- Initialize Data
DELETE FROM abapanalytics.abapbmfr;
INSERT INTO abapanalytics.abapbmfr(FCTR_ID, FSTDATE, FSTTIME, RELE, PS_POSID, PS_POSID_LMAX)
SELECT FCTR_ID, FSTDATE, FSTTIME, RELE, PS_POSID, (length(ps_posid )-length(replace(ps_posid ,'-',''))) as PS_POSID_LMAX 
  FROM abap.df14l
  where length(trim(fctr_id)) > 0
;

-- PS_POSID Level 1
UPDATE abapanalytics.abapbmfr
  SET ps_posid_l1 = SUBSTRING_INDEX(ps_posid, '-', 1)
;

-- PS_POSID Level 2
UPDATE abapanalytics.abapbmfr
  SET ps_posid_l2 = SUBSTRING_INDEX(ps_posid, '-', 2)
;

UPDATE abapanalytics.abapbmfr
  SET ps_posid_l2 = NULL
  WHERE (length(ps_posid_l2)-length(replace(ps_posid_l2 ,'-','')) + 1) <> 2;
;

-- PS_POSID Level 3
UPDATE abapanalytics.abapbmfr
  SET ps_posid_l3 = SUBSTRING_INDEX(ps_posid, '-', 3)
;

UPDATE abapanalytics.abapbmfr
  SET ps_posid_l3 = NULL
  WHERE (length(ps_posid_l3)-length(replace(ps_posid_l3 ,'-','')) + 1) <> 3;
;

-- PS_POSID Level 4
UPDATE abapanalytics.abapbmfr
  SET ps_posid_l4 = SUBSTRING_INDEX(ps_posid, '-', 4)
;

UPDATE abapanalytics.abapbmfr
  SET ps_posid_l4 = NULL
  WHERE (length(ps_posid_l4)-length(replace(ps_posid_l4 ,'-','')) + 1) <> 4;
;

-- PS_POSID Level 5
UPDATE abapanalytics.abapbmfr
  SET ps_posid_l5 = SUBSTRING_INDEX(ps_posid, '-', 5)
;

UPDATE abapanalytics.abapbmfr
  SET ps_posid_l5 = NULL
  WHERE (length(ps_posid_l5)-length(replace(ps_posid_l5 ,'-','')) + 1) <> 5;
;

-- PS_POSID Level 6
UPDATE abapanalytics.abapbmfr
  SET ps_posid_l6 = SUBSTRING_INDEX(ps_posid, '-', 6)
;

UPDATE abapanalytics.abapbmfr
  SET ps_posid_l6 = NULL
  WHERE (length(ps_posid_l6)-length(replace(ps_posid_l6 ,'-','')) + 1) <> 6;
;

-- PS_POSID Level 7
UPDATE abapanalytics.abapbmfr
  SET ps_posid_l7 = SUBSTRING_INDEX(ps_posid, '-', 7)
;

UPDATE abapanalytics.abapbmfr
  SET ps_posid_l7 = NULL
  WHERE (length(ps_posid_l7)-length(replace(ps_posid_l7 ,'-','')) + 1) <> 7;
;

-- PS_POSID Level 8
UPDATE abapanalytics.abapbmfr
  SET ps_posid_l8 = SUBSTRING_INDEX(ps_posid, '-', 8)
;

UPDATE abapanalytics.abapbmfr
  SET ps_posid_l8 = NULL
  WHERE (length(ps_posid_l8)-length(replace(ps_posid_l8 ,'-','')) + 1) <> 8;
;

-- PS_POSID Level 9
UPDATE abapanalytics.abapbmfr
  SET ps_posid_l9 = SUBSTRING_INDEX(ps_posid, '-', 9)
;

UPDATE abapanalytics.abapbmfr
  SET ps_posid_l9 = NULL
  WHERE (length(ps_posid_l9)-length(replace(ps_posid_l9 ,'-','')) + 1) <> 9;
;

-- FCTR_ID Levels

update abapanalytics.abapbmfr a
  left join abap.df14l b on a.ps_posid_l1 = b.PS_POSID
  set a.fctr_id_l1 = b.fctr_id
;

update abapanalytics.abapbmfr a
  left join abap.df14l b on a.ps_posid_l2 = b.PS_POSID
  set a.fctr_id_l2 = b.fctr_id
;

update abapanalytics.abapbmfr a
  left join abap.df14l b on a.ps_posid_l3 = b.PS_POSID
  set a.fctr_id_l3 = b.fctr_id
;

update abapanalytics.abapbmfr a
  left join abap.df14l b on a.ps_posid_l4 = b.PS_POSID
  set a.fctr_id_l4 = b.fctr_id
;

update abapanalytics.abapbmfr a
  left join abap.df14l b on a.ps_posid_l5 = b.PS_POSID
  set a.fctr_id_l5 = b.fctr_id
;

update abapanalytics.abapbmfr a
  left join abap.df14l b on a.ps_posid_l6 = b.PS_POSID
  set a.fctr_id_l6 = b.fctr_id
;

update abapanalytics.abapbmfr a
  left join abap.df14l b on a.ps_posid_l7 = b.PS_POSID
  set a.fctr_id_l7 = b.fctr_id
;

update abapanalytics.abapbmfr a
  left join abap.df14l b on a.ps_posid_l8 = b.PS_POSID
  set a.fctr_id_l8 = b.fctr_id
;

update abapanalytics.abapbmfr a
  left join abap.df14l b on a.ps_posid_l9 = b.PS_POSID
  set a.fctr_id_l9 = b.fctr_id
;

-- Clear non-exist FCTR_ID

SELECT * FROM abapanalytics.abapbmfr 
  where fctr_id_l1 is null
    and fctr_id_l2 is not null
  limit 10000
;

update abapanalytics.abapbmfr 
  set ps_posid_l1 = ps_posid_l2,
	  ps_posid_l2 = null,
      fctr_id_l1 = fctr_id_l2,
      fctr_id_l2 = null
  where fctr_id_l1 is null
    and fctr_id_l2 is not null
;

SELECT * FROM abapanalytics.abapbmfr 
  where fctr_id_l2 is null
    and fctr_id_l3 is not null
  limit 10000
;

update abapanalytics.abapbmfr 
  set ps_posid_l2 = ps_posid_l3,
	  ps_posid_l3 = null,
      fctr_id_l2 = fctr_id_l3,
      fctr_id_l3 = null
  where fctr_id_l2 is null
    and fctr_id_l3 is not null
;

SELECT * FROM abapanalytics.abapbmfr 
  where fctr_id_l3 is null
    and fctr_id_l4 is not null
  limit 10000
;

update abapanalytics.abapbmfr 
  set ps_posid_l3 = ps_posid_l4,
	  ps_posid_l4 = null,
      fctr_id_l3 = fctr_id_l4,
      fctr_id_l4 = null
  where fctr_id_l3 is null
    and fctr_id_l4 is not null
;

SELECT * FROM abapanalytics.abapbmfr 
  where fctr_id_l4 is null
    and fctr_id_l5 is not null
  limit 10000
;

update abapanalytics.abapbmfr 
  set ps_posid_l4 = ps_posid_l5,
	  ps_posid_l5 = null,
      fctr_id_l4 = fctr_id_l5,
      fctr_id_l5 = null
  where fctr_id_l4 is null
    and fctr_id_l5 is not null
;

SELECT * FROM abapanalytics.abapbmfr 
  where fctr_id_l5 is null
    and fctr_id_l6 is not null
  limit 10000
;

update abapanalytics.abapbmfr 
  set ps_posid_l5 = ps_posid_l6,
	  ps_posid_l6 = null,
      fctr_id_l5 = fctr_id_l6,
      fctr_id_l6 = null
  where fctr_id_l5 is null
    and fctr_id_l6 is not null
;

-- Not exists
SELECT * FROM abapanalytics.abapbmfr 
  where fctr_id_l6 is null
    and fctr_id_l7 is not null
  limit 10000
;

update abapanalytics.abapbmfr 
  set ps_posid_l6 = ps_posid_l7,
	  ps_posid_l7 = null,
      fctr_id_l6 = fctr_id_l7,
      fctr_id_l7 = null
  where fctr_id_l6 is null
    and fctr_id_l7 is not null
;

SELECT * FROM abapanalytics.abapbmfr 
  where fctr_id_l7 is null
    and fctr_id_l8 is not null
  limit 10000
;

update abapanalytics.abapbmfr 
  set ps_posid_l7 = ps_posid_l8,
	  ps_posid_l8 = null,
      fctr_id_l7 = fctr_id_l8,
      fctr_id_l8 = null
  where fctr_id_l7 is null
    and fctr_id_l8 is not null
;

SELECT * FROM abapanalytics.abapbmfr 
  where fctr_id_l8 is null
    and fctr_id_l9 is not null
  limit 10000
;

update abapanalytics.abapbmfr 
  set ps_posid_l8 = ps_posid_l9,
	  ps_posid_l9 = null,
      fctr_id_l8 = fctr_id_l9,
      fctr_id_l9 = null
  where fctr_id_l8 is null
    and fctr_id_l9 is not null
;
