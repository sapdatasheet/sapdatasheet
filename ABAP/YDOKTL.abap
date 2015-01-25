*&---------------------------------------------------------------------*
*& Report  YDOKTL
*&
*&---------------------------------------------------------------------*
*& Copy DOKTL to YDOKTL
*&---------------------------------------------------------------------*

REPORT  ydoktl.

PARAMETERS i_grp_sz     TYPE i DEFAULT   1000 OBLIGATORY.  " Group Size for Each Job

TYPES: BEGIN OF ts_key,
     id       TYPE doku_id,
     object   TYPE doku_obj,
     END OF ts_key.
TYPES: tt_key TYPE SORTED TABLE OF ts_key WITH UNIQUE KEY id object.

CONSTANTS:
      cv_para_count   TYPE i VALUE 3.
DATA: gv_uzeit        TYPE sy-uzeit,
      gt_rsparam      TYPE rsparams_tt,
      gs_rsparam      LIKE LINE OF gt_rsparam.


START-OF-SELECTION.

  PERFORM main.

*&---------------------------------------------------------------------*
*&      Form  main
*&---------------------------------------------------------------------*
*       Entrance
*----------------------------------------------------------------------*
FORM main.

  DATA: lv_log_s        TYPE string,
        lv_log          TYPE string.
  DATA: ls_key          TYPE ts_key,
        lt_key          TYPE tt_key.
  DATA: lv_grp_min      TYPE i,
        lv_counter      TYPE i,
        ls_doktl        TYPE doktl,
        lv_lines        TYPE i.

  gv_uzeit   = sy-uzeit.
  lv_grp_min = i_grp_sz * cv_para_count.

  MESSAGE 'Loading Key ...' TYPE 'I'.                       "#EC NOTEXT

  CLEAR lt_key.
  SELECT id object FROM doktl INTO ls_doktl.  " UP TO 20000 ROWS.
    READ TABLE lt_key TRANSPORTING NO FIELDS
      WITH TABLE KEY
        id     = ls_doktl-id
        object = ls_doktl-object.
    IF sy-subrc NE 0.
      CLEAR ls_key.
      ls_key-id     = ls_doktl-id.
      ls_key-object = ls_doktl-object.
      APPEND ls_key TO lt_key.
    ENDIF.
  ENDSELECT.


  lv_counter = 0.
  LOOP AT lt_key INTO ls_key.

    lv_counter = lv_counter + 1.

    " Prepare Paramters
    CLEAR gs_rsparam.
    gs_rsparam-selname = 'I_ID'.
    gs_rsparam-kind    = 'S'.
    gs_rsparam-sign    = 'I'.
    gs_rsparam-option  = 'EQ'.
    gs_rsparam-low     = ls_key-id.
    APPEND gs_rsparam TO gt_rsparam.

    CLEAR gs_rsparam.
    gs_rsparam-selname = 'I_OBJ1'.
    gs_rsparam-kind    = 'S'.
    gs_rsparam-sign    = 'I'.
    gs_rsparam-option  = 'EQ'.
    gs_rsparam-low     = ls_key-object(45).
    APPEND gs_rsparam TO gt_rsparam.

    CLEAR gs_rsparam.
    gs_rsparam-selname = 'I_OBJ2'.
    gs_rsparam-kind    = 'S'.
    gs_rsparam-sign    = 'I'.
    gs_rsparam-option  = 'EQ'.
    gs_rsparam-low     = ls_key-object+45.
    APPEND gs_rsparam TO gt_rsparam.


    DESCRIBE TABLE gt_rsparam LINES lv_lines.
    IF lv_lines >= lv_grp_min.
      PERFORM submit_job USING lv_counter.
      CLEAR gt_rsparam.
    ENDIF.

  ENDLOOP.


  IF gt_rsparam IS NOT INITIAL.
    PERFORM submit_job USING lv_counter.
    CLEAR gt_rsparam.
  ENDIF.

  " Write Job Log
  MOVE lv_counter TO lv_log_s.
  CONCATENATE 'DOKTL(id, object) group count is ' lv_log_s INTO lv_log RESPECTING BLANKS. "#EC NOTEXT
  MESSAGE lv_log TYPE 'I'.
  MESSAGE 'Done.' TYPE 'I'.                                 "#EC NOTEXT

ENDFORM.                    "main


*&---------------------------------------------------------------------*
*&      Form  submit_job
*&---------------------------------------------------------------------*
*       Submit background job.
*----------------------------------------------------------------------*
FORM submit_job
  USING i_counter     TYPE i.

  DATA: lv_line       TYPE i,
        lv_line_s     TYPE string,
        lv_dbcnt      TYPE i,
        lv_dbcnt_s    TYPE char16,
        lv_job_name   TYPE btcjob,
        lv_job_count  TYPE btcjobcnt.
  DATA: lv_log        TYPE string.

  DESCRIBE TABLE gt_rsparam LINES lv_line.
  lv_line = lv_line / cv_para_count.
  MOVE lv_line TO lv_line_s.

  lv_dbcnt = i_counter - lv_line + 1.
  MOVE lv_dbcnt TO lv_dbcnt_s.
  CONDENSE lv_dbcnt_s.
  UNPACK lv_dbcnt_s TO lv_dbcnt_s.    " Add leading zero (0)

  CONCATENATE 'DL' gv_uzeit '_' lv_dbcnt_s '_' lv_line_s INTO lv_job_name.

  " 1/3 - Job Open
  CALL FUNCTION 'JOB_OPEN'
    EXPORTING
      jobname          = lv_job_name
    IMPORTING
      jobcount         = lv_job_count
    EXCEPTIONS
      cant_create_job  = 1
      invalid_job_data = 2
      jobname_missing  = 3
      OTHERS           = 4.
  IF sy-subrc <> 0.
    MESSAGE ID sy-msgid TYPE sy-msgty NUMBER sy-msgno
            WITH sy-msgv1 sy-msgv2 sy-msgv3 sy-msgv4.
  ENDIF.

  " 2/3 - Submit program
  SUBMIT ydoktl_job
          WITH SELECTION-TABLE gt_rsparam
          VIA JOB lv_job_name
          NUMBER lv_job_count
          AND RETURN.

  " 3/3 - Job Close
  CALL FUNCTION 'JOB_CLOSE'
    EXPORTING
      jobcount             = lv_job_count
      jobname              = lv_job_name
      strtimmed            = 'X'                       " Job Start Immediately
    EXCEPTIONS
      cant_start_immediate = 1
      invalid_startdate    = 2
      jobname_missing      = 3
      job_close_failed     = 4
      job_nosteps          = 5
      job_notex            = 6
      lock_failed          = 7
      invalid_target       = 8
      OTHERS               = 9.
  IF sy-subrc <> 0.
    MESSAGE ID sy-msgid TYPE sy-msgty NUMBER sy-msgno
            WITH sy-msgv1 sy-msgv2 sy-msgv3 sy-msgv4.
  ENDIF.

  CONCATENATE 'Job submitted: ' lv_job_name INTO lv_log RESPECTING BLANKS. "#EC NOTEXT
  MESSAGE lv_log TYPE 'I'.

ENDFORM.                    "submit_job