-- Create Table

CREATE TABLE `abapbmfr_l1` (
  `FCTR_ID_L1` varchar(20) COLLATE utf8_bin NOT NULL,
  `PS_POSID_L1` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `TEXT` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`FCTR_ID_L1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Level 1 of Application Component';

-- Prepare Data

INSERT INTO abapanalytics.abapbmfr_l1
SELECT a.FCTR_ID_L1, b.PS_POSID_L1, c.`NAME`
  from (
    select distinct `FCTR_ID_L1`
      from abapanalytics.`abapbmfr`
      where `abapbmfr`.`PS_POSID_L1` not like 'NOT USED%'
        and `abapbmfr`.`FCTR_ID_L1` is not null
  ) a
  left join abapanalytics.abapbmfr b on a.FCTR_ID_L1 = b.FCTR_ID
  left join abap.df14t c on a.FCTR_ID_L1 = c.FCTR_ID
  where c.LANGU = 'E'
  ORDER BY PS_POSID_L1

