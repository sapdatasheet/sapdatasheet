*&---------------------------------------------------------------------*
*& Report  YCROSSREF_JOB
*&
*&---------------------------------------------------------------------*
*& YCROSSREF Background Job
*&---------------------------------------------------------------------*

REPORT ycrossref_job.

PARAMETERS  p_ocls  TYPE seu_obj DEFAULT 'NN' OBLIGATORY.  " Object Class
PARAMETERS  p_eobj  TYPE ycrossref-encl_objec OBLIGATORY.  " Enclosing Object Name
PARAMETERS  p_obj   TYPE ycrossref-object OBLIGATORY.      " Object Name
PARAMETERS  p_idx   TYPE i OBLIGATORY.                     " Record Index
PARAMETERS  p_src   TYPE xflag DEFAULT ' '.                " Load Source Code lines or Not

START-OF-SELECTION.

  PERFORM main.

FORM main.
  DATA: ls_find    TYPE rsfind.

  " Check Parameters
  CONDENSE p_eobj.
  CONDENSE p_obj.
  IF p_eobj IS INITIAL OR p_obj IS INITIAL.
    RETURN.
  ENDIF.

  CLEAR ls_find.
  ls_find-encl_obj = p_eobj.
  ls_find-object = p_obj.
  PERFORM crossref USING ls_find.

  MESSAGE 'Done' TYPE 'I'.
ENDFORM.

FORM crossref
  USING
    is_find   TYPE rsfind.

  DATA: lt_find  TYPE STANDARD TABLE OF rsfind,
        lt_found TYPE STANDARD TABLE OF rsfindlst,
        ls_found TYPE rsfindlst,
        lv_count TYPE i,
        lt_db    TYPE STANDARD TABLE OF ycrossref,
        ls_db    TYPE ycrossref.
  DATA: lv_subrc_s TYPE string,
        lv_count_s TYPE string,
        lv_index_s TYPE string,
        lv_message TYPE string.

  CONDENSE is_find-object.
  CONDENSE is_find-encl_obj.
  IF is_find-encl_obj IS INITIAL OR is_find-object IS INITIAL.
    RETURN.
  ENDIF.

  MOVE p_idx TO lv_index_s.

  CLEAR lt_find.
  APPEND is_find TO lt_find.
  CALL FUNCTION 'RS_EU_CROSSREF'
    EXPORTING
      i_find_obj_cls           = p_ocls
      no_dialog                = 'X'
*     expand_source_in_online_mode = p_src    " Load the Source Code Line Number
    TABLES
      i_findstrings            = lt_find
      o_founds                 = lt_found
    EXCEPTIONS
      not_executed             = 1
      not_found                = 2
      illegal_object           = 3
      no_cross_for_this_object = 4
      batch                    = 5
      batchjob_error           = 6
      wrong_type               = 7
      object_not_exist         = 8
      OTHERS                   = 9.
  IF sy-subrc <> 0.
    MOVE sy-subrc TO lv_subrc_s.
    CONCATENATE 'Item ' lv_index_s ' (' is_find-encl_obj ', ' is_find-object '): '
      'Exception code '  lv_subrc_s
      INTO lv_message.
    MESSAGE lv_message TYPE 'I'.
    sy-msgty = 'I'.                   " Avoid Job Terminate due to one item
    RETURN.
  ENDIF.

  DESCRIBE TABLE lt_found LINES lv_count.
  IF lv_count > 0.
    " Prepare Data
    LOOP AT lt_found INTO ls_found.
      ls_db-seq = sy-tabix.
      ls_db-src_otype = p_ocls.
      ls_db-src_object  = is_find-object.
      ls_db-src_encl_obj = is_find-encl_obj.
      MOVE-CORRESPONDING ls_found TO ls_db.
      MOVE ls_found-program TO ls_db-program_2.
      MOVE ls_found-compress TO ls_db-compress_2 .
      MOVE ls_found-last TO ls_db-last_2.
      APPEND ls_db TO lt_db.
    ENDLOOP.

    CALL FUNCTION 'YCROSSREF_INSERTDB' IN UPDATE TASK
      TABLES
        it_data = lt_db.
    COMMIT WORK.

    FREE lt_found.
    FREE lt_db.
  ENDIF.

  " Job Log - One log item for each 100 records
  MOVE lv_count TO lv_count_s.
  CONCATENATE 'Item ' lv_index_s
    ' (' is_find-encl_obj ', ' is_find-object ') processed, '
    lv_count_s ' Records saved'
    INTO lv_message.
  MESSAGE lv_message TYPE 'I'.

ENDFORM.