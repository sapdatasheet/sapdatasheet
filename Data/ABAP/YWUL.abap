*&---------------------------------------------------------------------*
*& Report  YWUL
*&
*&---------------------------------------------------------------------*
*& Generate Where-Used-List data.
*&---------------------------------------------------------------------*

REPORT ywul.

TYPES: BEGIN OF ts_item,
         eobj TYPE ycrossref-encl_objec,
         obj  TYPE ycrossref-object,
       END OF ts_item,
       tt_list TYPE STANDARD TABLE OF ts_item.
CONSTANTS: c_otype_all       TYPE tadir-object VALUE 'ALL'.
CONSTANTS: c_jobname_prefix  TYPE string VALUE 'YWUL_'.

* Selection Parameters
PARAMETERS p_otype   TYPE tadir-object OBLIGATORY DEFAULT c_otype_all.    " Object Type
PARAMETERS p_maxjob  TYPE i DEFAULT 2.                                    " Max Job Count
PARAMETERS p_batchn  TYPE i DEFAULT 2000.                                 " Default Batch Size

START-OF-SELECTION.

  PERFORM main.

FORM main.
  DATA: lt_list     TYPE fdt_tab_sobj_name,
        lt_list2    TYPE tt_list,
        lv_fullname TYPE string.
  DATA: lv_message  TYPE string.

  IF p_otype EQ 'DOMA' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT domname FROM dd01l INTO TABLE lt_list.
    lv_fullname = 'DOMA (Domain) loaded records '.
    PERFORM wul_jobs USING  'DOMA' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'DTEL' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT rollname FROM dd04l INTO TABLE lt_list.
    lv_fullname = 'DTEL (Data Element) loaded records'.
    PERFORM wul_jobs USING  'DTEL' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'TABL' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT tabname FROM dd02l INTO TABLE lt_list.
    lv_fullname = 'TABL (Transparent/Cluster/Pooled/etc Table) loaded records'.
    PERFORM wul_jobs USING  'TABL' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'SQLT' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT sqltab FROM dd06l INTO TABLE lt_list.
    lv_fullname = 'SQLT (Table Cluster/Pool) loaded records '.
    PERFORM wul_jobs USING  'SQLT' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'VIEW' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT viewname FROM dd25l INTO TABLE lt_list WHERE aggtype = 'V'.
    lv_fullname = 'VIEW (View) loaded records '.
    PERFORM wul_jobs USING  'VIEW' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'SHLP' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT shlpname FROM dd30l INTO TABLE lt_list.
    lv_fullname = 'SHLP (Search Help) loaded records '.
    PERFORM wul_jobs USING  'SHLP' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'INTF' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT clsname FROM seoclass INTO TABLE lt_list WHERE clstype = 1.
    lv_fullname = 'INTF (ABAP OO Interface) loaded records '.
    PERFORM wul_jobs USING  'INTF' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'CLAS' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT clsname FROM seoclass INTO TABLE lt_list WHERE clstype = 0.
    lv_fullname = 'CLAS (ABAP OO Class) loaded records '.
    PERFORM wul_jobs USING  'CLAS' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'FUNC' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT funcname FROM tfdir INTO TABLE lt_list.
    lv_fullname = 'FUNC (Function Group) loaded records '.
    PERFORM wul_jobs USING  'FUNC' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'PROG' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT obj_name FROM tadir INTO TABLE lt_list
      WHERE pgmid = 'R3TR' AND object = 'PROG'.
    lv_fullname = 'PROG (Program) loaded records '.
    PERFORM wul_jobs USING  'PROG' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'TRAN' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT tcode FROM tstc INTO TABLE lt_list.
    lv_fullname = 'TRAN (Transaction Codes) loaded records '.
    PERFORM wul_jobs USING  'TRAN' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'MSAG' OR p_otype EQ c_otype_all.
    CLEAR lt_list.
    SELECT arbgb FROM t100a INTO TABLE lt_list.
    lv_fullname = 'MSAG (Message Class) loaded records '.
    PERFORM wul_jobs USING  'MSAG' lv_fullname lt_list p_batchn.
  ENDIF.

  IF p_otype EQ 'OM' OR p_otype EQ c_otype_all.
    CLEAR lt_list2.
    SELECT clsname AS eobj cmpname AS obj
      FROM seocompo
      INTO CORRESPONDING FIELDS OF TABLE lt_list2
      WHERE cmptype = 1.
    lv_fullname = 'Class Method (SEOCOMPO) loaded records'.
    PERFORM wul_jobs2 USING  'OM' lv_fullname lt_list2 p_batchn.
  ENDIF.

  IF p_otype EQ 'NN' OR p_otype EQ c_otype_all.
    CLEAR lt_list2.
    SELECT arbgb AS eobj msgnr AS obj
      FROM t100
      INTO CORRESPONDING FIELDS OF TABLE lt_list2
      WHERE sprsl = 'E'.
    lv_fullname = 'Message Number (T100) loaded records'.
    PERFORM wul_jobs2 USING  'NN' lv_fullname lt_list2 p_batchn.
  ENDIF.

  IF p_otype EQ 'DTF' OR p_otype EQ c_otype_all.
    CLEAR lt_list2.
    SELECT tabname AS eobj fieldname AS obj
      FROM dd03l
      INTO CORRESPONDING FIELDS OF TABLE lt_list2
      WHERE fieldname NOT LIKE '.%'.
    lv_fullname = 'Table Field (DD03L) loaded records'.
    PERFORM wul_jobs2 USING  'DTF' lv_fullname lt_list2 p_batchn.
  ENDIF.

