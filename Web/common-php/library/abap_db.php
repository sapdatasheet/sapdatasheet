<?php

$__COMMON_ROOT__ = dirname(__FILE__, 2);
require_once($__COMMON_ROOT__ . '/library/abap_dbconfig.php');
require_once($__COMMON_ROOT__ . '/library/abap_dbdata.php');

/**
 * ABAP Analytics database tables.
 */
class ABAPANA_DB_TABLE {

    const WULCOUNTER = "wulcounter";
    const WILCOUNTER = "wilcounter";
    const ABAPBMFR = "abapbmfr";
    const ABAPBMFR_L1 = "abapbmfrl1";
    const ABAPBMFR_L2 = "abapbmfrl2";
    const ABAPDEVC = "abapdevc";
    const ABAPTABL = "abaptabl";
    const ABAPTABLFLD = "abaptablfld";
    const ABAPTRAN = "abaptran";
    const ABAPTRAN_PGMNA = "pgmna";               // Column name
    const ABAPTRAN_PACKAGE = "package";           // Column name
    const ABAPTRAN_PACKAGEP = "packagep";         // Column name
    const ABAPTRAN_SOFTCOMP = "softcomp";         // Column name
    const ABAPTRAN_APPLFCTR = 'applfctr';         // Column name
    const ABAPTRAN_APPLPOSID = 'applposid';       // Column name
    const ABAPTRAN_CALLEDTCODE = "calledtcode";   // Column name
    const ABAPTRAN_CALLEDVIEW = "calledview";     // Column name
    const ABAPTRAN_CALLEDVIEWC = "calledviewc";   // Column name
    const ABAPTRAN_FCTR_ID_L1 = "fctr_id_l1";     // Column name
    const ABAPTRAN_FCTR_ID_L2 = "fctr_id_l2";     // Column name
    const ABAPTRAN_FCTR_ID_L3 = "fctr_id_l3";     // Column name
    const ABAPTRAN_FCTR_ID_L4 = "fctr_id_l4";     // Column name
    const ABAPTRAN_FCTR_ID_L5 = "fctr_id_l5";     // Column name
    const ABAPTRAN_FCTR_ID_L6 = "fctr_id_l6";     // Column name
    const ABAPTRAN_FCTR_ID_L7 = "fctr_id_l7";     // Column name
    const ABAPTRAN_FCTR_ID_L8 = "fctr_id_l8";     // Column name
    const ABAPTRAN_FCTR_ID_L9 = "fctr_id_l9";     // Column name
    const ABAPTRAN_PS_POSID_L1 = "ps_posid_l1";   // Column name
    const ABAPTRAN_PS_POSID_L2 = "ps_posid_l2";   // Column name
    const ABAPTRAN_FIELDS_DOWNLOAD = " TCODE, '' AS TCODE_DESC, '' AS TCODE_URL, PGMNA AS ABAP_PROGRAM, PACKAGE, '' AS PACKAGE_DESC, APPLPOSID AS MODULE,  '' AS MODULE_DESC, '' AS MODULE_URL, PS_POSID_L1 AS MODULE_TOP, '' AS MODULE_TOP_DESC, '' AS MODULE_TOP_URL, SOFTCOMP_GROUP AS COMPONENT, '' AS COMPONENT_DESC, '' AS COMPONENT_URL";
    const ABAPTRAN_FIELDS_LOAD = ' TCODE, SOFTCOMP, APPLPOSID, APPLFCTR, PS_POSID_L1, FCTR_ID_L1 ';

    /**
     * Load Level 1 Application Component from database by PS_POSID_L1.
     * <pre>
     * SELECT * FROM abapanalytics.abapbmfr_l1
     *   where PS_POSID_L1 = 'FI'
     * </pre>
     */
    public static function ABAPBMFRL1_POSID($posid) {
        $sql = 'SELECT * FROM ' . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPBMFR_L1
                . ' where PS_POSID_L1 = :id';
        return ABAP_DB_TABLE::select_single($sql, $posid);
    }

    /**
     * Level 1 Application Component description.
     */
    public static function ABAPBMFRL1_TEXT($posid) {
        $row = ABAPANA_DB_TABLE::ABAPBMFRL1_POSID($posid);
        return $row['TEXT'];
    }

    /**
     * Load Level 2 Application Component from database by PS_POSID_L2.
     */
    public static function ABAPBMFRL2_POSID($posid) {
        $sql = 'SELECT * FROM ' . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPBMFR_L2
                . ' where PS_POSID_L2 = :id';
        return ABAP_DB_TABLE::select_single($sql, $posid);
    }

    /**
     * Level 2 Application Component description.
     */
    public static function ABAPBMFRL2_TEXT($posid) {
        $row = ABAPANA_DB_TABLE::ABAPBMFRL2_POSID($posid);
        return $row['TEXT'];
    }

    /**
     * Get one record for a given posid.
     */
    public static function ABAPBMFR_FCTR_ID($fctr_id) {
        $sql = "SELECT * FROM " . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPBMFR
                . " WHERE FCTR_ID = :id";
        return ABAP_DB_TABLE::select_single($sql, $fctr_id);
    }

    /**
     * Get one record for a given posid.
     */
    public static function ABAPBMFR_POSID($posid) {
        $bufkey = GLOBAL_BUFFER::KEYPREFIX_DB . ABAPANA_DB_TABLE::ABAPBMFR . 'ps_posid' . $posid;
        $bufval = GLOBAL_BUFFER::Get($bufkey);
        if (!is_array($bufval)) {
            $sql = "SELECT * FROM " . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPBMFR
                    . " WHERE ps_posid = :id";
            $bufval = ABAP_DB_TABLE::select_single($sql, $posid);
            // Set Buffer
            GLOBAL_BUFFER::Set($bufkey, $bufval);
        }

        return $bufval;
    }

    /**
     * Convert application component POSID to FCTR id.
     */
    public static function ABAPBMFR_POSID_2_FCTR($posid) {
        $abap_bmfr = ABAPANA_DB_TABLE::ABAPBMFR_POSID($posid);
        return $abap_bmfr['FCTR_ID'];
    }

    /**
     * Get application component level.
     * The level 1 appl-comp is the top level.
     * The level 2's parent is an level 1 appl-comp.
     */
    public static function ABAPBMFR_POSID_LEVEL($posid) {
        $abap_bmfr = ABAPANA_DB_TABLE::ABAPBMFR_POSID($posid);
        return $abap_bmfr['PS_POSID_LMAX'];
    }

    /**
     * Get Text for an application component posid.
     */
    public static function ABAPBMFR_TEXT($posid) {
        $bmfr = ABAPANA_DB_TABLE::ABAPBMFR_POSID_2_FCTR($posid);
        if (GLOBAL_UTIL::IsEmpty($bmfr)) {
            return '';
        } else {
            return ABAP_DB_TABLE_HIER::DF14T($bmfr);
        }
    }

    /**
     * Load ABAP Package data.
     */
    public static function ABAPDEVC($devclass) {
        $sql = "SELECT * FROM " . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPDEVC
                . " where devclass = :id";
        return ABAP_DB_TABLE::select_single($sql, $devclass);
    }

    /**
     * Load ABAP Transaction Code Basic Data.
     * <pre>
     * SELECT * FROM abapanalytics.abaptran where tcode = 'SE90'
     * </pre>
     */
    public static function ABAPTRAN($tcode) {
        $sql = "SELECT * FROM " . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . " where tcode = :id";
        return ABAP_DB_TABLE::select_single($sql, $tcode);
    }

    /**
     * Get record cound for a filter.
     *
     * @param string $col Database Column Name
     * @param string $value Column Value
     */
    public static function ABAPTRAN_COUNT($col, $value) {
        $sql = "SELECT count(*) as COUNT FROM " . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . " WHERE " . $col . ' = :id';
        $count_array = ABAP_DB_TABLE::select_single($sql, $value);
        return $count_array['COUNT'];
    }

    /**
     * Get records for a filter.
     *
     * @param string $col Database Column Name
     * @param string $value Column Value
     * @param true $limit Limit the result set max row
     */
    public static function ABAPTRAN_LOAD($col, $value, $limit = TRUE) {
        $sql = "SELECT " . ABAPANA_DB_TABLE::ABAPTRAN_FIELDS_LOAD . " FROM "
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . " WHERE " . $col . ' = :id';
        if ($limit == TRUE) {
            $sql = $sql . ' LIMIT ' . ABAP_DB_CONST::MAX_ROWS_LIMIT;
        }

        return ABAP_DB_TABLE::select_1filter($sql, $value);
    }

    /**
     * Download records for a filter.
     *
     * @param string $col Database Column Name
     * @param string $value Column Value
     */
    public static function ABAPTRAN_DOANLOAD($col, $value) {
        $sql = "SELECT " . ABAPANA_DB_TABLE::ABAPTRAN_FIELDS_DOWNLOAD . " FROM "
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . " WHERE " . $col . ' = :id';

        return ABAP_DB_TABLE::select_1filter($sql, $value);
    }

    /**
     * Count tcodes for name pattern.
     */
    public static function ABAPTRAN_NAMEPATTERN_COUNT($pattern) {
        $sql = "SELECT  count(*) as COUNT FROM "
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . " WHERE TCODE like :id";
        $count_array = ABAP_DB_TABLE::select_single($sql, $pattern);
        return $count_array['COUNT'];
    }

    /**
     * Load tcodes for name pattern.
     *
     * <pre>
     * SELECT * FROM abapanalytics.abaptran where tcode like 'SE%'
     * </pre>
     */
    public static function ABAPTRAN_NAMEPATTERN_LOAD($pattern, $limit = TRUE) {
        $sql = "SELECT " . ABAPANA_DB_TABLE::ABAPTRAN_FIELDS_LOAD . " FROM "
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . " WHERE TCODE like :id";
        if ($limit == TRUE) {
            $sql = $sql . ' limit ' . ABAP_DB_CONST::MAX_ROWS_LIMIT;
        }

        return ABAP_DB_TABLE::select_1filter($sql, $pattern);
    }

    /**
     * Download tcodes for name pattern.
     */
    public static function ABAPTRAN_NAMEPATTERN_DOWNLOAD($pattern) {
        $sql = "SELECT " . ABAPANA_DB_TABLE::ABAPTRAN_FIELDS_DOWNLOAD . " FROM "
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . " WHERE TCODE like :id";
        return ABAP_DB_TABLE::select_1filter($sql, $pattern);
    }

