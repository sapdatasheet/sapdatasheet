*&---------------------------------------------------------------------*
*& Report  YCROSSREF
*&
*&---------------------------------------------------------------------*
*& Corss Reference via RS_EU_CROSSREF
*&---------------------------------------------------------------------*

REPORT ycrossref.

PARAMETERS p_ocls   TYPE euobj-id OBLIGATORY.         " Object Class
PARAMETERS p_maxjob  TYPE i DEFAULT 5 OBLIGATORY.     " Max Job Count
PARAMETERS p_src    TYPE xflag DEFAULT ' '.           " Load Source Code lines or Not

TYPES: BEGIN OF ts_item,
         eobj TYPE ycrossref-encl_objec,
         obj  TYPE ycrossref-object,
       END OF ts_item,
       tt_list TYPE STANDARD TABLE OF ts_item.


START-OF-SELECTION.

  PERFORM main.

FORM main.

  DATA: lt_list     TYPE tt_list,
        lv_log_text TYPE string.

  CASE p_ocls.
*   Class/Interface Methods, http://scn.sap.com/thread/701737
    WHEN 'OM'.
      lv_log_text = 'Class/Interface Method (SEOCOMPO) loaded records'.
      SELECT clsname AS eobj cmpname AS obj
        FROM seocompo
        INTO CORRESPONDING FIELDS OF TABLE lt_list
        WHERE cmptype = 1.

*   Message Number
    WHEN 'NN'.
      lv_log_text = 'Message Number (T100) loaded records'.
      SELECT arbgb AS eobj msgnr AS obj
        FROM t100
        INTO CORRESPONDING FIELDS OF TABLE lt_list
        WHERE sprsl = 'E'.

    WHEN OTHERS.
      MESSAGE 'The object type is not supported' TYPE 'I'.
      MESSAGE p_ocls TYPE 'I'.
  ENDCASE.

  PERFORM crossref_jobs USING lv_log_text lt_list.
  MESSAGE 'Done' TYPE 'I'.
ENDFORM.

FORM crossref_jobs
  USING iv_log_text  TYPE string
        it_list      TYPE tt_list.

* Logging
  DATA: lv_lines   TYPE i,
        lv_lines_s TYPE string,
        lv_message TYPE string.

  DESCRIBE TABLE it_list LINES lv_lines.
  MOVE lv_lines TO lv_lines_s.
  CONCATENATE iv_log_text ' ' lv_lines_s
    INTO lv_message RESPECTING BLANKS.
  MESSAGE lv_message TYPE 'I'.

* Process
  DATA: ls_item  TYPE ts_item,
        lv_index TYPE i.
  DATA: lv_active_cnt TYPE i.
  DATA: ls_rsparam TYPE LINE OF rsparams_tt,
        lt_rsparam TYPE rsparams_tt.

  lv_index = 0.
  LOOP AT it_list INTO ls_item.
    lv_index = lv_index + 1.

    IF ls_item-eobj IS INITIAL OR ls_item-obj IS INITIAL.
      CONTINUE.
    ENDIF.

*   Wait until there is not Much Jobs
    IF lv_index MOD 50 EQ 0.
      SELECT COUNT( * ) INTO lv_active_cnt
        FROM tbtco WHERE status = 'R'.
      WHILE lv_active_cnt >= p_maxjob.
        WAIT UP TO 1 SECONDS.
        MESSAGE 'Wait 1 second...' TYPE 'I'.
        SELECT COUNT( * ) INTO lv_active_cnt
          FROM tbtco WHERE status = 'R'.
      ENDWHILE.
    ENDIF.

    " Prepare Paramters
    CLEAR lt_rsparam.
    CLEAR ls_rsparam.
    ls_rsparam-selname = 'P_OCLS'.
    ls_rsparam-kind    = 'P'.
    ls_rsparam-sign    = 'I'.
    ls_rsparam-option  = 'EQ'.
    ls_rsparam-low     = p_ocls.
    APPEND ls_rsparam TO lt_rsparam.

    CLEAR ls_rsparam.
    ls_rsparam-selname = 'P_EOBJ'.
    ls_rsparam-kind    = 'P'.
    ls_rsparam-sign    = 'I'.
    ls_rsparam-option  = 'EQ'.
    ls_rsparam-low     = ls_item-eobj.
    APPEND ls_rsparam TO lt_rsparam.

    CLEAR ls_rsparam.
    ls_rsparam-selname = 'P_OBJ'.
    ls_rsparam-kind    = 'P'.
    ls_rsparam-sign    = 'I'.
    ls_rsparam-option  = 'EQ'.
    ls_rsparam-low     = ls_item-obj.
    APPEND ls_rsparam TO lt_rsparam.

    CLEAR ls_rsparam.
    ls_rsparam-selname = 'P_IDX'.
    ls_rsparam-kind    = 'P'.
    ls_rsparam-sign    = 'I'.
    ls_rsparam-option  = 'EQ'.
    ls_rsparam-low     = lv_index.
    APPEND ls_rsparam TO lt_rsparam.

    CLEAR ls_rsparam.
    ls_rsparam-selname = 'P_SRC'.
    ls_rsparam-kind    = 'P'.
    ls_rsparam-sign    = 'I'.
    ls_rsparam-option  = 'EQ'.
    ls_rsparam-low     = p_src.
    APPEND ls_rsparam TO lt_rsparam.

    " Submit job
    PERFORM submit_job USING lt_rsparam lv_index.
  ENDLOOP.

ENDFORM.


FORM submit_job
  USING it_list  TYPE rsparams_tt
        iv_last  TYPE i.

  DATA: lv_last_s    TYPE char12,
        lv_job_name  TYPE btcjob,
        lv_job_count TYPE btcjobcnt.

* Format Job Name
  MOVE iv_last TO lv_last_s.
  CONDENSE lv_last_s.
  UNPACK lv_last_s TO lv_last_s.       " Add leading zero (0)
  CONCATENATE 'YCROSSREF_' p_ocls '_' lv_last_s INTO lv_job_name.

  MESSAGE lv_job_name TYPE 'I'.

* Submit Job Now
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

  SUBMIT ycrossref_job
          WITH SELECTION-TABLE it_list
          VIA JOB lv_job_name
          NUMBER lv_job_count
          AND RETURN.

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

ENDFORM.