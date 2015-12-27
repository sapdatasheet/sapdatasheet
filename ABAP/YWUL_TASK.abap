FUNCTION YWUL_TASK.
*"----------------------------------------------------------------------
*"*"Local Interface:
*"  IMPORTING
*"     VALUE(IV_OTYPE) TYPE  TROBJTYPE
*"     VALUE(IV_ONAME) TYPE  SOBJ_NAME
*"     VALUE(IV_SUBNAME) TYPE  SOBJ_NAME OPTIONAL
*"----------------------------------------------------------------------

  DATA: lt_refer TYPE akb_except_type,
        ls_refer TYPE LINE OF akb_except_type,
        lv_count TYPE i,
        ls_db    TYPE ywul,
        lt_db    TYPE STANDARD TABLE OF ywul.

  CONDENSE iv_oname.
  IF iv_oname IS INITIAL.
    RETURN.
  ENDIF.

  sy-rtitl = iv_oname.                       " For ST22 Dump
  CALL FUNCTION 'YAKB_WHERE_USED_LIST'
    EXPORTING
      obj_type   = iv_otype
      obj_name   = iv_oname
    IMPORTING
      references = lt_refer.
  DESCRIBE TABLE lt_refer LINES lv_count.
  IF lv_count > 0.
    " Prepare Data
    CLEAR: lt_db.
    SORT lt_refer BY obj_type obj_name.
    LOOP AT lt_refer INTO ls_refer.
      ls_db-seq = sy-tabix.
      ls_db-src_obj_type = iv_otype.
      ls_db-src_obj_name = iv_oname.
      MOVE-CORRESPONDING ls_refer TO ls_db.
      APPEND ls_db TO lt_db.
    ENDLOOP.

    " Save to DB
    INSERT ywul FROM TABLE lt_db ACCEPTING DUPLICATE KEYS.
    COMMIT WORK.

    FREE lt_refer.
    FREE lt_db.
  ENDIF.

ENDFUNCTION.