* Logging
  CONCATENATE 'Processing done for the object type ' p_otype
    INTO lv_message RESPECTING BLANKS.
  MESSAGE lv_message TYPE 'I'.
ENDFORM.


FORM wul_jobs
  USING
    iv_otype   TYPE tadir-object
    iv_prefix  TYPE string
    it_list    TYPE fdt_tab_sobj_name
    iv_batch   TYPE i.

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
    IF lv_counter >= iv_batch.
      PERFORM submit_job USING iv_otype lt_rsparam lv_index.
      CLEAR lt_rsparam.
    ENDIF.
  ENDLOOP.

  " Submit for the last portion
  DESCRIBE TABLE lt_rsparam LINES lv_counter.
  IF lv_counter > 0.
    PERFORM submit_job USING iv_otype lt_rsparam lv_index.
    CLEAR lt_rsparam.
  ENDIF.

  CONCATENATE 'Submit job(s) finished for the object type ' iv_otype
    INTO lv_message RESPECTING BLANKS.
  MESSAGE lv_message TYPE 'I'.

ENDFORM.


FORM wul_jobs2
  USING
    iv_otype   TYPE tadir-object
    iv_prefix  TYPE string
    it_list    TYPE tt_list
    iv_batch   TYPE i.

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
  DATA: ls_item    TYPE ts_item,
        lv_index   TYPE i,
        lv_counter TYPE i.
  DATA: ls_param_eobj TYPE LINE OF rsparams_tt,
        ls_param_obj  TYPE LINE OF rsparams_tt,
        lt_rsparam    TYPE rsparams_tt.

  lv_index = 0.
  LOOP AT it_list INTO ls_item.
    lv_index = lv_index + 1.

*   Skip the Empty Items
    CONDENSE ls_item-eobj.
    CONDENSE ls_item-obj.
    IF ls_item-eobj IS INITIAL OR ls_item-obj IS INITIAL.
      CONTINUE.
    ENDIF.

    " Prepare Paramters
    CLEAR ls_param_eobj.
    ls_param_eobj-selname = 'P_ONAME'.
    ls_param_eobj-kind    = 'S'.
    ls_param_eobj-sign    = 'I'.
    ls_param_eobj-option  = 'EQ'.
    ls_param_eobj-low     = ls_item-eobj.
    APPEND ls_param_eobj TO lt_rsparam.

    CLEAR ls_param_obj.
    ls_param_obj-selname = 'P_SUBOBJ'.
    ls_param_obj-kind    = 'S'.
    ls_param_obj-sign    = 'I'.
    ls_param_obj-option  = 'EQ'.
    ls_param_obj-low     = ls_item-obj.
    APPEND ls_param_obj TO lt_rsparam.

    " Submit job
    DESCRIBE TABLE lt_rsparam LINES lv_counter.
    lv_counter = lv_counter / 2.
    IF lv_counter >= iv_batch.
      PERFORM submit_job USING iv_otype lt_rsparam lv_index.
      CLEAR lt_rsparam.
    ENDIF.
  ENDLOOP.

  " Submit for the last portion
  DESCRIBE TABLE lt_rsparam LINES lv_counter.
  IF lv_counter > 0.
    PERFORM submit_job USING iv_otype lt_rsparam lv_index.
    CLEAR lt_rsparam.
  ENDIF.
ENDFORM.


FORM submit_job
  USING iv_otype TYPE tadir-object
        it_list  TYPE rsparams_tt
        iv_last  TYPE i.

  DATA: lv_active_cnt TYPE i,
        ls_rsparam    TYPE LINE OF rsparams_tt.
  DATA: lv_last_s    TYPE char12,
        lv_job_name  TYPE btcjob,
        lv_job_count TYPE btcjobcnt.

* Wait until there is not Much Jobs
  CONCATENATE c_jobname_prefix '%' INTO lv_job_name.
  DO.
    SELECT COUNT( * ) INTO lv_active_cnt
      FROM tbtco
      WHERE status = 'R'
        AND jobname LIKE lv_job_name.
    IF lv_active_cnt  >= p_maxjob .
      WAIT UP TO 1 SECONDS.
*     WAIT UP TO '0.01' SECONDS.
    ELSE.
      EXIT.  " Exit the DO loop
    ENDIF.
  ENDDO.

* Format Job Name
  MOVE iv_last TO lv_last_s.
  CONDENSE lv_last_s.
  UNPACK lv_last_s TO lv_last_s.       " Add leading zero (0)
  CONCATENATE c_jobname_prefix iv_otype '_' lv_last_s INTO lv_job_name.

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
  ls_rsparam-low     = iv_otype.
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