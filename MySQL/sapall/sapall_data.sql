--
-- All tables are created based on sapcrm7ehp3sr2
-- Since it contains the latest SAP_BASIS
--

-- Database table for DOMA

insert into sapall.dd01l select * from sapcrm7ehp3sr2.dd01l;
insert ignore into sapall.dd01l select * from sapsrm7ehp3sr2.dd01l;
insert ignore into sapall.dd01l select * from saperp6ehp7.dd01l;
insert ignore into sapall.dd01l select * from sapsolman71sr1.dd01l;

insert into sapall.dd01t select * from sapcrm7ehp3sr2.dd01t;
insert ignore into sapall.dd01t select * from sapsrm7ehp3sr2.dd01t;
insert ignore into sapall.dd01t select * from saperp6ehp7.dd01t;
insert ignore into sapall.dd01t select * from sapsolman71sr1.dd01t;


truncate table sapall.dd07l;
insert into sapall.dd07l select * from sapcrm7ehp3sr2.dd07l;
insert ignore into sapall.dd07l select * from sapsrm7ehp3sr2.dd07l as a
  where not exists ( select DOMNAME from sapall.dd07l where DOMNAME = a.DOMNAME );
insert ignore into sapall.dd07l select * from saperp6ehp7.dd07l as a
  where not exists ( select DOMNAME from sapall.dd07l where DOMNAME = a.DOMNAME );
insert ignore into sapall.dd07l select * from sapsolman71sr1.dd07l as a
  where not exists ( select DOMNAME from sapall.dd07l where DOMNAME = a.DOMNAME );


insert into sapall.dd07t select * from sapcrm7ehp3sr2.dd07t;
insert ignore into sapall.dd07t select * from sapsrm7ehp3sr2.dd07t;
insert ignore into sapall.dd07t select * from saperp6ehp7.dd07t;
insert ignore into sapall.dd07t select * from sapsolman71sr1.dd07t;


-- Database table for DTEL

insert into sapall.dd04l select * from sapcrm7ehp3sr2.dd04l;
insert ignore into sapall.dd04l select * from sapsrm7ehp3sr2.dd04l;
insert ignore into sapall.dd04l select * from saperp6ehp7.dd04l;
insert ignore into sapall.dd04l select * from sapsolman71sr1.dd04l;

insert into sapall.dd04t select * from sapcrm7ehp3sr2.dd04t;
insert ignore into sapall.dd04t select * from sapsrm7ehp3sr2.dd04t;
insert ignore into sapall.dd04t select * from saperp6ehp7.dd04t;
insert ignore into sapall.dd04t select * from sapsolman71sr1.dd04t;

create table if not exists sapall.ydok_dedz like saperp6ehp7.ydok_dedz;
insert ignore into sapall.ydok_dedz select * from saperp6ehp7.ydok_dedz;


-- Database table for VIEW

truncate table sapall.dd25l;
insert into sapall.dd25l select * from sapcrm7ehp3sr2.dd25l;
insert ignore into sapall.dd25l select * from sapsrm7ehp3sr2.dd25l;
insert ignore into sapall.dd25l
(
VIEWNAME, 
AS4LOCAL, 
AS4VERS, 
AGGTYPE, 
APPLCLASS, 
AUTHCLASS, 
READONLY, 
ROOTTAB, 
AS4USER, 
AS4DATE, 
AS4TIME, 
VIEWCLASS, 
ACTFLAG, 
MASTERLANG, 
CUSTOMAUTH, 
VIEWGRANT, 
GLOBALFLAG, 
MANKEY, 
DBREFNAME
) select * from saperp6ehp7.dd25l;
insert ignore into sapall.dd25l (
VIEWNAME, 
AS4LOCAL, 
AS4VERS, 
AGGTYPE, 
APPLCLASS, 
AUTHCLASS, 
READONLY, 
ROOTTAB, 
AS4USER, 
AS4DATE, 
AS4TIME, 
VIEWCLASS, 
ACTFLAG, 
MASTERLANG, 
CUSTOMAUTH, 
VIEWGRANT, 
GLOBALFLAG, 
MANKEY
) select * from sapsolman71sr1.dd25l;


insert into sapall.dd25t select * from sapcrm7ehp3sr2.dd25t;
insert ignore into sapall.dd25t select * from sapsrm7ehp3sr2.dd25t;
insert ignore into sapall.dd25t select * from saperp6ehp7.dd25t;
insert ignore into sapall.dd25t select * from sapsolman71sr1.dd25t;


truncate table sapall.dd26s;
insert into sapall.dd26s select * from sapcrm7ehp3sr2.dd26s;
insert ignore into sapall.dd26s select * from sapsrm7ehp3sr2.dd26s as a
  where not exists ( select VIEWNAME from sapall.dd26s where VIEWNAME = a.VIEWNAME );
insert ignore into sapall.dd26s select * from saperp6ehp7.dd26s as a
  where not exists ( select VIEWNAME from sapall.dd26s where VIEWNAME = a.VIEWNAME );
insert ignore into sapall.dd26s select * from sapsolman71sr1.dd26s as a
  where not exists ( select VIEWNAME from sapall.dd26s where VIEWNAME = a.VIEWNAME );


truncate table sapall.dd27s;
insert into sapall.dd27s select * from sapcrm7ehp3sr2.dd27s;
insert ignore into sapall.dd27s select * from sapsrm7ehp3sr2.dd27s as a
  where not exists ( select VIEWNAME from sapall.dd27s where VIEWNAME = a.VIEWNAME );
insert ignore into sapall.dd27s select * from saperp6ehp7.dd27s as a
  where not exists ( select VIEWNAME from sapall.dd27s where VIEWNAME = a.VIEWNAME );
