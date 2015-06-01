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











