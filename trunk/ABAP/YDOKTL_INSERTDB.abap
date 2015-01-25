FUNCTION ydoktl_insertdb.
*"----------------------------------------------------------------------
*"*"Update Function Module:
*"
*"*"Local Interface:
*"  TABLES
*"      IT_DB STRUCTURE  YDOKTL
*"----------------------------------------------------------------------

  INSERT ydoktl FROM TABLE it_db ACCEPTING DUPLICATE KEYS.

ENDFUNCTION.