insert ignore into sapall.dd27s (
VIEWNAME, 
AS4LOCAL, 
OBJPOS, 
AS4VERS, 
VIEWFIELD, 
TABNAME, 
FIELDNAME, 
KEYFLAG, 
MCFIELDID, 
EFORM, 
ROLLNAME, 
ENQMODE, 
RDONLY, 
ROLLCHANGE
) select * from sapsolman71sr1.dd27s as a
  where not exists ( select VIEWNAME from sapall.dd27s where VIEWNAME = a.VIEWNAME );


truncate table sapall.dd28s;
insert into sapall.dd28s select * from sapcrm7ehp3sr2.dd28s;
insert ignore into sapall.dd28s select * from sapsrm7ehp3sr2.dd28s as a
  where not exists ( select CONDNAME from sapall.dd28s where CONDNAME = a.CONDNAME );
insert ignore into sapall.dd28s select * from saperp6ehp7.dd28s as a
  where not exists ( select CONDNAME from sapall.dd28s where CONDNAME = a.CONDNAME );
insert ignore into sapall.dd28s (
CONDNAME, 
AS4LOCAL, 
AS4VERS, 
POSITION, 
TABNAME, 
FIELDNAME, 
NEGATION, 
OPERATOR, 
CONSTANTS, 
CONTLINE, 
AND_OR, 
OFFSET, 
FLENGTH, 
MCOFIELD
) select * from sapsolman71sr1.dd28s as a
  where not exists ( select CONDNAME from sapall.dd28s where CONDNAME = a.CONDNAME );


insert into sapall.dm02t select * from sapcrm7ehp3sr2.dm02t;
insert ignore into sapall.dm02t select * from sapsrm7ehp3sr2.dm02t;
insert ignore into sapall.dm02t select * from saperp6ehp7.dm02t;
insert ignore into sapall.dm02t select * from sapsolman71sr1.dm02t;

insert into sapall.dm25l select * from sapcrm7ehp3sr2.dm25l;
insert ignore into sapall.dm25l select * from sapsrm7ehp3sr2.dm25l;
insert ignore into sapall.dm25l select * from saperp6ehp7.dm25l;
insert ignore into sapall.dm25l select * from sapsolman71sr1.dm25l;


-- Database table for TABL

insert into sapall.dd06l select * from sapcrm7ehp3sr2.dd06l;
insert ignore into sapall.dd06l select * from sapsrm7ehp3sr2.dd06l;
insert ignore into sapall.dd06l select * from saperp6ehp7.dd06l;
insert ignore into sapall.dd06l select * from sapsolman71sr1.dd06l;

insert into sapall.dd06t select * from sapcrm7ehp3sr2.dd06t;
insert ignore into sapall.dd06t select * from sapsrm7ehp3sr2.dd06t;
insert ignore into sapall.dd06t select * from saperp6ehp7.dd06t;
insert ignore into sapall.dd06t select * from sapsolman71sr1.dd06t;


truncate table sapall.dd16s;
insert into sapall.dd16s select * from sapcrm7ehp3sr2.dd16s;
insert ignore into sapall.dd16s select * from sapsrm7ehp3sr2.dd16s as a
  where not exists ( select SQLTAB from sapall.dd16s where SQLTAB = a.SQLTAB );
insert ignore into sapall.dd16s select * from saperp6ehp7.dd16s as a
  where not exists ( select SQLTAB from sapall.dd16s where SQLTAB = a.SQLTAB );
insert ignore into sapall.dd16s select * from sapsolman71sr1.dd16s as a
  where not exists ( select SQLTAB from sapall.dd16s where SQLTAB = a.SQLTAB );


insert into sapall.dartt select * from sapcrm7ehp3sr2.dartt;
insert ignore into sapall.dartt select * from sapsrm7ehp3sr2.dartt;
insert ignore into sapall.dartt select * from saperp6ehp7.dartt;
insert ignore into sapall.dartt select * from sapsolman71sr1.dartt;


truncate table sapall.dd02l;
insert into sapall.dd02l select * from sapcrm7ehp3sr2.dd02l;
insert ignore into sapall.dd02l select * from sapsrm7ehp3sr2.dd02l;
insert ignore into sapall.dd02l (
TABNAME, 
AS4LOCAL, 
AS4VERS, 
TABCLASS, 
SQLTAB, 
DATMIN, 
DATMAX, 
DATAVG, 
CLIDEP, 
BUFFERED, 
COMPRFLAG, 
LANGDEP, 
ACTFLAG, 
APPLCLASS, 
AUTHCLASS, 
AS4USER, 
AS4DATE, 
AS4TIME, 
MASTERLANG, 
MAINFLAG, 
CONTFLAG, 
RESERVETAB, 
GLOBALFLAG, 
PROZPUFF, 
VIEWCLASS, 
VIEWGRANT, 
MULTIPLEX, 
SHLPEXI, 
PROXYTYPE, 
EXCLASS, 
WRONGCL, 
ALWAYSTRP
) select * from saperp6ehp7.dd02l;
insert ignore into sapall.dd02l (
TABNAME, 
AS4LOCAL, 
AS4VERS, 
TABCLASS, 
SQLTAB, 
DATMIN, 
DATMAX, 
DATAVG, 
CLIDEP, 
BUFFERED, 
COMPRFLAG, 
LANGDEP, 
ACTFLAG, 
APPLCLASS, 
AUTHCLASS, 
AS4USER, 
AS4DATE, 
AS4TIME, 
MASTERLANG, 
MAINFLAG, 
CONTFLAG, 
RESERVETAB, 
GLOBALFLAG, 
PROZPUFF, 
VIEWCLASS, 
VIEWGRANT, 
MULTIPLEX, 
SHLPEXI, 
PROXYTYPE, 
EXCLASS, 
WRONGCL
) select * from sapsolman71sr1.dd02l;


