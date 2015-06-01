
-- Database table for VIEW

-- dd25l

select * from information_schema.COLUMNS
  where TABLE_NAME = 'dd25l'
    and TABLE_SCHEMA in ('sapcrm7ehp3sr2', 'saperp6ehp7', 'sapsolman71sr1', 'sapsrm7ehp3sr2')
  order by COLUMN_NAME;

select COLUMN_NAME, count(COLUMN_NAME) as count from information_schema.COLUMNS
  where TABLE_NAME = 'dd25l'
    and TABLE_SCHEMA in ('sapcrm7ehp3sr2', 'saperp6ehp7')
  group by COLUMN_NAME 
  order by count, COLUMN_NAME;

select concat(COLUMN_NAME, ', ') as colname  from information_schema.columns
  where TABLE_NAME = 'dd25l'
    and TABLE_SCHEMA = 'saperp6ehp7'
  order by ORDINAL_POSITION;

select COLUMN_NAME, count(COLUMN_NAME) as count from information_schema.COLUMNS
  where TABLE_NAME = 'dd25l'
    and TABLE_SCHEMA in ('sapcrm7ehp3sr2', 'sapsolman71sr1')
  group by COLUMN_NAME 
  order by count, COLUMN_NAME;

select concat(COLUMN_NAME, ', ') as colname  from information_schema.columns
  where TABLE_NAME = 'dd25l'
    and TABLE_SCHEMA = 'sapsolman71sr1'
  order by ORDINAL_POSITION;

-- dd27s

select COLUMN_NAME, count(COLUMN_NAME) as count from information_schema.COLUMNS
  where TABLE_NAME = 'dd27s'
    and TABLE_SCHEMA in ('sapcrm7ehp3sr2', 'sapsolman71sr1')
  group by COLUMN_NAME 
  order by count, COLUMN_NAME;

select concat(COLUMN_NAME, ', ') as colname  from information_schema.columns
  where TABLE_NAME = 'dd27s'
    and TABLE_SCHEMA = 'sapsolman71sr1'
  order by ORDINAL_POSITION;

-- dd28s

select COLUMN_NAME, count(COLUMN_NAME) as count from information_schema.COLUMNS
  where TABLE_NAME = 'dd28s'
    and TABLE_SCHEMA in ('sapcrm7ehp3sr2', 'sapsolman71sr1')
  group by COLUMN_NAME 
  order by count, COLUMN_NAME;

select concat(COLUMN_NAME, ', ') as colname  from information_schema.columns
  where TABLE_NAME = 'dd28s'
    and TABLE_SCHEMA = 'sapsolman71sr1'
  order by ORDINAL_POSITION;


-- Database table for TABL

-- dd02l

select COLUMN_NAME, count(COLUMN_NAME) as count from information_schema.COLUMNS
  where TABLE_NAME = 'dd02l'
    and TABLE_SCHEMA in ('sapcrm7ehp3sr2', 'saperp6ehp7')
  group by COLUMN_NAME 
  order by count, COLUMN_NAME;

select concat(COLUMN_NAME, ', ') as colname  from information_schema.columns
  where TABLE_NAME = 'dd02l'
    and TABLE_SCHEMA = 'saperp6ehp7'
  order by ORDINAL_POSITION;

-- dd09l

select COLUMN_NAME, count(COLUMN_NAME) as count from information_schema.COLUMNS
  where TABLE_NAME = 'dd09l'
    and TABLE_SCHEMA in ('sapcrm7ehp3sr2', 'sapsolman71sr1')
  group by COLUMN_NAME 
  order by count, COLUMN_NAME;

select concat(COLUMN_NAME, ', ') as colname  from information_schema.columns
  where TABLE_NAME = 'dd09l'
    and TABLE_SCHEMA = 'sapsolman71sr1'
  order by ORDINAL_POSITION;

-- dd12l

select COLUMN_NAME, count(COLUMN_NAME) as count from information_schema.COLUMNS
  where TABLE_NAME = 'dd12l'
    and TABLE_SCHEMA in ('sapcrm7ehp3sr2', 'sapsolman71sr1')
  group by COLUMN_NAME 
  order by count, COLUMN_NAME;
select concat(COLUMN_NAME, ', ') as colname  from information_schema.columns
  where TABLE_NAME = 'dd12l'
    and TABLE_SCHEMA = 'sapsolman71sr1'
  order by ORDINAL_POSITION;

select COLUMN_NAME, count(COLUMN_NAME) as count from information_schema.COLUMNS
  where TABLE_NAME = 'dd12l'
    and TABLE_SCHEMA in ('sapcrm7ehp3sr2', 'sapsolman71sr1')
  group by COLUMN_NAME 
  order by count, COLUMN_NAME;
select concat(COLUMN_NAME, ', ') as colname  from information_schema.columns
  where TABLE_NAME = 'dd12l'
    and TABLE_SCHEMA = 'sapsolman71sr1'
  order by ORDINAL_POSITION;

-- Database table for HIER

-- df14l

select COLUMN_NAME, count(COLUMN_NAME) as count from information_schema.COLUMNS
  where TABLE_NAME = 'df14l'
    and TABLE_SCHEMA in ('sapcrm7ehp3sr2', 'sapsolman71sr1')
  group by COLUMN_NAME 
  order by count, COLUMN_NAME;

select concat(COLUMN_NAME, ', ') as colname  from information_schema.columns
  where TABLE_NAME = 'df14l'
    and TABLE_SCHEMA = 'sapsolman71sr1'
  order by ORDINAL_POSITION;

