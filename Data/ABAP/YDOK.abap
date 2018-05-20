*&---------------------------------------------------------------------*
*& Report  YDOK
*&
*&---------------------------------------------------------------------*
*&
*&
*&---------------------------------------------------------------------*

REPORT ydok.

TYPES: BEGIN OF  ts_key,
         id     TYPE doku_id,
         object TYPE doku_obj,
         langu  TYPE doku_langu,
         typ    TYPE doku_typ,
       END OF ts_key.

TABLES dokhl.
SELECT-OPTIONS i_clas FOR dokhl-id DEFAULT 'HY'.
PARAMETERS i_size   TYPE i DEFAULT 5000.  " Package Size

DATA: gt_db   TYPE STANDARD TABLE OF ydok.

PERFORM main.

FORM main.

  DATA: lt_key     TYPE STANDARD TABLE OF ts_key,
        ls_key     TYPE ts_key,
        lv_lines   TYPE i,
        lv_message TYPE string,
        lv_count1  TYPE i VALUE 0,
        lv_count2  TYPE i VALUE 0.

  SELECT DISTINCT id object langu typ
    FROM dokil
    INTO CORRESPONDING FIELDS OF TABLE lt_key
    WHERE id IN i_clas.

  " Log Loaded the Record Count
  DESCRIBE TABLE lt_key LINES lv_lines.
  MOVE lv_lines TO lv_message.
  CONCATENATE 'Records loaded ' lv_message INTO lv_message.
  MESSAGE lv_message TYPE 'I'.


  LOOP AT lt_key INTO ls_key.
    lv_count1 = lv_count1 + 1.
    lv_count2 = lv_count2 + 1.
    PERFORM transform USING ls_key.

    " Check Buffer Size
    IF lv_count2 >= i_size.
      PERFORM save.
      lv_count2 = 0.

      MOVE lv_count1 TO lv_message.
      CONCATENATE 'Current record id ' lv_message INTO lv_message.
      MESSAGE lv_message TYPE 'I'.
    ENDIF.
  ENDLOOP.

  PERFORM save.
  MESSAGE 'Done.' TYPE 'I'.                                 "#EC NOTEXT

ENDFORM.

FORM transform
  USING is_key   TYPE ts_key.

  DATA: ls_dokil TYPE dokil,                       " Index for Documentation Table DOKH
        ls_head  TYPE thead,                       " Text Header
        lt_lines TYPE TABLE OF tline,              " Text Lines
        lr_text  TYPE REF TO cl_wd_formatted_text, " Formatted Text
        lr_exp   TYPE REF TO cx_root.
  DATA: ls_db    TYPE ydok.

* Get indx of customer defined documentation
  CALL FUNCTION 'DOCU_INIT'
    EXPORTING
      typ    = is_key-typ
      id     = is_key-id
      langu  = is_key-langu
      object = is_key-object
    IMPORTING
      xdokil = ls_dokil.

* Get detail text of documentation
  CALL FUNCTION 'DOCU_READ'
    EXPORTING
      id      = ls_dokil-id
      langu   = ls_dokil-langu
      object  = ls_dokil-object
      typ     = ls_dokil-typ
      version = ls_dokil-version
    IMPORTING
      head    = ls_head
    TABLES
      line    = lt_lines.

* Convert documentation into formatted style
  CLEAR lr_text.
  TRY .
      cl_wd_formatted_text=>create_from_sapscript(
        EXPORTING
          sapscript_head  = ls_head
          sapscript_lines = lt_lines
        RECEIVING
          formatted_text  = lr_text
      ).
    CATCH cx_root INTO lr_exp.
      ls_db-htmltext = lr_exp->get_text( ).
      CONCATENATE 'EXCEPTION: ' ls_db-htmltext INTO ls_db-htmltext.
  ENDTRY.

  CLEAR ls_db.
  MOVE-CORRESPONDING is_key TO ls_db.
  ls_db-dokversion = ls_dokil-version.
  IF lr_text IS BOUND.
    ls_db-htmltext = lr_text->m_xml_text.
  ENDIF.
  APPEND ls_db TO gt_db.
ENDFORM.


FORM save.

  DATA: lv_lines   TYPE i,
        lv_message TYPE string.

  DESCRIBE TABLE gt_db LINES lv_lines.
  IF lv_lines < 1.
    RETURN.
  ENDIF.

  INSERT ydok FROM TABLE gt_db ACCEPTING DUPLICATE KEYS.
  COMMIT WORK.
  CLEAR gt_db.

  " Log Message
  MOVE lv_lines TO lv_message.
  CONCATENATE 'Saved record count' lv_message INTO lv_message.
  MESSAGE lv_message TYPE 'I'.

ENDFORM.