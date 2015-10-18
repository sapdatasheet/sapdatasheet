
-- Study Merged Data layout
select * from (
  (SELECT 'crm7' as system, component, `RELEASE`, extrelease FROM sapcrm7ehp3sr2.cvers order by component) 
  UNION 
  (SELECT 'erp6' as system, component, `RELEASE`, extrelease FROM saperp6ehp7.cvers order by component) 
  UNION 
  (SELECT 'sm71' as system, component, `RELEASE`, extrelease FROM sapsolman71sr1.cvers order by component) 
  UNION 
  (SELECT 'srm7' as system, component, `RELEASE`, extrelease FROM sapsrm7ehp3sr2.cvers order by component) 
  ) as a 
order by a.COMPONENT, a.`RELEASE` 
LIMIT 0, 1000


-- Improve performance: Drop un-used Primary Key fields

alter table abapall.dd01l drop column AS4LOCAL;
alter table abapall.dd01l drop column AS4VERS;
alter table abapall.dd01t drop column AS4VERS;

alter table abapall.dd01t drop column AS4LOCAL;
-- Error Code: 1062. Duplicate entry 'AUTODEL-E' for key 'PRIMARY'	0.141 sec

-- Study for Class
SELECT DISTINCT LEFT(CLSNAME, 1) as letter FROM abap.seoclass
  where CLSTYPE = 0;

SELECT DISTINCT LEFT(CLSNAME, 2) from abap.seoclass
  where CLSTYPE = 0
    and CLSNAME like 'C%';

SELECT count(*) from abap.seoclass
  where CLSTYPE = 0
    and CLSNAME like 'CL%';

SELECT * FROM abap.seoclass
  WHERE CLSTYPE = 0
  ORDER BY CLSNAME
  LIMIT 5000 OFFSET 10000;