insert into sapall.dd02t select * from sapcrm7ehp3sr2.dd02t;
insert ignore into sapall.dd02t select * from sapsrm7ehp3sr2.dd02t;
insert ignore into sapall.dd02t select * from saperp6ehp7.dd02t;
insert ignore into sapall.dd02t select * from sapsolman71sr1.dd02t;


insert into sapall.dd03l select * from sapcrm7ehp3sr2.dd03l;
insert ignore into sapall.dd03l select * from sapsrm7ehp3sr2.dd03l as a
  where not exists ( select TABNAME from sapall.dd03l where TABNAME = a.TABNAME );
insert ignore into sapall.dd03l select * from saperp6ehp7.dd03l as a
  where not exists ( select TABNAME from sapall.dd03l where TABNAME = a.TABNAME );
insert ignore into sapall.dd03l select * from sapsolman71sr1.dd03l as a
  where not exists ( select TABNAME from sapall.dd03l where TABNAME = a.TABNAME );


insert into sapall.dd05s select * from sapcrm7ehp3sr2.dd05s;
insert ignore into sapall.dd05s select * from sapsrm7ehp3sr2.dd05s as a
  where not exists ( select TABNAME from sapall.dd05s where TABNAME = a.TABNAME );
insert ignore into sapall.dd05s select * from saperp6ehp7.dd05s as a
  where not exists ( select TABNAME from sapall.dd05s where TABNAME = a.TABNAME );
insert ignore into sapall.dd05s select * from sapsolman71sr1.dd05s as a
  where not exists ( select TABNAME from sapall.dd05s where TABNAME = a.TABNAME );


insert into sapall.dd08l select * from sapcrm7ehp3sr2.dd08l;
insert ignore into sapall.dd08l select * from sapsrm7ehp3sr2.dd08l as a
  where not exists ( select TABNAME from sapall.dd08l where TABNAME = a.TABNAME );
insert ignore into sapall.dd08l select * from saperp6ehp7.dd08l as a
  where not exists ( select TABNAME from sapall.dd08l where TABNAME = a.TABNAME );
insert ignore into sapall.dd08l select * from sapsolman71sr1.dd08l as a
  where not exists ( select TABNAME from sapall.dd08l where TABNAME = a.TABNAME );


insert into sapall.dd08t select * from sapcrm7ehp3sr2.dd08t;
insert ignore into sapall.dd08t select * from sapsrm7ehp3sr2.dd08t as a
  where not exists ( select TABNAME from sapall.dd08t where TABNAME = a.TABNAME );
insert ignore into sapall.dd08t select * from saperp6ehp7.dd08t as a
  where not exists ( select TABNAME from sapall.dd08t where TABNAME = a.TABNAME );
insert ignore into sapall.dd08t select * from sapsolman71sr1.dd08t as a
  where not exists ( select TABNAME from sapall.dd08t where TABNAME = a.TABNAME );


truncate table sapall.dd09l;
insert into sapall.dd09l select * from sapcrm7ehp3sr2.dd09l;
insert ignore into sapall.dd09l select * from sapsrm7ehp3sr2.dd09l;
insert ignore into sapall.dd09l select * from saperp6ehp7.dd09l;
insert ignore into sapall.dd09l (
TABNAME, 
AS4LOCAL, 
AS4VERS, 
TABKAT, 
TABART, 
PUFFERUNG, 
SCHFELDANZ, 
PROTOKOLL, 
SPEICHPUFF, 
AS4USER, 
AS4DATE, 
AS4TIME, 
TRANSPFLAG, 
RESERVE, 
UEBERSETZ, 
ACTFLAG, 
BUFALLOW, 
JAVAONLY
) select * from sapsolman71sr1.dd09l;


truncate table sapall.dd12l;
insert into sapall.dd12l select * from sapcrm7ehp3sr2.dd12l;
insert ignore into sapall.dd12l select * from sapsrm7ehp3sr2.dd12l as a
  where not exists ( select SQLTAB from sapall.dd12l where SQLTAB = a.SQLTAB );
insert ignore into sapall.dd12l (
SQLTAB, 
INDEXNAME, 
AS4LOCAL, 
AS4VERS, 
AUTHCLASS, 
UNIQUEFLAG, 
AS4USER, 
AS4DATE, 
AS4TIME, 
ACTFLAG, 
DBINDEX, 
DBSTATE, 
DBINCLEXCL, 
DBSYSSEL1, 
DBSYSSEL2, 
DBSYSSEL3, 
DBSYSSEL4, 
ISEXTIND, 
FULL_TEXT, 
LANGU_COLUMN, 
MIME_TYPE_COL, 
MIME_TYPE, 
LANGU_DETECTION, 
FAST_PREPROCESS, 
FUZZY_SEARCH_INDX, 
SEARCH_ONLY, 
UPDATE_MODE, 
CONFIGURATION, 
PHRASE_INDX_RATIO, 
TEXT_ANALYSIS
)select * from saperp6ehp7.dd12l as a
  where not exists ( select SQLTAB from sapall.dd12l where SQLTAB = a.SQLTAB );
insert ignore into sapall.dd12l (
SQLTAB, 
INDEXNAME, 
AS4LOCAL, 
AS4VERS, 
AUTHCLASS, 
UNIQUEFLAG, 
AS4USER, 
AS4DATE, 
AS4TIME, 
ACTFLAG, 
DBINDEX, 
DBSTATE, 
DBINCLEXCL, 
DBSYSSEL1, 
DBSYSSEL2, 
DBSYSSEL3, 
DBSYSSEL4, 
ISEXTIND
) select * from sapsolman71sr1.dd12l as a
  where not exists ( select SQLTAB from sapall.dd12l where SQLTAB = a.SQLTAB );


insert into sapall.dd12t select * from sapcrm7ehp3sr2.dd12t;
insert ignore into sapall.dd12t select * from sapsrm7ehp3sr2.dd12t;
insert ignore into sapall.dd12t select * from saperp6ehp7.dd12t;
insert ignore into sapall.dd12t select * from sapsolman71sr1.dd12t;


