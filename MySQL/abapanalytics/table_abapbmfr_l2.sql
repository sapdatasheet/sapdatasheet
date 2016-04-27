
-- Create Table

CREATE TABLE `abapbmfr_l2` (
  `FCTR_ID_L2` varchar(20) COLLATE utf8_bin NOT NULL,
  `PS_POSID_L2` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `FCTR_ID_L1` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `PS_POSID_L1` varchar(24) COLLATE utf8_bin DEFAULT NULL,
  `TEXT` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`FCTR_ID_L2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Level 2 of Application Component';


-- Prepare Data

DELETE FROM abapanalytics.abapbmfr_l2
;

INSERT INTO abapanalytics.abapbmfr_l2
SELECT a.FCTR_ID_L2, b.PS_POSID_L2, b.FCTR_ID_L1, b.PS_POSID_L1, c.`NAME`
  from (
    select distinct `FCTR_ID_L2`
      from abapanalytics.`abapbmfr`
      where `abapbmfr`.`PS_POSID_L2` not like 'NOT USED%'
        and `abapbmfr`.`FCTR_ID_L2` is not null
  ) a
  left join abapanalytics.abapbmfr b on a.FCTR_ID_L2 = b.FCTR_ID
  left join abap.df14t c on a.FCTR_ID_L2 = c.FCTR_ID
  where c.LANGU = 'E'
  ORDER BY PS_POSID_L1, PS_POSID_L2
;
