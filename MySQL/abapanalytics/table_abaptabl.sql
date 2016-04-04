CREATE TABLE `abaptabl` (
  `TABNAME` varchar(30) COLLATE utf8_bin NOT NULL COMMENT 'Table Name',
  `TABCLASS` varchar(8) COLLATE utf8_bin DEFAULT NULL COMMENT 'Table Class, examles: TRANSP, INTTAB, ',
  `CONTFLAG` varchar(1) COLLATE utf8_bin DEFAULT NULL COMMENT 'Cont. Flag, examples: A - Application',
  `SOFTCOMP` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Software Component',
  `APPLPOSID` varchar(24) COLLATE utf8_bin DEFAULT NULL COMMENT 'Application Component POSID',
  `APPLFCTR` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT 'Application Component FCTR',
  `PACKAGE` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Package',
  `PACKAGENS` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT 'Package Name Space',
  `PACKAGEP` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Package Parent',
  `DEBUG` varchar(254) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`TABNAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='ABAP Tables';
