
-- Database table for DOMA

create table if not exists abap.dd01l like saperpehp7.dd01l;
insert into abap.dd01l select * from saperpehp7.dd01l;

create table if not exists abap.dd01t like saperpehp7.dd01t;
insert into abap.dd01t select * from saperpehp7.dd01t 
  where DDLANGUAGE = 'E' 
     or DDLANGUAGE = 'D';

create table if not exists abap.dd07l like saperpehp7.dd07l;
insert into abap.dd07l select * from saperpehp7.dd07l;

create table if not exists abap.dd07t like saperpehp7.dd07t;
insert into abap.dd07t select * from saperpehp7.dd07t 
  where DDLANGUAGE = 'E' 
     or DDLANGUAGE = 'D';

-- Database table for DTEL

create table if not exists abap.dd04l like saperpehp7.dd04l;
insert into abap.dd04l select * from saperpehp7.dd04l;

create table if not exists abap.dd04t like saperpehp7.dd04t;
insert into abap.dd04t select * from saperpehp7.dd04t 
  where DDLANGUAGE = 'E' 
     or DDLANGUAGE = 'D';

-- Database table for FUNC

create table if not exists abap.enlfdir like saperpehp7.enlfdir;
insert into abap.enlfdir select * from saperpehp7.enlfdir;

create table if not exists abap.funct like saperpehp7.funct;
insert into abap.funct select * from saperpehp7.funct 
  where SPRAS = 'D'
     or SPRAS = 'E';

create table if not exists abap.fupararef like saperpehp7.fupararef;
insert into abap.fupararef select * from saperpehp7.fupararef;

create table if not exists abap.tfdir like saperpehp7.tfdir;
insert into abap.tfdir select * from saperpehp7.tfdir;

create table if not exists abap.tftit like saperpehp7.tftit;
insert into abap.tftit select * from saperpehp7.tftit;

-- Database table for HIER

create table if not exists abap.cvers like saperpehp7.cvers;
insert into abap.cvers select * from saperpehp7.cvers;

create table if not exists abap.cvers_ref like saperpehp7.cvers_ref;
insert into abap.cvers_ref select * from saperpehp7.cvers_ref;

create table if not exists abap.df14l like saperpehp7.df14l;
insert into abap.df14l select * from saperpehp7.df14l;

create table if not exists abap.df14t like saperpehp7.df14t;
insert into abap.df14t select * from saperpehp7.df14t;

create table if not exists abap.tadir like saperpehp7.tadir;
insert into abap.tadir select * from saperpehp7.tadir;

create table if not exists abap.tdevc like saperpehp7.tdevc;
insert into abap.tdevc select * from saperpehp7.tdevc;

create table if not exists abap.tdevct like saperpehp7.tdevct;
insert into abap.tdevct select * from saperpehp7.tdevct;

-- Database table for PROG

create table if not exists abap.d020s like saperpehp7.d020s;
insert into abap.d020s select * from saperpehp7.d020s;

create table if not exists abap.d020t like saperpehp7.d020t;
insert into abap.d020t select * from saperpehp7.d020t;

create table if not exists abap.ldbt like saperpehp7.ldbt;
insert into abap.ldbt select * from saperpehp7.ldbt;

create table if not exists abap.rsmptexts like saperpehp7.rsmptexts;
insert into abap.rsmptexts select * from saperpehp7.rsmptexts 
  where sprsl = 'D'
     or sprsl = 'E';

create table if not exists abap.trdirt like saperpehp7.trdirt;
insert into abap.trdirt select * from saperpehp7.trdirt where sprsl in ('D', 'E');

create table if not exists abap.ytaplt like saperpehp7.ytaplt;
alter table abap.ytaplt partition by key() partitions 10;
insert into abap.ytaplt select * from saperpehp7.ytaplt;

CREATE TABLE abap.`yd021s` (
  `PROGNAME` varchar(120) COLLATE utf8_bin NOT NULL DEFAULT ' ',
  `DYNPNUMBER` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT ' ',
  `SEQ` int(10) NOT NULL DEFAULT '0',
  `FNAM` varchar(396) COLLATE utf8_bin DEFAULT ' ',
  `DIDX` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `PAID` varchar(60) COLLATE utf8_bin DEFAULT ' ',
  PRIMARY KEY (`PROGNAME`,`DYNPNUMBER`,`SEQ`)
) ;
alter table abap.yd021s partition by key() partitions 10;
insert into abap.yd021s select PROGNAME, dynpnumber, seq, fnam, didx, paid from saperpehp7.ydynpsourced021s;

