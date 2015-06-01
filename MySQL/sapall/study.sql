
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

