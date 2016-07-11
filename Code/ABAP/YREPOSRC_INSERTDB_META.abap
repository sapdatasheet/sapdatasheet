FUNCTION YREPOSRC_INSERTDB_META.
*"----------------------------------------------------------------------
*"*"Update Function Module:
*"
*"*"Local Interface:
*"  TABLES
*"      IT_META STRUCTURE  YREPOSRCMETA
*"----------------------------------------------------------------------

  INSERT yreposrcmeta FROM TABLE it_meta ACCEPTING DUPLICATE KEYS.

ENDFUNCTION.