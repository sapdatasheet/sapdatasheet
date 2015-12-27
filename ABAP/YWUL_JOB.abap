*&---------------------------------------------------------------------*
*& Report  YWUL_JOB
*&
*&---------------------------------------------------------------------*
*& YWUL Background Job
*&---------------------------------------------------------------------*

REPORT ywul_job.

TABLES akb_relobjs.

PARAMETERS     p_otype  TYPE tadir-object OBLIGATORY.         " Object Type
SELECT-OPTIONS p_oname  FOR akb_relobjs-obj_name OBLIGATORY.  " Object Name
PARAMETERS     p_last   TYPE i OBLIGATORY.                    " Last Record Index of current Job

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
        iv_otype = p_otype
        iv_oname = lv_oname.
    IF SY-SUBRC <> 0.
      CLEAR LV_COUNT_S.
      MOVE SY-SUBRC TO LV_COUNT_S.
      CONCATENATE '====> Call RFC failed with SY-SUBRC:' lv_count_s
        INTO lv_message RESPECTING BLANKS.
      MESSAGE lv_message TYPE 'I'.
    ENDIF.
  ENDLOOP.

  MESSAGE 'Done' TYPE 'I'.
ENDFORM.