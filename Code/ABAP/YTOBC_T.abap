*&---------------------------------------------------------------------*
*& Report  YTOBC_T
*&
*&---------------------------------------------------------------------*
*& Copy TOBC  to YTOBC
*& Copy TOBCT to YTOBCT
*&---------------------------------------------------------------------*

REPORT ytobc_t.

DATA: lt_ytobc  TYPE STANDARD TABLE OF ytobc,
      lt_ytobct TYPE STANDARD TABLE OF ytobct.

SELECT * FROM tobc INTO CORRESPONDING FIELDS OF TABLE lt_ytobc.
SELECT * FROM tobct INTO CORRESPONDING FIELDS OF TABLE lt_ytobct.

DELETE FROM ytobc.
COMMIT WORK.
DELETE FROM ytobct.
COMMIT WORK.

INSERT ytobc FROM TABLE lt_ytobc.
COMMIT WORK.
INSERT ytobct FROM TABLE lt_ytobct.
COMMIT WORK.

WRITE: 'Finished'.
