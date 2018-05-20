*&---------------------------------------------------------------------*
*& Report  YTEST_SPRO_TOP_DOWN
*&
*&---------------------------------------------------------------------*
*& Generate Tree Hierarchy for SPRO IMG
*&---------------------------------------------------------------------*

REPORT  ytest_spro_top_down.

PERFORM main.

DATA: gt_item TYPE STANDARD TABLE OF yspro.


*&---------------------------------------------------------------------*
*&      Form  main
*&---------------------------------------------------------------------*
*       Start Main
*----------------------------------------------------------------------*
FORM main.
  DATA: lt_tnodeimg       TYPE STANDARD TABLE OF tnodeimg,
        ls_tnodeimg       TYPE tnodeimg,
        ls_tnodeimg_check TYPE tnodeimg.

  SELECT * FROM tnodeimg INTO TABLE lt_tnodeimg
    WHERE parent_id = '368DDFAC3AB96CCFE10000009B38F976'.

  LOOP AT lt_tnodeimg INTO ls_tnodeimg.
    IF ls_tnodeimg-node_type EQ 'REF'.
*     Check reftree_id
      IF ls_tnodeimg-reftree_id IS NOT INITIAL.
        SELECT SINGLE * FROM tnodeimg INTO ls_tnodeimg_check
          WHERE tree_id = ls_tnodeimg-reftree_id.  " ##WARN_OK
        IF sy-subrc NE 0.
          CONTINUE.
        ENDIF.
      ENDIF.

*     Check refnode_id
      IF ls_tnodeimg-refnode_id IS NOT INITIAL.
        SELECT SINGLE * FROM tnodeimg INTO ls_tnodeimg_check
          WHERE node_id = ls_tnodeimg-refnode_id.
        IF sy-subrc NE 0.
          CONTINUE.
        ENDIF.
      ENDIF.
    ENDIF.

    PERFORM write_line USING ls_tnodeimg 0.
  ENDLOOP.

  INSERT yspro FROM TABLE gt_item ACCEPTING DUPLICATE KEYS.
  COMMIT WORK.

ENDFORM.                    "main


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

  DATA: lt_tnodeimg TYPE STANDARD TABLE OF tnodeimg,
        ls_tnodeimg TYPE tnodeimg.


  SELECT * FROM tnodeimg INTO TABLE lt_tnodeimg
    WHERE tree_id EQ iv_tree_id
      AND node_id NE iv_node_id
    ORDER BY node_type.

  LOOP AT lt_tnodeimg INTO ls_tnodeimg.
    PERFORM write_line USING ls_tnodeimg iv_level.
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
FORM write_child_node
  USING iv_node_id TYPE tnodeimg-refnode_id
        iv_level   TYPE i.

  DATA: lt_tnodeimg TYPE STANDARD TABLE OF tnodeimg,
        ls_tnodeimg TYPE tnodeimg,
        lv_level    TYPE i.

  SELECT * FROM tnodeimg INTO TABLE lt_tnodeimg
    WHERE parent_id EQ iv_node_id
    ORDER BY node_type.

  LOOP AT lt_tnodeimg INTO ls_tnodeimg.
    PERFORM write_line USING ls_tnodeimg iv_level.
  ENDLOOP.

ENDFORM.                    "write_child


FORM write_line
  USING is_tnodeimg  TYPE tnodeimg
        iv_level     TYPE i.

  DATA: lv_text   TYPE tnodeimgt-text,
        lv_level  TYPE i,
        lv_string TYPE string.

  CLEAR lv_string.
  CLEAR lv_text.
  SELECT SINGLE text INTO lv_text FROM tnodeimgt
    WHERE node_id = is_tnodeimg-node_id AND spras = 'E'.

  NEW-LINE.
  lv_level = iv_level.
  WHILE lv_level > 0.
    lv_level = lv_level - 1.
    CONCATENATE lv_string '-' INTO lv_string.
  ENDWHILE.

  CONCATENATE lv_string ':' is_tnodeimg-node_id ':' is_tnodeimg-node_type ':' lv_text INTO lv_string.


  IF is_tnodeimg-node_type = 'IMG' OR is_tnodeimg-node_type = 'IMG1'.
    DATA: lt_tnodeimgr TYPE STANDARD TABLE OF tnodeimgr,
          ls_tnodeimgr TYPE tnodeimgr,
          lv_text_act  TYPE cus_imgact-text.

    SELECT * FROM tnodeimgr INTO TABLE lt_tnodeimgr
      WHERE node_id = is_tnodeimg-node_id.
    IF sy-subrc NE 0.
      NEW-LINE.
      CONCATENATE lv_string  ': !!! No Activity Found' INTO lv_string.
    ELSE.
      LOOP AT lt_tnodeimgr INTO ls_tnodeimgr.
        CLEAR lv_text_act.
        IF ls_tnodeimgr-ref_type EQ 'COBJ'.
          SELECT SINGLE text INTO lv_text_act FROM cus_imgact
            WHERE activity = ls_tnodeimgr-ref_object
              AND spras = 'E'.
        ENDIF.

        CONCATENATE lv_string ',-->' ls_tnodeimgr-ref_type ':' ls_tnodeimgr-ref_object ':' lv_text_act INTO lv_string.
      ENDLOOP.
    ENDIF.
  ENDIF.

  " Add Item
  DATA: ls_item  TYPE yspro,
        lv_lines TYPE i.

  DESCRIBE TABLE gt_item LINES lv_lines.
  lv_lines = lv_lines + 1.

  CLEAR ls_item.
  ls_item-seq = lv_lines.
  ls_item-item = lv_string.
  APPEND ls_item TO gt_item.

  " Process Next Node
  lv_level = iv_level + 1.

  IF is_tnodeimg-node_type = 'REF'
    AND is_tnodeimg-reftree_id IS NOT INITIAL
    AND is_tnodeimg-refnode_id IS NOT INITIAL.
    PERFORM write_child_tree USING
          is_tnodeimg-reftree_id
          is_tnodeimg-refnode_id
          lv_level.
  ELSEIF is_tnodeimg-node_type = 'IMG0'.
    PERFORM write_child_node USING
          is_tnodeimg-node_id
          lv_level.
  ENDIF.

ENDFORM.