*&---------------------------------------------------------------------*
*& Report  YREPOSRC_GENERATE_CONTROL
*&
*&---------------------------------------------------------------------*
*& Prepare YREPOSRC META & DATA
*&---------------------------------------------------------------------*

REPORT  yreposrc_generate_control.

PARAMETERS i_grp_sz     TYPE i DEFAULT   4000 OBLIGATORY.  " Group Size for Each Job
PARAMETERS i_min_ln     TYPE i DEFAULT  20000 OBLIGATORY.  " Minimal lines to be submitted to Database

START-OF-SELECTION.

  DATA: lt_progname      TYPE STANDARD TABLE OF reposrc-progname,
        lv_progname      TYPE reposrc-progname,
        lv_tabix         TYPE sy-tabix,
        lv_uzeit         TYPE sy-uzeit,
        gv_counter       TYPE int4.
  DATA: gt_rsparam       TYPE rsparams_tt,
        gs_rsparam       LIKE LINE OF gt_rsparam.

  SELECT progname FROM reposrc INTO TABLE lt_progname. " UP TO 14400 ROWS.

  lv_uzeit = sy-uzeit.

  PERFORM clear_counter.
  LOOP AT lt_progname INTO lv_progname.
    lv_tabix = sy-tabix.

    " Prepare Paramters
    CLEAR gs_rsparam.
    gs_rsparam-selname = 'I_PROG'.
    gs_rsparam-kind    = 'S'.
    gs_rsparam-sign    = 'I'.
    gs_rsparam-option  = 'EQ'.
    gs_rsparam-low     = lv_progname.

    APPEND gs_rsparam TO gt_rsparam.
    gv_counter = gv_counter + 1.

    " Submit job
    IF gv_counter >= i_grp_sz.
      PERFORM submit_job USING lv_uzeit lv_tabix gt_rsparam.
      PERFORM clear_counter.
    ENDIF.

  ENDLOOP.

  " Submit remaining jobs
  IF gt_rsparam IS NOT INITIAL.
    PERFORM submit_job USING lv_uzeit lv_tabix gt_rsparam.
    PERFORM clear_counter.
  ENDIF.

  WRITE: 'Done'.


*&---------------------------------------------------------------------*
*&      Form  clear_counter
*&---------------------------------------------------------------------*
*       Clear Counter.
*----------------------------------------------------------------------*
FORM clear_counter.

  gv_counter = 0.
  CLEAR gt_rsparam.

ENDFORM.                    "clear_counter


*&---------------------------------------------------------------------*
*&      Form  submit_job
*&---------------------------------------------------------------------*
*       Submit background job.
*----------------------------------------------------------------------*
FORM submit_job
  USING uzeit   TYPE sy-uzeit
        tabix   TYPE sy-tabix
        rspar   TYPE rsparams_tt.

  DATA: lv_tabix_s    TYPE char16,
        lv_line       TYPE i,
        lv_line_s     TYPE string,
        lv_job_name   TYPE btcjob,
        lv_job_count  TYPE btcjobcnt.

  WAIT UP TO 10 SECONDS.

  DESCRIBE TABLE rspar LINES lv_line.
  MOVE lv_line TO lv_line_s.

  tabix = tabix - lv_line + 1.
  MOVE tabix TO lv_tabix_s.
  CONDENSE lv_tabix_s.
  UNPACK lv_tabix_s TO lv_tabix_s.    " Add leading zero (0)

  CONCATENATE 'RS' uzeit '_' lv_tabix_s '_' lv_line_s INTO lv_job_name.

  " 1/3 - Job Open
  CALL FUNCTION 'JOB_OPEN'
    EXPORTING
*     DELANFREP              = ' '
*     JOBGROUP               = ' '
      jobname                = lv_job_name
*     SDLSTRTDT              = NO_DATE
*     SDLSTRTTM              = NO_TIME
*     JOBCLASS               =
    IMPORTING
      jobcount               = lv_job_count
*   CHANGING
*     RET                    =
    EXCEPTIONS
      cant_create_job        = 1
      invalid_job_data       = 2
      jobname_missing        = 3
      OTHERS                 = 4.
  IF sy-subrc <> 0.
    MESSAGE ID sy-msgid TYPE sy-msgty NUMBER sy-msgno
            WITH sy-msgv1 sy-msgv2 sy-msgv3 sy-msgv4.
  ENDIF.

  " 2/3 - Submit program
  CLEAR gs_rsparam.
  gs_rsparam-selname = 'I_MIN_LN'.
  gs_rsparam-kind    = 'P'.
  gs_rsparam-sign    = 'I'.
  gs_rsparam-option  = 'EQ'.
  gs_rsparam-low     = i_min_ln.
  APPEND gs_rsparam TO rspar.

  SUBMIT yreposrc_generate_job
          WITH SELECTION-TABLE rspar
          VIA JOB lv_job_name
          NUMBER lv_job_count
          AND RETURN.

  " 3/3 - Job Close
  CALL FUNCTION 'JOB_CLOSE'
    EXPORTING
*     AT_OPMODE                         = ' '
*     AT_OPMODE_PERIODIC                = ' '
*     CALENDAR_ID                       = ' '
*     EVENT_ID                          = ' '
*     EVENT_PARAM                       = ' '
*     EVENT_PERIODIC                    = ' '
      jobcount                          = lv_job_count
      jobname                           = lv_job_name
*     LASTSTRTDT                        = NO_DATE
*     LASTSTRTTM                        = NO_TIME
*     PRDDAYS                           = 0
*     PRDHOURS                          = 0
*     PRDMINS                           = 0
*     PRDMONTHS                         = 0
*     PRDWEEKS                          = 0
*     PREDJOB_CHECKSTAT                 = ' '
*     PRED_JOBCOUNT                     = ' '
*     PRED_JOBNAME                      = ' '
*     SDLSTRTDT                         = NO_DATE
*     SDLSTRTTM                         = NO_TIME
*     STARTDATE_RESTRICTION             = BTC_PROCESS_ALWAYS
      strtimmed                         = 'X'                       " Job Start Immediately
*     TARGETSYSTEM                      = ' '
*     START_ON_WORKDAY_NOT_BEFORE       = SY-DATUM
*     START_ON_WORKDAY_NR               = 0
*     WORKDAY_COUNT_DIRECTION           = 0
*     RECIPIENT_OBJ                     =
*     TARGETSERVER                      = ' '
*     DONT_RELEASE                      = ' '
*     TARGETGROUP                       = ' '
*     DIRECT_START                      =
*   IMPORTING
*     JOB_WAS_RELEASED                  =
*   CHANGING
*     RET                               =
    EXCEPTIONS
      cant_start_immediate              = 1
      invalid_startdate                 = 2
      jobname_missing                   = 3
      job_close_failed                  = 4
      job_nosteps                       = 5
      job_notex                         = 6
      lock_failed                       = 7
      invalid_target                    = 8
      OTHERS                            = 9.
  IF sy-subrc <> 0.
    MESSAGE ID sy-msgid TYPE sy-msgty NUMBER sy-msgno
            WITH sy-msgv1 sy-msgv2 sy-msgv3 sy-msgv4.
  ENDIF.

ENDFORM.                    "submit_job