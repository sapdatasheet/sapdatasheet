*&---------------------------------------------------------------------*
*& Report  YDOKTL_JOB
*&
*&---------------------------------------------------------------------*
*&
*&---------------------------------------------------------------------*

REPORT  ydoktl_job.

TABLES doktl.
TABLES rsparams.

SELECT-OPTIONS i_id         FOR doktl-id OBLIGATORY.
SELECT-OPTIONS i_obj1       FOR rsparams-low OBLIGATORY.
SELECT-OPTIONS i_obj2       FOR rsparams-low.

START-OF-SELECTION.

  DATA: ls_id               LIKE LINE OF i_id,
        ls_obj1             LIKE LINE OF i_obj1,
        ls_obj2             LIKE LINE OF i_obj2,
        lv_tabix            TYPE syst-tabix,
        ls_doktl            TYPE doktl,
        lt_doktl_sel        TYPE STANDARD TABLE OF doktl,
        lt_ydoktl           TYPE STANDARD TABLE OF ydoktl.
  DATA: lv_lines            TYPE i,
        lv_log_s            TYPE string,
        lv_log              TYPE string.

  LOOP AT i_id INTO ls_id.
    lv_tabix = sy-tabix.
    READ TABLE i_obj1 INTO ls_obj1 INDEX lv_tabix.
    READ TABLE i_obj2 INTO ls_obj2 INDEX lv_tabix.

    CLEAR ls_doktl.
    ls_doktl-id            = ls_id-low.
    ls_doktl-object(45)    = ls_obj1-low.
    ls_doktl-object+45(15) = ls_obj2-low(15).
    APPEND ls_doktl TO lt_doktl_sel.
  ENDLOOP.

  " Write Job Log
  MESSAGE 'LOAD data from table DOKTL' TYPE 'I'.            "#EC NOTEXT

  SELECT * FROM doktl INTO CORRESPONDING FIELDS OF TABLE lt_ydoktl
    FOR ALL ENTRIES IN lt_doktl_sel
    WHERE id     = lt_doktl_sel-id
      AND object = lt_doktl_sel-object.

  CALL FUNCTION 'YDOKTL_INSERTDB' IN UPDATE TASK
    TABLES
      it_db = lt_ydoktl.
  COMMIT WORK.

  " Write Job Log
  DESCRIBE TABLE lt_ydoktl LINES lv_lines.
  MOVE lv_lines TO lv_log_s.
  CONCATENATE 'SAVE to YDOKTL record count is ' lv_log_s INTO lv_log RESPECTING BLANKS. "#EC NOTEXT
  MESSAGE lv_log TYPE 'I'.