*&---------------------------------------------------------------------*
*& Report  YTDDAT
*&
*&---------------------------------------------------------------------*
*& Copy TDDAT to YTDDAT.
*&---------------------------------------------------------------------*

REPORT  ytddat.

PARAMETERS i_min_ln     TYPE i DEFAULT  20000 OBLIGATORY.  " Minimal lines to be submitted to Database


DATA: lv_log_s        TYPE string,
      lv_log          TYPE string,
      gv_dbcnt        TYPE i.
DATA: ls_db           TYPE tddat,
      lt_db           TYPE STANDARD TABLE OF tddat,
      ls_ydb          TYPE ytddat,
      gt_ydb          TYPE STANDARD TABLE OF ytddat,
      lv_lines        TYPE i.

SELECT * FROM tddat INTO TABLE lt_db.   " Only work when records count is small
LOOP AT lt_db INTO ls_db.

  MOVE-CORRESPONDING ls_db TO ls_ydb.
  APPEND ls_ydb TO gt_ydb.

  DESCRIBE TABLE gt_ydb LINES lv_lines.
  IF lv_lines >= i_min_ln.
    PERFORM save.
  ENDIF.
ENDLOOP.

IF gt_ydb IS NOT INITIAL.
  PERFORM save.
ENDIF.

" Write Job Log
MOVE gv_dbcnt TO lv_log_s.
CONCATENATE 'SAVE to ytddat record count is ' lv_log_s INTO lv_log RESPECTING BLANKS.
MESSAGE lv_log TYPE 'I'.
MESSAGE 'Done.' TYPE 'I'.

*&---------------------------------------------------------------------*
*&      Form  save
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
FORM save.
  DATA: lv_dbcnt      TYPE int4,
        lv_dbcnt_s    TYPE string,
        lv_log        TYPE string.

  DESCRIBE TABLE gt_ydb LINES lv_dbcnt.
  MOVE lv_dbcnt TO lv_dbcnt_s.
  gv_dbcnt = gv_dbcnt + lv_dbcnt.

  INSERT ytddat FROM TABLE gt_ydb ACCEPTING DUPLICATE KEYS.
  COMMIT WORK.
  CLEAR gt_ydb.

  " Write Job Log
  CONDENSE lv_dbcnt_s.
  CONCATENATE 'SAVE DATA: Saved to ytddat, record count = ' lv_dbcnt_s INTO lv_log.
  MESSAGE lv_log TYPE 'I'.
ENDFORM.                    "save