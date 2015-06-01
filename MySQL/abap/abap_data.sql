
-- Database table for DOMA

create table if not exists abap.dd01l like sapall.dd01l;
insert into abap.dd01l select * from sapall.dd01l;

create table if not exists abap.dd01t like sapall.dd01t;
insert into abap.dd01t select * from sapall.dd01t 
  where DDLANGUAGE = 'E' 
     or DDLANGUAGE = 'D';

create table if not exists abap.dd07l like sapall.dd07l;
insert into abap.dd07l select * from sapall.dd07l;

create table if not exists abap.dd07t like sapall.dd07t;
insert into abap.dd07t select * from sapall.dd07t 
  where DDLANGUAGE = 'E' 
     or DDLANGUAGE = 'D';

-- Database table for DTEL

create table if not exists abap.dd04l like sapall.dd04l;
insert into abap.dd04l select * from sapall.dd04l;

create table if not exists abap.dd04t like sapall.dd04t;
insert into abap.dd04t select * from sapall.dd04t 
  where DDLANGUAGE = 'E' 
     or DDLANGUAGE = 'D';

-- Database table for VIEW

create table if not exists abap.dd25l like sapall.dd25l;
insert into abap.dd25l select * from sapall.dd25l;

create table if not exists abap.dd25t like sapall.dd25t;
insert into abap.dd25t select * from sapall.dd25t;

create table if not exists abap.dd26s like sapall.dd26s;
insert into abap.dd26s select * from sapall.dd26s;

create table if not exists abap.dd27s like sapall.dd27s;
insert into abap.dd27s select * from sapall.dd27s;

create table if not exists abap.dd28s like sapall.dd28s;
insert into abap.dd28s select * from sapall.dd28s;

create table if not exists abap.dm02t like sapall.dm02t;
insert into abap.dm02t select * from sapall.dm02t;

create table if not exists abap.dm25l like sapall.dm25l;
insert into abap.dm25l select * from sapall.dm25l;

-- Database table for TABL

create table if not exists abap.dd06l like sapall.dd06l;
insert into abap.dd06l select * from sapall.dd06l;

create table if not exists abap.dd06t like sapall.dd06t;
insert into abap.dd06t select * from sapall.dd06t;

create table if not exists abap.dd16s like sapall.dd16s;
insert into abap.dd16s select * from sapall.dd16s;

create table if not exists abap.dartt like sapall.dartt;
insert into abap.dartt select * from sapall.dartt;

create table if not exists abap.dd02l like sapall.dd02l;
insert into abap.dd02l select * from sapall.dd02l;

create table if not exists abap.dd02t like sapall.dd02t;
insert into abap.dd02t select * from sapall.dd02t where DDLANGUAGE in ('D', 'E');

create table if not exists abap.dd03l like sapall.dd03l;
alter table abap.dd03l partition by key() partitions 10;
insert into abap.dd03l select * from sapall.dd03l;

create table if not exists abap.dd05s like sapall.dd05s;
insert into abap.dd05s select * from sapall.dd05s;

create table if not exists abap.dd08l like sapall.dd08l;
insert into abap.dd08l select * from sapall.dd08l;

create table if not exists abap.dd08t like sapall.dd08t;
insert into abap.dd08t select * from sapall.dd08t where DDLANGUAGE in ('D', 'E');

create table if not exists abap.dd09l like sapall.dd09l;
insert into abap.dd09l select * from sapall.dd09l;

create table if not exists abap.dd12l like sapall.dd12l;
insert into abap.dd12l select * from sapall.dd12l;

create table if not exists abap.dd12t like sapall.dd12t;
insert into abap.dd12t select * from sapall.dd12t;

create table if not exists abap.dd17s like sapall.dd17s;
insert into abap.dd17s select * from sapall.dd17s;

create table if not exists abap.dd35l like sapall.dd35l;
insert into abap.dd35l select * from sapall.dd35l;

