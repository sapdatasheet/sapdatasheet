*&---------------------------------------------------------------------*
*& Report  YWUL_JOB
*&
*&---------------------------------------------------------------------*
*& YWUL Background Job
*&---------------------------------------------------------------------*

REPORT ywul_job.

TABLES rsfind.

PARAMETERS     p_otype   TYPE tadir-object OBLIGATORY.    " Object Type
SELECT-OPTIONS p_oname   FOR rsfind-encl_obj OBLIGATORY.  " Object Name
SELECT-OPTIONS p_subobj  FOR rsfind-object.               " Sub-Object name (Optional)
PARAMETERS     p_last    TYPE i OBLIGATORY.               " Last Record Index of current Job

START-OF-SELECTION.

  PERFORM main.

FORM main.
  DATA: lv_count     TYPE i,
        lv_count_sub TYPE i,
        lv_both      TYPE boolean,
        ls_oname     LIKE LINE OF p_oname,
        ls_subobj    LIKE LINE OF p_subobj,
        lv_obj_name  TYPE sobj_name,
        lv_subobj    TYPE eu_cro_obj.
  DATA: lv_count_s TYPE string,
        lv_message TYPE string.

  DESCRIBE TABLE p_oname LINES lv_count.
  DESCRIBE TABLE p_subobj LINES lv_count_sub.
  IF lv_count_sub > 0.
    lv_both = abap_true.
    IF lv_count <> lv_count_sub.
      MESSAGE 'Unmatched P_ONAME and P_SUBOBJ' TYPE 'E'.
      RETURN.
    ENDIF.
  ELSE.
    lv_both = abap_false.
    IF lv_count < 1.
      MESSAGE 'No P_ONAME provided' TYPE 'E'.
      RETURN.
    ENDIF.
  ENDIF.

  " Process one by one
  lv_count = p_last - lv_count.
  LOOP AT p_oname INTO ls_oname.
    READ TABLE p_subobj INTO ls_subobj INDEX sy-tabix.
    lv_count = lv_count + 1.

    CLEAR lv_obj_name.
    MOVE ls_oname-low TO lv_obj_name.
    IF lv_both EQ abap_false.

      " Logging
      MOVE lv_count TO lv_count_s.
      CONCATENATE 'Processing item ' lv_count_s ' (' ls_oname-low ')'
        INTO lv_message RESPECTING BLANKS.
      MESSAGE lv_message TYPE 'I'.

      " Start the Task
      PERFORM check_cpuload.
      CALL FUNCTION 'YWUL_TASK'
        STARTING NEW TASK 'YWUL'
        DESTINATION 'NONE'
        EXPORTING
          iv_obj_type                = p_otype
          iv_obj_name                = lv_obj_name
        EXCEPTIONS
          communication_failure      = 1
          dbsql_sql_error            = 2
          dest_communication_failure = 3
          dest_system_failure        = 4
          internal_failure           = 5
          no_update_authority        = 6
          resource_failure           = 7
          system_failure             = 8
          timeout                    = 9
          update_failure             = 10
          OTHERS                     = 20.
      IF sy-subrc <> 0.
        MOVE sy-subrc TO lv_count_s.
        CONCATENATE 'ERROR ====> Call RFC failed with SY-SUBRC:' lv_count_s
          INTO lv_message RESPECTING BLANKS.
        MESSAGE lv_message TYPE 'I'.
      ENDIF.

    ELSEIF lv_both EQ abap_true.

      " Logging
      MOVE lv_count TO lv_count_s.
      CONCATENATE 'Processing item: ' lv_count_s ' (' ls_oname-low '-' ls_subobj-low ')'
        INTO lv_message.
      MESSAGE lv_message TYPE 'I'.

      " Start the Task
      " PERFORM check_cpuload.
      CLEAR lv_subobj.
      MOVE ls_subobj-low TO lv_subobj.
      CALL FUNCTION 'YWUL_TASK'
        STARTING NEW TASK 'YWUL'
        DESTINATION 'NONE'
        EXPORTING
          iv_obj_type                = p_otype
          iv_obj_name                = lv_obj_name
          iv_subobj                  = lv_subobj
        EXCEPTIONS
          communication_failure      = 1
          dbsql_sql_error            = 2
          dest_communication_failure = 3
          dest_system_failure        = 4
          internal_failure           = 5
          no_update_authority        = 6
          resource_failure           = 7
          system_failure             = 8
          timeout                    = 9
          update_failure             = 10
          OTHERS                     = 20.
      IF sy-subrc <> 0.
        MOVE sy-subrc TO lv_count_s.
        CONCATENATE 'ERROR ====> Call RFC failed with SY-SUBRC:' lv_count_s
          INTO lv_message RESPECTING BLANKS.
        MESSAGE lv_message TYPE 'I'.
      ENDIF.

    ENDIF.
  ENDLOOP.

  MESSAGE 'Done' TYPE 'I'.
ENDFORM.


FORM check_cpuload.

  DATA: lt_cpu_all TYPE STANDARD TABLE OF cpu_all,
        ls_cpu_all TYPE cpu_all,
        lv_count   TYPE i,
        lv_load    TYPE i,
        lv_load_s  TYPE string.
  DATA: lv_subrc_s TYPE string,
        lv_message TYPE string.

  DO.
    CLEAR lt_cpu_all.
    CALL FUNCTION 'GET_CPU_ALL'
      EXPORTING
        local_remote                   = 'LOCAL'
      TABLES
        tf_cpu_all                     = lt_cpu_all
      EXCEPTIONS
        internal_error_adress_failed   = 1
        internal_error_different_field = 2
        internal_error_no_new_line     = 3
        collector_not_running          = 4
        shared_memory_not_available    = 5
        collector_busy                 = 6
        version_conflict               = 7
        no_network_collector_running   = 8
        system_failure                 = 9
        communication_failure          = 10
        OTHERS                         = 11.
    IF sy-subrc NE 0.
      MOVE sy-subrc TO lv_subrc_s.
      CONCATENATE 'ERROR ====> Call Function GET_CPU_ALL failed with SY-SUBRC: ' lv_subrc_s
        INTO lv_message RESPECTING BLANKS.
      MESSAGE lv_message TYPE 'I'.
    ENDIF.

    DESCRIBE TABLE lt_cpu_all LINES lv_count.
    IF lv_count EQ 1.
      READ TABLE lt_cpu_all INTO ls_cpu_all INDEX 1.
      " Calculate average load in the past 1 min and past 5 min
      lv_load = ( ls_cpu_all-load1_avg + ls_cpu_all-load5_avg ) / 2.
      IF lv_load > 340.
        MOVE lv_load to lv_load_s.
        CONCATENATE 'Zzz zzz -> Wait for a while because CPU is busy. load = ' lv_load_s
          INTO lv_message RESPECTING BLANKS.
        MESSAGE lv_message TYPE 'I'.
        WAIT UP TO 2 SECONDS.
      ELSE.
        MOVE lv_load to lv_load_s.
        CONCATENATE 'CPU is not busy, EXIT. load = ' lv_load_s
          INTO lv_message RESPECTING BLANKS.
        MESSAGE lv_message TYPE 'I'.
        EXIT.  " End Loop
      ENDIF.
    ELSE.
      MESSAGE 'ERROR ====> Function GET_CPU_ALL returns no data, EXIT' TYPE 'I'.
      EXIT. " Exit the log to avoid end-less log
    ENDIF.
  ENDDO.

ENDFORM.