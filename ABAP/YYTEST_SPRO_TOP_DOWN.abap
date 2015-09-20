*&---------------------------------------------------------------------*
*& Report  YTEST_SPRO_TOP_DOWN
*&
*&---------------------------------------------------------------------*
*&
*&
*&---------------------------------------------------------------------*

REPORT  YTEST_SPRO_TOP_DOWN.

PERFORM main.


*&---------------------------------------------------------------------*
*&      Form  main
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
FORM main.
  DATA: ls_tnodeimg           TYPE tnodeimg,
        ls_tnodeimg_check     TYPE tnodeimg,
        lv_text               TYPE tnodeimgt-text.


  SELECT * FROM tnodeimg INTO ls_tnodeimg
    WHERE parent_id = '368DDFAC3AB96CCFE10000009B38F976'.

    IF ls_tnodeimg-node_type EQ 'REF'.
*   Check reftree_id
      IF ls_tnodeimg-reftree_id IS NOT INITIAL.
        SELECT SINGLE * FROM tnodeimg INTO ls_tnodeimg_check
          WHERE tree_id = ls_tnodeimg-reftree_id.
        IF sy-subrc NE 0.
          CONTINUE.
        ENDIF.
      ENDIF.

*   Check refnode_id
      IF ls_tnodeimg-refnode_id IS NOT INITIAL.
        SELECT SINGLE * FROM tnodeimg INTO ls_tnodeimg_check
          WHERE node_id = ls_tnodeimg-refnode_id.
        IF sy-subrc NE 0.
          CONTINUE.
        ENDIF.
      ENDIF.
    ENDIF.

    CLEAR lv_text.
    SELECT SINGLE text INTO lv_text FROM tnodeimgt
      WHERE node_id = ls_tnodeimg-node_id AND spras = 'E'.

    NEW-LINE.
    WRITE: ls_tnodeimg-node_id, ls_tnodeimg-node_type, lv_text.

    PERFORM process_tnodeimg USING ls_tnodeimg 0.

  ENDSELECT.
ENDFORM.                    "main


*&---------------------------------------------------------------------*
*&      Form  process_tnodeimg
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
*      -->IS_TNODEIMG  text
*----------------------------------------------------------------------*
FORM process_tnodeimg
  USING is_tnodeimg  TYPE tnodeimg
        iv_level     TYPE i.

  DATA lv_level TYPE i.

  lv_level = iv_level + 1.

  IF is_tnodeimg-node_type = 'REF'
    AND is_tnodeimg-reftree_id IS NOT INITIAL
    AND is_tnodeimg-refnode_id IS NOT INITIAL.
    PERFORM write_child_tree USING
          is_tnodeimg-reftree_id
          is_tnodeimg-refnode_id
          lv_level.
  ELSEIF is_tnodeimg-node_type = 'IMG0'.
    PERFORM write_child USING
          is_tnodeimg-node_id
          lv_level.
  ELSEIF is_tnodeimg-node_type = 'IMG' OR is_tnodeimg-node_type = 'IMG1'.
    PERFORM write_img_activity USING
          is_tnodeimg.
  ENDIF.

ENDFORM.                    "process_tnodeimg


*&---------------------------------------------------------------------*
*&      Form  write_child_tree
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
*      -->IV_TREE_ID text
*----------------------------------------------------------------------*
FORM write_child_tree
  USING iv_tree_id TYPE tnodeimg-reftree_id
        iv_node_id TYPE tnodeimg-refnode_id
        iv_level   TYPE i.

  DATA: lt_tnodeimg           TYPE STANDARD TABLE OF tnodeimg,
        ls_tnodeimg           TYPE tnodeimg,
        ls_tnodeimg_check     TYPE tnodeimg,
        lv_text               TYPE tnodeimgt-text,
        lv_level              TYPE i.


  SELECT * FROM tnodeimg INTO TABLE lt_tnodeimg
    WHERE tree_id EQ iv_tree_id
      AND node_id NE iv_node_id
    ORDER BY node_type.

  LOOP AT lt_tnodeimg INTO ls_tnodeimg.
    CLEAR lv_text.
    SELECT SINGLE text INTO lv_text FROM tnodeimgt
      WHERE node_id = ls_tnodeimg-node_id AND spras = 'E'.

    NEW-LINE.
    lv_level = iv_level.
    WHILE lv_level > 0.
      lv_level = lv_level - 1.
      WRITE '-'.
    ENDWHILE.
    WRITE: ls_tnodeimg-node_id, ls_tnodeimg-node_type.
    IF lv_text IS NOT INITIAL.
      WRITE lv_text.
    ENDIF.

    lv_level = iv_level.
    PERFORM process_tnodeimg USING ls_tnodeimg lv_level.
  ENDLOOP.


ENDFORM.                    "write_child_tree


*&---------------------------------------------------------------------*
*&      Form  write_child
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
*      -->IV_NODE_ID text
*      -->IV_LEVEL   text
*----------------------------------------------------------------------*
FORM write_child
  USING iv_node_id TYPE tnodeimg-refnode_id
        iv_level   TYPE i.

  DATA: lt_tnodeimg           TYPE STANDARD TABLE OF tnodeimg,
        ls_tnodeimg           TYPE tnodeimg,
        lv_text               TYPE tnodeimgt-text,
        lv_level              TYPE i.

  SELECT * FROM tnodeimg INTO TABLE lt_tnodeimg
    WHERE parent_id EQ iv_node_id
    ORDER BY node_type.

  LOOP AT lt_tnodeimg INTO ls_tnodeimg.
    CLEAR lv_text.
    SELECT SINGLE text INTO lv_text FROM tnodeimgt
      WHERE node_id = ls_tnodeimg-node_id AND spras = 'E'.

    NEW-LINE.
    lv_level = iv_level.
    WHILE lv_level > 0.
      lv_level = lv_level - 1.
      WRITE '-'.
    ENDWHILE.
    WRITE: ls_tnodeimg-node_id, ls_tnodeimg-node_type.
    IF lv_text IS NOT INITIAL.
      WRITE lv_text.
    ENDIF.

    lv_level = iv_level.
    PERFORM process_tnodeimg USING ls_tnodeimg lv_level.
  ENDLOOP.

ENDFORM.                    "write_child

*&---------------------------------------------------------------------*
*&      Form  write_IMG_activity
*&---------------------------------------------------------------------*
*       text
*----------------------------------------------------------------------*
*      -->IV_NODE_ID text
*      -->IV_LEVEL   text
*----------------------------------------------------------------------*
FORM write_img_activity
  USING is_tnodeimg  TYPE tnodeimg.

  DATA: ls_tnodeimgr          TYPE tnodeimgr,
        lv_text               TYPE cus_imgact-text.

  SELECT SINGLE * FROM tnodeimgr INTO ls_tnodeimgr
    WHERE node_id = is_tnodeimg-node_id.
  IF sy-subrc NE 0.
    WRITE '!!! No Activity Found'.
    RETURN.
  ENDIF.

  CLEAR lv_text.
  SELECT SINGLE text INTO lv_text FROM cus_imgact
    WHERE activity = ls_tnodeimgr-ref_object
      AND spras = 'E'.
  IF sy-subrc EQ 0.
    WRITE lv_text.
  ELSE.
    WRITE ls_tnodeimgr-ref_object.
  ENDIF.

ENDFORM.                    "write_child_tree