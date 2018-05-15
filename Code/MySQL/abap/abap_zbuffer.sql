USE abap;

-- Buffer table for Index pages

DROP TABLE IF EXISTS `zbuffer_index_counter`;
CREATE TABLE `zbuffer_index_counter` (
  `ABAP_OTYPE` varchar(6) CHARACTER SET utf8 NOT NULL COMMENT 'ABAP Object type: BMFR, CLAS, CUS0, CVERS, DEVC, DOMA, DTEL, FUGR, FUNC, INTF, MENU, MSAG, PROG, etc',
  `LEFT1` varchar(1) CHARACTER SET utf8 NOT NULL COMMENT 'The left 1 character of the object name',
  `COUNTER` int(11) DEFAULT NULL COMMENT 'Number of records of the left 1 index',
  `PAGE_COUNT` int(11) DEFAULT NULL COMMENT 'Pages for the left 1 character',
  PRIMARY KEY (`ABAP_OTYPE`,`LEFT1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Buffer table for Index data counter';


DROP TABLE IF EXISTS `zbuffer_index_data`;
CREATE TABLE `zbuffer_index_data` (
  `ABAP_OTYPE` varchar(6) CHARACTER SET utf8 NOT NULL COMMENT 'ABAP Object type: BMFR, CLAS, CUS0, CVERS, DEVC, DOMA, DTEL, FUGR, FUNC, INTF, MENU, MSAG, PROG, etc',
  `INDEX_KEY` varchar(1) CHARACTER SET utf8 NOT NULL COMMENT 'Index key, Could be 1, 2, 3..., or A, B, C, ...',
  `PAGE` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Page of the Index key. Example: 1, 2, 3, etc',
  `data_count` int(11) DEFAULT NULL COMMENT 'Number of records of the data in data_json field',
  `data_json` json DEFAULT NULL COMMENT 'Data in JSON format',
  PRIMARY KEY (`ABAP_OTYPE`,`INDEX_KEY`,`PAGE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Buffer table for Index pages';


-- Prepare data for each Object Type

-- BMFR: Application Component

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'BMFR' as abap_otype,
    '@' as left1,                            -- TOP level Appl-Comp
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.df14l
  WHERE PS_POSID not like '%-%'              -- Top level only
    AND trim(coalesce(PS_POSID, '')) <> ''   -- Ignor Empty Appl-Comp
UNION
SELECT 
    'BMFR' as abap_otype,
    LEFT(PS_POSID, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.df14l
  WHERE length(trim(LEFT(PS_POSID, 1)))  > 0
  GROUP BY left1
;


-- DEVC: Package

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'DEVC' as abap_otype,
    LEFT(DEVCLASS, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.tdevc
  WHERE LEFT(DEVCLASS, 1) NOT IN ('$', 'Y', 'Z')
  GROUP BY left1
;


-- MSAG: Message Class

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'MSAG' as abap_otype,
    upper(LEFT(ARBGB, 1)) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.t100a
  GROUP BY left1
;


-- CUS0: IMG Activity

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'CUS0' as abap_otype,
    LEFT(ACTIVITY, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.cus_imgach
  GROUP BY left1
;


-- TRAN: Transaction Code

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'TRAN' as abap_otype,
    LEFT(TCODE, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.tstc
  WHERE LEFT(TCODE, 1) <> 'Y'
  GROUP BY left1
;


-- PROG: Program

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'PROG' as abap_otype,
    LEFT(OBJ_NAME, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.tadir
  WHERE PGMID = 'R3TR'
    AND OBJECT = 'PROG'
    AND LEFT(OBJ_NAME, 1) NOT IN (' ', '!', '$', 'Y')
  GROUP BY left1
;

-- FUGR: Function Group

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'FUGR' as abap_otype,
    LEFT(OBJ_NAME, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.tadir
  WHERE PGMID = 'R3TR'
    AND OBJECT = 'FUGR'
    AND LEFT(OBJ_NAME, 1) NOT IN (' ', 'Y')
  GROUP BY left1
;


-- FUNC: Function Module

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'FUNC' as abap_otype,
    '@' as left1,                  -- RFC
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.tfdir
  WHERE FMODE = 'R'                -- R = Remote
UNION
SELECT 
    'FUNC' as abap_otype,
    upper(LEFT(FUNCNAME, 1)) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.tfdir
  GROUP BY left1
;


-- CLAS: Class

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'CLAS' as abap_otype,
    LEFT(CLSNAME, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.seoclass
  WHERE CLSTYPE = 0                    --  0 Class, 1 Interface
  GROUP BY left1
;


-- INTF: Interface

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'INTF' as abap_otype,
    LEFT(CLSNAME, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.seoclass
  WHERE CLSTYPE = 1                    --  0 Class, 1 Interface
  GROUP BY left1
;


-- SHLP: Search Help

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'SHLP' as abap_otype,
    LEFT(SHLPNAME, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.dd30l
  GROUP BY left1
;


-- TABL: Table

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'TABL' as abap_otype,
    LEFT(TABNAME, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.dd02l
  WHERE LEFT(TABNAME, 1) NOT IN ('Y', 'Z')
    AND TABCLASS IN ('TRANSP', 'CLUSTER', 'POOL')
  GROUP BY left1
;


-- VIEW: View

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'VIEW' as abap_otype,
    LEFT(VIEWNAME, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.dd25l
  WHERE LEFT(VIEWNAME, 1) NOT IN (' ')
  GROUP BY left1
;


-- DTEL: Data Element

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'DTEL' as abap_otype,
    LEFT(ROLLNAME, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.dd04l
  WHERE LEFT(ROLLNAME, 1) NOT IN ('Z')
  GROUP BY left1
;


-- DOMA: Domain

INSERT IGNORE INTO `abap`.`zbuffer_index_counter`
  (`ABAP_OTYPE`, `LEFT1`, `COUNTER`, `PAGE_COUNT`)
SELECT 
    'DOMA' as abap_otype,
    LEFT(DOMNAME, 1) as left1, 
    count(*) as counter, 
    ceil(count(*) / 500) as page_count
  FROM abap.dd01l
  GROUP BY left1
;

