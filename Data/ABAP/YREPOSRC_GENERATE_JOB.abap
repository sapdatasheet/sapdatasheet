*&---------------------------------------------------------------------*
*& Report  YREPOSRC_GENERATE_JOB
*&
*&---------------------------------------------------------------------*
*& Prepare YREPOSRC META & DATA
*&---------------------------------------------------------------------*

REPORT  yreposrc_generate_job.

TABLES: rs38m.


SELECT-OPTIONS i_prog       FOR rs38m-programm OBLIGATORY.
PARAMETERS     i_min_ln     TYPE i DEFAULT 20000 OBLIGATORY.  " Minimal lines to be submited to Database

START-OF-SELECTION.

  DATA: gt_meta       TYPE STANDARD TABLE OF yreposrcmeta,
        gt_data       TYPE STANDARD TABLE OF yreposrcdata,
        gv_meta_dbcnt TYPE i VALUE 0,
        gv_data_dbcnt TYPE i VALUE 0.
  DATA: ls_prog       LIKE LINE OF i_prog,
        ls_reposrc    TYPE reposrc,
        lv_line       TYPE i,
        lt_src        TYPE TABLE OF string,
        lv_src        TYPE string,
        ls_meta       TYPE yreposrcmeta,
        ls_data       TYPE yreposrcdata.
  DATA: lv_lines      TYPE i.
  DATA: lv_log_s      TYPE string,
        lv_log        TYPE string.

  LOOP AT i_prog INTO ls_prog.

    " Write Job Log
    MOVE sy-tabix TO lv_log_s.
    CONCATENATE 'seq = ' lv_log_s ': Processing for program ' ls_prog-low INTO lv_log RESPECTING BLANKS.
    MESSAGE lv_log TYPE 'I'.

    " Meta
    CLEAR ls_reposrc.
    SELECT SINGLE * FROM reposrc INTO ls_reposrc WHERE progname = ls_prog-low.
    IF sy-subrc EQ 0 AND ls_reposrc IS NOT INITIAL.
      MOVE-CORRESPONDING ls_reposrc TO ls_meta.
      APPEND ls_meta TO gt_meta.           " Collect Meta
    ENDIF.

    " Data
    CLEAR lt_src.
    READ REPORT ls_meta-progname INTO lt_src.
    IF lt_src IS NOT INITIAL.
      lv_line = 1.
      LOOP AT lt_src INTO lv_src.
        CLEAR ls_data.
        ls_data-progname = ls_reposrc-progname.
        ls_data-seq = lv_line.
        ls_data-len = STRLEN( lv_src ).
        MOVE lv_src TO ls_data-line.

        APPEND ls_data TO gt_data.          " Collect data
        lv_line = lv_line + 1.
      ENDLOOP.
    ENDIF.

    " Save to Database - Group the save into a big package according to i_min_ln
    DESCRIBE TABLE gt_meta LINES lv_lines.
    IF lv_lines >= i_min_ln.
      PERFORM save_meta.
    ENDIF.
    DESCRIBE TABLE gt_data LINES lv_lines.
    IF lv_lines >= i_min_ln.
      PERFORM save_data.
    ENDIF.

  ENDLOOP.

  " Save to Database - Save the last package in case there is
  IF gt_meta IS NOT INITIAL.
    PERFORM save_meta.
  ENDIF.
  IF gt_data IS NOT INITIAL.
    PERFORM save_data.
  ENDIF.

  " Write Job Log
  MOVE gv_meta_dbcnt TO lv_log_s.
  CONCATENATE 'SAVE to yreposrcmeta record count is ' lv_log_s INTO lv_log RESPECTING BLANKS.
  MESSAGE lv_log TYPE 'I'.
  MOVE gv_data_dbcnt TO lv_log_s.
  CONCATENATE 'SAVE to yreposrcdata record count is ' lv_log_s INTO lv_log RESPECTING BLANKS.
  MESSAGE lv_log TYPE 'I'.
  MESSAGE 'Done.' TYPE 'I'.


*&---------------------------------------------------------------------*
*&      Form  save_meta
*&---------------------------------------------------------------------*
*       Save to yreposrcmeta.
*----------------------------------------------------------------------*
FORM save_meta.
  DATA: lv_dbcnt      TYPE int4,
        lv_dbcnt_s    TYPE string,
        lv_log        TYPE string.

  DESCRIBE TABLE gt_meta LINES lv_dbcnt.
  MOVE lv_dbcnt TO lv_dbcnt_s.
  gv_meta_dbcnt = gv_meta_dbcnt + lv_dbcnt.

  CALL FUNCTION 'YREPOSRC_INSERTDB_META' IN UPDATE TASK
    TABLES
      it_meta = gt_meta.
  COMMIT WORK.
  CLEAR gt_meta.

  " Write Job Log
  CONDENSE lv_dbcnt_s.
  CONCATENATE 'SAVE META: Saved to yreposrcmeta, record count = ' lv_dbcnt_s INTO lv_log.
  MESSAGE lv_log TYPE 'I'.
ENDFORM.                    "save_meta


*&---------------------------------------------------------------------*
*&      Form  save_data
*&---------------------------------------------------------------------*
*       Save to yreposrcdata.
*----------------------------------------------------------------------*
FORM save_data.
  DATA: lv_dbcnt      TYPE int4,
        lv_dbcnt_s    TYPE string,
        lv_log        TYPE string.

  DESCRIBE TABLE gt_data LINES lv_dbcnt.
  MOVE lv_dbcnt TO lv_dbcnt_s.
  gv_data_dbcnt = gv_data_dbcnt + lv_dbcnt.

  CALL FUNCTION 'YREPOSRC_INSERTDB_DATA' IN UPDATE TASK
    TABLES
      it_data = gt_data.
  COMMIT WORK.
  CLEAR gt_data.

  " Write Job Log
  CONDENSE lv_dbcnt_s.
  CONCATENATE 'SAVE DATA: Saved to yreposrcdata, record count = ' lv_dbcnt_s INTO lv_log.
  MESSAGE lv_log TYPE 'I'.
ENDFORM.                    "save_data