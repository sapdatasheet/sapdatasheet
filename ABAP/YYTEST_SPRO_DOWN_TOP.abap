*&---------------------------------------------------------------------*
*& Report  YYTEST_SPRO_DOWN_TOP
*&
*&---------------------------------------------------------------------*
*&
*&
*&---------------------------------------------------------------------*

REPORT yytest_spro_down_top.

PARAMETERS i_type  TYPE tnodeimgr-ref_type DEFAULT 'COBJ'.
PARAMETERS i_obj   TYPE tnodeimgr-ref_object DEFAULT '/MRSS/V_NW_AVAIL'.

PERFORM main.

FORM main.

  NEW-LINE.
  WRITE 'Start'.
  NEW-LINE.

  DATA: lt_imgr TYPE STANDARD TABLE OF tnodeimgr,
        ls_imgr TYPE tnodeimgr,
        ls_img  TYPE tnodeimg.

  SELECT * INTO TABLE lt_imgr
    FROM tnodeimgr
    WHERE ref_type = i_type
      AND ref_object = i_obj.

  LOOP AT lt_imgr INTO ls_imgr.
    SELECT SINGLE * FROM tnodeimg INTO ls_img WHERE node_id = ls_imgr-node_id.
    IF sy-subrc EQ 0.
      PERFORM down_top USING ls_img 10.
    ENDIF.
  ENDLOOP.

  NEW-LINE.
  NEW-LINE.
  WRITE 'End'.

ENDFORM.

FORM down_top
  USING is_img   TYPE tnodeimg
        iv_level TYPE i.

  DATA: lv_level   TYPE i,
        lt_parents TYPE STANDARD TABLE OF tnodeimg,
        lt_refs    TYPE STANDARD TABLE OF tnodeimg,
        ls_img     TYPE tnodeimg.

  IF iv_level < 1.
    RETURN.
  ENDIF.

  lv_level = iv_level.
  PERFORM write USING is_img lv_level.

  lv_level = lv_level - 1.

  IF is_img-parent_id IS NOT INITIAL.
    CLEAR lt_parents.
    SELECT * FROM tnodeimg INTO TABLE lt_parents WHERE node_id = is_img-parent_id.
    IF sy-subrc EQ 0.
      LOOP AT lt_parents INTO ls_img.
        PERFORM write USING ls_img lv_level.
        PERFORM down_top USING ls_img lv_level.
      ENDLOOP.
    ENDIF.
  ENDIF.

  CLEAR lt_refs.
  SELECT * FROM tnodeimg INTO TABLE lt_refs
    WHERE reftree_id = is_img-tree_id
      AND refnode_id = is_img-node_id.
  IF sy-subrc EQ 0.
    LOOP AT lt_refs INTO ls_img.
      PERFORM write USING ls_img lv_level.
      PERFORM down_top USING ls_img lv_level.
    ENDLOOP.
  ENDIF.

ENDFORM.

FORM write
  USING is_img   TYPE tnodeimg
        iv_level TYPE i.

  DATA: lv_level  TYPE i,
        lv_prefix TYPE string,
        lv_imgt   TYPE tnodeimgt-text,
        lv_row    TYPE string.

  lv_level = iv_level.
  MOVE lv_level to lv_prefix.
  WHILE lv_level > 0.
    lv_level = lv_level - 1.
    CONCATENATE lv_prefix '-' INTO lv_prefix.
  ENDWHILE.

  PERFORM imgt USING is_img-tree_id is_img-node_id CHANGING lv_imgt.
  NEW-LINE.
  CONCATENATE lv_prefix '-' is_img-node_id '-' is_img-node_type '-' lv_imgt INTO lv_row.
  WRITE: lv_row.

ENDFORM.

FORM imgt
  USING    iv_tree  TYPE tnodeimg-tree_id
           iv_node  TYPE tnodeimg-node_id
  CHANGING cv_text  TYPE tnodeimgt-text.

  CLEAR cv_text.
  SELECT SINGLE text FROM tnodeimgt INTO cv_text
    WHERE spras = 'E'
      AND tree_id = iv_tree
      AND node_id = iv_node.

ENDFORM.