    /**
     * Analysis the TCode Names via left(1) charactors.
     * We ignore the "S_%" spro dummy t-codes.
     */
    public static function ABAPTRAN_ANALYTICS_NAME_LEFT1() {
        $sql = 'select distinct left(tcode, 1) as TCODEPREFIX, count(*) as COUNT from '
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . ' where left(tcode, 2) <> "S_" group by left(tcode, 1)';

        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Analysis the TCode Names via left(2) charactors and namespace (if exists).
     * We ignore the "S_%" spro dummy t-codes.
     */
    /*
      select distinct tcodens as TCODEPREFIX, count(*) as COUNT
      from abapanalytics.abaptran
      where tcodens is not null
      group by tcodens
      union
      select distinct left(tcode, 2) as TCODEPREFIX, count(*) as COUNT
      from abapanalytics.abaptran
      where tcodens is null and left(tcode, 2) <> 'S_'
      group by left(tcode, 2)
     */
    public static function ABAPTRAN_ANALYTICS_NAME_LEFT2() {
        $sql = ' select distinct tcodens as TCODEPREFIX, count(*) as COUNT from '
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . ' where tcodens is not null group by tcodens'
                . ' union '
                . 'select distinct left(tcode, 2) as TCODEPREFIX, count(*) as COUNT from '
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . ' where tcodens is null and left(tcode, 2) <> "S_" group by left(tcode, 2) ';
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Analysis the TCode Names via level 1 application component.
     * <pre>
     * SELECT PS_POSID_L1, count(*)
     *   FROM abapanalytics.abaptran
     *   group by PS_POSID_L1
     * </pre>
     */
    public static function ABAPTRAN_ANALYTICS_PS_POSID_L1() {
        $sql = 'select PS_POSID_L1, count(*) as COUNT from '
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . ' group by PS_POSID_L1';
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Analysis the TCode Names via level 2 appl-comp for a specified L1 appl-comp.
     */
    /*
      SELECT PS_POSID_L2, count(*) as COUNT
      FROM abapanalytics.abaptran
      where PS_POSID_L1 = 'FI' AND PS_POSID_L2 is not null
      GROUP BY PS_POSID_L2
     */
    public static function ABAPTRAN_ANALYTICS_PS_POSID_L2($posid_l1) {
        $sql = 'select PS_POSID_L2, count(*) as COUNT from '
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                // . ' where PS_POSID_L1 = :id AND PS_POSID_L2 is not null'
                . ' where PS_POSID_L1 = :id'
                . ' group by PS_POSID_L2';
        return ABAP_DB_TABLE::select_1filter($sql, $posid_l1);
    }

    /**
     * Analysis the TCode Names via software component.
     * <pre>
     * select SOFTCOMP_GROUP as SOFTCOMP, count(*) as COUNT
     *   from abapanalytics.abaptran
     *   GROUP BY SOFTCOMP
     * </pre>
     */
    public static function ABAPTRAN_ANALYTICS_SOFTCOMP() {
        $sql = 'select SOFTCOMP_GROUP as SOFTCOMP, count(*) as COUNT from '
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . ' group by SOFTCOMP_GROUP';
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Analysis the TCode Names via application component by software component.
     * <pre>
     * SELECT APPLPOSID, COUNT(*) AS COUNT
     *   from abapanalytics.abaptran
     *   WHERE SOFTCOMP = 'SAP_BASIS'
     *   GROUP BY APPLPOSID
     * </pre>
     */
    public static function ABAPTRAN_ANALYTICS_SOFTCOMP_APPLPOSID($softcomp) {
        $sql = 'select APPLPOSID, count(*) as COUNT from '
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN
                . ' WHERE SOFTCOMP_GROUP = :id GROUP BY APPLPOSID';
        return ABAP_DB_TABLE::select_1filter($sql, $softcomp);
    }

    /**
     * Sitemap for Analytics Module.
     * <pre>
     *   SELECT distinct APPLPOSID as MODULE FROM abapanalytics.abaptran
     * </pre>
     */
    public static function ABAPTRAN_Sitemap_Module() {
        $sql = "SELECT distinct APPLPOSID as MODULE FROM "
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN;
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * ABAP T-Code sitemap.
     */
    public static function ABAPTRAN_Sitemap_TCode() {
        $sql = "SELECT TCODE FROM "
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::ABAPTRAN;
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Load Where-Used-List counter for an ABAP Object.
     *
     * <pre>
     * SELECT * FROM abapanalytics.counter
     *   where SRC_OBJ_TYPE = 'DOMA'
     *     and SRC_OBJ_NAME = 'MANDT'
     *     and OBJ_TYPE = 'DTEL'
     * </pre>
     */
    public static function WULCOUNTER($srcOType, $srcOName, $oType, $srcSubobj = '') {
        $sql = 'SELECT * from ' . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::WULCOUNTER
                . ' where SRC_OBJ_TYPE = :sotype AND SRC_OBJ_NAME = :soname AND SRC_SUBOBJ = :ssubob AND OBJ_TYPE = :otype';
        $paras = array(
            'sotype' => $srcOType,
            'soname' => $srcOName,
            'ssubob' => $srcSubobj,
            'otype' => $oType,
        );

        $row = current(ABAP_DB_TABLE::select($sql, $paras));
        if (empty($row)) {
            return -1;
        } else {
            return $row[ABAP_DB_CONST::COUNTER];
        }
    }

    /**
     * Load Where-Used-List counters by page index.
     * <pre>
     * SELECT * FROM abapanalytics.counter
     *   order by SRC_OBJ_TYPE, SRC_OBJ_NAME, OBJ_TYPE
     *   limit 10000
     *   offset 2000000
     * </pre>
     */
    public static function WULCOUNTER_Index($page) {
        $sql = 'select * from ' . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::WULCOUNTER
//              . ' ORDER BY SRC_OBJ_TYPE, SRC_OBJ_NAME, OBJ_TYPE'  -- Do not order for performance reason
                . ABAP_DB_CONST::SQL_LIMIT($page);
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Load Where-Used-List counter for an ABAP Object.
     * <pre>
     * SELECT * FROM abapanalytics.counter
     *   where SRC_OBJ_TYPE = 'DTEL'
     *     and SRC_OBJ_NAME = 'MANDT'
     *   order by OBJ_TYPE
     * </pre>
     */
    public static function WULCOUNTER_List($srcOType, $srcOName, $srcSubobj = '') {
        $sql = 'SELECT * from ' . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::WULCOUNTER
                . ' where SRC_OBJ_TYPE = :sotype AND SRC_OBJ_NAME = :soname AND SRC_SUBOBJ = :ssubob'
                . ' order by OBJ_TYPE';
        $paras = array(
            'sotype' => $srcOType,
            'soname' => $srcOName,
            'ssubob' => $srcSubobj,
        );

        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Top 100 most used Table object.
     */
    public static function WULCOUNTER_Ranking_TABL(int $page = 1): array {
        /*
          SELECT
          SRC_OBJ_NAME, SUM(COUNTER) as COUNTER
          FROM abapanalytics.wulcounter
          WHERE SRC_OBJ_TYPE = 'TABL'
          AND SRC_OBJ_NAME in (SELECT TABNAME FROM abap.dd02l where TABCLASS IN ('TRANSP', 'CLUSTER', 'POOL'))
          GROUP BY SRC_OBJ_NAME
          ORDER BY COUNTER DESC
         */
        
        $sql = "SELECT"
                . " SRC_OBJ_NAME as TABNAME,"
                . " SUM(COUNTER) as " . ABAP_DB_CONST::COUNTER
                . " FROM " . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::WULCOUNTER
                . " WHERE SRC_OBJ_TYPE = '" . GLOBAL_ABAP_OTYPE::TABL_NAME . "'"
                . "   AND SRC_OBJ_NAME in ("
                . "     SELECT TABNAME"
                . "     FROM " . ABAP_DB_CONFIG::schema_abap . '.' . ABAP_DB_TABLE_TABL::DD02L
                . "     WHERE TABCLASS IN ("
                . " '" . ABAP_DB_CONST::DOMAINVALUE_TABCLASS_TRANSP . "',"
                . " '" . ABAP_DB_CONST::DOMAINVALUE_TABCLASS_CLUSTER . "',"
                . " '" . ABAP_DB_CONST::DOMAINVALUE_TABCLASS_POOL . "')"
                . "   )"
                . " GROUP BY SRC_OBJ_NAME"
                . " ORDER BY COUNTER DESC"
                . " " . ABAP_DB_CONST::SQL_LIMIT_SMALL($page) ;
        
        return ABAP_DB_TABLE::select($sql);
    }

    public static function WULCOUNTER_Sitemap(): array {
        $sql = "select * from "
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::WULCOUNTER;
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Load Where-Using-List counter for an ABAP Object.
     *
     * <pre>
     * SELECT * FROM abapanalytics.wilcounter
     *   where OBJ_TYPE = 'TABL'
     *     and OBJ_NAME = 'BKPF'
     *     and SRC_OBJ_TYPE = 'DTEL'
     * </pre>
     */
    public static function WILCOUNTER($oType, $oName, $srcOType) {
        $sql = 'SELECT * from ' . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::WILCOUNTER
                . ' where OBJ_TYPE = :otype AND OBJ_NAME = :oname AND SRC_OBJ_TYPE = :sotyp';
        $paras = array(
            'otype' => $oType,
            'oname' => $oName,
            'sotyp' => $srcOType,
        );

        $row = current(ABAP_DB_TABLE::select($sql, $paras));
        if (empty($row)) {
            return -1;
        } else {
            return $row[ABAP_DB_CONST::COUNTER];
        }
    }

    /**
     * Load Where-Using-List counters by page index.
     *
     * <pre>
     * SELECT * FROM abapanalytics.wilcounter
     *   order by OBJ_TYPE, OBJ_NAME, SRC_OBJ_TYPE
     *   limit  10000
     *   offset 50000
     * </pre>
     */
    public static function WILCOUNTER_Index($page) {
        $sql = 'select * from ' . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::WILCOUNTER
//              . ' ORDER BY OBJ_TYPE, OBJ_NAME, SRC_OBJ_TYPE'
                . ABAP_DB_CONST::SQL_LIMIT($page);
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Load Where-Using-List counter for an ABAP Object.
     *
     * <pre>
     * SELECT * FROM abapanalytics.wilcounter
     *   where OBJ_TYPE = 'TABL'
     *     and OBJ_NAME = 'BKPF'
     *   order by SRC_OBJ_TYPE
     * </pre>
     */
    public static function WILCOUNTER_List($oType, $oName) {
        $sql = 'SELECT * from ' . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::WILCOUNTER
                . ' where OBJ_TYPE = :otype AND OBJ_NAME = :oname'
                . ' order by SRC_OBJ_TYPE';
        $paras = array(
            'otype' => $oType,
            'oname' => $oName,
        );

        return ABAP_DB_TABLE::select($sql, $paras);
    }

    public static function WILCOUNTER_Sitemap() {
        $sql = "select * from "
                . ABAP_DB_CONFIG::schema_abapana . '.' . ABAPANA_DB_TABLE::WILCOUNTER;
        return ABAP_DB_TABLE::select($sql);
    }

}


class ABAP_DB_CONST {

    const COUNTER = 'COUNTER';

    /**
     * Max rows limit for result set, to avoid load too many record to UI.
     */
    const MAX_ROWS_LIMIT = 500;
    const MAX_ROWS_LIMIT_SMALL = 100;
    const INDEX_A = 'A';                       // First page, start from 'A'
    const INDEX_LIST = 'LIST';                 // List all contents, no paging
    const INDEX_SLASH = 'SLASH';
    const INDEX_TOP = "TOP";
    const INDEX_PAGE_1 = 1;                    // Page 1
    const INDEX_SEQNO_DTEL = 'SEQNZ';          // Data Element for Sequence Number
    const USED_BY_LIMIT_DOMA = 15;
    const USED_BY_LIMIT_DTEL = 40;
    const SEO_METAREL_LIMIT = 10;
    const LANGU_EN = "E";
    const LANGU_DE = "D";
    const FLAG_TRUE = "X";
    const FLAG_FALSE = "";

    /**
     * Description column.
     */
    const COLUMN_V_DESCR = 'DESCR';

    /** Domain names OR Domain values */
    const DOMAIN_DATATYPE = "DATATYPE";
    const DOMAIN_INTTYPE = "INTTYPE";
    const DOMAIN_CUS_ACTOBJ_OBJECTTYPE = 'OB_TYP';
    const DOMAIN_CUS_ATRH_ACTIVITY = 'SIMG_ACT';
    const DOMAIN_CUS_ATRH_COUNTRY = 'SIMG_C_OPT';
    const DOMAIN_CUS_ATRH_CRITICAL = 'SIMG_CRIT';
    const DOMAIN_DD03L_COMPTYPE_E = "E";         // E - Data Element
    const DOMAIN_DD03L_COMPTYPE_S = "S";         // S - Structure (Table)
    const DOMAIN_DD03L_COMPTYPE = "COMPTYPE";
    const DOMAIN_DD03L_LANGUFLAG = "DDLANGUFLG";
    const DOMAIN_DD03L_NOTNULL = "NOTNULL";
    const DOMAIN_DD03L_SHLPORIGIN = "SHLPORIGIN";
    const DOMAIN_DD03L_TABLETYPE = "DDFLAG";
    const DOMAIN_DD03L_REFTYPE = "DDREFTYPE";
    const DOMAIN_DD08L_CARD = "CARD";
    const DOMAIN_DD08L_CARDLEFT = "CARDLEFT";
    const DOMAIN_DD04L_REFKIND = "TYPEKIND";
    const DOMAIN_DD04L_REFTYPE = "DDREFTYPE";
    const DOMAIN_DD25L_CUSTOMAUTH = "CONTFLAG";
    const DOMAIN_DD25L_GLOBALFLAG = "MAINTFLAG";
    const DOMAIN_DD25L_VIEWCLASS = "VIEWCLASS";
    const DOMAIN_DD25L_VIEWGRANT = "VIEWGRANT";
    const DOMAIN_DD27S_RDONLY = "VFLDRDONLY";
    const DOMAIN_REPOSRC_RSTAT = "RSTAT";
    const DOMAIN_REPOSRC_SUBC = "SUBC";
    const DOMAIN_TADIR_COMP_TYPE = "RELC_TYPE";
    const DOMAIN_TDEVC_MAINPACK = "MAINPACK";

    /** Each record in check table has any no. of dependent records. */
    const DOMAINVALUE_CARD_CN = 'CN';

    /** Each record in check table has max. of one dependent record */
    const DOMAINVALUE_CARD_C = 'C';

    /** Each record in check table has at least one dependent record */
    const DOMAINVALUE_CARD_N = 'N';

    /** Each record in check table has exactly one dependent record */
    const DOMAINVALUE_CARD_1 = '1';
    const DOMAINVALUE_MP_OBJTYPE_M = "M";            // Menu
    const DOMAINVALUE_MP_OBJTYPE_F = "F";            // Function
    const DOMAINVALUE_MP_OBJTYPE_T = "T";            // Title
    const DOMAINVALUE_MP_OBJTYPE_A = "A";            // Menu Bar
    const DOMAINVALUE_MP_OBJTYPE_P = "P";            // Function Key Setting
    const DOMAINVALUE_MP_OBJTYPE_B = "B";            // Pushbutton settings
    const DOMAINVALUE_MP_OBJTYPE_C = "C";            // Status
    const DOMAINVALUE_SUBC_F = "F";                  // Function group
    const DOMAINVALUE_TABCLASS_TRANSP = "TRANSP";    // Transparent table
    const DOMAINVALUE_TABCLASS_CLUSTER = "CLUSTER";  // Cluster table
    const DOMAINVALUE_TABCLASS_POOL = "POOL";        // Pooled table
    const DOMAINVALUE_TABCLASS_VIEW = "VIEW";        // General view structure
    const DOMAINVALUE_VIEWGRANT_R = 'R';
    const DOMAINVALUE_VIEWGRANT_U = 'U';
    const DOMAINVALUE_VIEWGRANT_M = 'M';
    const DOMAINVALUE_VIEWGRANT_SPACE = ' ';
    const DOMAINVALUE_VIEWGRANT_R_DESC = 'read only';
    const DOMAINVALUE_VIEWGRANT_U_DESC = 'read and change';
    const DOMAINVALUE_VIEWGRANT_M_DESC = "Time-dependent views: like U, validity data like ' '";
    const DOMAINVALUE_VIEWGRANT_SPACE_DESC = 'read, change, delete and insert';

    /* Table values */
    const CUS_ACTH_ACT_TYPE_C = 'C';           // IMG Activity Type - Customizing Object
    const CUS_ACTH_ACT_TYPE_E = 'E';           // IMG Activity Type - Business Add-In - Definition
    const CUS_ACTH_ACT_TYPE_I = 'I';           // IMG Activity Type - Business Add-In - Implementation
    const DD02L_TABCLASS_TRANSP = "TRANSP";
    const DD02L_TABCLASS_CLUSTER = "CLUSTER";
    const DD02L_TABCLASS_POOL = "POOL";
    const DOKHL_ID_DE = 'DE';                  // Document class: Data element
    const DOKHL_ID_DZ = 'DZ';                  // Document class: Data element supplement
    const DOKHL_ID_HY = 'HY';                  // Document class: Implementation Guide chapter (SIMG)
    const DOKHL_ID_NA = 'NA';                  // Document class: T100 Message
    const FUNCT_KIND_P = "P";
    const FUPARAREF_PARAMTYPE_I = "I";         // Importing
    const FUPARAREF_PARAMTYPE_E = "E";         // Exporting
    const FUPARAREF_PARAMTYPE_C = "C";         // Changing
    const FUPARAREF_PARAMTYPE_T = "T";         // Tables
    const FUPARAREF_PARAMTYPE_X = "X";         // Exception
    const TFDIR_FMODE_SPACE = " ";             // Type of function module - Normal Function Module.
    const TFDIR_FMODE_AT = "@";
    const TFDIR_FMODE_J = "J";                 // Type of function module - JAVA Module Callable from ABAP.
    const TFDIR_FMODE_K = "K";                 // Type of function module - Remote-Enabled JAVA Module.
    const TFDIR_FMODE_L = "L";                 // Type of function module - Module Callable from JAVA.
    const TFDIR_FMODE_R = "R";                 // Type of function module - Remote-Enabled Module.
    const TFDIR_FMODE_X = "X";                 // Type of function module - Remote-Enabled Module & BaseXML supported.
    const TFDIR_UTASK_1 = "1";                 // Update module - Start immediately.
    const TFDIR_UTASK_2 = "2";                 // Update module - Immediate Start, No Restart.
    const TFDIR_UTASK_3 = "3";                 // Update module - Start Delayed.
    const TFDIR_UTASK_4 = "4";                 // Update module - Coll.run.
    const TSTCC_S_WEBGUI_1 = "1";
    const TSTCC_S_WEBGUI_2 = "2";

    public static function SQL_LIMIT(int $page): string {
        $left = ((($page < 1) ? 1 : $page) - 1) * self::MAX_ROWS_LIMIT;
        return ' LIMIT ' . $left . ', ' . self::MAX_ROWS_LIMIT;
    }

    public static function SQL_LIMIT_SMALL(int $page): string {
        $left = ((($page < 1) ? 1 : $page) - 1) * self::MAX_ROWS_LIMIT_SMALL;
        return ' LIMIT ' . $left . ', ' . self::MAX_ROWS_LIMIT_SMALL;
    }
    
}

/** Database table names. */
class ABAP_DB_TABLE {

    /**
     * ATAB plagiarism, Table pool.
     *
     * @deprecated Replaced by {@link #YTAPLT} and {@link #YTDDAT}.
     */
    const ATAB = "atab";

    /**
     * Program Application Long Texts.
     *
     * @see #ATAB
     * @deprecated Replaced by {@link #YTAPLT}
     */
    const ATAB_TAPLT = "taplt";

    /**
     * Maintenance Areas for Tables.
     *
     * @see #ATAB
     * @deprecated Replaced by {@link #YTDDAT}
     */
    const ATAB_TDDAT = "tddat";

    /**
     * Customizing Activity - Assigned Enhancement Object.
     */
    const CUS_ACTEXT = "cus_actext";

    /**
     * Table use in programs. Table for Use Report and Tables.
     */
    const D010TAB = "d010tab";

    /**
     * Where-Used Table for ABAP INCLUDEs.
     */
    const D010INC = "d010inc";

    /**
     * Documentation - text lines.
     *
     * @deprecated Replaced by {@link #YDOKTL}
     * @see #YDOKTL
     */
    const DOKTL = "doktl";

    /**
     * Switch.
     */
    const SFW_SWITCH = "sfw_switch";

    /**
     * SWitch text.
     */
    const SFW_SWITCHT = "sfw_switcht";

    /**
     * Node Table for General Structure Storage.
     */
    const TMENU01 = "tmenu01";

    /**
     * General Structure Storage References.
     */
    const TMENU01R = "tmenu01r";

    /**
     * General Structure Storage Node Names.
     */
    const TMENU01T = "tmenu01t";

    /**
     * Assignment of SFW Switches to Hierarchy Tool Nodes.
     */
    const TTREE_SFW_NODES = "ttree_sfw_nodes";

    /**
     * Documentation - text lines.
     *
     * @see #DOKTL
     */
    const YDOKTL = "ydoktl";

    /**
     * Extracted string of the source code of database table {@link #REPOSRC}.
     *
     * @see #REPOSRC
     */
    const YREPOSRCDATA = "yreposrcdata";

    /** Database connection. */
    private static $conn_abap = null;
    private static $conn_abapana = null;

    /**
     * Get a new Database connection for 'abap' schema.
     *
     * @return mixed PDO Database Connection
     */
    private static function get_conn_abap() {
        if (self::$conn_abap == null) {
            $dsn = 'mysql:host=' . ABAP_DB_CONFIG::host
                    . ';dbname=' . ABAP_DB_CONFIG::schema_abap;
            self::$conn_abap = new PDO($dsn, ABAP_DB_CONFIG::user, ABAP_DB_CONFIG::pass, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => TRUE,
            ));
            // ABAP_DB_TABLE::$conn_abap->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE); 
        }

        return self::$conn_abap;
    }

    /**
     * Get a new Database connection for 'abapanalytics' schema.
     *
     * @return mixed PDO Database Connection
     */
    private static function get_conn_abapana() {
        if (self::$conn_abapana == null) {
            $dsn = 'mysql:host=' . ABAP_DB_CONFIG::host
                    . ';dbname=' . ABAP_DB_CONFIG::schema_abap;
            self::$conn_abapana = new PDO($dsn, ABAP_DB_CONFIG::user, ABAP_DB_CONFIG::pass, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => TRUE,
            ));
            // ABAP_DB_TABLE::$conn_abapana->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE); 
        }

        return self::$conn_abapana;
    }

    /**
     * Close the database connection(s).
     */
    public static function close_conn() {
        ABAP_DB_TABLE::$conn_abap = null;
        ABAP_DB_TABLE::$conn_abapana = null;
    }

    /**
     * Run an Select statement.
     */
    public static function select(string $sql, $paras = null): array {
        $conn = ABAP_DB_TABLE::get_conn_abap();
        $stmt = $conn->prepare($sql);
        $stmt->execute($paras);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }

    /**
     * Select with 1 filter only.
     *
     * <pre>
     * SELECT * FROM table WHERE OBJID_COLUMN = :id
     * </pre>
     */
    public static function select_1filter(string $sql, $id): array {
        $paras = array(
            'id' => $id,
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Select one single record.
     */
    public static function select_single(string $sql, $id) {
        return current(ABAP_DB_TABLE::select_1filter($sql, $id));
    }

    /**
     * Get Object Desription.
     * Note: the SQL script should rename the description column as 'DESCR', and the language column as 'lg'.
     *
     * <pre>
     * SELECT TEXT_COLUMN as DESCR
     *   FROM texttable
     *   WHERE OBJID_COLUMN1 = :id1
     *     AND OBJID_COLUMN2 = :id2
     *     AND OBJID_COLUMN2 = :id2
     *     AND LANGUAGE_COLUMN :lg
     * </pre>
     */
    public static function descr(string $sql, $paras) : string {
        $record = current(ABAP_DB_TABLE::select($sql, $paras));
        $text = is_array($record) ? $record[ABAP_DB_CONST::COLUMN_V_DESCR] : '';
        // If we cannot find the text in logon language, then use English
        if (empty($text)) {
            $paras['lg'] = ABAP_DB_CONST::LANGU_EN;
            $record = current(ABAP_DB_TABLE::select($sql, $paras));
            $text = is_array($record) ? $record[ABAP_DB_CONST::COLUMN_V_DESCR] : '';
        }
        // If we cannot find the text in English, then use Germany
        if (empty($text)) {
            $paras['lg'] = ABAP_DB_CONST::LANGU_DE;
            $record = current(ABAP_DB_TABLE::select($sql, $paras));
            $text = is_array($record) ? $record[ABAP_DB_CONST::COLUMN_V_DESCR] : '';
        }

        // If we cannot find the text, say the database do not has the record - example: DD02T/(TABNAME='CI_EEW_BUT000')
        // We return an empety string
        if (empty($text)) {
            $text = '';
        }
        
        return $text;
    }

    /**
     * Get Object Desription.
     * First we try to load the description in session language,
     * in case not found we will load in English language.
     *
     * <pre>
     * SELECT TEXT_COLUMN as DESCR
     *   FROM texttable
     *   WHERE OBJID_COLUMN = :id AND LANGUAGE_COLUMN :lg
     * </pre>
     */
    public static function descr_1filter(string $sql, $objId) {
        if (strlen(trim($objId)) < 1) {
            return '';
        }
        $paras = array(
            'id' => $objId,
            'lg' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]
        );
        return ABAP_DB_TABLE::descr($sql, $paras);
    }

}


/** Database table access for - SPRO - Customizing - Edit Project. */
class ABAP_DB_TABLE_CUS0 {

    const TNODEIMG_NODE_TYPE_REF = 'REF';
    const TNODEIMG_NODE_TYPE_IMG = 'IMG';
    const TNODEIMG_NODE_TYPE_IMG0 = 'IMG0';
    const TNODEIMG_NODE_TYPE_IMG1 = 'IMG1';

    /**
     * Customizing Activity - Object List.
     */
    const CUS_ACTOBJ = "cus_actobj";

    /**
     * Customizing Activity - Object List.
     */
    const CUS_ACTOBT = "cus_actobt";

    /**
     * Customizing Activity - Header Data.
     */
    const CUS_ACTH = "cus_acth";

    /**
     * Customizing Activity Text Table.
     */
    const CUS_ACTT = "cus_actt";

    /**
     * Country Assignment for Activities.
     */
    const CUS_ATRCOU = 'cus_atrcou';

    /**
     * Customizing Attributes - Header Data.
     */
    const CUS_ATRH = "cus_atrh";

    /**
     * Text Table for Customizing Attributes.
     */
    const CUS_ATRT = "cus_atrt";

    /**
     * IMG Activities.
     */
    const CUS_IMGACH = "cus_imgach";
    const CUS_IMGACH_TCODE_DTEL = "TCODE";

    /**
     * Text Table for IMG Activity.
     */
    const CUS_IMGACT = "cus_imgact";

    /**
     * Countries.
     */
    const T005 = "t005";

    /**
     * Country Names.
     */
    const T005T = "t005t";

    /**
     * Assignment of functions to IMG chapters.
     */
    const TFM18 = "tfm18";

    /**
     * Node table for the new IMG.
     */
    const TNODEIMG = "tnodeimg";

    /**
     * References for the new IMG.
     */
    const TNODEIMGR = "tnodeimgr";

    /**
     * General Structure Storage Node Names.
     */
    const TNODEIMGT = "tnodeimgt";

    /**
     * Entity table for Roadmap nodes.
     */
    const TROADMAP = "troadmap";

    /**
     * Text table for Roadmap nodes.
     */
    const TROADMAPT = "troadmapt";

    /**
     * Parsed HTML document.
     */
    const YDOK_HY = "ydok_hy";

    /**
     * Customizing Activity - Header Data.
     */
    public static function CUS_ACTH(string $act_id) {
        $sql = 'select * from ' . self::CUS_ACTH
                . ' where `act_id` = :id';
        return ABAP_DB_TABLE::select_single($sql, $act_id);
    }

    /**
     * Customizing Activity Text Table.
     */
    public static function CUS_ACTT(string $act_id) {
        $sql = 'select TEXT as ' . ABAP_DB_CONST::COLUMN_V_DESCR
                . ' from ' . ABAP_DB_TABLE_CUS0::CUS_ACTT
                . ' where `act_id` = :id and spras = :lg';
        return ABAP_DB_TABLE::descr_1filter($sql, $act_id);
    }

    public static function CUS_ACTOBJ(string $act_id) {
        $sql = 'select * from ' . ABAP_DB_TABLE_CUS0::CUS_ACTOBJ
                . ' where `act_id` = :id order by IMG_POS';
        return ABAP_DB_TABLE::select_1filter($sql, $act_id);
    }

    public static function CUS_ACTOBT(array $actobj) {
        $sql = 'select TEXT as ' . ABAP_DB_CONST::COLUMN_V_DESCR
                . ' from ' . ABAP_DB_TABLE_CUS0::CUS_ACTOBT
                . ' where `act_id` = :id'
                . ' and objecttype = :objtype'
                . ' and objectname = :objname'
                . ' and tcode = :tcode'
                . ' and subobjname = :subobjname'
                . ' and spras = :lg';
        $paras = array(
            'id' => $actobj['ACT_ID'],
            'objtype' => $actobj['OBJECTTYPE'],
            'objname' => $actobj['OBJECTNAME'],
            'tcode' => $actobj['TCODE'],
            'subobjname' => $actobj['SUBOBJNAME'],
            'lg' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]
        );
        return ABAP_DB_TABLE::descr($sql, $paras);
    }

    /**
     * Country Assignment for Activities.
     */
    public static function CUS_ATRCOU(string $attr_id) {
        $sql = 'select * from ' . self::CUS_ATRCOU
                . ' where `attr_id` = :id';
        return ABAP_DB_TABLE::select_1filter($sql, $attr_id);
    }

    public static function CUS_ATRH(string $attr_id) {
        $sql = 'select * from ' . self::CUS_ATRH
                . ' where `attr_id` = :id';
        return ABAP_DB_TABLE::select_single($sql, $attr_id);
    }

    public static function CUS_ATRT(string $attr_id) {
        $sql = 'select TEXT as ' . ABAP_DB_CONST::COLUMN_V_DESCR
                . ' from ' . self::CUS_ATRT
                . ' where `attr_id` = :id and spras = :lg';
        return ABAP_DB_TABLE::descr_1filter($sql, $attr_id);
    }

    public static function CUS_IMGACH_List($index, int $index_page) {
        $sql = 'select * from ' . self::CUS_IMGACH
                . ' where activity like :id'
                . ' order by activity'
                . ABAP_DB_CONST::SQL_LIMIT($index_page);
        $index = ($index == '_') ? '\_' : $index;
        return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
    }

    public static function CUS_IMGACH_Sitemap(): array {
        $sql = 'select ACTIVITY from ' . self::CUS_IMGACH
                . ' order by activity';
        return ABAP_DB_TABLE::select($sql);
    }

    public static function CUS_IMGACH($activity) {
        $sql = 'select * from ' . self::CUS_IMGACH
                . ' where `activity` = :id';
        return ABAP_DB_TABLE::select_single($sql, $activity);
    }

    public static function CUS_IMGACT($activity) {
        $sql = 'select TEXT as ' . ABAP_DB_CONST::COLUMN_V_DESCR
                . ' from ' . self::CUS_IMGACT
                . ' where `activity` = :id and spras = :lg';
        return ABAP_DB_TABLE::descr_1filter($sql, $activity);
    }

    /**
     * Get country name.
     */
    public static function T005T($land1) {
        $sql = 'select LANDX as ' . ABAP_DB_CONST::COLUMN_V_DESCR
                . ' from ' . self::T005T
                . ' where `land1` = :id and spras = :lg';
        return ABAP_DB_TABLE::descr_1filter($sql, $land1);
    }

    public static function TFM18($dok_class, $dok_name) {
        $sql = 'select * from ' . self::TFM18
                . ' where dokclass = :clas and dokname = :name';
        $paras = array(
            'clas' => $dok_class,
            'name' => $dok_name
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Load TNODEIMG based on node_id.
     *
     * @return array Result list, could be empty
     */
    public static function TNODEIMG_NODE_ID($node_id) {
        $sql = 'select * from ' . self::TNODEIMG
                . ' where `node_id` = :id';
        return ABAP_DB_TABLE::select_single($sql, $node_id);
    }

    /**
     * Load TNODEIMG based on parent_id.
     *
     * @return array Result list, could be empty
     */
    public static function TNODEIMG_PARENT_ID($parent_id) {
        $sql = 'select * from ' . self::TNODEIMG
                . ' where `parent_id` = :id order by node_type';
        return ABAP_DB_TABLE::select_1filter($sql, $parent_id);
        //return ABAP_DB_TABLE::select_single($sql, $parent_id);
    }

    /**
     * Load TNODEIMG based on tree_id.
     *
     * @return array Result list, could be empty
     */
    public static function TNODEIMG_TREE_ID($tree_id) {
        $sql = 'select * from ' . self::TNODEIMG
                . ' where `tree_id` = :id';
        return ABAP_DB_TABLE::select_single($sql, $tree_id);
    }

    /**
     * Load TNODEIMG based on tree_id.
     *
     * @return array Result list, could be empty
     */
    public static function TNODEIMG_TREE_NODE_ID($tree_id, $node_id) {
        $sql = 'select * from ' . self::TNODEIMG
                . ' where `tree_id` = :tid and `node_id` <> :nid order by node_type';
        $paras = array(
            'tid' => $tree_id,
            'nid' => $node_id
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    public static function TNODEIMGR($node_id) {
        $sql = "select * from " . self::TNODEIMGR
                . " where `node_id` = :id and ref_type = 'COBJ'";
        return ABAP_DB_TABLE::select_single($sql, $node_id);
    }

    public static function TNODEIMGT($node_id) {
        $sql = 'select TEXT as ' . ABAP_DB_CONST::COLUMN_V_DESCR
                . ' from ' . self::TNODEIMGT
                . ' where `node_id` = :id and spras = :lg';
        return ABAP_DB_TABLE::descr_1filter($sql, $node_id);
    }

    public static function TROADMAPT($roadmap_id) {
        $sql = 'select TEXT as ' . ABAP_DB_CONST::COLUMN_V_DESCR
                . ' from ' . self::TROADMAPT
                . ' where `roadmap_id` = :id and spras = :lg';
        return ABAP_DB_TABLE::descr_1filter($sql, $roadmap_id);
    }

    public static function YDOK_HY($object) {
        $sql = "select HTMLTEXT as " . ABAP_DB_CONST::COLUMN_V_DESCR
                . " from " . self::YDOK_HY
                . " where `id` = '" . ABAP_DB_CONST::DOKHL_ID_HY
                . "' and object = :id and langu = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, $object);
    }

}

/** Database table names - domain. */
class ABAP_DB_TABLE_DOMA {

    /**
     * Domains.
     */
    const DD01L = "dd01l";
    const DD01L_DOMNAME_DTEL = "DOMNAME";
    const DD01L_DATATYPE_DTEL = "DATATYPE_D";
    const DD01L_LENG_DTEL = "DDLENG";
    const DD01L_DECIMALS_DTEL = "DECIMALS";

    /**
     * R/3 DD: domain texts.
     */
    const DD01T = "dd01t";
    const DD01T_DDTEXT_DTEL = "AS4TEXT";

    /**
     * R/3 DD: values for the domains.
     */
    const DD07L = "dd07l";

    /**
     * DD: Texts for Domain Fixed Values (Language-Dependent).
     */
    const DD07T = "dd07t";
    const DD07T_DDTEXT_DTEL = "VAL_TEXT";

    /**
     * Domain List.
     * <pre>
     * SELECT * FROM dd01l where DOMNAME LIKE 'A%' order by DOMNAME
     * </pre>
     */
    public static function DD01L_List(string $index, int $index_page = 1) {
        $sql = "SELECT DOMNAME, DATATYPE, LENG, DECIMALS, AS4DATE FROM "
                . self::DD01L
                . " where DOMNAME LIKE :id"
                . " order by DOMNAME"
                . ABAP_DB_CONST::SQL_LIMIT($index_page);
        return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
    }

    /**
     * DD01L Site Map.
     * <pre>
     * SELECT DOMNAME FROM abapdoma.dd01l where DOMNAME not like 'Y%' and DOMNAME not like 'Z%'
     * </pre>
     */
    public static function DD01L_Sitemap(): array {
        $sql = "select DOMNAME from " . self::DD01L
                . " where DOMNAME not like 'Y%' and DOMNAME not like 'Z%'";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Domain.
     */
    public static function DD01L(string $DomName) {
        $sql = "SELECT * FROM " . self::DD01L
                . " where DOMNAME = :id";
        return ABAP_DB_TABLE::select_single($sql, $DomName);
    }

    /**
     * Domain text.
     */
    public static function DD01T(string $Domain) {
        $sql = "select DDTEXT as " . ABAP_DB_CONST::COLUMN_V_DESCR
                . " from " . self::DD01T
                . " where DOMNAME = :id and DDLANGUAGE = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, $Domain);
    }

    /**
     * Domain value list.
     * <pre>
     * SELECT * FROM abapdoma.dd07l where DOMNAME = 'DATATYPE' ORDER BY valpos;
     * </pre>
     */
    public static function DD07L(string $Domain) {
        $sql = "SELECT * FROM " . self::DD07L
                . " where DOMNAME = :id order by valpos";
        return ABAP_DB_TABLE::select_1filter($sql, $Domain);
    }

    /**
     * Get Domain Value Text.
     */
    public static function DD07T(string $Domain, $ValueL) {
        $sql = "select DDTEXT  from " . self::DD07T
                . " where DOMNAME = :domain and DDLANGUAGE = :langu and DOMVALUE_L = :domval";
        $paras = array(
            'domain' => $Domain,
            'domval' => $ValueL,
            'langu' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU],
        );
        $record = current(ABAP_DB_TABLE::select($sql, $paras));
        $text = $record['DDTEXT'];
        if (empty($text)) {
            unset($paras);
            $paras = array(
                'domain' => $Domain,
                'domval' => $ValueL,
                'langu' => ABAP_DB_CONST::LANGU_EN,
            );
            $record = current(ABAP_DB_TABLE::select($sql, $paras));
            $text = $record['DDTEXT'];
        }
        return $text;
    }

}

/** Database table names - data element. */
class ABAP_DB_TABLE_DTEL {

    /**
     * Data elements.
     */
    const DD04L = "dd04l";
    const DD04L_ROLLNAME_DTEL = "ROLLNAME";
    const DD04L_DOMNAME_DTEL = "DOMNAME";
    const DD04L_DATATYPE_DTEL = "DATATYPE_D";

    /**
     * R/3 DD: Data element texts.
     */
    const DD04T = "dd04t";
    const DD04T_DDTEXT_DTEL = "AS4TEXT";

    /**
     * Extracted document.
     */
    const YDOK_DEDZ = "ydok_dedz";

    /**
     * Data Element List.
     * <pre>
     * SELECT * FROM dd04l where ROLLNAME LIKE 'A%' order by ROLLNAME
     * SELECT ROLLNAME, DOMNAME, DATATYPE, LENG, AS4DATE FROM dd04l
     *     where ROLLNAME LIKE 'A%' order by ROLLNAME
     * </pre>
     */
    public static function DD04L_List($index, int $index_page = 1) {
        $sql = "SELECT ROLLNAME, DOMNAME, DATATYPE, LENG, AS4DATE FROM " . self::DD04L
                . " where ROLLNAME LIKE :id"
                . " order by ROLLNAME"
                . ABAP_DB_CONST::SQL_LIMIT($index_page);
        return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
    }

    /**
     * DD01L Site Map.
     * <pre>
     * SELECT ROLLNAME FROM abapdtel.dd04l where ROLLNAME not like 'Y%' and ROLLNAME not like 'Z%'
     * </pre>
     */
    public static function DD04L_Sitemap() {
        $sql = "select ROLLNAME from " . self::DD04L
                . " where ROLLNAME not like 'Y%' and ROLLNAME not like 'Z%'";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Data Element.
     */
    public static function DD04L($Rollname) {
        $sql = "SELECT * FROM " . self::DD04L
                . " where ROLLNAME = :id";
        return ABAP_DB_TABLE::select_single($sql, $Rollname);
    }

    /**
     * Where Used List for Domain.
     */
    public static function DD04L_DOMNAME($domain) {
        // No Order By - for performance issue
        $sql = "select ROLLNAME FROM " . self::DD04L
                . " where DOMNAME = :id limit "
                . ABAP_DB_CONST::USED_BY_LIMIT_DOMA;
        return ABAP_DB_TABLE::select_1filter($sql, strtoupper($domain));
    }

    /**
     * Data Element text.
     * <pre>
     * SELECT DDTEXT FROM dd04t where ROLLNAME = 'BUKRS' and DDLANGUAGE = 'E';
     * </pre>
     */
    public static function DD04T($Rollname) {
        $sql = "select DDTEXT as " . ABAP_DB_CONST::COLUMN_V_DESCR
                . " from " . self::DD04T
                . " where ROLLNAME = :id and DDLANGUAGE = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, $Rollname);
    }

    /**
     * Data Element text.
     * <pre>
     * SELECT * FROM dd04t where ROLLNAME = 'BUKRS' and DDLANGUAGE = 'E';
     * </pre>
     */
    public static function DD04T_ALL($Rollname) {
        $sql = "SELECT * FROM " . self::DD04T
                . " where ROLLNAME = :id and DDLANGUAGE = 'E'";
        return ABAP_DB_TABLE::select_single($sql, $Rollname);
    }

    public static function YDOK_DE($object) {
        $sql = "select HTMLTEXT as DESCR from " . self::YDOK_DEDZ
                . " where `id` = '" . ABAP_DB_CONST::DOKHL_ID_DE
                . "' and object = :id and langu = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, $object);
    }

    public static function YDOK_DZ($object) {
        $sql = "select * from " . self::YDOK_DEDZ
                . " where `id` = '" . ABAP_DB_CONST::DOKHL_ID_DZ
                . "' and object like :object and langu = :langu";
        $paras = array(
            'object' => $object . '%',
            'langu' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]
        );
        $result = ABAP_DB_TABLE::select($sql, $paras);
        if (empty(array_filter($result))) {
            unset($paras);
            $paras = array(
                'object' => $object . '%',
                'langu' => ABAP_DB_CONST::LANGU_EN
            );
            $result = ABAP_DB_TABLE::select($sql, $paras);
        }
        return $result;
    }

}

/** Database table names - function module. */
class ABAP_DB_TABLE_FUNC {

    /**
     * Additional Attributes for Function Modules.
     */
    const ENLFDIR = "enlfdir";

    /**
     * Function Module Short Texts.
     */
    const FUNCT = "funct";

    /**
     * Parameters of function modules.
     */
    const FUPARAREF = "fupararef";

    /**
     * Function Module.
     */
    const TFDIR = "tfdir";
    const TFDIR_FMODE_RFC = 'RFC';
    const TFDIR_FUNCNAME_DTEL = "RS38L_FNAM";

    /**
     * Function Module Short Text.
     */
    const TFTIT = "tftit";
    const TFTIT_STEXT_DTEL = "RS38L_FTXT";

    /**
     * Function Groups.
     */
    const TLIBG = "TLIBG";
    const TLIBG_AREA_DTEL = "RS38L_AREA";

    /**
     * Function Group Short Texts.
     */
    const TLIBT = "tlibt";

    /**
     * Function Module List.
     * <pre>
     * SELECT funcname, fmode FROM tfdir where funcname LIKE 'A%' order by funcname
     * </pre>
     */
    public static function TFDIR_List($index, int $index_page) {
        if (strcmp($index, self::TFDIR_FMODE_RFC) == 0) {
            $sql = "SELECT FUNCNAME, FMODE FROM " . self::TFDIR
                    . " where FMODE = 'R'"
                    . " order by funcname"
                    . ABAP_DB_CONST::SQL_LIMIT($index_page);
            return ABAP_DB_TABLE::select($sql);
        } else {
            // Avoid hacker
            if (strlen(trim($index)) > 1) {
                $index = ABAP_DB_CONST::INDEX_A;
            }

            $sql = "SELECT FUNCNAME, FMODE FROM " . self::TFDIR
                    . " where funcname LIKE :id"
                    . " order by funcname"
                    . ABAP_DB_CONST::SQL_LIMIT($index_page);
            $index = ($index == '_') ? '\_' : $index;
            return ABAP_DB_TABLE::select_1filter($sql, strtoupper($index . '%'));
        }
    }

    /**
     * DD01L Site Map.
     * <pre>
     * SELECT FUNCNAME FROM abapfunc.tfdir where FUNCNAME not like 'Y%' and FUNCNAME not like 'Z%'
     * </pre>
     */
    public static function TFDIR_Sitemap() {
        $sql = "select FUNCNAME from " . self::TFDIR
                . " where FUNCNAME not like 'Y%' and FUNCNAME not like 'Z%'";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Function Module text.
     */
    public static function TFTIT($fm) {
        $sql = "select STEXT as DESCR from " . self::TFTIT
                . " where FUNCNAME = :id and SPRAS = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, $fm);
    }

    /**
     * Function Group text.
     * <pre>
     * SELECT AREAT FROM abapfunc.tlibt where area = 'FMCA_INCORR_BOR' and spras = 'E'
     * </pre>
     */
    public static function TLIBT($fg) {
        $sql = "select AREAT as DESCR from " . self::TLIBT
                . " where area = :id and SPRAS = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, $fg);
    }

    /**
     * Generate the include file name of current function module. <p>ABAP is
     * trying to load the include file from the ABAP source code of the
     * corresponding function group file L+FunctionGroup+UXX. </p> <p>Refer to
     * the ABAP code class CL_FUNCTION_BUILDER_DATA method GET_INCLUDE. </p> <p>
     * We have no place to find the source code of the UXX file. So we just
     * generate the file based on the following pattern:</p>
     * <pre>
     * Function Module name: RFC_READ_TABLE  /BEV1/EM0_LEERGUT_VERBUCHER
     * Function Group name : SDTX            /BEV1/EM0
     * INCLUDE name        : LSDTXU01        /BEV1/LEM0U04
     * Program nmae        : SAPLSDTX        /BEV1/SAPLEM0
     * </pre>
     * <pre>
     * Function Group name : [FG]            [NameSpace]EM0
     * INCLUDE name        : L[FG]U[01]      [NameSpace]L[FG]U[04]
     * </pre>
     *
     * @param fg Function Group name
     * @param seq Sequence number of the include file
     */
    public static function GET_INCLUDE($fg, $seq) {
        // TODO - To be fixed - namsapce is just the first 2 '/'
        $pos1 = strpos($fg, "/");
        if ($pos1 === false) { // note: three equal signs
            // not found...
            return 'L' . $fg . 'U' . $seq;
        } else {
            $pos2 = strpos($fg, "/", 1);  // Get the 2nd position
            $fg_left = substr($fg, 0, $pos2 + 1);
            $fg_right = substr($fg, $pos2 + 1);
            return $fg_left . 'L' . $fg_right . 'U' . $seq;
        }
    }

    /**
     * Function Module Attributes.
     * <pre>
     * SELECT * FROM tfdir WHERE funcname = 'RFC_READ_TABLE'
     * </pre>
     */
    public static function TFDIR($fm) {
        $sql = "SELECT * FROM " . self::TFDIR . " WHERE funcname = :id";
        return ABAP_DB_TABLE::select_single($sql, $fm);
    }

    /**
     * Calculate function module processing type.
     */
    public static function TFDIR_PTYPE($fmode, $utask) {
        $ptype = new ABAP_UI_TFDIR_ProcessingType();

        switch ($fmode) {
            case ABAP_DB_CONST::TFDIR_FMODE_SPACE:
                $ptype->CHK_NORMAL = TRUE;
                $ptype->CHK_UKIND1 = TRUE;
                break;
            case ABAP_DB_CONST::TFDIR_FMODE_J:
                $ptype->CHK_ABAP2JAVA = TRUE;
                break;
            case ABAP_DB_CONST::TFDIR_FMODE_K:
                $ptype->CHK_REMOTE_JAVA = TRUE;
                break;
            case ABAP_DB_CONST::TFDIR_FMODE_L:
            case ABAP_DB_CONST::TFDIR_FMODE_AT:
                $ptype->CHK_JAVA2ABAP = TRUE;
                break;
            case ABAP_DB_CONST::TFDIR_FMODE_R:
                $ptype->CHK_REMOTE = TRUE;
                $ptype->CHK_UKIND1 = TRUE;
                break;
            case ABAP_DB_CONST::TFDIR_FMODE_X:
                $ptype->CHK_REMOTE = TRUE;
                $ptype->CHK_BASXML_ENABLED = TRUE;
                break;
        }
        switch ($utask) {
            case ABAP_DB_CONST::TFDIR_UTASK_1:
                $ptype->CHK_VERBUCHER = TRUE;
                $ptype->CHK_UKIND1 = TRUE;
                break;
            case ABAP_DB_CONST::TFDIR_UTASK_2:
                $ptype->CHK_VERBUCHER = TRUE;
                $ptype->CHK_UKIND2 = TRUE;
                break;
            case ABAP_DB_CONST::TFDIR_UTASK_3:
                $ptype->CHK_VERBUCHER = TRUE;
                $ptype->CHK_UKIND3 = TRUE;
                break;
            case ABAP_DB_CONST::TFDIR_UTASK_4:
                $ptype->CHK_VERBUCHER = TRUE;
                $ptype->CHK_UKIND4 = TRUE;
                break;
        }

        return $ptype;
    }

    /**
     * List function modules in an program (function group).
     * <pre>
     * SELECT INCLUDE, FUNCNAME, FMODE FROM abap.tfdir
     * WHERE PNAME = '/1BCDWBEN/SAPL/BDL/EN0000' ORDER BY INCLUDE;
     * </pre>
     */
    public static function TFDIR_PGMNA($prog) {
        $sql = "SELECT INCLUDE, FUNCNAME, FMODE FROM " . self::TFDIR
                . " where PNAME = :id order by INCLUDE";
        return ABAP_DB_TABLE::select_1filter($sql, $prog);
    }

    /**
     * Additional Attributes for Function Modules.
     * <pre>
     * SELECT * FROM abapfunc.enlfdir where funcname = 'RFC_READ_TABLE'
     * </pre>
     */
    public static function ENLFDIR($fm) {
        $sql = "SELECT * FROM " . self::ENLFDIR . " WHERE funcname = :id";
        return ABAP_DB_TABLE::select_single($sql, $fm);
    }

    /**
     * Function Module parameters.
     * <pre>
     * SELECT * FROM abapfunc.fupararef where funcname = 'RFC_READ_TABLE' ORDER BY PARAMTYPE, PPOSITION;
     * </pre>
     */
    public static function FUPARAREF($fm) {
        $sql = "SELECT * FROM " . self::FUPARAREF
                . " where funcname = :id order by PARAMTYPE, PPOSITION";
        return ABAP_DB_TABLE::select_1filter($sql, $fm);
    }

    /**
     * Function Module parameters text.
     * <pre>
     * SELECT STEXT FROM abapfunc.funct_e
     *   where SPRAS = 'E' AND funcname = 'RFC_READ_TABLE' AND PARAMETER = 'DATA' AND KIND = 'P'
     * </pre>
     */
    public static function FUNCT($fm, $para, $kind) {
        if ($kind != ABAP_DB_CONST::FUPARAREF_PARAMTYPE_X) {
            $kind = ABAP_DB_CONST::FUNCT_KIND_P;
        }
        $sql = "select STEXT as DESCR from " . self::FUNCT         // Only English text in this table
                . " where SPRAS = :lg and funcname = :fname and PARAMETER = :param and KIND = :kind";
        $paras = array(
            'lg' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU],
            'fname' => $fm,
            'param' => $para,
            'kind' => $kind,
        );
        return ABAP_DB_TABLE::descr($sql, $paras);
    }

}

/** Database table names - hierarchy objects. */
class ABAP_DB_TABLE_HIER {

    /**
     * Release Status of Software Components in System.
     */
    const CVERS = "cvers";
    const CVERS_COMPONENT_DTEL = "DLVUNIT";
    const CVERS_COMP_TYPE_DTEL = "RELC_TYPE";

    /**
     * Reference Table for CVERS Entries.
     */
    const CVERS_REF = "cvers_ref";
    const CVERS_REF_DESC_TEXT_DTEL = "COMP_DESC";

    /**
     * Application Components.
     */
    const DF14L = "df14l";
    const DF14L_FCTR_ID_DTEL = "UFFCTR";
    const DF14L_PS_POSID_DTEL = "UFPS_POSID";
    const DF14L_FSTDATE_DTEL = "UDFDATE";

    /**
     * Business Application Component Names.
     */
    const DF14T = "df14t";

    /**
     * Language Key Texts.
     */
    const T002T = "t002t";

    /**
     * Directory of Repository Objects.
     */
    const TADIR = "tadir";
    const TADIR_DEVCLASS_DTEL = "DEVCLASS";
    const TADIR_PGMID_R3TR = "R3TR";

    /**
     * Packages.
     */
    const TDEVC = "tdevc";
    const TDEVC_DEVCLASS_DTEL = "DEVCLASS";

    /**
     * Texts for Packages.
     */
    const TDEVCT = "tdevct";
    const TDEVCT_CTEXT_DTEL = "AS4TEXT";

    /**
     * Software Component list.
     */
    public static function CVERS_List() {
        $sql = "select * from " . self::CVERS . " order by COMPONENT";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Software Component.
     */
    public static function CVERS($SoftComp) {
        $sql = "select * from " . self::CVERS . " where COMPONENT = :id";
        return ABAP_DB_TABLE::select_single($sql, $SoftComp);
    }

    /**
     * Software Component text.
     */
    public static function CVERS_REF($SoftComp) {
        $bufkey = GLOBAL_BUFFER::KEYPREFIX_DB . self::CVERS_REF . $SoftComp;
        $bufval = GLOBAL_BUFFER::Get($bufkey);
        if (GLOBAL_UTIL::IsEmpty($bufval)) {
            $sql = "select desc_text as DESCR from " . self::CVERS_REF
                    . " where COMPONENT = :id and LANGU = :lg";
            $bufval = ABAP_DB_TABLE::descr_1filter($sql, $SoftComp);
            // Set Buffer
            GLOBAL_BUFFER::Set($bufkey, $bufval);
        }

        return $bufval;
    }

    /**
     * BMFR Site Map.
     * <pre>
     * SELECT FCTR_ID FROM abaphier.df14l where FCTR_ID <> '';
     * </pre>
     */
    public static function DF14L_Sitemap() {
        $sql = "select FCTR_ID from " . self::DF14L
                . " where FCTR_ID <> ''";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Application Component list, by index.
     * <p>
     * Example SQL Statement:</p>
     * <pre>
     * SELECT * FROM df14l where PS_POSID not like '%s-%s' AND trim(coalesce(PS_POSID, '')) <>'' ORDER BY PS_POSID
     * SELECT * FROM df14l where PS_POSID like '%s%s' AND trim(coalesce(PS_POSID, '')) <>'' ORDER BY PS_POSID
     * </pre>
     */
    public static function DF14L_List($index, int $index_page) {
        if (ABAP_DB_CONST::INDEX_TOP == $index) {
            $sql = "select * from " . self::DF14L
                    . " where PS_POSID not like '%-%' AND trim(coalesce(PS_POSID, '')) <>'' ORDER BY PS_POSID";
            return ABAP_DB_TABLE::select($sql);
        } else {
            $sql = "select * from " . self::DF14L
                    . " where PS_POSID like :id"
                    . " AND trim(coalesce(PS_POSID, '')) <>''"
                    . " ORDER BY PS_POSID"
                    . ABAP_DB_CONST::SQL_LIMIT($index_page);
            return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
        }
    }

    /**
     * Application Component.
     */
    public static function DF14L($AppComp) {
        $sql = "select * from " . self::DF14L . " where FCTR_ID = :id";
        return ABAP_DB_TABLE::select_single($sql, $AppComp);
    }

    /**
     * Get application component list for one software component.
     * <p>
     * Example SQL Statement:</p>
     * a. with sub-query, low performance:
     * <pre>
     * select FCTR_ID, PS_POSID, (length(PS_POSID) - LENGTH(REPLACE(PS_POSID, '-', '')) + 1) AS LEVEL
     * from df14l where fctr_id in (
     *     select distinct COMPONENT from tdevc where dlvunit = 'SAP_BASIS'
     * ) AND trim(coalesce(PS_POSID, '')) <>'' order by PS_POSID
     * </pre>
     * b. without sub-query:
     * <pre>
     * select FCTR_ID, PS_POSID, (length(PS_POSID) - LENGTH(REPLACE(PS_POSID, '-', '')) + 1) AS LEVEL
     * from df14l where fctr_id = '/ISDFPS/PD10000011' AND trim(coalesce(PS_POSID, '')) <>''
     * order by PS_POSID
     * </pre>
     */
    public static function DF14L_ID_LEVEL($Fctr_id) {
        $sql = "select FCTR_ID, PS_POSID, (length(PS_POSID) - LENGTH(REPLACE(PS_POSID, '-', '')) + 1) AS LEVEL "
                . " from " . self::DF14L
                . " where fctr_id = :id AND trim(coalesce(PS_POSID, '')) <>'' order by PS_POSID ";
        return ABAP_DB_TABLE::select_1filter($sql, $Fctr_id);
    }

    public static function DF14L_ID($Fctr_id) {
        $sql = "select FCTR_ID, PS_POSID "
                . " from " . self::DF14L
                . " where fctr_id = :id AND trim(coalesce(PS_POSID, '')) <>'' order by PS_POSID ";
        return ABAP_DB_TABLE::select_1filter($sql, $Fctr_id);
    }

    /**
     * Application Component PS_POSID.
     */
    public static function DF14L_PS_POSID($fctr_id) {
        $sql = "select PS_POSID from " . self::DF14L . " where FCTR_ID = :id";
        $rec = ABAP_DB_TABLE::select_single($sql, $fctr_id);
        return $rec['PS_POSID'];
    }

    /**
     * Child Application Component.
     * <pre>
     * select FCTR_ID, PS_POSID from df14l
     * where PS_POSID LIKE 'BW-SYS%' and FCTR_ID <> 'ARS0000024'
     * order by PS_POSID
     * </pre>
     */
    public static function DF14L_Child($posid, $fctr) {
        $sql = "select FCTR_ID, PS_POSID from " . self::DF14L
                . " where PS_POSID LIKE :posid"
                . " and FCTR_ID <> :fctr order by PS_POSID";
        $paras = array(
            'posid' => $posid . '%',
            'fctr' => $fctr,
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Application Component text.
     */
    public static function DF14T($fctr) {
        $bufkey = GLOBAL_BUFFER::KEYPREFIX_DB . self::DF14T . strtoupper($fctr);
        $bufval = GLOBAL_BUFFER::Get($bufkey);
        if (GLOBAL_UTIL::IsEmpty($bufval)) {
            $sql = "select name as DESCR from " . self::DF14T
                    . " where FCTR_ID = :id and LANGU = :lg";
            $bufval = ABAP_DB_TABLE::descr_1filter($sql, strtoupper($fctr));
            // Set Buffer
            GLOBAL_BUFFER::Set($bufkey, $bufval);
        }
        return $bufval;
    }

    public static function Hier($Pgmid, $ObjType, $ObjName) {
        $hier = new ABAP_UI_Hierarchy();
        $tadir = self::TADIR($Pgmid, $ObjType, $ObjName);
        $hier->CRELEASE = $tadir['CRELEASE'];
        $hier->DEVCLASS = $tadir['DEVCLASS'];
        $hier->DEVCLASS_T = self::TDEVCT($hier->DEVCLASS);
        $tdevc = self::TDEVC($hier->DEVCLASS);
        $hier->DLVUNIT = $tdevc['DLVUNIT'];
        $hier->DLVUNIT_T = self::CVERS_REF($hier->DLVUNIT);
        if (strlen(trim($tdevc['COMPONENT'])) > 0) {
            self::HierAppComp($tdevc['COMPONENT'], $hier);
        } else if (strlen(trim($tdevc['PARENTCL'])) > 0) {
            $hier->PARENTCL1 = $tdevc['PARENTCL'];
            $hier->PARENTCL1_T = self::TDEVCT($hier->PARENTCL1);
            $tdevc_up1 = self::TDEVC($tdevc['PARENTCL']);
            if (strlen(trim($tdevc_up1['COMPONENT'])) > 0) {
                self::HierAppComp($tdevc_up1['COMPONENT'], $hier);
            } else if (strlen(trim($tdevc_up1['PARENTCL'])) > 0) {
                $hier->PARENTCL2 = $tdevc_up1['PARENTCL'];
                $hier->PARENTCL2_T = self::TDEVCT($hier->PARENTCL2);
                $tdevc_up2 = self::TDEVC($tdevc['PARENTCL']);
                if (strlen(trim($tdevc_up2['COMPONENT'])) > 0) {
                    self::HierAppComp($tdevc_up2['COMPONENT'], $hier);
                }
            }
        }

        return $hier;
    }

    /**
     * Update the Application Component information in hierarchy structure.
     */
    private static function HierAppComp($fctr, &$hier) {
        $df14l = self::DF14L($fctr);
        $hier->FCTR_ID = $df14l['FCTR_ID'];
        $hier->POSID = $df14l['PS_POSID'];
        $hier->POSID_T = self::DF14T($hier->FCTR_ID);
    }

    /**
     * ABAP Object directory.
     */
    public static function TADIR($Pgmid, $ObjType, $ObjName) {
        $sql = "select * from " . self::TADIR
                . " where pgmid = :pgmid"
                . " and object = :otype"
                . " and obj_name = :oname";
        $paras = array(
            'pgmid' => $Pgmid,
            'otype' => $ObjType,
            'oname' => $ObjName,
        );
        return current(ABAP_DB_TABLE::select($sql, $paras));
    }

    /**
     * Get contained object for one package.
     * <pre>
     * select OBJ_NAME from tadir where PGMID = 'R3TR' and OBJECT = 'TABL' AND DEVCLASS = '/AIN/ACTIVITIES'
     * </pre>
     */
    public static function TADIR_Child($Package, $Pgmid, $ObjType) {
        $sql = "select OBJ_NAME from " . self::TADIR
                . " where PGMID = :pgmid"
                . " and OBJECT = :otype"
                . " AND DEVCLASS = :pkage";
        $paras = array(
            'pgmid' => $Pgmid,
            'otype' => $ObjType,
            'pkage' => $Package,
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Get function group list.
     */
    public static function TADIR_FUGR_List($index, int $index_page) {
        $sql = "SELECT OBJ_NAME, DEVCLASS, COMPONENT FROM " . self::TADIR
                . " WHERE pgmid = 'R3TR' and object = 'FUGR' "
                . " and OBJ_NAME like :id"
                . " order by OBJ_NAME"
                . ABAP_DB_CONST::SQL_LIMIT($index_page);
        return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
    }

    /**
     * Function Group Site Map.
     */
    public static function TADIR_FUGR_Sitemap() {
        $sql = "select OBJ_NAME from " . self::TADIR
                . " WHERE pgmid = 'R3TR' and object = 'FUGR'"
                . " and OBJ_NAME <> ''"
                . " and OBJ_NAME not like 'Y%'"
                . " and OBJ_NAME not like 'Z%'"
                . " and OBJ_NAME not like '$%'"
                . " and OBJ_NAME not like '!%'"
                . " and OBJ_NAME not like ' %'"
                . " and OBJ_NAME not like '*%'"
                . " and OBJ_NAME not like '-%'"
                . " and OBJ_NAME not like '\%%' escape '\\\\'";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Get program list.
     * <pre>
     * SELECT OBJ_NAME, DEVCLASS, COMPONENT FROM abap.tadir
     *   where pgmid = 'R3TR' and object = 'PROG'
     *   and obj_name like 'A%'
     *   order by obj_name
     * </pre>
     */
    public static function TADIR_PROG_List($index, int $index_page) {
        $sql = "SELECT OBJ_NAME, DEVCLASS, COMPONENT FROM " . self::TADIR
                . " WHERE pgmid = 'R3TR' and object = 'PROG' "
                . " and OBJ_NAME like :id"
                . " order by OBJ_NAME"
                . ABAP_DB_CONST::SQL_LIMIT($index_page);
        $index = ($index == '_') ? '\_' : $index;
        return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
    }

    /**
     * Program Site Map.
     * <pre>
     * SELECT OBJ_NAME FROM abaphier.tadir
     *      WHERE pgmid = 'R3TR' and object = 'PROG'
     *      and OBJ_NAME <> ''
     *      and OBJ_NAME not like 'Y%'
     *      and OBJ_NAME not like 'Z%'
     *      and OBJ_NAME not like '$%'
     *      and OBJ_NAME not like '!%'
     *      and OBJ_NAME not like ' %'
     *      and OBJ_NAME not like '*%'
     *      and OBJ_NAME not like '-%'
     *      and OBJ_NAME not like '\%%' escape '\\'
     * </pre>
     */
    public static function TADIR_PROG_Sitemap() {
        $sql = "select OBJ_NAME from " . self::TADIR
                . " WHERE pgmid = 'R3TR' and object = 'PROG'"
                . " and OBJ_NAME <> ''"
                . " and OBJ_NAME not like 'Y%'"
                . " and OBJ_NAME not like 'Z%'"
                . " and OBJ_NAME not like '$%'"
                . " and OBJ_NAME not like '!%'"
                . " and OBJ_NAME not like ' %'"
                . " and OBJ_NAME not like '*%'"
                . " and OBJ_NAME not like '-%'"
                . " and OBJ_NAME not like '\%%' escape '\\\\'";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Package List, of an index.
     * <pre>
     * SELECT * FROM tdevc where DEVCLASS LIKE 'A%' order by devclass
     * </pre>
     */
    public static function TDEVC_List($index, int $index_page) {
        $sql = "select * from " . self::TDEVC
                . " where devclass like :id"
                . " order by devclass"
                . ABAP_DB_CONST::SQL_LIMIT($index_page);
        return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
    }

    /**
     * DEVC Site Map.
     * <pre>
     * SELECT DEVCLASS FROM abaphier.tdevc where devclass not like 'Y%' and devclass not like 'Z%' and devclass not like '$%'
     * </pre>
     */
    public static function TDEVC_Sitemap() {
        $sql = "select DEVCLASS from " . self::TDEVC
                . " where devclass not like 'Y%' and devclass not like 'Z%' and devclass not like '$%'";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Package.
     */
    public static function TDEVC($Package) {
        $sql = "select * from " . self::TDEVC
                . " where devclass = :id";
        return ABAP_DB_TABLE::select_single($sql, $Package);
    }

    /**
     * Application Component list for one software component.
     * <pre>
     * select distinct COMPONENT from tdevc where dlvunit = 'SAP_BASIS'
     * </pre>
     */
    public static function TDEVC_COMPONENT($SoftComp) {
        $sql = "select distinct COMPONENT from " . self::TDEVC
                . " where dlvunit = :id";
        return ABAP_DB_TABLE::select_1filter($sql, $SoftComp);
    }

    /**
     * Package list for one application component.
     * <pre>
     * select DEVCLASS from tdevc where COMPONENT = 'HLB0009110'
     * and devclass not like 'Y%' and devclass not like 'Z%'
     * </pre>
     */
    public static function TDEVC_DEVCLASS($AppComp) {
        $sql = "select DEVCLASS from " . self::TDEVC
                . " where COMPONENT = :id"
                . " and devclass not like 'Y%' and devclass not like 'Z%'";
        return ABAP_DB_TABLE::select_1filter($sql, $AppComp);
    }

    /**
     * Package text.
     */
    public static function TDEVCT($Package) {
        $sql = "select ctext as DESCR from " . self::TDEVCT
                . " where devclass = :id and spras = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, strtoupper($Package));
    }

}

/** Database table access - Message Class. */
class ABAP_DB_TABLE_MSAG {

    const T100 = "t100";                    // Messages
    const T100A = 't100a';                  // Message IDs for T100
    const T100A_ARBGB_DTEL = 'ARBGB';
    const T100T = 't100t';                  // Table T100A text
    const T100T_STEXT_DTEL = 'AS4TEXT';
    const T100U = 't100u';                  // Last person to change messages
    const T100U_SELFDEF_DOMAIN = 'DOKU_SELFD';
    const T100X = 't100x';                  // Error Messages: Supplements
    const YDOK_NA = 'ydok_na';              // Messages

    /**
     * Messages.
     */

    public static function T100($msgcls) {
        $sql = 'select * from ' . self::T100
                . ' where `ARBGB` = :id and SPRSL = :lg'
                . ' order by MSGNR';
        $paras = array(
            'id' => $msgcls,
            'lg' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    public static function T100_Sitemap() {
        $sql = "select concat(ARBGB, '-', MSGNR) as MSGNBR from " . self::T100
                . " where sprsl = '" . ABAP_DB_CONST::LANGU_EN . "'"
                . " order by ARBGB, MSGNR";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Message.
     */
    public static function T100_NR($msgcls, $msgnr) {
        $sql = 'select TEXT as DESCR from ' . self::T100
                . ' where `ARBGB` = :id and MSGNR = :nr and SPRSL = :lg';
        $paras = array(
            'id' => $msgcls,
            'nr' => $msgnr,
            'lg' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU],
        );
        return ABAP_DB_TABLE::descr($sql, $paras);
    }

    /**
     * Message classes.
     */
    public static function T100A_List($index, int $index_page) {
        $sql = 'select * from ' . self::T100A
                . ' where ARBGB like :id'
                . ' order by ARBGB'
                . ABAP_DB_CONST::SQL_LIMIT($index_page);
        return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
    }

    public static function T100A_Sitemap() {
        $sql = 'select ARBGB from ' . self::T100A
                . ' order by ARBGB';
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Message IDs for T100.
     */
    public static function T100A($msgcls) {
        $sql = 'select * from ' . self::T100A
                . ' where `ARBGB` = :id';
        return ABAP_DB_TABLE::select_single($sql, $msgcls);
    }

    /**
     * Table T100A text.
     */
    public static function T100T($msgcls) {
        $sql = 'select STEXT as DESCR from ' . self::T100T
                . ' where `ARBGB` = :id and SPRSL = :lg';
        return ABAP_DB_TABLE::descr_1filter($sql, strtoupper($msgcls));
    }

    /**
     * Object documentation status.
     */
    public static function T100U($msgcls, $msgnr) {
        $sql = 'select * from ' . self::T100U
                . ' where `ARBGB` = :id and `MSGNR` = :mr';
        $paras = array(
            'id' => $msgcls,
            'mr' => $msgnr,
        );
        return current(ABAP_DB_TABLE::select($sql, $paras));
    }

    /**
     * Error Messages: Supplements.
     */
    public static function T100X($msgcls, $msgnr) {
        $sql = 'select * from ' . self::T100X
                . ' where `ARBGB` = :id and `MSGNR` = :mr';
        $paras = array(
            'id' => $msgcls,
            'mr' => $msgnr,
        );
        return current(ABAP_DB_TABLE::select($sql, $paras));
    }

    public static function YDOK_NA($msgcls, $msgnr) {
        $sql = "select HTMLTEXT as DESCR from " . self::YDOK_NA
                . " where `id` = '" . ABAP_DB_CONST::DOKHL_ID_NA
                . "' and object = :id and langu = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, strtoupper($msgcls . $msgnr));
    }

}

/** Database table access - program. */
class ABAP_DB_TABLE_PROG {

    /**
     * System table D020S (screen sources).
     */
    const D020S = "d020s";

    /**
     * Screen Short Description.
     */
    const D020T = "d020t";

    /**
     * Contains Screen Source Information (Compressed).
     *
     * The data was depressed into table
     * {@link #YD021S}, {@link #YD022S} and
     * {@link #YD023S}.
     *
     * @deprecated Replaced by
     * {@link #YD021S}, {@link #YD022S} and
     * {@link #YD023S}
     */
    const DYNPSOURCE = "dynpsource";

    /**
     * Texts for logical databases.
     */
    const LDBT = "ldbt";

    /**
     * Report Source Code.
     *
     * @deprecated Replaced by {@link #YREPOSRCMETA} and {@link #YREPOSRCDATA}.
     */
    const REPOSRC = "reposrc";
    const YREPOSRCMETA = 'yreposrcmeta';
    const REPOSRC_PROGNAME_DTEL = "PROGNAME";

    /**
     * Menu Painter: Texts.
     */
    const RSMPTEXTS = "rsmptexts";

    /**
     * Table contains text for field REPOSRC-APPL (Application).
     *
     * The data was depressed into table {@link #YTAPLT}.
     *
     * @deprecated Replaced by {@link #YTAPLT}
     */
    const TAPLT = "taplt";

    /**
     * Title texts for programs in TRDIR.
     */
    const TRDIRT = "trdirt";
    const TRDIRT_TEXT_DTEL = "REPTI";

    /**
     * Contains Screen Source Information - Field Information. Parsed data of
     * the database table {@link #DYNPSOURCE} .
     *
     * @see #DYNPSOURCE
     */
    const YD021S = "yd021s";

    /**
     * Contains Screen Source Information - Flow Logic. Parsed data of the
     * database table {@link #DYNPSOURCE} .
     *
     * @see #DYNPSOURCE
     */
    const YD022S = "yd022s";

    /**
     * Contains Screen Source Information - Field Information. Parsed data of
     * the database table {@link #DYNPSOURCE} .
     *
     * @see #DYNPSOURCE
     */
    const YD023S = "yd023s";

    /**
     * Extracted data of table {@link #TAPLT}.
     * Table TAPLT contains text for field REPOSRC-APPL (Application).
     * <p>
     * Value from domain <code>PAPPL</code>, pointing to table TAPLP/TAPLT
     * (Pooled Table).
     * </p>
     *
     */
    const YTAPLT = "ytaplt";

    /**
     * Screen number list.
     * <pre>
     * SELECT DNUM FROM abapprog.d020s
     * where prog = '/1BCDWB/DB/ORM/ORMT_ACT' order by DNUM
     * </pre>
     */
    public static function D020S_PROG($prog) {
        $sql = "select DNUM from " . self::D020S
                . " where prog = :id order by DNUM";
        return ABAP_DB_TABLE::select_1filter($sql, $prog);
    }

    /**
     * Screen number list.
     * <pre>
     * SELECT DTXT FROM abapprog.d020t
     * where prog = '/1BCDWB/DB/ORM/ORMT_ACT' and dynr = '1000' and lang = 'E'
     * </pre>
     */
    public static function D020T($prog, $dynr) {
        $sql = "select DTXT as DESCR from " . self::D020T
                . " where prog = :prog AND dynr = :dynr AND lang = :lg";
        $paras = array(
            'prog' => $prog,
            'dynr' => $dynr,
            'lg' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU],
        );
        return ABAP_DB_TABLE::descr($sql, $paras);
    }

    /**
     * Generate the program name of current function group.
     * <p>
     * Name space is defined in table NAMESPACE, with data type NAMESPACE
     * CHAR(10). Example of name space is:
     * </p>
     * <pre>
     * /1UKM/
     * /1WDA/
     * /1WRF/
     * /1WRMA/
     * /AFS/
     * /APB/
     * </pre>
     * <pre>
     * Function Group name : SDTX       /BEV1/EM0      /1BCDWBEN//BEV3/EN0000
     * Program nmae        : SAPLSDTX   /BEV1/SAPLEM0  /1BCDWBEN/SAPL/BEV3/EN0000
     * </pre>
     * <pre>
     * Function Group name : [FG]       [NameSpace]EM0
     * Program name        : SAPL[FG]   [NameSpace]SAPLEMO
     * </pre>
     *
     * @param $fugr string Function Group name
     */
    public static function GET_PROG_FUGR($fugr) {
        $pos1 = strpos($fugr, "/");
        if ($pos1 === false) { // note: three equal signs
            // not found...
            return 'SAPL' . $fugr;
        } else {
            $pos2 = strpos($fugr, "/", 1);  // get the 2nd position

            $fg_left = substr($fugr, 0, $pos2 + 1);
            $fg_right = substr($fugr, $pos2 + 1);
            return $fg_left . 'SAPL' . $fg_right;
        }
    }

    /**
     * Texts used in an program. Including:
     * <pre>
     *   1. M - Menu
     *   2. F - Function
     *   3. T - Title
     *   4. A - Menu Bar
     *   5. P - Function Key Setting
     *   6. B - Pushbutton settings
     *   7. C - Status
     * </pre>
     *
     * <pre>
     * SELECT * FROM abap.rsmptexts_e where progname = 'RDDM0001' and SPRSL = 'E'
     * order by obj_type, OBJ_CODE, SUB_CODE, TEXTTYPE
     * </pre>
     */
    public static function RSMPTEXTS($ProgName, $ObjType) {
        $sql = "SELECT * FROM " . self::RSMPTEXTS
                . " WHERE PROGNAME = :id "
                . " AND OBJ_TYPE = :ot"
                . " AND SPRSL = :lg"
                . " order by obj_type, OBJ_CODE, SUB_CODE, TEXTTYPE";
        $paras = array(
            'id' => $ProgName,
            'ot' => $ObjType,
            'lg' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU],
        );
        $result = ABAP_DB_TABLE::select($sql, $paras);
        if (count($result) < 1) {
            $paras['lg'] = ABAP_DB_CONST::LANGU_EN;
            $result = ABAP_DB_TABLE::select($sql, $paras);
        }
        if (count($result) < 1) {
            $paras['lg'] = ABAP_DB_CONST::LANGU_DE;
            $result = ABAP_DB_TABLE::select($sql, $paras);
        }

        return $result;
    }

    /**
     * Report title text.
     */
    public static function TRDIRT($Progname) {
        $sql = "select TEXT as DESCR from " . self::TRDIRT
                . " where NAME = :id and SPRSL = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, strtoupper($Progname));
    }

    /**
     * Text for field REPOSRC-LDBNAME (Logical database).
     * <pre>
     * SELECT LDBTEXT FROM abapprog.ldbt where LDBNAME = 'AAV' and spras = 'E';
     * </pre>
     */
    public static function LDBT($LdbName) {
        $sql = "select LDBTEXT as DESCR from " . self::LDBT
                . " where LDBNAME = :id and spras = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, strtoupper($LdbName));
    }

    /**
     * Report Attributes.
     * <pre>
     * SELECT * FROM abapprog.yreposrcmeta where PROGNAME = 'SAPLFMCA_INCORR_BOR';
     * </pre>
     */
    public static function YREPOSRCMETA($ProgName) {
        $sql = "SELECT * FROM " . self::YREPOSRCMETA . " WHERE PROGNAME = :id";
        return ABAP_DB_TABLE::select_single($sql, $ProgName);
    }

    /**
     * Text for field REPOSRC-APPL (Application).
     * <pre>
     * SELECT ATEXT FROM abapprog.ytaplt where sprsl = 'E' and appl = 'A'
     * </pre>
     */
    public static function YTAPLT($Appl) {
        $sql = "select ATEXT as DESCR from " . self::YTAPLT
                . " where APPL = :id and SPRSL = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, strtoupper($Appl));
    }

}

/**
 * Database table access for - CLAS & INTF. 
 */
class ABAP_DB_TABLE_SEO {

    /**
     * Class/Interface.
     */
    const SEOCLASS = 'seoclass';
    const SEOCLASS_CLSNAME_DTEL = 'SEOCLSNAME';
    const SEOCLASS_CLSTYPE_CLAS = 0;                     // Class
    const SEOCLASS_CLSTYPE_INTF = 1;                     // Interface

    /**
     * Definition of class/interface.
     */
    const SEOCLASSDF = 'seoclassdf';
    const SEOCLASSDF_EXPOSURE_DOMAIN = 'SEOCREATE';
    const SEOCLASSDF_RSTAT_DOMAIN = 'RSTAT';
    const SEOCLASSDF_CATEGORY_DOMAIN = 'SEOCATEGRY';

    /**
     * Short description class/interface.
     */
    const SEOCLASSTX = 'seoclasstx';
    const SEOCLASSTX_DESCRIPT_DTEL = 'SEODESCR';

    /**
     * Class/Interface component.
     */
    const SEOCOMPO = 'seocompo';
    const SEOCOMPO_CMPTYPE_0 = 0;                        // Attribute
    const SEOCOMPO_CMPTYPE_1 = 1;                        // Method
    const SEOCOMPO_CMPTYPE_2 = 2;                        // Event
    const SEOCOMPO_CMPTYPE_3 = 3;                        // Type
    const SEOCOMPO_MTDTYPE_DOMAIN = 'SEOMTDTYPE';
    const SEOCOMPODF = 'seocompodf';
    const SEOCOMPODF_ATTDECLTYP_0 = 0;                   // Instance attribute
    const SEOCOMPODF_ATTDECLTYP_1 = 1;                   // Static Attribute
    const SEOCOMPODF_ATTDECLTYP_2 = 2;                   // Constant
    const SEOCOMPODF_ATTDECLTYP_DOMAIN = 'SEOATTDECL';
    const SEOCOMPODF_EXPOSURE_DOMAIN = 'SEOEXPOSE';
    const SEOCOMPODF_TYPTYPE_DOMAIN = 'SEOTYPTYPE';
    const SEOCOMPODF_MTDDECLTYP_DOMAIN = 'SEOMTDDECL';
    const SEOCOMPODF_EVTDECLTYP_DOMAIN = 'SEOEVTDECL';
    const SEOCOMPODF_TYPTYPE_3 = 3;                      // Object reference (TYPE REF TO)
    const SEOCOMPOTX = 'seocompotx';
    const SEOFRIENDS = 'seofriends';
    const SEOMETAREL = 'seometarel';
    const SEOMETAREL_RELTYPE_DOMAIN = 'SEORELTYPE';      // Relationship type between classes
    const SEOMETAREL_RELTYPE_ALL = -1;                   // All types
    const SEOMETAREL_RELTYPE_0 = 0;                      // Interface composition    (i COMPRISING i_ref)
    const SEOMETAREL_RELTYPE_1 = 1;                      // Interface implementation (CLASS c. INTERFACES i_ref)
    const SEOMETAREL_RELTYPE_2 = 2;                      // Inheritance              (c INHERITING FROM c_ref)
    const SEOSUBCO = 'seosubco';
    const SEOSUBCO_SCOTYPE_0 = 0;                        // Parameters
    const SEOSUBCO_SCOTYPE_1 = 1;                        // Exception
    const SEOSUBCODF = 'seosubcodf';
    const SEOSUBCODF_PARDECLTYP_DOMAIN = 'SEOPARDECL';
    const SEOSUBCODF_PARDECLTYP_0 = 0;                   // Importing
    const SEOSUBCODF_PARDECLTYP_1 = 1;                   // Exporting
    const SEOSUBCODF_PARDECLTYP_2 = 2;                   // Changing
    const SEOSUBCODF_PARDECLTYP_3 = 3;                   // Returning
    const SEOSUBCODF_PARPASSTYP_DOMAIN = 'SEOPARPASS';
    const SEOSUBCODF_TYPTYPE_DOMAIN = 'SEOTYPTYPE';
    const SEOSUBCOTX = 'seosubcotx';
    const SEOTYPEPLS = 'seotypepls';
    const SEOTYPEPLS_TPUTYPE_DOMAIN = 'SEOTPUTYPE';
    const SEOTYPEPLS_TPUTYPE_0 = 0;                      // Type group use                (TYPE-POOLS tp)
    const SEOTYPEPLS_TPUTYPE_1 = 1;                      // Forward declaration class     (CLASS c DEFINITION DEFERRED)
    const SEOTYPEPLS_TPUTYPE_2 = 2;                      // Forward declaration interface (INTERFACE i DEFINITION DEF...

    /**
     * List the classes/interfaces.
     */

    public static function SEOCLASS_List($clstype, $index, int $index_page) {
        $sql = 'select * from ' . self::SEOCLASS
                . ' where `CLSTYPE` = ' . $clstype
                . ' AND CLSNAME like :id'
                . ' ORDER BY CLSNAME'
                . ABAP_DB_CONST::SQL_LIMIT($index_page);
        $index = ($index == '_') ? '\_' : $index;
        return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
    }

    public static function SEOCLASS_Sitemap($clstype) {
        $sql = 'select CLSNAME from ' . self::SEOCLASS
                . " where `CLSTYPE` = " . $clstype
                . ' ORDER BY CLSNAME';
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Classes/Interfaces.
     */
    public static function SEOCLASS($clsname) {
        $sql = 'select * from ' . self::SEOCLASS
                . ' where `CLSNAME` = :id';
        return ABAP_DB_TABLE::select_single($sql, strtoupper($clsname));
    }

    /**
     * Classes/Interfaces definition.
     */
    public static function SEOCLASSDF($clsname) {
        $sql = 'select * from ' . self::SEOCLASSDF
                . ' where `CLSNAME` = :id and VERSION = 1';
        return ABAP_DB_TABLE::select_single($sql, $clsname);
    }

    /**
     * Classes/Interfaces description.
     */
    public static function SEOCLASSTX($clsname) {
        $sql = 'select DESCRIPT as DESCR from ' . self::SEOCLASSTX
                . ' where `CLSNAME` = :id and LANGU = :lg';
        return ABAP_DB_TABLE::descr_1filter($sql, strtoupper($clsname));
    }

    /**
     * Class/Interface component.
     */
    public static function SEOCOMPO($clsname, $cmptype) {
        $sql = 'select * from ' . self::SEOCOMPO
                . ' where `CLSNAME` = :id and CMPTYPE = :ct order by CMPNAME';
        $paras = array(
            'id' => $clsname,
            'ct' => $cmptype,
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Definition class/interface component.
     */
    public static function SEOCOMPODF($clsname, $cmpname) {
        $sql = 'select * from ' . self::SEOCOMPODF
                . ' where `CLSNAME` = :id and `CMPNAME` = :cn';
        $paras = array(
            'id' => $clsname,
            'cn' => $cmpname,
        );
        return current(ABAP_DB_TABLE::select($sql, $paras));
    }

    /**
     * Short description class/interface component.
     */
    public static function SEOCOMPOTX($clsname, $cmpname) {
        $sql = 'select * from ' . self::SEOCOMPOTX
                . ' where `CLSNAME` = :id and CMPNAME = :cn and LANGU = :lg';
        $paras = array(
            'id' => $clsname,
            'cn' => $cmpname,
            'lg' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]
        );
        $record = current(ABAP_DB_TABLE::select($sql, $paras));
        return $record['DESCRIPT'];
    }

    /**
     * Friend relationship.
     */
    public static function SEOFRIENDS($clsname) {
        $sql = 'select * from ' . self::SEOFRIENDS
                . ' where `CLSNAME` = :id';
        return ABAP_DB_TABLE::select_1filter($sql, $clsname);
    }

    /**
     * Classes/Interfaces relationship: interfaces, super classes.
     */
    public static function SEOMETAREL($clsname, $relatype) {
        if ($relatype === self::SEOMETAREL_RELTYPE_ALL) {
            $sql = 'select * from ' . self::SEOMETAREL
                    . ' where `CLSNAME` = :id';
            $paras = array(
                'id' => $clsname,
            );
        } else {
            $sql = 'select * from ' . self::SEOMETAREL
                    . ' where `CLSNAME` = :id and RELTYPE = :rt';
            $paras = array(
                'id' => $clsname,
                'rt' => $relatype
            );
        }
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Class/Interface is used by list.
     */
    public static function SEOMETAREL_REFCLSNAME($refclsname) {
        $sql = 'select * from ' . self::SEOMETAREL
                . ' where `REFCLSNAME` = :id order by RELTYPE';
        return ABAP_DB_TABLE::select_1filter($sql, $refclsname);
    }

    /**
     * Get super class of a class.
     */
    public static function SEOMETAREL_GetSuperClass($clsname) {
        $super_array = self::SEOMETAREL($clsname, self::SEOMETAREL_RELTYPE_2);
        if (empty($super_array)) {
            return '';
        } else {
            $super = current($super_array);
            return $super['REFCLSNAME'];
        }
    }

    /**
     * Class/interface subcomponent.
     */
    public static function SEOSUBCO($clsname, $cmpname, $scotype) {
        $sql = 'select * from ' . self::SEOSUBCO
                . ' where `CLSNAME` = :cls and CMPNAME = :cmp and SCOTYPE = :sco'
                . ' order by SCONAME';
        $paras = array(
            'cls' => $clsname,
            'cmp' => $cmpname,
            'sco' => $scotype,
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Definition class/interface subcomponent.
     */
    public static function SEOSUBCODF($clsname, $cmpname, $sconame) {
        $sql = 'select * from ' . self::SEOSUBCODF
                . ' where `CLSNAME` = :cls and `CMPNAME` = :cmp and SCONAME = :sco';
        $paras = array(
            'cls' => $clsname,
            'cmp' => $cmpname,
            'sco' => $sconame,
        );
        return current(ABAP_DB_TABLE::select($sql, $paras));
    }

    /**
     * Class/interface subcomponent short description.
     */
    public static function SEOSUBCOTX($clsname, $cmpname, $sconame) {
        $sql = 'select * from ' . self::SEOSUBCOTX
                . ' where `CLSNAME` = :cls and `CMPNAME` = :cmp and SCONAME = :sco';
        $paras = array(
            'cls' => $clsname,
            'cmp' => $cmpname,
            'sco' => $sconame,
        );
        $record = current(ABAP_DB_TABLE::select($sql, $paras));
        return $record['DESCRIPT'];
    }

    /**
     * Load forward declarations.
     */
    public static function SEOTYPEPLS($clsname) {
        $sql = 'select * from ' . self::SEOTYPEPLS
                . ' where `CLSNAME` = :id';
        return ABAP_DB_TABLE::select_1filter($sql, $clsname);
    }

}

/** 
 * Database table access for - Search Help. 
 */
class ABAP_DB_TABLE_SHLP {

    const DD30L = 'dd30l';                        // Search helps
    const DD30L_SHLPNAME_DTEL = 'SHLPNAME';
    const DD30L_SELMTYPE_DOMAIN = 'SELMTYPE';
    const DD30L_SELMTYPE_T = 'T';                 // Selection from table
    const DD30L_SELMTYPE_X = 'X';                 // Selection from table with text table
    const DD30L_SELMTYPE_V = 'V';                 // Selection from DB view or projection view
    const DD30L_SELMTYPE_H = 'H';                 // Selection with a help view
    const DD30L_SELMTYPE_F = 'F';                 // Selection by function module
    const DD30L_SELMETHOD_DTEL = 'SELMETHOD';
    const DD30L_TEXTTAB_DTEL = 'SELMETHTXT';
    const DD30L_DIALOGTYPE_DTEL = 'DDSHDIATYP';
    const DD30L_DIALOGTYPE_DOMAIN = 'DDSHDIATYP';
    const DD30L_AUTOSUGGEST_DTEL = 'DDAUTOSUGGEST';
    const DD30L_AUTOSUGGEST_DOMAIN = 'DDAUTOSUGGEST';
    const DD30L_FUZZY_SEARCH_DTEL = 'DDFUZZY_SEARCH';
    const DD30L_FUZZY_SEARCH_DOMAIN = 'DDFUZZY_SEARCH';
    const DD30L_FUZZY_SIMILARITY_DTEL = 'DDFUZZY_SIMILARITY';
    const DD30L_FUZZY_SIMILARITY_DOMAIN = 'DDFUZZY_SIMILARITY';
    const DD30L_SELMEXIT_DTEL = 'DDSHSELEXT';
    const DD30L_HOTKEY_DTEL = 'DDSHHOTKEY';
    const DD30T = 'dd30t';                            // Search help texts
    const DD30T_DDTEXT_DTEL = 'DDTEXT';

    /**
     * Not Used.
     */
    const DD31S = 'dd31s';                            // Assignment of search helps to collective search helps
    const DD32S = 'dd32s';                            // Search Help Parameter
    const DD32S_DEFAULTTYP_DOMAIN = 'DDSHDEFTYP';

    /**
     * Not Used.
     */
    const DD33S = 'dd33s';                            // Assignment of search help fields

    /**
     * List the search helps.
     */

    public static function DD30L_List($index, int $index_page = 1) {
        $sql = 'SELECT * from ' . self::DD30L
                . ' where SHLPNAME LIKE :id'
                . ' ORDER BY SHLPNAME'
                . ABAP_DB_CONST::SQL_LIMIT($index_page);
        return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
    }

    public static function DD30L_Sitemap() {
        $sql = 'select SHLPNAME from ' . self::DD30L
                . ' ORDER BY SHLPNAME';
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Search help.
     */
    public static function DD30L($name) {
        $sql = 'select * from ' . self::DD30L
                . ' where `SHLPNAME` = :id';
        return ABAP_DB_TABLE::select_single($sql, $name);
    }

    /**
     * Search help description.
     */
    public static function DD30T($name) {
        $sql = 'select DDTEXT as DESCR from ' . self::DD30T
                . ' where `SHLPNAME` = :id and DDLANGUAGE = :lg';
        return ABAP_DB_TABLE::descr_1filter($sql, strtoupper($name));
    }

    /**
     * Get list.
     */
    public static function DD31S($name) {
        $sql = 'select * from ' . self::DD31S
                . ' where `SHLPNAME` = :id';
        $paras = array(
            'id' => $name,
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Get list.
     */
    public static function DD32S($name) {
        $sql = 'select * from ' . self::DD32S
                . ' where `SHLPNAME` = :id'
                . ' order by FLPOSITION';
        $paras = array(
            'id' => $name,
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Get list.
     */
    public static function DD33S($name) {
        $sql = 'select * from ' . self::DD33S
                . ' where `SHLPNAME` = :id';
        $paras = array(
            'id' => $name,
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

}

/** 
 * Database table access for - tables. 
 */
class ABAP_DB_TABLE_TABL {

    /**
     * DD: Data Class in Technical Settings: Texts.
     */
    const DARTT = "dartt";

    /**
     * SAP Tables.
     */
    const DD02L = "dd02l";
    const DD02L_TABNAME_DTEL = "TABNAME";
    const DD02L_TABCLASS_DOMAIN = "TABCLASS";
    const DD02L_TABCLASS_DTEL = "TABCLASS";
    const DD02L_CONTFLAG_DOMAIN = "CONTFLAG";
    const DD02L_CONTFLAG_DTEL = "CONTFLAG";
    const DD02L_MAINFLAG_DOMAIN = "MAINTFLAG";

    /**
     * SAP DD: SAP Table Texts.
     */
    const DD02T = "dd02t";
    const DD02T_DDTEXT_DTEL = "AS4TEXT";

    /**
     * Table Fields.
     */
    const DD03L = "dd03l";
    const DD03L_FIELDNAME_DTEL = "FIELDNAME";

    /**
     * Foreign key fields.
     */
    const DD05S = "dd05s";

    /**
     * Map FIELDNAME column as CHECKFIELDNAME.
     */
    const DD05S_V_CHECKFIELDNAME = 'CHECKFIELDNAME';

    /**
     * Pool/cluster structures.
     */
    const DD06L = "dd06l";
    const DD06L_SQLTAB_DTEL = "SQLTABLE";
    const DD06L_SQLCLASS_DOMAIN = "SQLCLASS";
    const DD06L_SQLCLASS_DTEL = "SQLCLASS";
    const DD06L_AS4DATE_DTEL = "AS4DATE";

    /**
     * R/3 DD: texts on SQL tables.
     */
    const DD06T = "dd06t";
    const DD06T_DDTEXT_DTEL = "DDTEXT";

    /**
     * R/3 DD: relationship definitions.
     */
    const DD08L = "dd08l";
    const DD08L_CARD_DTEL = 'CARD';
    const DD08L_CARDLEFT_DTEL = 'CARDLEFT';
    const DD08L_FRKART_DTEL = 'FRKART';

    /**
     * Texts on the relationship definitions.
     */
    const DD08T = "dd08t";

    /**
     * DD: Technical settings of tables.
     */
    const DD09L = "dd09l";

    /**
     * R/3 S_SECINDEX: secondary indexes, header;.
     */
    const DD12L = "dd12l";

    /**
     * Text Table for DD12L (Short Descriptions of Secondary Indexes).
     */
    const DD12T = "dd12t";

    /**
     * R/3 DD: SQL table fields.
     */
    const DD16S = "dd16s";

    /**
     * R/3 S_SECINDEX: secondary indexes, fields.
     */
    const DD17S = "dd17s";

    /**
     * Search help attachments to structures: Headers.
     */
    const DD35L = "dd35l";

    /**
     * Parameter-field assignments for search help attachment.
     */
    const DD36S = "dd36s";

    /**
     * Object: Header.
     */
    const OBJH = "objh";

    /**
     * Authorization Group Names.
     */
    const TBRGT = "tbrgt";

    /**
     * View Directory.
     */
    const TVDIR = "tvdir";

    /**
     * Extracted data of table {@link #TDDAT}.
     */
    const YTDDAT = "ytddat";

    /**
     * Table Attributes.
     * <pre>
     * SELECT * FROM dd02l WHERE tabname = 'BKPF'
     * </pre>
     */
    public static function DD02L($TableName) {
        $sql = "SELECT * FROM " . self::DD02L . " WHERE tabname = :id";
        return ABAP_DB_TABLE::select_single($sql, $TableName);
    }

    /**
     * Table List.
     * <pre>
     * SELECT TABNAME, TABCLASS, CONTFLAG FROM dd02l WHERE tabname like 'A%' order by TABNAME
     * </pre>
     */
    public static function DD02L_List($index, int $index_page = 1) {
        if ($index == ABAP_DB_CONST::DD02L_TABCLASS_CLUSTER) {
            $sql = "SELECT TABNAME, TABCLASS, CONTFLAG FROM " . self::DD02L
                    . " WHERE TABCLASS = '" . ABAP_DB_CONST::DD02L_TABCLASS_CLUSTER . "' order by TABNAME";
            return ABAP_DB_TABLE::select($sql);
        } else if ($index == ABAP_DB_CONST::DD02L_TABCLASS_POOL) {
            $sql = "SELECT TABNAME, TABCLASS, CONTFLAG FROM " . self::DD02L
                    . " WHERE TABCLASS = '" . ABAP_DB_CONST::DD02L_TABCLASS_POOL . "' order by TABNAME";
            return ABAP_DB_TABLE::select($sql);
        } else {
            $sql = "SELECT TABNAME, TABCLASS, CONTFLAG FROM " . self::DD02L
                    . " WHERE tabname like :id and"
                    . " ( TABCLASS = '" . ABAP_DB_CONST::DD02L_TABCLASS_TRANSP
                    . "' OR TABCLASS = '" . ABAP_DB_CONST::DD02L_TABCLASS_CLUSTER
                    . "' OR TABCLASS = '" . ABAP_DB_CONST::DD02L_TABCLASS_POOL . "' )"
                    . " order by TABNAME"
                    . ABAP_DB_CONST::SQL_LIMIT($index_page);
            return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
        }
    }

    /**
     * DD02L Site Map.
     * <pre>
     * SELECT TABNAME FROM abaptabl.dd02l WHERE TABNAME NOT LIKE 'Y%' AND TABNAME NOT LIKE 'Z%'
     * </pre>
     */
    public static function DD02L_Sitemap() {
        $sql = "select TABNAME from " . self::DD02L
                . " where TABNAME not like 'Y%'"
                . "   and TABNAME not like 'Z%'"
                . "   and TABCLASS in ("
                . "'" . ABAP_DB_CONST::DD02L_TABCLASS_TRANSP . "', "
                . "'" . ABAP_DB_CONST::DD02L_TABCLASS_CLUSTER . "', "
                . "'" . ABAP_DB_CONST::DD02L_TABCLASS_POOL . "')";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Table list for a SQLTAB.
     * <pre>
     * SELECT * FROM dd02l where sqltab = 'RFBLG' order by TABNAME
     * </pre>
     */
    public static function DD02L_SQLTAB($Sqltab) {
        $sql = "SELECT * FROM " . self::DD02L
                . " WHERE SQLTAB = :id order by TABNAME";
        return ABAP_DB_TABLE::select_1filter($sql, $Sqltab);
    }

    /**
     * Table text.
     * <pre>
     * SELECT DDTEXT FROM dd02t where tabname = 'BKPF' AND DDLANGUAGE = 'E'
     * </pre>
     */
    public static function DD02T($TableName) {
        $sql = "select DDTEXT as " . ABAP_DB_CONST::COLUMN_V_DESCR
                . " from " . self::DD02T
                . " where tabname = :id and DDLANGUAGE = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, $TableName);
    }

    /**
     * Select the columns for Entity-Relationship-Diagram only.
     * To avoid show too many columns in the ERD, we only show the PK and FK columns.
     */
    public static function DD03L_Erd($TableName) {
        /*
          SELECT * FROM dd03l
          WHERE TABNAME = 'DD04L'
          AND ( KEYFLAG = 'X' OR FIELDNAME in (
          SELECT FIELDNAME FROM dd08l where TABNAME = 'DD04L'
          ))
          AND LENG > 0
          ORDER BY POSITION
         */

        $sql = "SELECT *"
                . " FROM " . self::DD03L
                . " WHERE TABNAME = :id"
                . " AND ( KEYFLAG = 'X' OR FIELDNAME in ("
                . "  SELECT FIELDNAME FROM " . self::DD08L . "  WHERE TABNAME = :id ))"
                . " AND LENG > 0"
                . " ORDER BY POSITION";
        return ABAP_DB_TABLE::select_1filter($sql, $TableName);
    }

    /**
     * Table Field List.
     * <pre>
     * SELECT * FROM dd03l WHERE tabname = 'BKPF' order by POSITION;
     * </pre>
     */
    public static function DD03L_List($TableName) {
        $sql = "SELECT * FROM " . self::DD03L
                . " WHERE tabname = :id order by POSITION";
        $fields = ABAP_DB_TABLE::select_1filter($sql, $TableName);
        foreach ($fields as $key => $value) {
            $fields[$key]['DDTEXT'] = self::GetTablFieldDesc($value['PRECFIELD'], $value['ROLLNAME']);
        }
        return $fields;
    }

    /**
     * Table primary key fields.
     */
    public static function DD03L_PK($TableName) {
        $sql = "SELECT * FROM " . self::DD03L
                . " WHERE tabname = :id"
                . "   AND KEYFLAG = 'X'"
                . "   AND LENG > 0"
                . " order by POSITION";
        return ABAP_DB_TABLE::select_1filter($sql, $TableName);
    }

    /**
     * Table Field Sitemap.
     * <pre>
     * SELECT IF (CHAR_LENGTH(TRIM(PRECFIELD)) > 0, CONCAT(TABNAME, '-', POSITION), CONCAT(TABNAME, '-', FIELDNAME)) AS FIELD
     * FROM abaptabl.dd03l WHERE TABNAME NOT LIKE 'Y%' AND TABNAME NOT LIKE 'Z%'
     * </pre>
     */
    public static function DD03L_Sitemap() {
        $sql = "select IF (CHAR_LENGTH(TRIM(PRECFIELD)) > 0, CONCAT(TABNAME, '-', POSITION), CONCAT(TABNAME, '-', FIELDNAME)) AS FIELD from " . ABAP_DB_TABLE_TABL::DD03L
                . " where TABNAME NOT LIKE 'Y%' AND TABNAME NOT LIKE 'Z%'";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Table Field Attributes.
     * <pre>
     * SELECT * FROM abaptabl.dd03l where TABNAME = 'BKPF' and FIELDNAME = 'BUKRS'
     * </pre>
     */
    public static function DD03L($TableName, $FieldName) {
        $sql = "SELECT * FROM " . self::DD03L
                . " WHERE TABNAME = :tname"
                . " AND FIELDNAME = :fname";
        $paras = array(
            'tname' => $TableName,
            'fname' => $FieldName,
        );
        return current(ABAP_DB_TABLE::select($sql, $paras));
    }

    /**
     * Table Field Attributes, by position.
     * <pre>
     * SELECT * FROM abaptabl.dd03l where TABNAME = 'BKPF' and POSITION = '0076'
     * </pre>
     */
    public static function DD03L_POSITION($TableName, $Position) {
        $sql = "SELECT * FROM " . self::DD03L
                . " WHERE TABNAME = :tname"
                . " AND POSITION = :pos";
        $paras = array(
            'tname' => $TableName,
            'pos' => $Position,
        );
        return current(ABAP_DB_TABLE::select($sql, $paras));
    }

    /**
     * Where Used List for data element.
     */
    public static function DD03L_ROLLNAME($rollname) {
        /*  No distinct, No order by  */
        $sql = "SELECT TABNAME FROM " . self::DD03L
                . " where ROLLNAME = :id limit "
                . ABAP_DB_CONST::USED_BY_LIMIT_DTEL;
        return ABAP_DB_TABLE::select_1filter($sql, strtoupper($rollname));
    }

    /**
     * Cluster/Pool Table List.
     * <pre>
     * SELECT * FROM dd06l order by SQLTAB
     * </pre>
     */
    public static function DD06L_List() {
        $sql = "SELECT * FROM " . self::DD06L . " order by SQLTAB";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     *  R/3 DD: relationship definitions / Foreign key fields.
     * 
     *  Special case.
     *   Table FINBTEST_T1T has foreign key to FINBTEST_T1, but FINBTEST_T1 does not exist.
     *   So, in the SQL we ask v_dd08l_dd03l to join DD05s, since v_dd08l_dd03l already checks the DD03L table
     */
    public static function DD05S_DD08L_DD03L($TableName) {
        /*
          SELECT v_dd08l_dd03l.*
          FROM (
          SELECT DD08L.TABNAME,
          DD08L.FIELDNAME,
          DD08L.CHECKTABLE,
          DD08L.FRKART,
          DD08L.CARDLEFT,
          DD08L.CARD,
          DD03L.FIELDNAME AS CHECKFIELDNAME,
          DD03L.POSITION,
          DD03L.ROLLNAME,
          DD03L.DOMNAME,
          DD03L.DATATYPE,
          DD03L.LENG,
          DD03L.DECIMALS
          FROM DD08L
          LEFT JOIN DD03L ON DD08L.CHECKTABLE = DD03L.TABNAME
          WHERE DD08L.TABNAME = 'FINBTEST_T1T'
          AND DD03L.KEYFLAG = 'X'
          AND DD03L.LENG > 0
          ) v_dd08l_dd03l
          LEFT JOIN dd05s

          ON dd05s.TABNAME = v_dd08l_dd03l.TABNAME
          AND dd05s.FIELDNAME = v_dd08l_dd03l.FIELDNAME
          AND dd05s.PRIMPOS = v_dd08l_dd03l.POSITION

          WHERE dd05s.TABNAME = 'FINBTEST_T1T'
          AND dd05s.FIELDNAME = dd05s.FORKEY
         */
        $sql = "SELECT v_dd08l_dd03l.*"
                . " FROM ( "
                . "  SELECT"
                . " " . self::DD08L . ".TABNAME,"
                . " " . self::DD08L . ".FIELDNAME,"
                . " " . self::DD08L . ".CHECKTABLE,"
                . " " . self::DD08L . ".FRKART,"
                . " " . self::DD08L . ".CARDLEFT,"
                . " " . self::DD08L . ".CARD,"
                . " " . self::DD03L . ".FIELDNAME AS " . self::DD05S_V_CHECKFIELDNAME . ","
                . " " . self::DD03L . ".POSITION,"
                . " " . self::DD03L . ".ROLLNAME,"
                . " " . self::DD03L . ".DOMNAME,"
                . " " . self::DD03L . ".DATATYPE,"
                . " " . self::DD03L . ".LENG,"
                . " " . self::DD03L . ".DECIMALS"
                . "  FROM " . self::DD08L
                . "  LEFT JOIN " . self::DD03L
                . "   ON " . self::DD08L . ".CHECKTABLE = " . self::DD03L . ".TABNAME"
                . "  WHERE " . self::DD08L . ".TABNAME = :id"
                . "  AND " . self::DD03L . ".KEYFLAG = 'X'"
                . "  AND " . self::DD03L . ".LENG > 0"
                . " ) v_dd08l_dd03l "
                . "LEFT JOIN " . self::DD05S
                . " ON  " . self::DD05S . ".TABNAME = v_dd08l_dd03l.TABNAME"
                . " AND " . self::DD05S . ".FIELDNAME = v_dd08l_dd03l.FIELDNAME"
                . " AND " . self::DD05S . ".PRIMPOS = v_dd08l_dd03l.POSITION"
                . " WHERE " . self::DD05S . ".TABNAME = :id"
                . "   AND " . self::DD05S . ".FIELDNAME = " . self::DD05S . ".FORKEY";

        return ABAP_DB_TABLE::select_1filter($sql, $TableName);
    }

    /**
     * Cluster/Pool table.
     */
    public static function DD06L($Sqltab) {
        $sql = "SELECT * FROM " . self::DD06L . " where SQLTAB = :id";
        return ABAP_DB_TABLE::select_single($sql, $Sqltab);
    }

    /**
     * Cluster/Pool table text.
     */
    public static function DD06T($Sqltab) {
        $sql = "select DDTEXT as " . ABAP_DB_CONST::COLUMN_V_DESCR
                . " from " . self::DD06T
                . " where SQLTAB = :id and DDLANGUAGE = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, $Sqltab);
    }

    public static function DD08L_Erd($TableName) {
        /*
          SELECT * FROM abap.dd08l
          where TABNAME = '/1BEA/IPMI_DLSK'
          AND trim(CHECKTABLE) <> '*'
          ORDER BY CHECKTABLE
         */
        $sql = "SELECT distinct CHECKTABLE FROM " . self::DD08L
                . " WHERE tabname = :id"
                . " AND trim(CHECKTABLE) <> '*'"
                . " ORDER BY CHECKTABLE";
        return ABAP_DB_TABLE::select_1filter($sql, $TableName);
    }

    /**
     * Field List.
     * <pre>
     * SELECT * FROM dd16s where SQLTAB = 'AABLG' order by position
     * </pre>
     */
    public static function DD16S($Sqltable) {
        $sql = "SELECT * FROM " . self::DD16S
                . " where SQLTAB = :id order by position";
        return ABAP_DB_TABLE::select_1filter($sql, $Sqltable);
    }

    /**
     * Get indexes by field.
     * <pre>
     * SELECT * FROM abaptabl.dd17s where SQLTAB = 'BKPF' AND FIELDNAME = 'MANDT' ORDER BY INDEXNAME
     * </pre>
     */
    public static function DD17S_FIELDNAME($Sqltab, $FieldName) {
        $sql = "SELECT * FROM " . self::DD17S
                . " WHERE SQLTAB = :sqlt"
                . " AND FIELDNAME = :fname order by INDEXNAME";
        $paras = array(
            'sqlt' => $Sqltab,
            'fname' => $FieldName,
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }
    
    /**
     * Get Table Filed description.
     */
    public static function GetTablFieldDesc($PrecField, $RollName): string {
        if (strlen(trim($PrecField)) > 0) {
            return self::DD02T($PrecField);
        } else {
            return ABAP_DB_TABLE_DTEL::DD04T($RollName);
        }
    }

}

/** Database table access for - transaction code. */
class ABAP_DB_TABLE_TRAN {

    /**
     * SAP Transaction Codes.
     */
    const TSTC = "tstc";
    const TSTC_TCODE_DTEL = "TCODE";

    /**
     * Values for transaction code authorizations.
     */
    const TSTCA = "tstca";

    /**
     * Additional Attributes for TSTC.
     */
    const TSTCC = "tstcc";

    /**
     * Parameters for Transactions.
     */
    const TSTCP = "tstcp";

    /**
     * Transaction Code Texts.
     */
    const TSTCT = "tstct";

    /**
     * Transaction Code List.
     * <pre>
     * SELECT * FROM tstc where TCODE LIKE 'A%' order by TCODE
     * </pre>
     */
    public static function TSTC_List($index, int $index_page) {
        $sql = 'SELECT * FROM ' . self::TSTC
                . ' where TCODE LIKE :id'
                . ' order by TCODE'
                . ABAP_DB_CONST::SQL_LIMIT($index_page);
        $index = ($index == '_') ? '\_' : $index;
        return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
    }

    /**
     * DD01L Site Map.
     * <pre>
     * SELECT TCODE FROM abaptran.tstc where TCODE not like 'Y%' and  TCODE not like 'Z%'
     * </pre>
     */
    public static function TSTC_Sitemap() {
        $sql = "select TCODE from " . self::TSTC
                . " where TCODE not like 'Y%' and TCODE not like 'Z%'";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * Transaction Code attribute.
     * <pre>
     * SELECT * FROM tstc where TCODE  = 'FB01'
     * </pre>
     */
    public static function TSTC($tcode) {
        $sql = "SELECT * FROM " . self::TSTC . " where TCODE = :id";
        return ABAP_DB_TABLE::select_single($sql, $tcode);
    }

    /**
     * Transaction Code attribute - Authorization.
     * <pre>
     * SELECT * FROM tstca where TCODE  = 'FB01'
     * </pre>
     */
    public static function TSTCA_List($tcode) {
        $sql = "SELECT * FROM " . self::TSTCA
                . " where TCODE = :id order by OBJCT, FIELD";
        return ABAP_DB_TABLE::select_1filter($sql, $tcode);
    }

    /**
     * Transaction code refers to one program.
     * <pre>
     * SELECT TCODE FROM abaptran.tstc where PGMNA = '/AIN/SAPLUI_DOC' order by TCODE
     * </pre>
     */
    public static function TSTC_PGMNA($prog) {
        $sql = "SELECT TCODE FROM " . self::TSTC
                . " where PGMNA = :id order by TCODE";
        return ABAP_DB_TABLE::select_1filter($sql, $prog);
    }

    /**
     * Transaction Code attribute - Additional Attributes.
     * <pre>
     * SELECT * FROM tstcc WHERE TCODE = 'FB01'
     * </pre>
     */
    public static function TSTCC($tcode) {
        $sql = "SELECT * FROM " . self::TSTCC . " where TCODE = :id";
        return ABAP_DB_TABLE::select_single($sql, $tcode);
    }

    /**
     * Transaction Code attribute - Additional Attributes.
     * <pre>
     * SELECT * FROM tstcp WHERE TCODE = '/AIN/CS'
     * </pre>
     */
    public static function TSTCP($tcode) {
        $sql = "SELECT * FROM " . self::TSTCP . " where TCODE = :id";
        return ABAP_DB_TABLE::select_single($sql, $tcode);
    }

    /**
     * Transaction Code text.
     * <pre>
     * SELECT ttext FROM tstct where tcode = 'FB03' AND SPRSL = 'E'
     * </pre>
     */
    public static function TSTCT($TCode) {
        // Load from Buffer
        $bufkey = GLOBAL_BUFFER::KEYPREFIX_DB . self::TSTCT . $TCode;
        $bufval = GLOBAL_BUFFER::Get($bufkey);

        if ($bufval == NULL) {
            $sql = "select ttext as " . ABAP_DB_CONST::COLUMN_V_DESCR
                    . " from " . self::TSTCT
                    . " where TCODE = :id and SPRSL = :lg";
            $bufval = ABAP_DB_TABLE::descr_1filter($sql, $TCode);
            if (GLOBAL_UTIL::IsEmpty($bufval)) {
                $bufval = '(empty)';
            }

            // Put to Buffer
            GLOBAL_BUFFER::Set($bufkey, $bufval);
        }

        return $bufval;
    }

    /**
     * Transaction Code text in all languages.
     * <pre>
     * SELECT SPTXT, TTEXT, a.SPRSL as SPRSL
     *   FROM abap.tstct a
     *   left join abap.t002t b on a.SPRSL = b.SPRSL and a.SPRSL = b.SPRAS
     *   where a.tcode = 'SE90'
     *     and b.SPTXT is not null
     *   ORDER BY SPRSL
     * </pre>
     */
    public static function TSTCT_All($TCode) {
        $sql = "select SPTXT, TTEXT, a.SPRSL as SPRSL"
                . " from " . self::TSTCT . " a"
                . " left join " . ABAP_DB_TABLE_BASIS::T002T . " b on a.SPRSL = b.SPRSL and a.SPRSL = b.SPRAS"
                . " where a.TCODE = :id and b.SPTXT is not null"
                . " ORDER BY SPRSL";
        return ABAP_DB_TABLE::select_1filter($sql, $TCode);
    }

}

/** Database table names - view. */
class ABAP_DB_TABLE_VIEW {

    /**
     * Aggregate Header (Views, MC Objects, Lock Objects).
     */
    const DD25L = "dd25l";
    const DD25L_VIEWNAME_DTEL = "VIEWNAME";
    const DD25L_VIEWCLASS_DTEL = "VIEWCLASS";
    const DD25L_ROOTTAB_DTEL = "ROOTTAB";

    /**
     * Short Texts for Views and Lock Objects.
     */
    const DD25T = "dd25t";
    const DD25T_DDTEXT_DTEL = "DDTEXT";

    /**
     * Base tables and foreign key relationships for a view.
     */
    const DD26S = "dd26s";

    /**
     * Fields in an Aggregate (View, MC Object, Lock Object).
     */
    const DD27S = "dd27s";

    /**
     * Lines of a selection condition.
     */
    const DD28S = "dd28s";

    /**
     * DM Entity Type Short Text.
     */
    const DM02T = "dm02t";

    /**
     * DM View-Entity Type Assignment.
     */
    const DM25L = "dm25l";

    /**
     * DDIC View List.
     * <pre>
     * SELECT * FROM dd25l where VIEWNAME like 'A%' order by VIEWNAME
     * </pre>
     */
    public static function DD25L_List($index, int $index_page = 1) {
        $sql = "SELECT VIEWNAME, VIEWCLASS, ROOTTAB FROM " . self::DD25L
                . " where VIEWNAME LIKE :id"
                . " order by VIEWNAME"
                . ABAP_DB_CONST::SQL_LIMIT($index_page);
        return ABAP_DB_TABLE::select_1filter($sql, $index . '%');
    }

    /**
     * DD25L Site Map.
     * <pre>
     * SELECT VIEWNAME FROM abapview.dd25l WHERE VIEWNAME <> '' AND VIEWNAME NOT LIKE 'Y%' AND VIEWNAME NOT LIKE 'Z%'
     * </pre>
     */
    public static function DD25L_Sitemap() {
        $sql = "select VIEWNAME from " . self::DD25L
                . " where VIEWNAME <> '' AND VIEWNAME NOT LIKE 'Y%' AND VIEWNAME NOT LIKE 'Z%'";
        return ABAP_DB_TABLE::select($sql);
    }

    /**
     * View.
     */
    public static function DD25L($ViewName) {
        $sql = "SELECT * FROM " . self::DD25L . " where VIEWNAME = :id";
        return ABAP_DB_TABLE::select_single($sql, $ViewName);
    }

    /**
     * View text.
     */
    public static function DD25T($ViewName) {
        $sql = "select DDTEXT as " . ABAP_DB_CONST::COLUMN_V_DESCR
                . " from " . self::DD25T
                . " where VIEWNAME = :id and DDLANGUAGE = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, strtoupper($ViewName));
    }

    /**
     * Base tables and foreign key relationships for a view.
     * <pre>
     * SELECT * FROM dd26s where viewname = 'AANL' order by TABPOS;
     * </pre>
     */
    public static function DD26S_List($ViewName) {
        $sql = "SELECT * FROM " . self::DD26S
                . " where VIEWNAME = :id order by TABPOS";
        return ABAP_DB_TABLE::select_1filter($sql, $ViewName);
    }

    /**
     * Fields in an Aggregate (View, MC Object, Lock Object).
     * <pre>
     * SELECT * FROM abapview.dd27s WHERE VIEWNAME = 'AANL' ORDER BY OBJPOS
     * </pre>
     */
    public static function DD27S_List($ViewName) {
        $sql = "SELECT * FROM " . self::DD27S
                . " where VIEWNAME = :id order by OBJPOS";
        return ABAP_DB_TABLE::select_1filter($sql, $ViewName);
    }

    /**
     * Lines of a selection condition.
     * <pre>
     * SELECT * FROM dd28s where CONDNAME = 'ANEKPV' order by POSITION
     * </pre>
     */
    public static function DD28S_List($ViewName) {
        $sql = "SELECT * FROM " . self::DD28S
                . " where CONDNAME = :id order by POSITION";
        return ABAP_DB_TABLE::select_1filter($sql, $ViewName);
    }

    /**
     * DM Entity Type Short Text.
     * <pre>
     * SELECT LANGBEZ FROM dm02t where SPRACHE = 'E' and entid = '12052'
     * </pre>
     */
    public static function DM02T($Entid) {
        $sql = "select LANGBEZ as " . ABAP_DB_CONST::COLUMN_V_DESCR
                . " from " . self::DM02T
                . " where entid = :id and SPRACHE = :lg";
        return ABAP_DB_TABLE::descr_1filter($sql, strtoupper($Entid));
    }

    /**
     * DM View-Entity Type Assignment.
     * <pre>
     * SELECT * FROM dm25l where VIEWNAME = 'ENT1003'
     * </pre>
     */
    public static function DM25L($ViewName) {
        $sql = "SELECT * FROM " . self::DM25L . " where VIEWNAME = :id";
        return ABAP_DB_TABLE::select_single($sql, $ViewName);
    }

}

/**
 * Database table access for Basis.
 */
class ABAP_DB_TABLE_BASIS {

    const T002T = 't002t';
    // Buffer - Index Counter table
    const ZBUFFER_INDEX_COUNTER = 'zbuffer_index_counter';
    const ZBUFFER_INDEX_COUNTER_ABAP_OTYPE = 'ABAP_OTYPE';
    const ZBUFFER_INDEX_COUNTER_LEFT1 = 'LEFT1';
    const ZBUFFER_INDEX_COUNTER_LEFT1_AT = '@';
    const ZBUFFER_INDEX_COUNTER_LEFT1_SLASH = '/';
    const ZBUFFER_INDEX_COUNTER_PAGE_COUNT = 'PAGE_COUNT';

    public static function ZBUFFER_INDEX_COUNTER(string $oType) {
        $sql = "SELECT * FROM " . self::ZBUFFER_INDEX_COUNTER . " where ABAP_OTYPE = :id";
        return ABAP_DB_TABLE::select_1filter($sql, $oType);
    }

}

/** 
 * Database table access for Cross Reference (eg. Where-Used-List). 
 */
class ABAP_DB_TABLE_CREF {

    /**
     * SEO Class Method name and Method program name.
     */
    const YSEOPROG = "yseoprog";
    const YWUL = "ywul";
    const YWUL_SUB_TYPE_METH = "METH";
    const YWUL_SUB_TYPE_VIED = "VIED";

    /**
     * Get method name from class method include name.
     */
    public static function YSEOPROG_CPDNAME($clsName, $include) {
        $sql = 'SELECT * from ' . self::YSEOPROG
                . ' where CLSNAME = :cls AND INCLUDE = :inc';
        $paras = array(
            'cls' => $clsName,
            'inc' => $include,
        );
        $result = current(ABAP_DB_TABLE::select($sql, $paras));
        return $result['CPDNAME'];
    }

    /**
     * Load Where-Used-List for an ABAP Object.
     *
     * <pre>
     * SELECT * from abap.ywul
     *   where SRC_OBJ_TYPE = 'DOMA'
     *     and SRC_OBJ_NAME = 'MANDT'
     *     and SRC_SUBOBJ   = ''
     *     and OBJ_TYPE = 'DTEL'
     *   limit 10, 30
     * </pre>
     */
    public static function YWUL($srcOType, $srcOName, $srcSubobj, $oType, $page) {
        $sql = 'SELECT * from ' . self::YWUL
                . ' where SRC_OBJ_TYPE = :sotype AND SRC_OBJ_NAME = :soname AND SRC_SUBOBJ = :ssubobj AND OBJ_TYPE = :otype'
                . ' order by OBJ_NAME'
                . ABAP_DB_CONST::SQL_LIMIT($page);
        $paras = array(
            'sotype' => $srcOType,
            'soname' => $srcOName,
            'ssubobj' => $srcSubobj,
            'otype' => $oType,
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Load Where-Using-List for an ABAP Object.
     *
     * <pre>
     * SELECT * FROM ABAP.ywul
     *   where OBJ_TYPE = 'TABL'
     *     and OBJ_NAME = 'BSEG'
     *     and SRC_OBJ_TYPE = 'DTEL'
     *   LIMIT 10
     *   OFFSET 30
     * </pre>
     */
    public static function YWIL($oType, $oName, $srcOType, $page) {
        $sql = 'SELECT * from ' . self::YWUL
                . ' where OBJ_TYPE = :otype AND OBJ_NAME = :oname AND SRC_OBJ_TYPE = :sotyp'
                . ' order by SRC_OBJ_NAME'
                . ABAP_DB_CONST::SQL_LIMIT($page);
        $paras = array(
            'otype' => $oType,
            'oname' => $oName,
            'sotyp' => $srcOType,
        );

        return ABAP_DB_TABLE::select($sql, $paras);
    }

}