insert into sapall.dd17s select * from sapcrm7ehp3sr2.dd17s;
insert ignore into sapall.dd17s select * from sapsrm7ehp3sr2.dd17s;
insert ignore into sapall.dd17s select * from saperp6ehp7.dd17s;
insert ignore into sapall.dd17s select * from sapsolman71sr1.dd17s;


insert into sapall.dd35l select * from sapcrm7ehp3sr2.dd35l;
insert ignore into sapall.dd35l select * from sapsrm7ehp3sr2.dd35l as a
  where not exists ( select TABNAME from sapall.dd35l where TABNAME = a.TABNAME );
insert ignore into sapall.dd35l select * from saperp6ehp7.dd35l as a
  where not exists ( select TABNAME from sapall.dd35l where TABNAME = a.TABNAME );
insert ignore into sapall.dd35l select * from sapsolman71sr1.dd35l as a
  where not exists ( select TABNAME from sapall.dd35l where TABNAME = a.TABNAME );


insert into sapall.dd36s select * from sapcrm7ehp3sr2.dd36s;
insert ignore into sapall.dd36s select * from sapsrm7ehp3sr2.dd36s as a
  where not exists ( select TABNAME from sapall.dd36s where TABNAME = a.TABNAME );
insert ignore into sapall.dd36s select * from saperp6ehp7.dd36s as a
  where not exists ( select TABNAME from sapall.dd36s where TABNAME = a.TABNAME );
insert ignore into sapall.dd36s select * from sapsolman71sr1.dd36s as a
  where not exists ( select TABNAME from sapall.dd36s where TABNAME = a.TABNAME );


insert into sapall.objh select * from sapcrm7ehp3sr2.objh;
insert ignore into sapall.objh select * from sapsrm7ehp3sr2.objh;
insert ignore into sapall.objh select * from saperp6ehp7.objh;
insert ignore into sapall.objh select * from sapsolman71sr1.objh;


insert into sapall.tbrgt select * from sapcrm7ehp3sr2.tbrgt;
insert ignore into sapall.tbrgt select * from sapsrm7ehp3sr2.tbrgt;
insert ignore into sapall.tbrgt select * from saperp6ehp7.tbrgt;
insert ignore into sapall.tbrgt select * from sapsolman71sr1.tbrgt;
delete from sapall.tbrgt where MANDT <> '000';


insert into sapall.tvdir select * from sapcrm7ehp3sr2.tvdir;
insert ignore into sapall.tvdir select * from sapsrm7ehp3sr2.tvdir;
insert ignore into sapall.tvdir select * from saperp6ehp7.tvdir;
insert ignore into sapall.tvdir select * from sapsolman71sr1.tvdir;


insert into sapall.ytddat select * from sapcrm7ehp3sr2.ytddat;
insert ignore into sapall.ytddat select * from sapsrm7ehp3sr2.ytddat;
insert ignore into sapall.ytddat select * from saperp6ehp7.ytddat;
-- insert ignore into sapall.ytddat select * from sapsolman71sr1.ytddat;       -- Error Code: 1146. Table 'sapsolman71sr1.ytddat' doesn't exist


-- Database table for FUNC

insert into sapall.enlfdir select * from sapcrm7ehp3sr2.enlfdir;
insert ignore into sapall.enlfdir select * from sapsrm7ehp3sr2.enlfdir;
insert ignore into sapall.enlfdir select * from saperp6ehp7.enlfdir;
insert ignore into sapall.enlfdir select * from sapsolman71sr1.enlfdir;


truncate table sapall.funct;
insert into sapall.funct select * from sapcrm7ehp3sr2.funct;
insert ignore into sapall.funct select * from sapsrm7ehp3sr2.funct as a
  where not exists ( select FUNCNAME from sapall.funct where SPRAS = a.SPRAS and FUNCNAME = a.FUNCNAME );
insert ignore into sapall.funct select * from saperp6ehp7.funct as a
  where not exists ( select FUNCNAME from sapall.funct where SPRAS = a.SPRAS and FUNCNAME = a.FUNCNAME );
insert ignore into sapall.funct select * from sapsolman71sr1.funct as a
  where not exists ( select FUNCNAME from sapall.funct where SPRAS = a.SPRAS and FUNCNAME = a.FUNCNAME );


insert into sapall.fupararef select * from sapcrm7ehp3sr2.fupararef;
insert ignore into sapall.fupararef select * from sapsrm7ehp3sr2.fupararef as a
  where not exists ( select FUNCNAME from sapall.fupararef where FUNCNAME = a.FUNCNAME );
insert ignore into sapall.fupararef select * from saperp6ehp7.fupararef as a
  where not exists ( select FUNCNAME from sapall.fupararef where FUNCNAME = a.FUNCNAME );
insert ignore into sapall.fupararef select * from sapsolman71sr1.fupararef as a
  where not exists ( select FUNCNAME from sapall.fupararef where FUNCNAME = a.FUNCNAME );


insert into sapall.tfdir select * from sapcrm7ehp3sr2.tfdir;
insert ignore into sapall.tfdir select * from sapsrm7ehp3sr2.tfdir;
insert ignore into sapall.tfdir select * from saperp6ehp7.tfdir;
insert ignore into sapall.tfdir select * from sapsolman71sr1.tfdir;


insert into sapall.tftit select * from sapcrm7ehp3sr2.tftit;
insert ignore into sapall.tftit select * from sapsrm7ehp3sr2.tftit as a
  where not exists ( select FUNCNAME from sapall.tftit where SPRAS = a.SPRAS and FUNCNAME = a.FUNCNAME );
insert ignore into sapall.tftit select * from saperp6ehp7.tftit as a
  where not exists ( select FUNCNAME from sapall.tftit where SPRAS = a.SPRAS and FUNCNAME = a.FUNCNAME );
