*&---------------------------------------------------------------------*
*& Report  YDDIC2MYSQL
*&
*&---------------------------------------------------------------------*
*& Generate MySQL CREATE TABLE script based on DD03L table contents.
*&---------------------------------------------------------------------*

REPORT yddic2mysql.

TABLES dd03l.

SELECT-OPTIONS it_tname FOR dd03l-tabname OBLIGATORY.
PARAMETER iv_drop TYPE flag AS CHECKBOX DEFAULT 'X'.
PARAMETER iv_mtxt TYPE flag AS CHECKBOX DEFAULT ' '. " Convert String as Medium Text (<=16MB text)


TYPES: BEGIN OF ts_ddic2mysql,
         datatype  TYPE dd03l-datatype,
         mysqltype TYPE char256,
       END OF ts_ddic2mysql.

CONSTANTS:
  mysql_char    TYPE char32 VALUE 'char',
  mysql_varchar TYPE char32 VALUE 'varchar',
  mysql_int     TYPE char32 VALUE 'int',
  mysql_double  TYPE char32 VALUE 'double',
  mysql_decimal TYPE char32 VALUE 'decimal'.
DATA: gt_ddic2mysql      TYPE STANDARD TABLE OF ts_ddic2mysql.


INITIALIZATION.

  PERFORM init.

FORM init.

* Initial Program Parameter

  DATA: ls_tname  LIKE LINE OF it_tname.

  CLEAR it_tname.

  ls_tname-sign = 'I'.
  ls_tname-option = 'EQ'.

  ls_tname-low = 'AGR_DEFINE'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'AGR_AGRS'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'AGR_AGRS2'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'AGR_1250'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'AGR_1251'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'AUTHX'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'AUTH_FLDINFO_TMP'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CUS_ACTEXT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CUS_ACTOBJ'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CUS_ACTOBT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CUS_ACTH'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CUS_ACTT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CUS_ATRCOU'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CUS_ATRH'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CUS_ATRT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CUS_IMGACH'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CUS_IMGACT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CVERS'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'CVERS_REF'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'D010INC'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'D010TAB'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'D020S'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'D020T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DARTT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD01L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD01T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD02L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD02T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD03L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD04L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD04T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD05S'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD06L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD06T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD07L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD07T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD08L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD08T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD09L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD12L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD12T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD16S'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD17S'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD25L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD25T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD26S'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD27S'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD28S'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD35L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DD36S'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DF14L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DF14T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DM02T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DM25L'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DOKHL'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'DOKIL'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'ENLFDIR'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'EPSSCHRFRM'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'FUNCT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'FUPARAREF'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'LDBT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'OBJH'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'RSMPTEXTS'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SCUS_HIER'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOCLASS'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOCLASSDF'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOCLASSTX'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOCOMPO'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOCOMPODF'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOCOMPOTX'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOFRIENDS'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOIMPLREL'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOMETAREL'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOSUBCO'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOSUBCODF'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOSUBCOTX'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SEOTYPEPLS'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SFW_SWITCH'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'SFW_SWITCHT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'T002T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'T005'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'T005T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TACT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TACTT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TACTZ'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TADIR'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TBRGT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TDEVC'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TDEVCT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TFDIR'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TFM18'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TFTIT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TLIBT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TMENU01'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TMENU01R'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TMENU01T'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TNODEH'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TNODET'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TNODEIMG'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TNODEIMGR'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TNODEIMGT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TOBJ'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TOBJT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TOBJVORFLG'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TRDIRT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TROADMAP'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TROADMAPT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TSTC'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TSTCA'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TSTCC'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TSTCP'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TSTCT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TTREES'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TTREET'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TTREE_SFW_NODES'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'TVDIR'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'USR12'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YDOKTL'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YDYNPSOURCED021S'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YDYNPSOURCED022S'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YDYNPSOURCED023S'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YREPOSRCDATA'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YREPOSRCMETA'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YSPFLMETADATA'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YSPFLPARASUB'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YSPFLPARAUSUB'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YTAPLT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YTDDAT'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YTOBC'. APPEND ls_tname TO it_tname.
  ls_tname-low = 'YTOBCT'. APPEND ls_tname TO it_tname.

