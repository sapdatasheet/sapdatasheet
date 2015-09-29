*&---------------------------------------------------------------------*
*& Report  YYTEST_SPRO_DOWN_TOP
*&
*&---------------------------------------------------------------------*
*&
*&
*&---------------------------------------------------------------------*

REPORT yytest_spro_down_top.

PARAMETERS i_type  TYPE tnodeimgr-ref_type DEFAULT 'COBJ'.
PARAMETERS i_obj   TYPE tnodeimgr-ref_object DEFAULT 'SIMG_CFMENUO000SMOD'.

TYPES: BEGIN OF  ts_node,
         id     TYPE i,
         node_t TYPE string,
       END OF ts_node.

DATA: gt_nodes      TYPE STANDARD TABLE OF ts_node.

PERFORM main.

*&---------------------------------------------------------------------*
*&      Form  main
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
FORM main.

  CLEAR gt_nodes.

  DATA: lt_imgr TYPE STANDARD TABLE OF tnodeimgr,
        ls_imgr TYPE tnodeimgr,
        ls_img  TYPE tnodeimg,
        ls_node TYPE ts_node.

  SELECT * INTO TABLE lt_imgr
    FROM tnodeimgr
    WHERE ref_type = i_type
      AND ref_object = i_obj.

  LOOP AT lt_imgr INTO ls_imgr.
    CLEAR gt_nodes.

    SELECT SINGLE * FROM tnodeimg INTO ls_img WHERE node_id = ls_imgr-node_id.
    IF sy-subrc EQ 0.
      NEW-PAGE.
      WRITE '========== Start =========='.
      NEW-LINE.

      PERFORM down_top USING ls_img 20 'Start point'.

*     Write Result
      LOOP AT gt_nodes INTO ls_node.
        NEW-LINE.
        WRITE ls_node-node_t.
      ENDLOOP.

      NEW-LINE.
      WRITE '========== End ============'.
    ENDIF.
  ENDLOOP.

ENDFORM.                    "main

*&---------------------------------------------------------------------*
*&      Form  down_top
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
*      -->IS_IMG     text
*      -->IV_LEVEL   text
*      -->IV_NOTE    text
*----------------------------------------------------------------------*
FORM down_top
  USING is_img   TYPE tnodeimg
        iv_level TYPE i
        iv_note  TYPE string.

  DATA: lv_level   TYPE i,
        lt_parents TYPE STANDARD TABLE OF tnodeimg,
        lt_refs    TYPE STANDARD TABLE OF tnodeimg,
        ls_img     TYPE tnodeimg.

  IF iv_level < 1.
    RETURN.
  ENDIF.

  PERFORM write USING is_img iv_level iv_note.

  IF is_img-parent_id IS NOT INITIAL.
    CLEAR lt_parents.
    SELECT * FROM tnodeimg INTO TABLE lt_parents WHERE node_id = is_img-parent_id.
    IF sy-subrc EQ 0.
      lv_level = iv_level - 1.
      LOOP AT lt_parents INTO ls_img.
        PERFORM down_top USING ls_img lv_level 'Parent'.
      ENDLOOP.
    ENDIF.
  ENDIF.

  CLEAR lt_refs.
  SELECT * FROM tnodeimg INTO TABLE lt_refs
    WHERE reftree_id = is_img-tree_id
      AND refnode_id = is_img-node_id.
  IF sy-subrc EQ 0.
    lv_level = iv_level - 1.
    LOOP AT lt_refs INTO ls_img.
      PERFORM down_top USING ls_img lv_level 'Reference Tree + Node'.
    ENDLOOP.
  ENDIF.

ENDFORM.                    "down_top

*&---------------------------------------------------------------------*
*&      Form  write
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
*      -->IS_IMG     text
*      -->IV_LEVEL   text
*      -->IV_NOTE    text
*----------------------------------------------------------------------*
FORM write
  USING is_img   TYPE tnodeimg
        iv_level TYPE i
        iv_note  TYPE string.

  DATA: lv_level  TYPE i,
        lv_prefix TYPE string,
        lv_imgt   TYPE tnodeimgt-text,
        lv_row    TYPE string,
        ls_node   TYPE ts_node.

  IF is_img-node_type EQ 'REF'.
    RETURN.
  ENDIF.

  lv_level = iv_level.
  MOVE lv_level TO lv_prefix.
  WHILE lv_level > 0.
    lv_level = lv_level - 1.
    CONCATENATE lv_prefix '-' INTO lv_prefix.
  ENDWHILE.

  PERFORM imgt USING is_img-tree_id is_img-node_id CHANGING lv_imgt.
  NEW-LINE.
  CONCATENATE lv_prefix '-' is_img-node_id '-' is_img-node_type '-' lv_imgt '-' iv_note INTO lv_row.

  CLEAR ls_node.
  ls_node-id = iv_level.
  ls_node-node_t = lv_row.
  INSERT ls_node INTO gt_nodes INDEX 1.

ENDFORM.                    "write

*&---------------------------------------------------------------------*
*&      Form  imgt
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
*      -->IV_TREE    text
*      -->IV_NODE    text
*      -->CV_TEXT    text
*----------------------------------------------------------------------*
FORM imgt
  USING    iv_tree  TYPE tnodeimg-tree_id
           iv_node  TYPE tnodeimg-node_id
  CHANGING cv_text  TYPE tnodeimgt-text.

  CLEAR cv_text.
  SELECT SINGLE text FROM tnodeimgt INTO cv_text
    WHERE spras = 'E'
      AND tree_id = iv_tree
      AND node_id = iv_node.

ENDFORM.                    "imgt