insert ignore into sapall.tftit select * from sapsolman71sr1.tftit as a
  where not exists ( select FUNCNAME from sapall.tftit where SPRAS = a.SPRAS and FUNCNAME = a.FUNCNAME );


truncate table sapall.tlibt;
insert into sapall.tlibt select * from sapcrm7ehp3sr2.tlibt;
insert ignore into sapall.tlibt select * from sapsrm7ehp3sr2.tlibt as a
  where not exists ( select AREA from sapall.tlibt where SPRAS = a.SPRAS and AREA = a.AREA );
insert ignore into sapall.tlibt select * from saperp6ehp7.tlibt as a
  where not exists ( select AREA from sapall.tlibt where SPRAS = a.SPRAS and AREA = a.AREA );
insert ignore into sapall.tlibt select * from sapsolman71sr1.tlibt as a
  where not exists ( select AREA from sapall.tlibt where SPRAS = a.SPRAS and AREA = a.AREA );

create table if not exists sapall.ydok_fu like saperp6ehp7.ydok_fu;
insert ignore into sapall.ydok_fu select * from saperp6ehp7.ydok_fu;


-- Database table for MSAG

create table if not exists sapall.t100 like saperp6ehp7.t100;
insert ignore into sapall.t100 select * from saperp6ehp7.t100;

create table if not exists sapall.t100a like saperp6ehp7.t100a;
insert ignore into sapall.t100a select * from saperp6ehp7.t100a;

create table if not exists sapall.t100t like saperp6ehp7.t100t;
insert ignore into sapall.t100t select * from saperp6ehp7.t100t;

create table if not exists sapall.t100u like saperp6ehp7.t100u;
insert ignore into sapall.t100u select * from saperp6ehp7.t100u;

create table if not exists sapall.t100x like saperp6ehp7.t100x;
insert ignore into sapall.t100x select * from saperp6ehp7.t100x;

create table if not exists sapall.ydok_na like saperp6ehp7.ydok_na;
insert ignore into sapall.ydok_na select * from saperp6ehp7.ydok_na;



-- Database table for PROG

insert into sapall.d020s select * from sapcrm7ehp3sr2.d020s;
insert ignore into sapall.d020s select * from sapsrm7ehp3sr2.d020s as a
  where not exists ( select PROG from sapall.d020s where PROG = a.PROG );
insert ignore into sapall.d020s select * from saperp6ehp7.d020s as a
  where not exists ( select PROG from sapall.d020s where PROG = a.PROG );
insert ignore into sapall.d020s select * from sapsolman71sr1.d020s as a
  where not exists ( select PROG from sapall.d020s where PROG = a.PROG );


insert into sapall.d020t select * from sapcrm7ehp3sr2.d020t;
insert ignore into sapall.d020t select * from sapsrm7ehp3sr2.d020t as a
  where not exists ( select PROG from sapall.d020t where PROG = a.PROG );
insert ignore into sapall.d020t select * from saperp6ehp7.d020t as a
  where not exists ( select PROG from sapall.d020t where PROG = a.PROG );
insert ignore into sapall.d020t select * from sapsolman71sr1.d020t as a
  where not exists ( select PROG from sapall.d020t where PROG = a.PROG );


insert into sapall.ldbt select * from sapcrm7ehp3sr2.ldbt;
insert ignore into sapall.ldbt select * from sapsrm7ehp3sr2.ldbt as a
  where not exists ( select LDBNAME from sapall.ldbt where SPRAS = a.SPRAS and LDBNAME = a.LDBNAME );
insert ignore into sapall.ldbt select * from saperp6ehp7.ldbt as a
  where not exists ( select LDBNAME from sapall.ldbt where SPRAS = a.SPRAS and LDBNAME = a.LDBNAME );
insert ignore into sapall.ldbt select * from sapsolman71sr1.ldbt as a
  where not exists ( select LDBNAME from sapall.ldbt where SPRAS = a.SPRAS and LDBNAME = a.LDBNAME );


insert into sapall.rsmptexts select * from sapcrm7ehp3sr2.rsmptexts;
insert ignore into sapall.rsmptexts select * from sapsrm7ehp3sr2.rsmptexts as a
  where not exists ( select PROGNAME from sapall.rsmptexts where PROGNAME = a.PROGNAME );
insert ignore into sapall.rsmptexts select * from saperp6ehp7.rsmptexts as a
  where not exists ( select PROGNAME from sapall.rsmptexts where PROGNAME = a.PROGNAME );
insert ignore into sapall.rsmptexts select * from sapsolman71sr1.rsmptexts as a
  where not exists ( select PROGNAME from sapall.rsmptexts where PROGNAME = a.PROGNAME );


insert into sapall.trdirt select * from sapcrm7ehp3sr2.trdirt;
insert ignore into sapall.trdirt select * from sapsrm7ehp3sr2.trdirt;
insert ignore into sapall.trdirt select * from saperp6ehp7.trdirt;
insert ignore into sapall.trdirt select * from sapsolman71sr1.trdirt;


insert into sapall.ytaplt select * from sapcrm7ehp3sr2.ytaplt;
insert ignore into sapall.ytaplt select * from sapsrm7ehp3sr2.ytaplt;
insert ignore into sapall.ytaplt select * from saperp6ehp7.ytaplt;
-- insert ignore into sapall.ytaplt select * from sapsolman71sr1.ytaplt;     -- Table does not exist


insert into sapall.ydynpsourced021s select * from sapcrm7ehp3sr2.ydynpsourced021s;
insert ignore into sapall.ydynpsourced021s select * from sapsrm7ehp3sr2.ydynpsourced021s as a
  where not exists ( select PROGNAME from sapall.ydynpsourced021s where PROGNAME = a.PROGNAME );
