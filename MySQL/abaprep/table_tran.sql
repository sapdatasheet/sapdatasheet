CREATE TABLE `tran` (
  `tcode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT 'Transaction Code',
  `softcomp` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Software Component',
  `applposid` varchar(24) COLLATE utf8_bin DEFAULT NULL COMMENT 'Application component - PS_POSID',
  `applfctr` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT 'Application component - FCTR_ID',
  `devclass` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Package',
  `progname` varchar(40) COLLATE utf8_bin DEFAULT NULL COMMENT 'ABAP Program name',
  `dypno` int(11) DEFAULT NULL COMMENT 'ABAP Program Dynpro number',
  `param` varchar(254) COLLATE utf8_bin DEFAULT NULL COMMENT 'TCode Parameter',
  `calltcode` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT 'Called transaction code (if exist)',
  `calltcodeviewname` varchar(30) COLLATE utf8_bin DEFAULT NULL COMMENT 'Called view',
  `calltcodeupdate` varchar(1) COLLATE utf8_bin DEFAULT NULL COMMENT 'Update mode or not',
  PRIMARY KEY (`tcode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Transaction Code';
