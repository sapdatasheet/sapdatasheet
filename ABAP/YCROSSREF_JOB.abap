*&---------------------------------------------------------------------*
*& Report  YCROSSREF_JOB
*&
*&---------------------------------------------------------------------*
*& YCROSSREF Background Job
*&---------------------------------------------------------------------*

REPORT ycrossref_job.


TABLES ycrossref.

PARAMETERS     p_ocls  TYPE seu_obj DEFAULT 'NN' OBLIGATORY.  " Object Class
SELECT-OPTIONS p_eobj  FOR ycrossref-encl_objec OBLIGATORY.   " Enclosing Object Name
SELECT-OPTIONS p_obj   FOR ycrossref-object OBLIGATORY.       " Object Name
PARAMETERS     p_last  TYPE i OBLIGATORY.                     " Last Record Index of current Job
PARAMETERS     p_src   TYPE xflag DEFAULT ' '.                " Load Source Code lines or Not
PARAMETERS     p_dbpkg TYPE i DEFAULT 10000 OBLIGATORY.       " Minimal Package Size to trigger Save DB

DATA: gt_db    TYPE STANDARD TABLE OF ycrossref.

START-OF-SELECTION.

  PERFORM main.

FORM main.
  DATA: lv_lines_e TYPE i,
        lv_lines   TYPE i.
  DATA: lv_tabix   TYPE i,
        lv_dbcount TYPE i,
        ls_eobj    LIKE LINE OF p_eobj,
        ls_obj     LIKE LINE OF p_obj,
        ls_find    TYPE rsfind.

  " Check Parameters
  DESCRIBE TABLE p_eobj LINES lv_lines_e.
  DESCRIBE TABLE p_obj LINES lv_lines.
  IF lv_lines_e <> lv_lines.
    RETURN.
  ENDIF.
  IF lv_lines < 1.
    RETURN.
  ENDIF.

* Process one by one
  lv_tabix = p_last - lv_lines.
  LOOP AT p_eobj INTO ls_eobj.
    READ TABLE p_obj INTO ls_obj INDEX sy-tabix.
    CLEAR ls_find.
    ls_find-encl_obj = ls_eobj-low.
    ls_find-object = ls_obj-low.
    lv_tabix = lv_tabix + 1.
    PERFORM crossref USING lv_tabix ls_find.

    DESCRIBE TABLE gt_db LINES lv_dbcount.
    IF lv_dbcount >= p_dbpkg.
      PERFORM save.
    ENDIF.
  ENDLOOP.

  IF gt_db IS NOT INITIAL.
    PERFORM save.
  ENDIF.

  MESSAGE 'Done' TYPE 'I'.
ENDFORM.

FORM crossref
  USING
    iv_tabix  TYPE sy-tabix
    is_find   TYPE rsfind.

  DATA: lt_find  TYPE STANDARD TABLE OF rsfind,
        lt_found TYPE STANDARD TABLE OF rsfindlst,
        ls_found TYPE rsfindlst,
        lv_count TYPE i,
        ls_db    TYPE ycrossref.
  DATA: lv_subrc_s TYPE string,
        lv_tabix_s TYPE string,
        lv_message TYPE string.

  CONDENSE is_find-object.
  CONDENSE is_find-encl_obj.
  IF is_find-encl_obj IS INITIAL OR is_find-object IS INITIAL.
    RETURN.
  ENDIF.

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
    CONCATENATE 'Item ' lv_tabix_s ' (' is_find-encl_obj ', ' is_find-object '): '
      'Exception code '  lv_subrc_s
      INTO lv_message RESPECTING BLANKS.
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
      APPEND ls_db TO gt_db.
    ENDLOOP.
    FREE lt_found.
  ENDIF.

  " Job Log - One log item for each 100 records
  IF iv_tabix MOD 100 EQ 0.
    MOVE iv_tabix TO lv_tabix_s.
    CONCATENATE 'Item ' lv_tabix_s ' (' is_find-encl_obj ', ' is_find-object ') process finished'
      INTO lv_message RESPECTING BLANKS.
    MESSAGE lv_message TYPE 'I'.
  ENDIF.

ENDFORM.

FORM save.
  DATA: lv_dbcnt   TYPE int4,
        lv_dbcnt_s TYPE string,
        lv_log     TYPE string.

  DESCRIBE TABLE gt_db LINES lv_dbcnt.

  CALL FUNCTION 'YCROSSREF_INSERTDB' IN UPDATE TASK
    TABLES
      it_data = gt_db.
  COMMIT WORK.
  CLEAR gt_db.

  " Write Job Log
  MOVE lv_dbcnt TO lv_dbcnt_s.
  CONDENSE lv_dbcnt_s.
  CONCATENATE 'SAVE DATA: Saved to YCROSSREF, record count = ' lv_dbcnt_s INTO lv_log.
  MESSAGE lv_log TYPE 'I'.
ENDFORM.