* Datatype mapping from DDIC type to MySQL type

  DATA: ls_ddic2mysql   TYPE ts_ddic2mysql.

  CLEAR gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'ACCP'.
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'CHAR'.
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'CLNT'.
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'CUKY'.
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'CURR'.
  ls_ddic2mysql-mysqltype = mysql_decimal.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

* D16D
* D16R
* D16S
* D34D
* D34R
* D34S

  ls_ddic2mysql-datatype = 'DATS'.
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'DEC'.
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'FLTP'.
  ls_ddic2mysql-mysqltype = mysql_double.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'INT1'.
  ls_ddic2mysql-mysqltype = mysql_int.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'INT2'.
  ls_ddic2mysql-mysqltype = mysql_int.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'INT4'.
  ls_ddic2mysql-mysqltype = mysql_int.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'LANG'.
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

* LCHR - To be tested
  ls_ddic2mysql-datatype = 'LCHR'.
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

* LRAW

  ls_ddic2mysql-datatype = 'NUMC'.
  ls_ddic2mysql-mysqltype = mysql_int.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

* PERC

  ls_ddic2mysql-datatype = 'QUAN'.
  ls_ddic2mysql-mysqltype = mysql_decimal.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'RAW'.
  ls_ddic2mysql-mysqltype = mysql_char.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

* RSTR

  ls_ddic2mysql-datatype = 'SSTR'.
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'STRG'.           " STRING
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'TIMS'.
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

  ls_ddic2mysql-datatype = 'UNIT'.
  ls_ddic2mysql-mysqltype = mysql_varchar.
  APPEND ls_ddic2mysql TO gt_ddic2mysql.

* VARC

ENDFORM.


START-OF-SELECTION.

  PERFORM main.

FORM main.
  DATA: ls_tname   LIKE LINE OF it_tname,
        lv_counter TYPE i.

  lv_counter = 0.
  LOOP AT it_tname INTO ls_tname.
    lv_counter = lv_counter + 1.
    PERFORM generate_mysql_create
      USING ls_tname-low lv_counter.
  ENDLOOP.

ENDFORM.


