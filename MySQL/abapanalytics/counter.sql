drop table abapanalytics.counter;
delete from abapanalytics.counter;

CREATE TABLE abapanalytics.`counter` (
  `SRC_OBJ_TYPE` varchar(4) COLLATE utf8_bin NOT NULL,
  `SRC_OBJ_NAME` varchar(40) COLLATE utf8_bin NOT NULL,
  `SRC_SUBOBJ` varchar(93) COLLATE utf8_bin NOT NULL,
  `OBJ_TYPE` varchar(4) COLLATE utf8_bin NOT NULL,
  `COUNTER` int(11) DEFAULT NULL,
  PRIMARY KEY (`SRC_OBJ_TYPE`,`SRC_OBJ_NAME`,`SRC_SUBOBJ`,`OBJ_TYPE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='ABAP Related Object Counter';


insert into abapanalytics.counter
select SRC_OBJ_TYPE, SRC_OBJ_NAME, SRC_SUBOBJ, OBJ_TYPE, count(OBJ_NAME) as COUNTER
  from abap.ywul
  group by SRC_OBJ_TYPE, SRC_OBJ_NAME, SRC_SUBOBJ, OBJ_TYPE;