insert ignore into sapall.ydynpsourced021s select * from saperp6ehp7.ydynpsourced021s as a
  where not exists ( select PROGNAME from sapall.ydynpsourced021s where PROGNAME = a.PROGNAME );
insert ignore into sapall.ydynpsourced021s select * from sapsolman71sr1.ydynpsourced021s as a
  where not exists ( select PROGNAME from sapall.ydynpsourced021s where PROGNAME = a.PROGNAME );


insert into sapall.yreposrcmeta select * from sapcrm7ehp3sr2.yreposrcmeta;
insert ignore into sapall.yreposrcmeta select * from sapsrm7ehp3sr2.yreposrcmeta;
insert ignore into sapall.yreposrcmeta select * from saperp6ehp7.yreposrcmeta;
insert ignore into sapall.yreposrcmeta select * from sapsolman71sr1.yreposrcmeta;


-- Database table for TRAN

insert into sapall.tstc select * from sapcrm7ehp3sr2.tstc;
insert ignore into sapall.tstc select * from sapsrm7ehp3sr2.tstc;
insert ignore into sapall.tstc select * from saperp6ehp7.tstc;
insert ignore into sapall.tstc select * from sapsolman71sr1.tstc;


insert into sapall.tstca select * from sapcrm7ehp3sr2.tstca;
insert ignore into sapall.tstca select * from sapsrm7ehp3sr2.tstca as a
  where not exists ( select TCODE from sapall.tstca where TCODE = a.TCODE );
insert ignore into sapall.tstca select * from saperp6ehp7.tstca as a
  where not exists ( select TCODE from sapall.tstca where TCODE = a.TCODE );
insert ignore into sapall.tstca select * from sapsolman71sr1.tstca as a
  where not exists ( select TCODE from sapall.tstca where TCODE = a.TCODE );


insert into sapall.tstcc select * from sapcrm7ehp3sr2.tstcc;
insert ignore into sapall.tstcc select * from sapsrm7ehp3sr2.tstcc;
insert ignore into sapall.tstcc select * from saperp6ehp7.tstcc;
insert ignore into sapall.tstcc select * from sapsolman71sr1.tstcc;


insert into sapall.tstcp select * from sapcrm7ehp3sr2.tstcp;
insert ignore into sapall.tstcp select * from sapsrm7ehp3sr2.tstcp;
insert ignore into sapall.tstcp select * from saperp6ehp7.tstcp;
insert ignore into sapall.tstcp select * from sapsolman71sr1.tstcp;


insert into sapall.tstct select * from sapcrm7ehp3sr2.tstct;
insert ignore into sapall.tstct select * from sapsrm7ehp3sr2.tstct;
insert ignore into sapall.tstct select * from saperp6ehp7.tstct;
insert ignore into sapall.tstct select * from sapsolman71sr1.tstct;


-- Database table for HIER

insert into sapall.cvers select * from sapcrm7ehp3sr2.cvers;
insert ignore into sapall.cvers select * from sapsrm7ehp3sr2.cvers;
insert ignore into sapall.cvers select * from saperp6ehp7.cvers;
insert ignore into sapall.cvers select * from sapsolman71sr1.cvers;


insert into sapall.cvers_ref select * from sapcrm7ehp3sr2.cvers_ref;
insert ignore into sapall.cvers_ref select * from sapsrm7ehp3sr2.cvers_ref;
insert ignore into sapall.cvers_ref select * from saperp6ehp7.cvers_ref;
insert ignore into sapall.cvers_ref select * from sapsolman71sr1.cvers_ref;


truncate table sapall.df14l;
insert into sapall.df14l select * from sapcrm7ehp3sr2.df14l;
insert ignore into sapall.df14l select * from sapsrm7ehp3sr2.df14l;
insert ignore into sapall.df14l select * from saperp6ehp7.df14l;
insert ignore into sapall.df14l (
FCTR_ID, 
AS4LOCAL, 
FSTUSER, 
FSTDATE, 
FSTTIME, 
LSTUSER, 
LSTDATE, 
LSTTIME, 
RELE, 
LSTRELE, 
ARIID, 
PS_POSID, 
XREF, 
CUSTASS, 
ALE_AGGR, 
DESKTOP, 
WWW, 
RELEASED, 
INCOMPLETE, 
SYNCH, 
VISIBLE, 
TSTAMP, 
UNAME1, 
UNAME2
) select * from sapsolman71sr1.df14l;


insert into sapall.df14t select * from sapcrm7ehp3sr2.df14t;
insert ignore into sapall.df14t select * from sapsrm7ehp3sr2.df14t as a
  where not exists ( select FCTR_ID from sapall.df14t where langu = a.langu and addon = a.addon and FCTR_ID = a.FCTR_ID );
insert ignore into sapall.df14t select * from saperp6ehp7.df14t as a
  where not exists ( select FCTR_ID from sapall.df14t where langu = a.langu and addon = a.addon and FCTR_ID = a.FCTR_ID );
insert ignore into sapall.df14t select * from sapsolman71sr1.df14t as a
  where not exists ( select FCTR_ID from sapall.df14t where langu = a.langu and addon = a.addon and FCTR_ID = a.FCTR_ID );


insert into sapall.tadir select * from sapcrm7ehp3sr2.tadir;
insert ignore into sapall.tadir select * from sapsrm7ehp3sr2.tadir;
insert ignore into sapall.tadir select * from saperp6ehp7.tadir;
insert ignore into sapall.tadir select * from sapsolman71sr1.tadir;


insert into sapall.tdevc select * from sapcrm7ehp3sr2.tdevc;
insert ignore into sapall.tdevc select * from sapsrm7ehp3sr2.tdevc;
insert ignore into sapall.tdevc select * from saperp6ehp7.tdevc;
insert ignore into sapall.tdevc select * from sapsolman71sr1.tdevc;