*
* Generate CREATE TABLE SQL script.
*
* Example of generated script:
*
*   -- 1. Table T000
*   DROP TABLE IF EXISTS `T000`;
*   CREATE TABLE IF NOT EXISTS `T000`(
*   `id`       int(11) NOT NULL AUTO_INCREMENT,
*   `MYUSER`   varchar(30)  COLLATE utf8_bin NOT NULL     COMMENT 'My user name',
*   `EMAIL`    varchar(30)  COLLATE utf8_bin DEFAULT NULL COMMENT 'Email address'' the user',
*   `WEBPAGE`  varchar(100) COLLATE utf8_bin NOT NULL     COMMENT 'Web Page',
*   `DATUM`    date                          NOT NULL,
*   `SUMMERY`  varchar(40)  COLLATE utf8_bin NOT NULL,
*   `COMMENTS` varchar(400) COLLATE utf8_bin NOT NULL,
*   `char01`   char(1)      COLLATE utf8_bin DEFAULT NULL,
*   PRIMARY KEY (`id`, `MYUSER`)
*   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

FORM generate_mysql_create
  USING i_tname         TYPE dd03l-tabname
        i_counter       TYPE i.

  DATA: lt_dd03l    TYPE STANDARD TABLE OF dd03l,
        lt_dd03l_pk TYPE STANDARD TABLE OF dd03l,
        ls_dd03l    TYPE dd03l.
  DATA: lv_tname  TYPE string,
        lv_string TYPE string.

  SELECT * FROM dd03l INTO TABLE lt_dd03l
    WHERE tabname = i_tname
    ORDER BY position.
  CONCATENATE '`' i_tname '`' INTO lv_tname.

* -- 1. Table T000
  MOVE i_counter TO lv_string.
  CONCATENATE '-- ' lv_string '. Table ' lv_tname
    INTO lv_string RESPECTING BLANKS.
  WRITE lv_string.
  NEW-LINE.

* DROP TABLE IF EXISTS `T000`;
  IF iv_drop EQ 'X'.
    CONCATENATE 'DROP TABLE IF EXISTS ' lv_tname ';'
      INTO lv_string RESPECTING BLANKS.
    WRITE lv_string.
    NEW-LINE.
  ENDIF.

* CREATE TABLE IF NOT EXISTS `T000`(
  CONCATENATE 'CREATE TABLE IF NOT EXISTS ' lv_tname ' ('
    INTO lv_string RESPECTING BLANKS.
  WRITE lv_string.
  NEW-LINE.

  DATA: lv_fieldname TYPE string,
        lv_mysqltype TYPE string.

  CLEAR lt_dd03l_pk.
  LOOP AT lt_dd03l INTO ls_dd03l.
    IF ls_dd03l-DATATYPE IS INITIAL.
      CONTINUE.
    ENDIF.

    CONCATENATE '`' ls_dd03l-fieldname '`'
      INTO lv_fieldname.

*   `SUMMERY`  varchar(40)  COLLATE utf8_bin NOT NULL,
    PERFORM ddictype2mysqltype
            USING
               ls_dd03l-datatype
               ls_dd03l-leng
               ls_dd03l-decimals
            CHANGING
               lv_mysqltype.
    CONCATENATE '  ' lv_fieldname '  ' lv_mysqltype '  COLLATE utf8_bin,'
      INTO lv_string RESPECTING BLANKS.
    WRITE lv_string.
    NEW-LINE.

    IF ls_dd03l-keyflag = abap_true.
      APPEND ls_dd03l TO lt_dd03l_pk.
    ENDIF.
  ENDLOOP.

  IF lt_dd03l_pk IS NOT INITIAL.
*   PRIMARY KEY (`id`, `MYUSER`)
    WRITE 'PRIMARY KEY ('.

    LOOP AT lt_dd03l_pk INTO ls_dd03l.
      IF sy-tabix > 1.
        WRITE ', '.
      ENDIF.

      CONCATENATE '`' ls_dd03l-fieldname '`'
        INTO lv_fieldname.
      WRITE lv_fieldname.
    ENDLOOP.

    WRITE ' )'.
    NEW-LINE.
  ENDIF.

*   ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
  WRITE ') ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;'.
  NEW-LINE.

ENDFORM.


FORM ddictype2mysqltype
  USING    i_datatype   TYPE dd03l-datatype
           i_leng       TYPE dd03l-leng
           i_decimals   TYPE dd03l-decimals
  CHANGING e_mysqltype  TYPE string.

  DATA: lv_msg         TYPE string.
  DATA: ls_map       TYPE ts_ddic2mysql,
        lv_mysqltype TYPE char32.

  CLEAR lv_mysqltype.
  READ TABLE gt_ddic2mysql INTO ls_map
    WITH KEY datatype = i_datatype.
  IF sy-subrc = 0.
    lv_mysqltype = ls_map-mysqltype.
  ELSE.
*   If the following error happens, add the corresponding mapping for the i_datatype
    CONCATENATE 'Cannot found corresponding data type for type' i_datatype
          INTO lv_msg.
    MESSAGE lv_msg TYPE 'E'.
  ENDIF.

  CASE lv_mysqltype.
    WHEN mysql_varchar OR mysql_char.
*     %s(%d)
      IF lv_mysqltype = 'RAW'.
        i_leng = i_leng + i_leng.
      ENDIF.
      IF i_datatype EQ 'STRG'.
        i_leng = 1024.
      ENDIF.
      MOVE i_leng TO e_mysqltype.
      CONCATENATE '(' e_mysqltype ')' INTO e_mysqltype.
      CONCATENATE lv_mysqltype e_mysqltype INTO e_mysqltype.
      IF iv_mtxt eq 'X' and i_datatype EQ 'STRG'.
        MOVE ' MEDIUMTEXT' to e_mysqltype.
      ENDIF.
    WHEN mysql_int.
      e_mysqltype = 'int(11)'.
    WHEN mysql_decimal.
*     %s(%d,%d)
      MOVE i_leng TO e_mysqltype.
      MOVE i_decimals TO lv_msg.
      CONCATENATE '(' e_mysqltype ',' lv_msg ')' INTO e_mysqltype.
      CONCATENATE lv_mysqltype e_mysqltype INTO e_mysqltype.
    WHEN OTHERS.
      e_mysqltype = lv_mysqltype.
  ENDCASE.

ENDFORM.