create table if not exists abap.dd36s like sapall.dd36s;
insert into abap.dd36s select * from sapall.dd36s;

create table if not exists abap.objh like sapall.objh;
insert into abap.objh select * from sapall.objh;

create table if not exists abap.tbrgt like sapall.tbrgt;
insert into abap.tbrgt select * from sapall.tbrgt;

create table if not exists abap.tvdir like sapall.tvdir;
insert into abap.tvdir select * from sapall.tvdir;

create table if not exists abap.ytddat like sapall.ytddat;
insert into abap.ytddat select * from sapall.ytddat;

-- Database table for FUNC

create table if not exists abap.enlfdir like sapall.enlfdir;
insert into abap.enlfdir select * from sapall.enlfdir;

create table if not exists abap.funct like sapall.funct;
insert into abap.funct select * from sapall.funct 
  where SPRAS = 'D'
     or SPRAS = 'E';

create table if not exists abap.fupararef like sapall.fupararef;
insert into abap.fupararef select * from sapall.fupararef;

create table if not exists abap.tfdir like sapall.tfdir;
insert into abap.tfdir select * from sapall.tfdir;

create table if not exists abap.tftit like sapall.tftit;
insert into abap.tftit select * from sapall.tftit;

create table if not exists abap.tlibt like sapall.tlibt;
insert into abap.tlibt select * from sapall.tlibt;

-- Database table for PROG

create table if not exists abap.d020s like sapall.d020s;
insert into abap.d020s select * from sapall.d020s;

create table if not exists abap.d020t like sapall.d020t;
insert into abap.d020t select * from sapall.d020t;

create table if not exists abap.ldbt like sapall.ldbt;
insert into abap.ldbt select * from sapall.ldbt;

create table if not exists abap.rsmptexts like sapall.rsmptexts;
insert into abap.rsmptexts select * from sapall.rsmptexts 
  where sprsl = 'D'
     or sprsl = 'E';

create table if not exists abap.trdirt like sapall.trdirt;
insert into abap.trdirt select * from sapall.trdirt where sprsl in ('D', 'E');

create table if not exists abap.ytaplt like sapall.ytaplt;
insert into abap.ytaplt select * from sapall.ytaplt;

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
insert into abap.yd021s select PROGNAME, dynpnumber, seq, fnam, didx, paid from sapall.ydynpsourced021s;

create table if not exists abap.yreposrcmeta like sapall.yreposrcmeta;
alter table abap.yreposrcmeta partition by key() partitions 10;
insert into abap.yreposrcmeta select * from sapall.yreposrcmeta;

-- Database table for TRAN

create table if not exists abap.tstc like sapall.tstc;
insert into abap.tstc select * from sapall.tstc;

create table if not exists abap.tstca like sapall.tstca;
insert into abap.tstca select * from sapall.tstca;

create table if not exists abap.tstcc like sapall.tstcc;
insert into abap.tstcc select * from sapall.tstcc;

create table if not exists abap.tstcp like sapall.tstcp;
insert into abap.tstcp select * from sapall.tstcp;

create table if not exists abap.tstct like sapall.tstct;
insert into abap.tstct select * from sapall.tstct;

-- Database table for HIER

create table if not exists abap.cvers like sapall.cvers;
insert into abap.cvers select * from sapall.cvers;

create table if not exists abap.cvers_ref like sapall.cvers_ref;
insert into abap.cvers_ref select * from sapall.cvers_ref;

create table if not exists abap.df14l like sapall.df14l;
insert into abap.df14l select * from sapall.df14l;

create table if not exists abap.df14t like sapall.df14t;
insert into abap.df14t select * from sapall.df14t;

create table if not exists abap.tadir like sapall.tadir;
insert into abap.tadir select * from sapall.tadir;

create table if not exists abap.tdevc like sapall.tdevc;
insert into abap.tdevc select * from sapall.tdevc;

create table if not exists abap.tdevct like sapall.tdevct;
insert into abap.tdevct select * from sapall.tdevct;

