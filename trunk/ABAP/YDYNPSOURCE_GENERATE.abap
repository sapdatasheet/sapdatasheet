*&---------------------------------------------------------------------*
*& Report  YDYNPSOURCE_GENERATE
*&
*&---------------------------------------------------------------------*
*& Generate YDYNPSOURCE* table contents
*& Refer to:
*&   Include LSVIMF45
*&   Line    185
*&---------------------------------------------------------------------*

REPORT ydynpsource_generate.

PARAMETERS i_min_ln     TYPE i DEFAULT  20000 OBLIGATORY.  " Minimal lines to be submitted to Database


DATA: lv_log_s        TYPE string,
      lv_log          TYPE string.
DATA: lt_dynpsource   TYPE STANDARD TABLE OF dynpsource,
      ls_dynpsource   TYPE dynpsource.
DATA: h               TYPE d020s,
      f               TYPE STANDARD TABLE OF d021s,
      e               TYPE STANDARD TABLE OF d022s,
      m               TYPE STANDARD TABLE OF d023s,
      dynid(44)       TYPE c.
DATA: lv_count        TYPE i,
      lv_lines        TYPE i,
      ls_f            TYPE d021s,
      ls_e            TYPE d022s,
      ls_m            TYPE d023s,
      ls_yd021s       TYPE ydynpsourced021s,
      ls_yd022s       TYPE ydynpsourced022s,
      ls_yd023s       TYPE ydynpsourced023s.
DATA: gt_db_d021s     TYPE STANDARD TABLE OF ydynpsourced021s,
      gt_db_d022s     TYPE STANDARD TABLE OF ydynpsourced022s,
      gt_db_d023s     TYPE STANDARD TABLE OF ydynpsourced023s,
      gv_dbcnt_d021s  TYPE i VALUE 0,
      gv_dbcnt_d022s  TYPE i VALUE 0,
      gv_dbcnt_d023s  TYPE i VALUE 0.

MESSAGE 'Start to load progname dynpnumber' TYPE 'I'.
SELECT progname dynpnumber FROM dynpsource
  INTO CORRESPONDING FIELDS OF TABLE lt_dynpsource.
MESSAGE 'Finished loading progname dynpnumber' TYPE 'I'.

LOOP AT lt_dynpsource INTO ls_dynpsource.

  " Write Job Log
  MOVE sy-tabix TO lv_log_s.
  CONCATENATE 'seq = ' lv_log_s ': Processing for dynpro '
     ls_dynpsource-progname
     ls_dynpsource-dynpnumber
     INTO lv_log RESPECTING BLANKS.
  MESSAGE lv_log TYPE 'I'.

  CLEAR: h, f, e, m, dynid.
  dynid = ls_dynpsource-progname.
  dynid+40(4) = ls_dynpsource-dynpnumber.
  IMPORT DYNPRO h f e m ID dynid.

  IF f IS NOT INITIAL.
    lv_count = 1.
    LOOP AT f INTO ls_f.
      ls_yd021s-progname   = ls_dynpsource-progname.
      ls_yd021s-dynpnumber = ls_dynpsource-dynpnumber.
      ls_yd021s-seq        = lv_count.
      MOVE-CORRESPONDING ls_f TO ls_yd021s.
      APPEND ls_yd021s TO gt_db_d021s.

      lv_count = lv_count + 1.
    ENDLOOP.
  ENDIF.

  IF e IS NOT INITIAL.
    lv_count = 1.
    LOOP AT e INTO ls_e.
      ls_yd022s-progname   = ls_dynpsource-progname.
      ls_yd022s-dynpnumber = ls_dynpsource-dynpnumber.
      ls_yd022s-seq        = lv_count.
      MOVE-CORRESPONDING ls_e TO ls_yd022s.
      APPEND ls_yd022s TO gt_db_d022s.

      lv_count = lv_count + 1.
    ENDLOOP.
  ENDIF.

  IF m IS NOT INITIAL.
    lv_count = 1.
    LOOP AT m INTO ls_m.
      ls_yd023s-progname   = ls_dynpsource-progname.
      ls_yd023s-dynpnumber = ls_dynpsource-dynpnumber.
      ls_yd023s-seq        = lv_count.
      MOVE ls_m-content   TO ls_yd023s-content.

      APPEND ls_yd023s TO gt_db_d023s.
      lv_count = lv_count + 1.
    ENDLOOP.
  ENDIF.

  " Save to Database - Group the save into a big package according to i_min_ln
  DESCRIBE TABLE gt_db_d021s LINES lv_lines.
  IF lv_lines >= i_min_ln.
    PERFORM save_d021s.
  ENDIF.
  DESCRIBE TABLE gt_db_d022s LINES lv_lines.
  IF lv_lines >= i_min_ln.
    PERFORM save_d022s.
  ENDIF.
  DESCRIBE TABLE gt_db_d023s LINES lv_lines.
  IF lv_lines >= i_min_ln.
    PERFORM save_d023s.
  ENDIF.

