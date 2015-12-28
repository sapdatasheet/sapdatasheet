*&---------------------------------------------------------------------*
*& Report  YWUL
*&
*&---------------------------------------------------------------------*
*& Generate Where-Used-List data.
*&---------------------------------------------------------------------*

REPORT ywul.

PARAMETERS p_otype   TYPE tadir-object.        " Object Type
PARAMETERS p_maxjob  TYPE i DEFAULT 2.         " Max Job Count
PARAMETERS p_batch   TYPE i DEFAULT 10000.     " Batch Size

START-OF-SELECTION.

  PERFORM main.

FORM main.
  DATA: lt_list     TYPE fdt_tab_sobj_name,
        lv_fullname TYPE string.

  CASE p_otype.
    WHEN 'DOMA'.
      lv_fullname = 'DOMA (Domain) loaded records '.
      SELECT domname FROM dd01l INTO TABLE lt_list.
    WHEN 'DTEL'.
      lv_fullname = 'DTEL (Data Element) loaded records'.
      SELECT rollname FROM dd04l INTO TABLE lt_list.
    WHEN 'TABL'.
      lv_fullname = 'TABL (Transparent/Cluster/Pooled/etc Table) loaded records'.
      SELECT tabname FROM dd02l INTO TABLE lt_list.
    WHEN 'SQLT'.
      lv_fullname = 'SQLT (Table Cluster/Pool) loaded records '.
      SELECT sqltab FROM dd06l INTO TABLE lt_list.
    WHEN 'VIEW'.
      lv_fullname = 'VIEW (View) loaded records '.
      SELECT viewname FROM dd25l INTO TABLE lt_list WHERE aggtype = 'V'.
    WHEN 'SHLP'.
      lv_fullname = 'SHLP (Search Help) loaded records '.
      SELECT shlpname FROM dd30l INTO TABLE lt_list.
    WHEN 'INTF'.
      lv_fullname = 'INTF (ABAP OO Interface) loaded records '.
      SELECT clsname FROM seoclass INTO TABLE lt_list WHERE clstype = 1.
    WHEN 'CLAS'.
      lv_fullname = 'CLAS (ABAP OO Class) loaded records '.
      SELECT clsname FROM seoclass INTO TABLE lt_list WHERE clstype = 0.
    WHEN 'FUNC'.
      lv_fullname = 'FUNC (Function Group) loaded records '.
      SELECT funcname FROM tfdir INTO TABLE lt_list.
    WHEN 'PROG'.
      lv_fullname = 'PROG (Program) loaded records '.
      SELECT obj_name FROM tadir INTO TABLE lt_list
        WHERE pgmid = 'R3TR' AND object = 'PROG'.
    WHEN 'TRAN'.
      lv_fullname = 'TRAN (Transaction Codes) loaded records '.
      SELECT tcode FROM tstc INTO TABLE lt_list.
    WHEN 'MSAG'.
      lv_fullname = 'MSAG (Message Class) loaded records '.
      SELECT arbgb FROM t100a INTO TABLE lt_list.
    WHEN OTHERS.
      MESSAGE 'The object type is not supported' TYPE 'I'.
      MESSAGE p_otype TYPE 'I'.
      RETURN.
  ENDCASE.

  PERFORM wul_jobs USING lv_fullname lt_list.
  MESSAGE 'Done' TYPE 'I'.
ENDFORM.

FORM wul_jobs
  USING
    iv_prefix  TYPE string
    it_list    TYPE fdt_tab_sobj_name.

* Logging
  DATA: lv_lines   TYPE i,
        lv_lines_s TYPE string,
        lv_message TYPE string.

  DESCRIBE TABLE it_list LINES lv_lines.
  MOVE lv_lines TO lv_lines_s.
  CONCATENATE iv_prefix ' ' lv_lines_s
    INTO lv_message RESPECTING BLANKS.
  MESSAGE lv_message TYPE 'I'.

* Process
  DATA: lv_item    TYPE LINE OF fdt_tab_sobj_name,
        lv_index   TYPE i,
        lv_counter TYPE i.
  DATA: lt_rsparam TYPE rsparams_tt,
        ls_rsparam TYPE LINE OF rsparams_tt.

  lv_index = 0.
  LOOP AT it_list INTO lv_item.
    lv_index = lv_index + 1.

*   Skip the Empty Items
    CONDENSE lv_item.
    IF lv_item IS INITIAL.
      CONTINUE.
    ENDIF.

    " Prepare Paramters
    CLEAR ls_rsparam.
    ls_rsparam-selname = 'P_ONAME'.
    ls_rsparam-kind    = 'S'.
    ls_rsparam-sign    = 'I'.
    ls_rsparam-option  = 'EQ'.
    ls_rsparam-low     = lv_item.
    APPEND ls_rsparam TO lt_rsparam.

    " Submit job
    DESCRIBE TABLE lt_rsparam LINES lv_counter.
    IF lv_counter >= p_batch.
      PERFORM submit_job USING lt_rsparam lv_index.
      CLEAR lt_rsparam.
    ENDIF.
  ENDLOOP.

  " Submit for the last portion
  DESCRIBE TABLE lt_rsparam LINES lv_counter.
  IF lv_counter > 0.
    PERFORM submit_job USING lt_rsparam lv_index.
    CLEAR lt_rsparam.
  ENDIF.
ENDFORM.

FORM submit_job
  USING it_list  TYPE rsparams_tt
        iv_last  TYPE i.

  DATA: lv_active_cnt TYPE i,
        ls_rsparam    TYPE LINE OF rsparams_tt.
  DATA: lv_last_s    TYPE char12,
        lv_job_name  TYPE btcjob,
        lv_job_count TYPE btcjobcnt.

* Wait until there is not Much Jobs
  lv_active_cnt = p_maxjob + 1.      " Make sure come to WHILE loop
  WHILE lv_active_cnt >= p_maxjob.
    WAIT UP TO 2 SECONDS.
    SELECT COUNT( * ) INTO lv_active_cnt
      FROM tbtco
      WHERE status = 'R'
        AND jobname LIKE 'YWUL_%'.
  ENDWHILE.

* Format Job Name
  MOVE iv_last TO lv_last_s.
  CONDENSE lv_last_s.
  UNPACK lv_last_s TO lv_last_s.       " Add leading zero (0)
  CONCATENATE 'YWUL_' p_otype '_' lv_last_s INTO lv_job_name.

  MESSAGE lv_job_name TYPE 'I'.

* Add Paratmer
  CLEAR ls_rsparam.
  ls_rsparam-selname = 'P_LAST'.
  ls_rsparam-kind    = 'P'.
  ls_rsparam-sign    = 'I'.
  ls_rsparam-option  = 'EQ'.
  ls_rsparam-low     = iv_last.
  APPEND ls_rsparam TO it_list.

  CLEAR ls_rsparam.
  ls_rsparam-selname = 'P_OTYPE'.
  ls_rsparam-kind    = 'P'.
  ls_rsparam-sign    = 'I'.
  ls_rsparam-option  = 'EQ'.
  ls_rsparam-low     = p_otype.
  APPEND ls_rsparam TO it_list.

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

  SUBMIT ywul_job
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