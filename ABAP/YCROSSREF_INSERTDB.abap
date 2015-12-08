FUNCTION ycrossref_insertdb.
*"----------------------------------------------------------------------
*"*"Update Function Module:
*"
*"*"Local Interface:
*"  TABLES
*"      IT_DATA STRUCTURE  YCROSSREF
*"----------------------------------------------------------------------

  INSERT ycrossref FROM TABLE it_data ACCEPTING DUPLICATE KEYS.

ENDFUNCTION.