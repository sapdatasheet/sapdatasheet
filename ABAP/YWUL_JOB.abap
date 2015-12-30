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
        ls_subobj    LIKE LINE OF p_subobj.
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

    IF lv_both EQ abap_false.

      " Logging
      MOVE lv_count TO lv_count_s.
      CONCATENATE 'Processing item ' lv_count_s ' (' ls_oname-low ')'
        INTO lv_message RESPECTING BLANKS.
      MESSAGE lv_message TYPE 'I'.

      " Start the Task
      CALL FUNCTION 'YWUL_TASK'
        STARTING NEW TASK 'YWUL'
        DESTINATION 'NONE'
        EXPORTING
          iv_obj_type = p_otype
          iv_obj_name = ls_oname-low.
      IF sy-subrc <> 0.
        CLEAR lv_count_s.
        MOVE sy-subrc TO lv_count_s.
        CONCATENATE '====> Call RFC failed with SY-SUBRC:' lv_count_s
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
      CALL FUNCTION 'YWUL_TASK'
        STARTING NEW TASK 'YWUL'
        DESTINATION 'NONE'
        EXPORTING
          iv_obj_type = p_otype
          iv_obj_name = ls_oname-low
          iv_subobj   = ls_subobj-low.
      IF sy-subrc <> 0.
        CLEAR lv_count_s.
        MOVE sy-subrc TO lv_count_s.
        CONCATENATE '====> Call RFC failed with SY-SUBRC:' lv_count_s
          INTO lv_message RESPECTING BLANKS.
        MESSAGE lv_message TYPE 'I'.
      ENDIF.

    ENDIF.
  ENDLOOP.

  MESSAGE 'Done' TYPE 'I'.
ENDFORM.