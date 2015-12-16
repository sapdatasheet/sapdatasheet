delete from abapanalytics.counter;

insert into abapanalytics.counter
select SRC_OBJ_TYPE, SRC_OBJ_NAME, OBJ_TYPE, count(OBJ_NAME) as COUNTER
  from abap.ywul
  group by SRC_OBJ_TYPE, SRC_OBJ_NAME, OBJ_TYPE;
