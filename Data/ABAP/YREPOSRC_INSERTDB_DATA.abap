FUNCTION yreposrc_insertdb_data.
*"----------------------------------------------------------------------
*"*"Update Function Module:
*"
*"*"Local Interface:
*"  TABLES
*"      IT_DATA STRUCTURE  YREPOSRCDATA
*"----------------------------------------------------------------------

  INSERT yreposrcdata FROM TABLE it_data ACCEPTING DUPLICATE KEYS.

ENDFUNCTION.