create table if not exists abap.yreposrcmeta like saperpehp7.yreposrcmeta;
alter table abap.yreposrcmeta partition by key() partitions 10;
insert into abap.yreposrcmeta select * from saperpehp7.yreposrcmeta;

-- Database table for TABL

create table if not exists abap.dd06l like saperpehp7.dd06l;
insert into abap.dd06l select * from saperpehp7.dd06l;

create table if not exists abap.dd06t like saperpehp7.dd06t;
insert into abap.dd06t select * from saperpehp7.dd06t;

create table if not exists abap.dd16s like saperpehp7.dd16s;
insert into abap.dd16s select * from saperpehp7.dd16s;

create table if not exists abap.dartt like saperpehp7.dartt;
insert into abap.dartt select * from saperpehp7.dartt;

create table if not exists abap.dd02l like saperpehp7.dd02l;
insert into abap.dd02l select * from saperpehp7.dd02l;

create table if not exists abap.dd02t like saperpehp7.dd02t;
insert into abap.dd02t select * from saperpehp7.dd02t where DDLANGUAGE in ('D', 'E');

create table if not exists abap.dd03l like saperpehp7.dd03l;
alter table abap.dd03l partition by key() partitions 10;
insert into abap.dd03l select * from saperpehp7.dd03l;

create table if not exists abap.dd05s like saperpehp7.dd05s;
insert into abap.dd05s select * from saperpehp7.dd05s;

create table if not exists abap.dd08l like saperpehp7.dd08l;
insert into abap.dd08l select * from saperpehp7.dd08l;

create table if not exists abap.dd08t like saperpehp7.dd08t;
insert into abap.dd08t select * from saperpehp7.dd08t where DDLANGUAGE in ('D', 'E');

create table if not exists abap.dd09l like saperpehp7.dd09l;
insert into abap.dd09l select * from saperpehp7.dd09l;

create table if not exists abap.dd12l like saperpehp7.dd12l;
insert into abap.dd12l select * from saperpehp7.dd12l;

create table if not exists abap.dd12t like saperpehp7.dd12t;
insert into abap.dd12t select * from saperpehp7.dd12t;

create table if not exists abap.dd17s like saperpehp7.dd17s;
insert into abap.dd17s select * from saperpehp7.dd17s;

create table if not exists abap.dd35l like saperpehp7.dd35l;
insert into abap.dd35l select * from saperpehp7.dd35l;

create table if not exists abap.dd36s like saperpehp7.dd36s;
insert into abap.dd36s select * from saperpehp7.dd36s;

create table if not exists abap.objh like saperpehp7.objh;
insert into abap.objh select * from saperpehp7.objh;

create table if not exists abap.tbrgt like saperpehp7.tbrgt;
insert into abap.tbrgt select * from saperpehp7.tbrgt;

create table if not exists abap.tvdir like saperpehp7.tvdir;
insert into abap.tvdir select * from saperpehp7.tvdir;

create table if not exists abap.ytddat like saperpehp7.ytddat;
insert into abap.ytddat select * from saperpehp7.ytddat;


-- Database table for TRAN

create table if not exists abap.tstc like saperpehp7.tstc;
insert into abap.tstc select * from saperpehp7.tstc;

create table if not exists abap.tstca like saperpehp7.tstca;
insert into abap.tstca select * from saperpehp7.tstca;

create table if not exists abap.tstcc like saperpehp7.tstcc;
insert into abap.tstcc select * from saperpehp7.tstcc;

create table if not exists abap.tstcp like saperpehp7.tstcp;
insert into abap.tstcp select * from saperpehp7.tstcp;

create table if not exists abap.tstct like saperpehp7.tstct;
insert into abap.tstct select * from saperpehp7.tstct;

-- Database table for VIEW

create table if not exists abap.dd25l like saperpehp7.dd25l;
insert into abap.dd25l select * from saperpehp7.dd25l;

create table if not exists abap.dd25t like saperpehp7.dd25t;
insert into abap.dd25t select * from saperpehp7.dd25t;

create table if not exists abap.dd26s like saperpehp7.dd26s;
insert into abap.dd26s select * from saperpehp7.dd26s;

create table if not exists abap.dd27s like saperpehp7.dd27s;
insert into abap.dd27s select * from saperpehp7.dd27s;

create table if not exists abap.dd28s like saperpehp7.dd28s;
insert into abap.dd28s select * from saperpehp7.dd28s;

create table if not exists abap.dm02t like saperpehp7.dm02t;
insert into abap.dm02t select * from saperpehp7.dm02t;

create table if not exists abap.dm25l like saperpehp7.dm25l;
insert into abap.dm25l select * from saperpehp7.dm25l;