insert into sapall.tdevct select * from sapcrm7ehp3sr2.tdevct;
insert ignore into sapall.tdevct select * from sapsrm7ehp3sr2.tdevct;
insert ignore into sapall.tdevct select * from saperp6ehp7.tdevct;
insert ignore into sapall.tdevct select * from sapsolman71sr1.tdevct;


-- Database table for SPRO

create table if not exists sapall.cus_imgach like saperp6ehp7.cus_imgach;
insert ignore into sapall.cus_imgach select * from saperp6ehp7.cus_imgach;

create table if not exists sapall.cus_imgact like saperp6ehp7.cus_imgact;
insert ignore into sapall.cus_imgact select * from saperp6ehp7.cus_imgact;

create table if not exists sapall.cus_atrh like saperp6ehp7.cus_atrh;
insert ignore into sapall.cus_atrh select * from saperp6ehp7.cus_atrh;

create table if not exists sapall.cus_atrt like saperp6ehp7.cus_atrt;
insert ignore into sapall.cus_atrt select * from saperp6ehp7.cus_atrt;

create table if not exists sapall.cus_atrcou like saperp6ehp7.cus_atrcou;
insert ignore into sapall.cus_atrcou select * from saperp6ehp7.cus_atrcou;

create table if not exists sapall.cus_actobj like saperp6ehp7.cus_actobj;
insert ignore into sapall.cus_actobj select * from saperp6ehp7.cus_actobj;

create table if not exists sapall.cus_actobt like saperp6ehp7.cus_actobt;
insert ignore into sapall.cus_actobt select * from saperp6ehp7.cus_actobt;

create table if not exists sapall.cus_actext like saperp6ehp7.cus_actext;
insert ignore into sapall.cus_actext select * from saperp6ehp7.cus_actext;

create table if not exists sapall.cus_acth like saperp6ehp7.cus_acth;
insert ignore into sapall.cus_acth select * from saperp6ehp7.cus_acth;

create table if not exists sapall.scus_hier like saperp6ehp7.scus_hier;
insert ignore into sapall.scus_hier select * from saperp6ehp7.scus_hier;

create table if not exists sapall.tnodeimg like saperp6ehp7.tnodeimg;
insert ignore into sapall.tnodeimg select * from saperp6ehp7.tnodeimg;

create table if not exists sapall.tnodeimgr like saperp6ehp7.tnodeimgr;
insert ignore into sapall.tnodeimgr select * from saperp6ehp7.tnodeimgr;

create table if not exists sapall.tnodeimgt like saperp6ehp7.tnodeimgt;
insert ignore into sapall.tnodeimgt select * from saperp6ehp7.tnodeimgt;

create table if not exists sapall.tnodeh like saperp6ehp7.tnodeh;
insert ignore into sapall.tnodeh select * from saperp6ehp7.tnodeh;

create table if not exists sapall.tnodet like saperp6ehp7.tnodet;
insert ignore into sapall.tnodet select * from saperp6ehp7.tnodet;

create table if not exists sapall.tfm18 like saperp6ehp7.tfm18;
insert ignore into sapall.tfm18 select * from saperp6ehp7.tfm18;

create table if not exists sapall.troadmap like saperp6ehp7.troadmap;
insert ignore into sapall.troadmap select * from saperp6ehp7.troadmap;

create table if not exists sapall.troadmapt like saperp6ehp7.troadmapt;
insert ignore into sapall.troadmapt select * from saperp6ehp7.troadmapt;

create table if not exists sapall.t005 like saperp6ehp7.t005;
insert ignore into sapall.t005 select * from saperp6ehp7.t005;

create table if not exists sapall.t005t like saperp6ehp7.t005t;
insert ignore into sapall.t005t select * from saperp6ehp7.t005t;

create table if not exists sapall.cus_actt like saperp6ehp7.cus_actt;
insert ignore into sapall.cus_actt select * from saperp6ehp7.cus_actt;

create table if not exists sapall.ydok_hy like saperp6ehp7.ydok_hy;
insert ignore into sapall.ydok_hy select * from saperp6ehp7.ydok_hy;


-- Database table for MENU

create table if not exists sapall.ttrees like saperp6ehp7.ttrees;
insert ignore into sapall.ttrees select * from saperp6ehp7.ttrees;

create table if not exists sapall.ttreet like saperp6ehp7.ttreet;
insert ignore into sapall.ttreet select * from saperp6ehp7.ttreet;

create table if not exists sapall.tmenu01 like saperp6ehp7.tmenu01;
insert ignore into sapall.tmenu01 select * from saperp6ehp7.tmenu01;

create table if not exists sapall.tmenu01r like saperp6ehp7.tmenu01r;
insert ignore into sapall.tmenu01r select * from saperp6ehp7.tmenu01r;

create table if not exists sapall.tmenu01t like saperp6ehp7.tmenu01t;
insert ignore into sapall.tmenu01t select * from saperp6ehp7.tmenu01t;


-- Database table for INTF or CLAS

create table if not exists sapall.seoclass like saperp6ehp7.seoclass;
insert ignore into sapall.seoclass select * from saperp6ehp7.seoclass;

create table if not exists sapall.seoclassdf like saperp6ehp7.seoclassdf;
insert ignore into sapall.seoclassdf select * from saperp6ehp7.seoclassdf;

create table if not exists sapall.seoclasstx like saperp6ehp7.seoclasstx;
insert ignore into sapall.seoclasstx select * from saperp6ehp7.seoclasstx;

create table if not exists sapall.seocompo like saperp6ehp7.seocompo;
insert ignore into sapall.seocompo select * from saperp6ehp7.seocompo;

create table if not exists sapall.seocompodf like saperp6ehp7.seocompodf;
insert ignore into sapall.seocompodf select * from saperp6ehp7.seocompodf;

