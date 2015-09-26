
-- Database table for DOMA

create table if not exists abap.dd01l like sapall.dd01l;
insert into abap.dd01l select * from sapall.dd01l;

create table if not exists abap.dd01t like sapall.dd01t;
insert into abap.dd01t select * from sapall.dd01t 
  where DDLANGUAGE in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

create table if not exists abap.dd07l like sapall.dd07l;
insert into abap.dd07l select * from sapall.dd07l;

create table if not exists abap.dd07t like sapall.dd07t;
insert into abap.dd07t select * from sapall.dd07t 
  where DDLANGUAGE in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

-- Database table for DTEL

create table if not exists abap.dd04l like sapall.dd04l;
insert into abap.dd04l select * from sapall.dd04l;

create table if not exists abap.dd04t like sapall.dd04t;
insert into abap.dd04t select * from sapall.dd04t 
  where DDLANGUAGE in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

create table if not exists abap.ydok_dedz like sapall.ydok_dedz;
insert ignore into abap.ydok_dedz select * from sapall.ydok_dedz
  where LANGU in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

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
insert into abap.dd02t select * from sapall.dd02t
  where DDLANGUAGE in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

create table if not exists abap.dd03l like sapall.dd03l;
alter table abap.dd03l partition by key() partitions 10;
insert into abap.dd03l select * from sapall.dd03l;

create table if not exists abap.dd05s like sapall.dd05s;
insert into abap.dd05s select * from sapall.dd05s;

create table if not exists abap.dd08l like sapall.dd08l;
insert into abap.dd08l select * from sapall.dd08l;

create table if not exists abap.dd08t like sapall.dd08t;
insert into abap.dd08t select * from sapall.dd08t
  where DDLANGUAGE in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

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
  where SPRAS in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

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
  where sprsl in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

create table if not exists abap.trdirt like sapall.trdirt;
insert into abap.trdirt select * from sapall.trdirt
  where sprsl in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

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


-- Database table for SPRO

create table if not exists abap.cus_imgach like sapall.cus_imgach;
insert ignore into abap.cus_imgach select * from sapall.cus_imgach;

create table if not exists abap.cus_imgact like sapall.cus_imgact;
insert ignore into abap.cus_imgact select * from sapall.cus_imgact
  where spras in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

create table if not exists abap.cus_atrh like sapall.cus_atrh;
insert ignore into abap.cus_atrh select * from sapall.cus_atrh;

create table if not exists abap.cus_atrt like sapall.cus_atrt;
insert ignore into abap.cus_atrt select * from sapall.cus_atrt
  where spras in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

create table if not exists abap.cus_atrcou like sapall.cus_atrcou;
insert ignore into abap.cus_atrcou select * from sapall.cus_atrcou;

create table if not exists abap.cus_actobj like sapall.cus_actobj;
insert ignore into abap.cus_actobj select * from sapall.cus_actobj;

create table if not exists abap.cus_actobt like sapall.cus_actobt;
insert ignore into abap.cus_actobt select * from sapall.cus_actobt
  where spras in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

create table if not exists abap.cus_actext like sapall.cus_actext;
insert ignore into abap.cus_actext select * from sapall.cus_actext;

create table if not exists abap.cus_acth like sapall.cus_acth;
insert ignore into abap.cus_acth select * from sapall.cus_acth;

create table if not exists abap.scus_hier like sapall.scus_hier;
insert ignore into abap.scus_hier select * from sapall.scus_hier;

create table if not exists abap.tnodeimg like sapall.tnodeimg;
insert ignore into abap.tnodeimg select * from sapall.tnodeimg;

create table if not exists abap.tnodeimgr like sapall.tnodeimgr;
insert ignore into abap.tnodeimgr select * from sapall.tnodeimgr;

create table if not exists abap.tnodeimgt like sapall.tnodeimgt;
insert ignore into abap.tnodeimgt select * from sapall.tnodeimgt;

create table if not exists abap.tnodeh like sapall.tnodeh;
insert ignore into abap.tnodeh select * from sapall.tnodeh;

create table if not exists abap.tnodet like sapall.tnodet;
insert ignore into abap.tnodet select * from sapall.tnodet
  where spras in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

create table if not exists abap.tfm18 like sapall.tfm18;
insert ignore into abap.tfm18 select * from sapall.tfm18;

create table if not exists abap.troadmap like sapall.troadmap;
insert ignore into abap.troadmap select * from sapall.troadmap;

create table if not exists abap.troadmapt like sapall.troadmapt;
insert ignore into abap.troadmapt select * from sapall.troadmapt;

create table if not exists abap.t005 like sapall.t005;
insert ignore into abap.t005 select * from sapall.t005;

create table if not exists abap.t005t like sapall.t005t;
insert ignore into abap.t005t select * from sapall.t005t;

create table if not exists abap.cus_actt like sapall.cus_actt;
insert ignore into abap.cus_actt select * from sapall.cus_actt
  where spras in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');