ENDLOOP.

IF gt_db_d021s IS NOT INITIAL.
  PERFORM save_d021s.
ENDIF.
IF gt_db_d022s IS NOT INITIAL.
  PERFORM save_d022s.
ENDIF.
IF gt_db_d023s IS NOT INITIAL.
  PERFORM save_d023s.
ENDIF.


*&---------------------------------------------------------------------*
*&      Form  save_d021s
*&---------------------------------------------------------------------*
*       Save D021S
*----------------------------------------------------------------------*
FORM save_d021s.
  DATA: lv_dbcnt      TYPE int4,
        lv_dbcnt_s    TYPE string,
        lv_log        TYPE string.

  DESCRIBE TABLE gt_db_d021s LINES lv_dbcnt.
  MOVE lv_dbcnt TO lv_dbcnt_s.
  gv_dbcnt_d021s = gv_dbcnt_d021s + lv_dbcnt.

  INSERT ydynpsourced021s FROM TABLE gt_db_d021s ACCEPTING DUPLICATE KEYS.
  COMMIT WORK.
  CLEAR gt_db_d021s.

  " Write Job Log
  CONDENSE lv_dbcnt_s.
  CONCATENATE 'SAVE D021S: Saved to ydynpsourced021s, record count = ' lv_dbcnt_s INTO lv_log.
  MESSAGE lv_log TYPE 'I'.
ENDFORM.                                                    "save_d021s


*&---------------------------------------------------------------------*
*&      Form  save_d022s
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
FORM save_d022s.
  DATA: lv_dbcnt      TYPE int4,
        lv_dbcnt_s    TYPE string,
        lv_log        TYPE string.

  DESCRIBE TABLE gt_db_d022s LINES lv_dbcnt.
  MOVE lv_dbcnt TO lv_dbcnt_s.
  gv_dbcnt_d022s = gv_dbcnt_d022s + lv_dbcnt.

  INSERT ydynpsourced022s FROM TABLE gt_db_d022s ACCEPTING DUPLICATE KEYS.
  COMMIT WORK.
  CLEAR gt_db_d022s.

  " Write Job Log
  CONDENSE lv_dbcnt_s.
  CONCATENATE 'SAVE D022S: Saved to ydynpsourced022s, record count = ' lv_dbcnt_s INTO lv_log.
  MESSAGE lv_log TYPE 'I'.
ENDFORM.                                                    "save_d022s

*&---------------------------------------------------------------------*
*&      Form  save_d023s
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
FORM save_d023s.
  DATA: lv_dbcnt      TYPE int4,
        lv_dbcnt_s    TYPE string,
        lv_log        TYPE string.

  DESCRIBE TABLE gt_db_d023s LINES lv_dbcnt.
  MOVE lv_dbcnt TO lv_dbcnt_s.
  gv_dbcnt_d023s = gv_dbcnt_d023s + lv_dbcnt.

  INSERT ydynpsourced023s FROM TABLE gt_db_d023s ACCEPTING DUPLICATE KEYS.
  COMMIT WORK.
  CLEAR gt_db_d023s.

  " Write Job Log
  CONDENSE lv_dbcnt_s.
  CONCATENATE 'SAVE D023S: Saved to ydynpsourced023s, record count = ' lv_dbcnt_s INTO lv_log.
  MESSAGE lv_log TYPE 'I'.
ENDFORM.                                                    "save_d023s