create table if not exists sapall.seocompotx like saperp6ehp7.seocompotx;
insert ignore into sapall.seocompotx select * from saperp6ehp7.seocompotx;

create table if not exists sapall.seofriends like saperp6ehp7.seofriends;
insert ignore into sapall.seofriends select * from saperp6ehp7.seofriends;

create table if not exists sapall.seoimplrel like saperp6ehp7.seoimplrel;
insert ignore into sapall.seoimplrel select * from saperp6ehp7.seoimplrel;

create table if not exists sapall.seometarel like saperp6ehp7.seometarel;
insert ignore into sapall.seometarel select * from saperp6ehp7.seometarel;

create table if not exists sapall.seosubco like saperp6ehp7.seosubco;
insert ignore into sapall.seosubco select * from saperp6ehp7.seosubco;

create table if not exists sapall.seosubcodf like saperp6ehp7.seosubcodf;
insert ignore into sapall.seosubcodf select * from saperp6ehp7.seosubcodf;

create table if not exists sapall.seosubcotx like saperp6ehp7.seosubcotx;
insert ignore into sapall.seosubcotx select * from saperp6ehp7.seosubcotx;

create table if not exists sapall.seotypepls like saperp6ehp7.seotypepls;
insert ignore into sapall.seotypepls select * from saperp6ehp7.seotypepls;

create table if not exists sapall.ydok_hy like saperp6ehp7.ydok_clif;
insert ignore into sapall.ydok_hy select * from saperp6ehp7.ydok_clif;

-- Database table for SU21

create table if not exists sapall.auth_fldinfo_tmp like saperp6ehp7.auth_fldinfo_tmp;
insert ignore into sapall.auth_fldinfo_tmp select * from saperp6ehp7.auth_fldinfo_tmp;

create table if not exists sapall.authx like saperp6ehp7.authx;
insert ignore into sapall.authx select * from saperp6ehp7.authx;

create table if not exists sapall.tact like saperp6ehp7.tact;
insert ignore into sapall.tact select * from saperp6ehp7.tact;

create table if not exists sapall.tactt like saperp6ehp7.tactt;
insert ignore into sapall.tactt select * from saperp6ehp7.tactt;

create table if not exists sapall.tactz like saperp6ehp7.tactz;
insert ignore into sapall.tactz select * from saperp6ehp7.tactz;

create table if not exists sapall.tobj like saperp6ehp7.tobj;
insert ignore into sapall.tobj select * from saperp6ehp7.tobj;

create table if not exists sapall.tobjt like saperp6ehp7.tobjt;
insert ignore into sapall.tobjt select * from saperp6ehp7.tobjt;

create table if not exists sapall.tobjvorflg like saperp6ehp7.tobjvorflg;
insert ignore into sapall.tobjvorflg select * from saperp6ehp7.tobjvorflg;

create table if not exists sapall.ytobc like saperp6ehp7.ytobc;
insert ignore into sapall.ytobc select * from saperp6ehp7.ytobc;

create table if not exists sapall.ytobct like saperp6ehp7.ytobct;
insert ignore into sapall.ytobct select * from saperp6ehp7.ytobct;

-- epsschrfrm: skip this table


-- Database table for PFCG

create table if not exists sapall.agr_define like saperp6ehp7.agr_define;
insert ignore into sapall.agr_define select * from saperp6ehp7.agr_define;

create table if not exists sapall.agr_agrs like saperp6ehp7.agr_agrs;
insert ignore into sapall.agr_agrs select * from saperp6ehp7.agr_agrs;

create table if not exists sapall.agr_agrs2 like saperp6ehp7.agr_agrs2;
insert ignore into sapall.agr_agrs2 select * from saperp6ehp7.agr_agrs2;

create table if not exists sapall.agr_1250 like saperp6ehp7.agr_1250;
insert ignore into sapall.agr_1250 select * from saperp6ehp7.agr_1250;

create table if not exists sapall.agr_1251 like saperp6ehp7.agr_1251;
insert ignore into sapall.agr_1251 select * from saperp6ehp7.agr_1251;

create table if not exists sapall.usr12 like saperp6ehp7.usr12;
insert ignore into sapall.usr12 select * from saperp6ehp7.usr12;


-- Database table for SHLP (Search Help)

create table if not exists sapall.dd30l like saperp6ehp7.dd30l;
insert ignore into sapall.dd30l select * from saperp6ehp7.dd30l;

create table if not exists sapall.dd30t like saperp6ehp7.dd30t;
insert ignore into sapall.dd30t select * from saperp6ehp7.dd30t;

create table if not exists sapall.dd31s like saperp6ehp7.dd31s;
insert ignore into sapall.dd31s select * from saperp6ehp7.dd31s;

create table if not exists sapall.dd32s like saperp6ehp7.dd32s;
insert ignore into sapall.dd32s select * from saperp6ehp7.dd32s;

create table if not exists sapall.dd33s like saperp6ehp7.dd33s;
insert ignore into sapall.dd33s select * from saperp6ehp7.dd33s;


-- Database table for RZ10

create table if not exists sapall.yspflmetadata like saperp6ehp7.yspflmetadata;
insert ignore into sapall.yspflmetadata select * from saperp6ehp7.yspflmetadata;

create table if not exists sapall.yspflparasub like saperp6ehp7.yspflparasub;
insert ignore into sapall.yspflparasub select * from saperp6ehp7.yspflparasub;

create table if not exists sapall.yspflparausub like saperp6ehp7.yspflparausub;
insert ignore into sapall.yspflparausub select * from saperp6ehp7.yspflparausub;


-- Database table for Where-Used-List

create table if not exists sapall.ywul like saperp6ehp7.ywul;
insert ignore into sapall.ywul select * from saperp6ehp7.ywul;

create table if not exists sapall.yseoprog like saperp6ehp7.yseoprog;
insert ignore into sapall.yseoprog select * from saperp6ehp7.yseoprog;
