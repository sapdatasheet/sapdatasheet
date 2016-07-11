FUNCTION ywul_task.
*"----------------------------------------------------------------------
*"*"Local Interface:
*"  IMPORTING
*"     VALUE(IV_OBJ_TYPE) TYPE  TROBJTYPE
*"     VALUE(IV_OBJ_NAME) TYPE  SOBJ_NAME
*"     VALUE(IV_SUBOBJ) TYPE  EU_CRO_OBJ OPTIONAL
*"----------------------------------------------------------------------

  DATA: lt_refer  TYPE ywul_tt,
        lv_suuobj TYPE EU_CRO_OBJ,
        lv_count  TYPE i.
  FIELD-SYMBOLS:
        <ls_db>  TYPE LINE OF ywul_tt.

  CONDENSE iv_obj_type.
  CONDENSE iv_obj_name.
  IF iv_obj_type IS INITIAL OR iv_obj_name IS INITIAL.
    RETURN.
  ENDIF.

  sy-title = iv_obj_name.                       " For ST22 Dump
  IF iv_subobj IS SUPPLIED AND iv_subobj IS NOT INITIAL.
    lv_suuobj = iv_subobj.

    CALL FUNCTION 'YAKB_WHERE_USED_LIST'
      EXPORTING
        obj_type   = iv_obj_type
        obj_name   = iv_obj_name
        subobj     = iv_subobj
      IMPORTING
        references = lt_refer.
  ELSE.
    lv_suuobj = space.

    CALL FUNCTION 'YAKB_WHERE_USED_LIST'
      EXPORTING
        obj_type   = iv_obj_type
        obj_name   = iv_obj_name
      IMPORTING
        references = lt_refer.
  ENDIF.

  DESCRIBE TABLE lt_refer LINES lv_count.
  IF lv_count > 0.
    " Prepare Data
    SORT lt_refer BY obj_type obj_name sub_name.
    LOOP AT lt_refer ASSIGNING <ls_db>.
      <ls_db>-seq = sy-tabix.
      <ls_db>-src_obj_type = iv_obj_type.
      <ls_db>-src_obj_name = iv_obj_name.
      <ls_db>-src_subobj = lv_suuobj.
    ENDLOOP.

    " Save to DB
    INSERT ywul FROM TABLE lt_refer ACCEPTING DUPLICATE KEYS.
    COMMIT WORK.

    FREE lt_refer.
  ENDIF.

ENDFUNCTION.