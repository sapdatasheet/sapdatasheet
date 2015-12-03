*&---------------------------------------------------------------------*
*& Report  YWUL_JOB
*&
*&---------------------------------------------------------------------*
*& YWUL Background Job
*&---------------------------------------------------------------------*

REPORT ywul_job.

TABLES akb_relobjs.

PARAMETERS     p_otype  TYPE tadir-object.
SELECT-OPTIONS p_oname   FOR akb_relobjs-obj_name OBLIGATORY.
PARAMETERS     p_last   TYPE i.

START-OF-SELECTION.

  PERFORM main.

FORM main.
  DATA: ls_oname LIKE LINE OF p_oname,
        lv_oname TYPE sobj_name,
        lv_count TYPE i.

  DESCRIBE TABLE p_oname LINES lv_count.
  lv_count = p_last - lv_count.

  LOOP AT p_oname INTO ls_oname.
    MOVE ls_oname-low TO lv_oname.
    PERFORM wul USING lv_count p_otype lv_oname.
    lv_count = lv_count + 1.
  ENDLOOP.

  MESSAGE 'Done' TYPE 'I'.
ENDFORM.


FORM wul
  USING
    i_tabix TYPE sy-tabix
    i_otype TYPE trobjtype
    i_oname TYPE sobj_name.

  DATA: lt_refer TYPE akb_except_type,
        ls_refer TYPE LINE OF akb_except_type,
        lv_count TYPE i,
        ls_db    TYPE ywul,
        lt_db    TYPE STANDARD TABLE OF ywul.
  DATA: lv_tabix_s TYPE string,
        lv_count_s TYPE string,
        lv_message TYPE string.

  CONDENSE i_oname.
  IF i_oname IS INITIAL.
    RETURN.
  ENDIF.

  sy-rtitl = i_oname.                       " For ST22 Dump
  CALL FUNCTION 'AKB_WHERE_USED_LIST'
    EXPORTING
      obj_type   = i_otype
      obj_name   = i_oname
    IMPORTING
      references = lt_refer.
  DESCRIBE TABLE lt_refer LINES lv_count.
  IF lv_count > 0.
    " Prepare Data
    CLEAR: lt_db.
    LOOP AT lt_refer INTO ls_refer.
      ls_db-seq = sy-tabix.
      ls_db-src_obj_type = i_otype.
      ls_db-src_obj_name = i_oname.
      MOVE-CORRESPONDING ls_refer TO ls_db.
      APPEND ls_db TO lt_db.
    ENDLOOP.

    " Save to DB
    INSERT ywul FROM TABLE lt_db ACCEPTING DUPLICATE KEYS.
    COMMIT WORK.

    FREE lt_refer.
    FREE lt_db.
  ENDIF.

  " Job Log - One log item for each 100 records
  IF i_tabix MOD 100 EQ 0.
    MOVE i_tabix TO lv_tabix_s.
    MOVE lv_count TO lv_count_s.
    CONCATENATE 'Item ' lv_tabix_s ' (' i_oname ') saved to db ' lv_count_s ' records'
      INTO lv_message RESPECTING BLANKS.
    MESSAGE lv_message TYPE 'I'.
  ENDIF.

ENDFORM.