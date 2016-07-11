*&---------------------------------------------------------------------*
*& Report  YSPFL
*&
*&---------------------------------------------------------------------*
*& Fill in YSPFL* tables based on CL_SPFL_PROFILE_PARAMETER
*&---------------------------------------------------------------------*

REPORT yspfl.

DATA: lt_metadata    TYPE spfl_parameter_metadata_list_t,
      ls_metadata    TYPE LINE OF spfl_parameter_metadata_list_t,
      lv_rc          TYPE i,
      lt_db_metadata TYPE STANDARD TABLE OF yspflmetadata,
      ls_db_metadata TYPE yspflmetadata.


CALL METHOD cl_spfl_profile_parameter=>get_all_metadata
  IMPORTING
    metadata = lt_metadata
  RECEIVING
    rc       = lv_rc.
IF lv_rc NE 0.
  WRITE: 'Failed to call cl_spfl_profile_parameter=>get_all_metadata'.
  EXIT.
ENDIF.

DELETE FROM yspflmetadata.
COMMIT WORK.

CLEAR ls_db_metadata.
CLEAR lt_db_metadata.
ls_db_metadata-seq = 0.
LOOP AT lt_metadata INTO ls_metadata.
  ls_db_metadata-seq = ls_db_metadata-seq + 1.
  MOVE-CORRESPONDING ls_metadata TO ls_db_metadata.
  APPEND ls_db_metadata TO lt_db_metadata.
ENDLOOP.

INSERT yspflmetadata FROM TABLE lt_db_metadata.
COMMIT WORK.
NEW-LINE.
WRITE: 'Insert into table YSPFLMETADATA finished'.

DATA: lt_p_sub     TYPE spfl_parameter_list_t,
      ls_p_sub     TYPE LINE OF spfl_parameter_list_t,
      lt_p_usub    TYPE spfl_parameter_list_t,
      ls_p_usub    TYPE LINE OF spfl_parameter_list_t,
      lt_db_p_sub  TYPE STANDARD TABLE OF yspflparasub,
      ls_db_p_sub  TYPE yspflparasub,
      lt_db_p_usub TYPE STANDARD TABLE OF yspflparausub,
      ls_db_p_usub TYPE yspflparausub.

CALL METHOD cl_spfl_profile_parameter=>get_all_parameter
  IMPORTING
    parameter_sub  = lt_p_sub
    parameter_usub = lt_p_usub
  RECEIVING
    rc             = lv_rc.
IF lv_rc NE 0.
  WRITE: 'Failed to call cl_spfl_profile_parameter=>get_all_parameter'.
  EXIT.
ENDIF.

DELETE FROM yspflparasub.
DELETE FROM yspflparausub.
COMMIT WORK.

CLEAR: lt_db_p_sub, ls_db_p_sub.
CLEAR: lt_db_p_usub, ls_db_p_usub.
ls_db_p_sub-seq = 0.
LOOP AT lt_p_sub INTO ls_p_sub.
  ls_db_p_sub-seq = ls_db_p_sub-seq + 1.
  MOVE-CORRESPONDING   ls_p_sub TO ls_db_p_sub.
  APPEND ls_db_p_sub TO lt_db_p_sub.
ENDLOOP.
ls_db_p_usub-seq = 0.
LOOP AT lt_p_usub INTO ls_p_usub.
  ls_db_p_usub-seq = ls_db_p_usub-seq + 1.
  MOVE-CORRESPONDING   ls_p_usub TO ls_db_p_usub.
  APPEND ls_db_p_usub TO lt_db_p_usub.
ENDLOOP.


INSERT yspflparasub  FROM TABLE lt_db_p_sub.
INSERT yspflparausub FROM TABLE lt_db_p_usub.
COMMIT WORK.
NEW-LINE.
WRITE: 'Insert into table YSPFLPARASUB, YSPFLPARAUSUB finished'.