create table if not exists abap.ydok_hy like sapall.ydok_hy;
insert ignore into abap.ydok_hy select * from sapall.ydok_hy
  where langu in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');


-- Database table for MENU

create table if not exists abap.ttrees like sapall.ttrees;
insert ignore into abap.ttrees select * from sapall.ttrees;

create table if not exists abap.ttreet like sapall.ttreet;
insert ignore into abap.ttreet select * from sapall.ttreet;

create table if not exists abap.tmenu01 like sapall.tmenu01;
insert ignore into abap.tmenu01 select * from sapall.tmenu01;

create table if not exists abap.tmenu01r like sapall.tmenu01r;
insert ignore into abap.tmenu01r select * from sapall.tmenu01r;

create table if not exists abap.tmenu01t like sapall.tmenu01t;
insert ignore into abap.tmenu01t select * from sapall.tmenu01t
  where spras in ('N', 'E', 'F', 'D', 'I', 'J', '3', 'L', 'P', 'R', '1', 'S', 'M', 'T');


-- Database table for INTF or CLAS

create table if not exists abap.seoclass like sapall.seoclass;
insert ignore into abap.seoclass select * from sapall.seoclass;

create table if not exists abap.seoclassdf like sapall.seoclassdf;
insert ignore into abap.seoclassdf select * from sapall.seoclassdf;

create table if not exists abap.seocompo like sapall.seocompo;
insert ignore into abap.seocompo select * from sapall.seocompo;

create table if not exists abap.seocompodf like sapall.seocompodf;
insert ignore into abap.seocompodf select * from sapall.seocompodf;

create table if not exists abap.seocompotx like sapall.seocompotx;
insert ignore into abap.seocompotx select * from sapall.seocompotx;

create table if not exists abap.seofriends like sapall.seofriends;
insert ignore into abap.seofriends select * from sapall.seofriends;

create table if not exists abap.seoimplrel like sapall.seoimplrel;
insert ignore into abap.seoimplrel select * from sapall.seoimplrel;

create table if not exists abap.seosubco like sapall.seosubco;
insert ignore into abap.seosubco select * from sapall.seosubco;

create table if not exists abap.seosubcodf like sapall.seosubcodf;
insert ignore into abap.seosubcodf select * from sapall.seosubcodf;

create table if not exists abap.seotypepls like sapall.seotypepls;
insert ignore into abap.seotypepls select * from sapall.seotypepls;


-- Database table for SU21

create table if not exists abap.auth_fldinfo_tmp like sapall.auth_fldinfo_tmp;
insert ignore into abap.auth_fldinfo_tmp select * from sapall.auth_fldinfo_tmp;

create table if not exists abap.authx like sapall.authx;
insert ignore into abap.authx select * from sapall.authx;

create table if not exists abap.tact like sapall.tact;
insert ignore into abap.tact select * from sapall.tact;

create table if not exists abap.tactt like sapall.tactt;
insert ignore into abap.tactt select * from sapall.tactt;

create table if not exists abap.tactz like sapall.tactz;
insert ignore into abap.tactz select * from sapall.tactz;

create table if not exists abap.tobj like sapall.tobj;
insert ignore into abap.tobj select * from sapall.tobj;

create table if not exists abap.tobjt like sapall.tobjt;
insert ignore into abap.tobjt select * from sapall.tobjt;

create table if not exists abap.tobjvorflg like sapall.tobjvorflg;
insert ignore into abap.tobjvorflg select * from sapall.tobjvorflg;

create table if not exists abap.ytobc like sapall.ytobc;
insert ignore into abap.ytobc select * from sapall.ytobc;

create table if not exists abap.ytobct like sapall.ytobct;
insert ignore into abap.ytobct select * from sapall.ytobct;
-- epsschrfrm: skip this table


-- Database table for PFCG

create table if not exists abap.agr_define like sapall.agr_define;
insert ignore into abap.agr_define select * from sapall.agr_define;

create table if not exists abap.agr_agrs like sapall.agr_agrs;
insert ignore into abap.agr_agrs select * from sapall.agr_agrs;

create table if not exists abap.agr_agrs2 like sapall.agr_agrs2;
insert ignore into abap.agr_agrs2 select * from sapall.agr_agrs2;

create table if not exists abap.agr_1250 like sapall.agr_1250;
insert ignore into abap.agr_1250 select * from sapall.agr_1250;

create table if not exists abap.agr_1251 like sapall.agr_1251;
insert ignore into abap.agr_1251 select * from sapall.agr_1251;

create table if not exists abap.usr12 like sapall.usr12;
insert ignore into abap.usr12 select * from sapall.usr12;


-- Database table for RZ10

create table if not exists abap.yspflmetadata like sapall.yspflmetadata;
insert ignore into abap.yspflmetadata select * from sapall.yspflmetadata;

create table if not exists abap.yspflparasub like sapall.yspflparasub;
insert ignore into abap.yspflparasub select * from sapall.yspflparasub;

create table if not exists abap.yspflparausub like sapall.yspflparausub;
insert ignore into abap.yspflparausub select * from sapall.yspflparausub;

