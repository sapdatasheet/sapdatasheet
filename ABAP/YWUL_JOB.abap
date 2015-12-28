*&---------------------------------------------------------------------*
*& Report  YWUL_JOB
*&
*&---------------------------------------------------------------------*
*& YWUL Background Job
*&---------------------------------------------------------------------*

REPORT ywul_job.

TABLES RSFIND.

PARAMETERS     p_otype   TYPE tadir-object OBLIGATORY.    " Object Type
SELECT-OPTIONS p_oname   FOR RSFIND-encl_obj OBLIGATORY.  " Object Name
SELECT-OPTIONS p_subobj  FOR RSFIND-object.               " Sub-Object name (Optional)
PARAMETERS     p_last    TYPE i OBLIGATORY.               " Last Record Index of current Job

START-OF-SELECTION.

  PERFORM main.

FORM main.
  DATA: ls_oname LIKE LINE OF p_oname,
        lv_oname TYPE sobj_name,
        lv_count TYPE i.
  DATA: lv_count_s TYPE string,
        lv_message TYPE string.

  DESCRIBE TABLE p_oname LINES lv_count.
  lv_count = p_last - lv_count.

  LOOP AT p_oname INTO ls_oname.
    lv_count = lv_count + 1.
    MOVE ls_oname-low TO lv_oname.

    " Logging
    MOVE lv_count TO lv_count_s.
    CONCATENATE 'Processing item ' lv_count_s ' (' lv_oname ')'
      INTO lv_message RESPECTING BLANKS.
    MESSAGE lv_message TYPE 'I'.

    " Start the Task
    CALL FUNCTION 'YWUL_TASK'
      STARTING NEW TASK 'YWUL'
      DESTINATION 'NONE'
      EXPORTING
        iv_obj_type = p_otype
        iv_obj_name = lv_oname.
    IF sy-subrc <> 0.
      CLEAR lv_count_s.
      MOVE sy-subrc TO lv_count_s.
      CONCATENATE '====> Call RFC failed with SY-SUBRC:' lv_count_s
        INTO lv_message RESPECTING BLANKS.
      MESSAGE lv_message TYPE 'I'.
    ENDIF.
  ENDLOOP.

  MESSAGE 'Done' TYPE 'I'.
ENDFORM.