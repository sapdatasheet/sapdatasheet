*&---------------------------------------------------------------------*
*& Report  YAMOSTOOL_FAVSORT
*&
*&---------------------------------------------------------------------*
*&
*&
*&---------------------------------------------------------------------*

REPORT YTOOL_FAVSORT.


PARAMETERS i_uname    TYPE syuname DEFAULT sy-uname OBLIGATORY.


DATA: lt_smen_buffc   TYPE STANDARD TABLE OF smen_buffc,
      lv_sort_order   TYPE menu_num_5.
FIELD-SYMBOLS:
      <ls_smen_buffc> TYPE smen_buffc.


SELECT * FROM smen_buffc INTO TABLE lt_smen_buffc
  WHERE uname = i_uname
    AND parent_id = 1.

SORT lt_smen_buffc BY reporttype report.
lv_sort_order = 10.
LOOP AT lt_smen_buffc ASSIGNING <ls_smen_buffc>.
  <ls_smen_buffc>-sort_order = lv_sort_order.
  lv_sort_order = lv_sort_order + 10.
ENDLOOP.

MODIFY smen_buffc FROM TABLE lt_smen_buffc.

SORT lt_smen_buffc BY sort_order.
LOOP AT lt_smen_buffc ASSIGNING <ls_smen_buffc>.
  NEW-LINE.
  WRITE <ls_smen_buffc>-sort_order.
  WRITE <ls_smen_buffc>-reporttype.
  WRITE <ls_smen_buffc>-report.
  WRITE <ls_smen_buffc>-text.
ENDLOOP.
WRITE: 'Done'.