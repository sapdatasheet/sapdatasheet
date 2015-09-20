<?php

$__ROOT__ = dirname(dirname(__FILE__));
require_once($__ROOT__ . '/include/config.php');

class ABAP_DB_CONST {

    const INDEX_A = "A";                       // First page, start from 'A'
    const INDEX_HIER = "HIERARCHY";            // Hierarchy view, example: SPRO
    const INDEX_LIST = "LIST";                 // List all contents, no paging
    const INDEX_SLASH = "SLASH";
    const INDEX_TOP = "TOP";
    const LANGU_EN = "E";
    const FLAG_TRUE = "X";
    const FLAG_FALSE = "";

    /** Domain names OR Domain values */
    const DOMAIN_DATATYPE = "DATATYPE";
    const DOMAIN_INTTYPE = "INTTYPE";
    const DOMAIN_DD02L_TABCLASS = "TABCLASS";
    const DOMAIN_DD02L_CONTFLAG = "CONTFLAG";
    const DOMAIN_DD02L_MAINFLAG = "MAINTFLAG";
    const DOMAIN_DD03L_COMPTYPE_E = "E";         // E - Data Element
    const DOMAIN_DD03L_COMPTYPE_S = "S";         // S - Structure (Table)
    const DOMAIN_DD03L_COMPTYPE = "COMPTYPE";
    const DOMAIN_DD03L_LANGUFLAG = "DDLANGUFLG";
    const DOMAIN_DD03L_NOTNULL = "NOTNULL";
    const DOMAIN_DD03L_SHLPORIGIN = "SHLPORIGIN";
    const DOMAIN_DD03L_TABLETYPE = "DDFLAG";
    const DOMAIN_DD03L_REFTYPE = "DDREFTYPE";
    const DOMAIN_DD04L_REFKIND = "TYPEKIND";
    const DOMAIN_DD04L_REFTYPE = "DDREFTYPE";
    const DOMAIN_DD06L_SQLCLASS = "SQLCLASS";
    const DOMAIN_DD25L_CUSTOMAUTH = "CONTFLAG";
    const DOMAIN_DD25L_GLOBALFLAG = "MAINTFLAG";
    const DOMAIN_DD25L_VIEWCLASS = "VIEWCLASS";
    const DOMAIN_DD25L_VIEWGRANT = "VIEWGRANT";
    const DOMAIN_DD27S_RDONLY = "VFLDRDONLY";
    const DOMAIN_REPOSRC_RSTAT = "RSTAT";
    const DOMAIN_REPOSRC_SUBC = "SUBC";
    const DOMAIN_TADIR_COMP_TYPE = "RELC_TYPE";
    const DOMAIN_TDEVC_MAINPACK = "MAINPACK";
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
    const DD02L_TABCLASS_TRANSP = "TRANSP";
    const DD02L_TABCLASS_CLUSTER = "CLUSTER";
    const DD02L_TABCLASS_POOL = "POOL";
    const FUNCT_KIND_P = "P";
    const FUPARAREF_PARAMTYPE_I = "I";         // Importing
    const FUPARAREF_PARAMTYPE_E = "E";         // Exporting
    const FUPARAREF_PARAMTYPE_C = "C";         // Changing
    const FUPARAREF_PARAMTYPE_T = "T";         // Tables
    const FUPARAREF_PARAMTYPE_X = "X";         // Exception
    const TADIR_PGMID_R3TR = "R3TR";
    const TFDIR_FMODE_SPACE = " ";      // Type of function module - Normal Function Module.
    const TFDIR_FMODE_AT = "@";
    const TFDIR_FMODE_J = "J";         // Type of function module - JAVA Module Callable from ABAP.
    const TFDIR_FMODE_K = "K";         // Type of function module - Remote-Enabled JAVA Module.
    const TFDIR_FMODE_L = "L";         // Type of function module - Module Callable from JAVA.
    const TFDIR_FMODE_R = "R";         // Type of function module - Remote-Enabled Module.
    const TFDIR_FMODE_X = "X";         // Type of function module - Remote-Enabled Module & BaseXML supported.
    const TFDIR_UTASK_1 = "1";         // Update module - Start immediately.
    const TFDIR_UTASK_2 = "2";         // Update module - Immediate Start, No Restart.
    const TFDIR_UTASK_3 = "3";         // Update module - Start Delayed.
    const TFDIR_UTASK_4 = "4";         // Update module - Coll.run.
    const TSTCC_S_WEBGUI_1 = "1";
    const TSTCC_S_WEBGUI_2 = "2";

}

/** Database schema & connection. */
class ABAP_DB_SCHEMA {

    /** Schema Name. */
    const SCHEMA = 'abap';

    /** Database connection. */
    private static $conn = null;

    /** Get database connection. */
    public static function getConnection() {
        if (ABAP_DB_SCHEMA::$conn == null) {
            ABAP_DB_SCHEMA::$conn = new mysqli(
                    ABAP_DB_CONN::$host, ABAP_DB_CONN::$user, ABAP_DB_CONN::$pass, ABAP_DB_SCHEMA::SCHEMA);
            ABAP_DB_SCHEMA::$conn->set_charset("utf8");
        }
        return ABAP_DB_SCHEMA::$conn;
    }

}

/** Database table names - domain. */
class ABAP_DB_TABLE_DOMA {

    /**
     * Domains.
     */
    const DD01L = "dd01l";

    /**
     * R/3 DD: domain texts.
     */
    const DD01T = "dd01t";

    /**
     * R/3 DD: values for the domains.
     */
    const DD07L = "dd07l";

    /**
     * DD: Texts for Domain Fixed Values (Language-Dependent).
     */
    const DD07T = "dd07t";

    /**
     * Domain List.
     * <pre>
     * SELECT * FROM dd01l where DOMNAME LIKE 'A%' order by DOMNAME
     * </pre>
     */
    public static function DD01L_List($index) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $index = $con->real_escape_string($index . '%');
        $sql = "SELECT DOMNAME, DATATYPE, LENG, DECIMALS, AS4DATE FROM " . ABAP_DB_TABLE_DOMA::DD01L
                . " where DOMNAME LIKE '" . $index . "' order by DOMNAME";
        return $con->query($sql);
    }

    /**
     * DD01L Site Map.
     * <pre>
     * SELECT DOMNAME FROM abapdoma.dd01l where DOMNAME not like 'Y%' and DOMNAME not like 'Z%'
     * </pre>
     */
    public static function DD01L_Sitemap() {
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "select DOMNAME from " . ABAP_DB_TABLE_DOMA::DD01L
                . " where DOMNAME not like 'Y%' and DOMNAME not like 'Z%'";
        return $con->query($sql);
    }

    /**
     * Domain.
     */
    public static function DD01L($DomName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $DomName = $con->real_escape_string($DomName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_DOMA::DD01L . " where DOMNAME = '" . $DomName . "'";
        $qry = $con->query($sql);
        $result = mysqli_fetch_array($qry);
        return $result;
    }

    /**
     * Domain text.
     */
    public static function DD01T($Domain) {
        $sql = "select DDTEXT from " . ABAP_DB_TABLE_DOMA::DD01T
                . " where DOMNAME = ? and DDLANGUAGE = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU];  // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $Domain, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    /**
     * Domain value list.
     * <pre>
     * SELECT * FROM abapdoma.dd07l where DOMNAME = 'DATATYPE' ORDER BY valpos;
     * </pre>
     */
    public static function DD07L($Domain) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $Domain = $con->real_escape_string($Domain);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_DOMA::DD07L
                . " where DOMNAME = '" . $Domain . "' order by valpos";
        return $con->query($sql);
    }

    /**
     * Get Domain Value Text.
     */
    public static function DD07T($Domain, $ValueL) {
        $sql = "select DDTEXT from " . ABAP_DB_TABLE_DOMA::DD07T . " where DOMNAME = ? and DDLANGUAGE = ? and DOMVALUE_L = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU];  // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param("sss", $Domain, $langu, $ValueL);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

}

/** Database table names - data element. */
class ABAP_DB_TABLE_DTEL {

    /**
     * Data elements.
     */
    const DD04L = "dd04l";

    /**
     * R/3 DD: Data element texts.
     */
    const DD04T = "dd04t";

    /**
     * Data Element List.
     * <pre>
     * SELECT * FROM dd04l where ROLLNAME LIKE 'A%' order by ROLLNAME
     * SELECT ROLLNAME, DOMNAME, DATATYPE, LENG, AS4DATE FROM dd04l
     *     where ROLLNAME LIKE 'A%' order by ROLLNAME
     * </pre>
     */
    public static function DD04L_List($index) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $index = $con->real_escape_string($index . '%');
        $sql = "SELECT ROLLNAME, DOMNAME, DATATYPE, LENG, AS4DATE FROM " . ABAP_DB_TABLE_DTEL::DD04L
                . " where ROLLNAME LIKE '" . $index . "' order by ROLLNAME";
        return $con->query($sql);
    }

    /**
     * DD01L Site Map.
     * <pre>
     * SELECT ROLLNAME FROM abapdtel.dd04l where ROLLNAME not like 'Y%' and ROLLNAME not like 'Z%'
     * </pre>
     */
    public static function DD04L_Sitemap() {
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "select ROLLNAME from " . ABAP_DB_TABLE_DTEL::DD04L
                . " where ROLLNAME not like 'Y%' and ROLLNAME not like 'Z%'";
        return $con->query($sql);
    }

    /**
     * Data Element.
     */
    public static function DD04L($Rollname) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $Rollname = $con->real_escape_string($Rollname);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_DTEL::DD04L . " where ROLLNAME = '" . $Rollname . "'";
        $qry = $con->query($sql);
        $result = mysqli_fetch_array($qry);
        return $result;
    }

    /**
     * Data Element text.
     * <pre>
     * SELECT DDTEXT FROM dd04t where ROLLNAME = 'BUKRS' and DDLANGUAGE = 'E';
     * </pre>
     */
    public static function DD04T($Rollname) {
        $sql = "select DDTEXT from " . ABAP_DB_TABLE_DTEL::DD04T
                . " where ROLLNAME = ? and DDLANGUAGE = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]; // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $Rollname, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    /**
     * Data Element text.
     * <pre>
     * SELECT * FROM dd04t where ROLLNAME = 'BUKRS' and DDLANGUAGE = 'E';
     * </pre>
     */
    public static function DD04T_ALL($Rollname) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $Rollname = $con->real_escape_string($Rollname);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_DTEL::DD04T
                . " where ROLLNAME = '" . $Rollname . "' and DDLANGUAGE = 'E'";
        $qry = $con->query($sql);
        $result = mysqli_fetch_array($qry);
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

    /**
     * Function Module Short Text.
     */
    const TFTIT = "tftit";

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
    public static function TFDIR_List($index) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $index = strtoupper($con->real_escape_string($index));
        if (strcmp($index, 'RFC') == 0) {
            $sql = "SELECT FUNCNAME, FMODE FROM " . ABAP_DB_TABLE_FUNC::TFDIR
                    . " where FMODE = 'R' order by funcname";
        } else {
            $sql = "SELECT FUNCNAME, FMODE FROM " . ABAP_DB_TABLE_FUNC::TFDIR
                    . " where funcname LIKE '" . $index . "%' order by funcname";
        }
        return $con->query($sql);
    }

    /**
     * DD01L Site Map.
     * <pre>
     * SELECT FUNCNAME FROM abapfunc.tfdir where FUNCNAME not like 'Y%' and FUNCNAME not like 'Z%'
     * </pre>
     */
    public static function TFDIR_Sitemap() {
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "select FUNCNAME from " . ABAP_DB_TABLE_FUNC::TFDIR
                . " where FUNCNAME not like 'Y%' and FUNCNAME not like 'Z%'";
        return $con->query($sql);
    }

    /**
     * Function Module text.
     */
    public static function TFTIT($fm) {
        $sql = "select STEXT from " . ABAP_DB_TABLE_FUNC::TFTIT
                . " where FUNCNAME = ? and SPRAS = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]; // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $fm, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    /**
     * Function Group text.
     * <pre>
     * SELECT AREAT FROM abapfunc.tlibt where area = 'FMCA_INCORR_BOR' and spras = 'E'
     * </pre>
     */
    public static function TLIBT($fg) {
        $sql = "select AREAT from " . ABAP_DB_TABLE_FUNC::TLIBT
                . " where area = ? and SPRAS = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]; // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $fg, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
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
        $con = ABAP_DB_SCHEMA::getConnection();
        $fm = $con->real_escape_string($fm);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_FUNC::TFDIR . " WHERE funcname = '" . $fm . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
    }

    /**
     * Calculate function module processing type.
     */
    public static function TFDIR_PTYPE($fmode, $utask) {
        $ptype = new ABAP_TFDIR_ProcessingType();

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
        $con = ABAP_DB_SCHEMA::getConnection();
        $prog = $con->real_escape_string($prog);
        $sql = "SELECT INCLUDE, FUNCNAME, FMODE FROM " . ABAP_DB_TABLE_FUNC::TFDIR
                . " where PNAME = '" . $prog . "' order by INCLUDE";
        return $con->query($sql);
    }

    /**
     * Additional Attributes for Function Modules.
     * <pre>
     * SELECT * FROM abapfunc.enlfdir where funcname = 'RFC_READ_TABLE'
     * </pre>
     */
    public static function ENLFDIR($fm) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $fm = $con->real_escape_string($fm);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_FUNC::ENLFDIR . " WHERE funcname = '" . $fm . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
    }

    /**
     * Function Module parameters.
     * <pre>
     * SELECT * FROM abapfunc.fupararef where funcname = 'RFC_READ_TABLE' ORDER BY PARAMTYPE, PPOSITION;
     * </pre>
     */
    public static function FUPARAREF($fm) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $fm = strtoupper($con->real_escape_string($fm));
        // TODO: Replace * with Field list for performance improvement
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_FUNC::FUPARAREF
                . " where funcname = '" . $fm . "' order by PARAMTYPE, PPOSITION";
        return $con->query($sql);
    }

    /**
     * Function Module parameters text.
     * <pre>
     * SELECT STEXT FROM abapfunc.funct_e where SPRAS = 'E' AND funcname = 'RFC_READ_TABLE' AND PARAMETER = 'DATA' AND KIND = 'P'
     * </pre>
     */
    public static function FUNCT($fm, $para, $kind) {
        if ($kind != ABAP_DB_CONST::FUPARAREF_PARAMTYPE_X) {
            $kind = ABAP_DB_CONST::FUNCT_KIND_P;
        }
        $sql = "select STEXT from " . ABAP_DB_TABLE_FUNC::FUNCT         // Only English text in this table
                . " where SPRAS = ? and funcname = ? and PARAMETER = ? and KIND = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]; // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ssss', $langu, $fm, $para, $kind);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

}

/** Database table names - hierarchy objects. */
class ABAP_DB_TABLE_HIER {

    /**
     * Release Status of Software Components in System.
     */
    const CVERS = "cvers";

    /**
     * Reference Table for CVERS Entries.
     */
    const CVERS_REF = "cvers_ref";

    /**
     * Application Components.
     */
    const DF14L = "df14l";

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

    /**
     * Packages.
     */
    const TDEVC = "tdevc";

    /**
     * Texts for Packages.
     */
    const TDEVCT = "tdevct";

    /**
     * Software Component list.
     */
    public static function CVERS_List() {
        $dbc = ABAP_DB_SCHEMA::getConnection();
        $sql = "select * from " . ABAP_DB_TABLE_HIER::CVERS . " order by COMPONENT";
        $result = $dbc->query($sql);
        return $result;
    }

    /**
     * Software Component.
     */
    public static function CVERS($SoftComp) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $SoftComp = $con->real_escape_string($SoftComp);
        $sql = "select * from " . ABAP_DB_TABLE_HIER::CVERS . " where COMPONENT = '" . $SoftComp . "'";
        $qry = $con->query($sql);
        $result = mysqli_fetch_array($qry);
        return $result;
    }

    /**
     * Software Component text.
     */
    public static function CVERS_REF($SoftComp) {
        if (empty($SoftComp)) {
            return '';
        }
        $dbc = ABAP_DB_SCHEMA::getConnection();
        $sql = "select desc_text from " . ABAP_DB_TABLE_HIER::CVERS_REF . " where COMPONENT = ? and LANGU = ?";
        $stmt = $dbc->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]; // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $SoftComp, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    /**
     * BMFR Site Map.
     * <pre>
     * SELECT FCTR_ID FROM abaphier.df14l where FCTR_ID <> '';
     * </pre>
     */
    public static function DF14L_Sitemap() {
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "select FCTR_ID from " . ABAP_DB_TABLE_HIER::DF14L
                . " where FCTR_ID <> ''";
        return $con->query($sql);
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
    public static function DF14L_List($index) {
        $con = ABAP_DB_SCHEMA::getConnection();
        if (ABAP_DB_CONST::INDEX_TOP == $index) {
            $sql = "select * from " . ABAP_DB_TABLE_HIER::DF14L
                    . " where PS_POSID not like '%-%' AND trim(coalesce(PS_POSID, '')) <>'' ORDER BY PS_POSID";
        } else {
            $index = $con->real_escape_string($index);
            $sql = "select * from " . ABAP_DB_TABLE_HIER::DF14L
                    . " where PS_POSID like '" . $index . "%' AND trim(coalesce(PS_POSID, '')) <>'' ORDER BY PS_POSID";
        }
        return $con->query($sql);
    }

    /**
     * Application Component.
     */
    public static function DF14L($AppComp) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $AppComp = $con->real_escape_string($AppComp);
        $sql = "select * from " . ABAP_DB_TABLE_HIER::DF14L . " where FCTR_ID = '" . $AppComp . "'";
        $qry = $con->query($sql);
        $result = mysqli_fetch_array($qry);
        return $result;
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
        $con = ABAP_DB_SCHEMA::getConnection();
        $Fctr_id = $con->real_escape_string($Fctr_id);
        $sql = "select FCTR_ID, PS_POSID, (length(PS_POSID) - LENGTH(REPLACE(PS_POSID, '-', '')) + 1) AS LEVEL "
                . " from " . ABAP_DB_TABLE_HIER::DF14L . " where fctr_id = '" . $Fctr_id . "' AND trim(coalesce(PS_POSID, '')) <>'' order by PS_POSID ";
        return $con->query($sql);
    }

    public static function DF14L_ID($Fctr_id) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $Fctr_id = $con->real_escape_string($Fctr_id);
        $sql = "select FCTR_ID, PS_POSID "
                . " from " . ABAP_DB_TABLE_HIER::DF14L . " where fctr_id = '" . $Fctr_id . "' AND trim(coalesce(PS_POSID, '')) <>'' order by PS_POSID ";
        return $con->query($sql);
    }

    /**
     * Application Component PS_POSID.
     */
    public static function DF14L_PS_POSID($fctr_id) {
        $sql = "select PS_POSID from " . ABAP_DB_TABLE_HIER::DF14L . " where FCTR_ID = ? ";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $stmt->bind_param('s', $fctr_id);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
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
        $con = ABAP_DB_SCHEMA::getConnection();
        $posid = $con->real_escape_string($posid);
        $fctr = $con->real_escape_string($fctr);
        $sql = "select FCTR_ID, PS_POSID from " . ABAP_DB_TABLE_HIER::DF14L
                . " where PS_POSID LIKE '" . $posid . "%'"
                . " and FCTR_ID <> " . $fctr . " order by PS_POSID";
        return $con->query($sql);
    }

    /**
     * Application Component text.
     */
    public static function DF14T($AppComp) {
        if (empty($AppComp)) {
            return '';
        }
        $sql = "select name from " . ABAP_DB_TABLE_HIER::DF14T . " where FCTR_ID = ? and LANGU = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU];  // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $AppComp, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    public static function Hier($Pgmid, $ObjType, $ObjName) {
        $hier = new ABAP_Hierarchy();
        $tadir = ABAP_DB_TABLE_HIER::TADIR($Pgmid, $ObjType, $ObjName);
        $hier->CRELEASE = $tadir['CRELEASE'];
        $hier->DEVCLASS = $tadir['DEVCLASS'];
        $hier->DEVCLASS_T = ABAP_DB_TABLE_HIER::TDEVCT($hier->DEVCLASS);
        $tdevc = ABAP_DB_TABLE_HIER::TDEVC($hier->DEVCLASS);
        $hier->DLVUNIT = $tdevc['DLVUNIT'];
        $hier->DLVUNIT_T = ABAP_DB_TABLE_HIER::CVERS_REF($hier->DLVUNIT);
        $df14l = ABAP_DB_TABLE_HIER::DF14L($tdevc['COMPONENT']);
        $hier->FCTR_ID = $tdevc['COMPONENT'];
        $hier->POSID = $df14l['PS_POSID'];
        $hier->POSID_T = ABAP_DB_TABLE_HIER::DF14T($hier->FCTR_ID);
        return $hier;
    }

    /**
     * ABAP Object directory.
     */
    public static function TADIR($Pgmid, $ObjType, $ObjName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $Pgmid = $con->real_escape_string($Pgmid);
        $ObjType = $con->real_escape_string($ObjType);
        $ObjName = $con->real_escape_string($ObjName);
        $sql = "select * from " . ABAP_DB_TABLE_HIER::TADIR
                . " where pgmid = '" . $Pgmid . "'"
                . " and object = '" . $ObjType . "'"
                . " and obj_name = '" . $ObjName . "'";
        $qry = $con->query($sql);
        $result = mysqli_fetch_array($qry);
        return $result;
    }

    /**
     * Get contained object for one package.
     * <pre>
     * select OBJ_NAME from tadir where PGMID = 'R3TR' and OBJECT = 'TABL' AND DEVCLASS = '/AIN/ACTIVITIES'
     * </pre>
     */
    public static function TADIR_Child($Package, $Pgmid, $ObjType) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $Package = $con->real_escape_string($Package);
        $Pgmid = $con->real_escape_string($Pgmid);
        $ObjType = $con->real_escape_string($ObjType);
        $sql = "select OBJ_NAME from " . ABAP_DB_TABLE_HIER::TADIR
                . " where PGMID = '" . $Pgmid . "'"
                . " and OBJECT = '" . $ObjType . "'"
                . " AND DEVCLASS = '" . $Package . "'";
        return $con->query($sql);
    }

    /**
     * Get function group list.
     */
    public static function TADIR_FUGR_List($index) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $index = $con->real_escape_string($index);
        $sql = "SELECT OBJ_NAME, DEVCLASS, COMPONENT FROM " . ABAP_DB_TABLE_HIER::TADIR
                . " WHERE pgmid = 'R3TR' and object = 'FUGR' "
                . " and OBJ_NAME like '" . $index . "%'"
                . " order by OBJ_NAME";
        return $con->query($sql);
    }

    /**
     * Function Group Site Map.
     */
    public static function TADIR_FUGR_Sitemap() {
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "select OBJ_NAME from " . ABAP_DB_TABLE_HIER::TADIR
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
        return $con->query($sql);
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
    public static function TADIR_PROG_List($index) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $index = $con->real_escape_string($index);
        $sql = "SELECT OBJ_NAME, DEVCLASS, COMPONENT FROM " . ABAP_DB_TABLE_HIER::TADIR
                . " WHERE pgmid = 'R3TR' and object = 'PROG' "
                . " and OBJ_NAME like '" . $index . "%'"
                . " order by OBJ_NAME";
        return $con->query($sql);
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
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "select OBJ_NAME from " . ABAP_DB_TABLE_HIER::TADIR
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
        return $con->query($sql);
    }

    /**
     * Package List, of an index.
     * <pre>
     * SELECT * FROM tdevc where DEVCLASS LIKE 'A%' order by devclass
     * </pre>
     */
    public static function TDEVC_List($index) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $index = $con->real_escape_string($index);
        $sql = "select * from " . ABAP_DB_TABLE_HIER::TDEVC
                . " where devclass like '" . $index . "%' order by devclass";
        return $con->query($sql);
    }

    /**
     * DEVC Site Map.
     * <pre>
     * SELECT DEVCLASS FROM abaphier.tdevc where devclass not like 'Y%' and devclass not like 'Z%' and devclass not like '$%'
     * </pre>
     */
    public static function TDEVC_Sitemap() {
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "select DEVCLASS from " . ABAP_DB_TABLE_HIER::TDEVC
                . " where devclass not like 'Y%' and devclass not like 'Z%' and devclass not like '$%'";
        return $con->query($sql);
    }

    /**
     * Package.
     */
    public static function TDEVC($Package) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $Package = $con->real_escape_string($Package);
        $sql = "select * from " . ABAP_DB_TABLE_HIER::TDEVC
                . " where devclass = '" . $Package . "'";
        $qry = $con->query($sql);
        $result = mysqli_fetch_array($qry);
        return $result;
    }

    /**
     * Application Component list for one software component.
     * <pre>
     * select distinct COMPONENT from tdevc where dlvunit = 'SAP_BASIS'
     * </pre>
     */
    public static function TDEVC_COMPONENT($SoftComp) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $SoftComp = $con->real_escape_string($SoftComp);
        $sql = "select distinct COMPONENT from " . ABAP_DB_TABLE_HIER::TDEVC
                . " where dlvunit = '" . $SoftComp . "'";
        return $con->query($sql);
    }

    /**
     * Package list for one application component.
     * <pre>
     * select DEVCLASS from tdevc where COMPONENT = 'HLB0009110'
     * and devclass not like 'Y%' and devclass not like 'Z%'
     * </pre>
     */
    public static function TDEVC_DEVCLASS($AppComp) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $AppComp = $con->real_escape_string($AppComp);
        $sql = "select DEVCLASS from " . ABAP_DB_TABLE_HIER::TDEVC
                . " where COMPONENT = '" . $AppComp . "'"
                . " and devclass not like 'Y%' and devclass not like 'Z%'";
        return $con->query($sql);
    }

    /**
     * Package text.
     */
    public static function TDEVCT($Package) {
        if (empty($Package)) {
            return '';
        }
        $sql = "select ctext from " . ABAP_DB_TABLE_HIER::TDEVCT . " where devclass = ? and spras = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]; // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $Package, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

}

/** Database table names - program. */
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
        $con = ABAP_DB_SCHEMA::getConnection();
        $prog = $con->real_escape_string($prog);
        $sql = "select DNUM from " . ABAP_DB_TABLE_PROG::D020S
                . " where prog = '" . $prog . "' order by DNUM";
        return $con->query($sql);
    }

    /**
     * Screen number list.
     * <pre>
     * SELECT DTXT FROM abapprog.d020t
     * where prog = '/1BCDWB/DB/ORM/ORMT_ACT' and dynr = '1000' and lang = 'E'
     * </pre>
     */
    public static function D020T($prog, $dynr) {
        $sql = "select DTXT from " . ABAP_DB_TABLE_PROG::D020T
                . " where prog = ? AND dynr = ? AND lang = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]; // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('sss', $prog, $dynr, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
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
     * @param $fugr Function Group name
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
    public static function RSMPTEXTS($ProgName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $ProgName = $con->real_escape_string($ProgName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_PROG::RSMPTEXTS
                . " WHERE PROGNAME = '" . $ProgName
                . "' AND SPRSL = '" . $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] // ABAP_DB_CONST::LANGU_EN
                . "' order by obj_type, OBJ_CODE, SUB_CODE, TEXTTYPE";
        return $con->query($sql);
    }

    /**
     * Report title text.
     */
    public static function TRDIRT($Progname) {
        if (empty($Progname)) {
            return '';
        }
        $sql = "select TEXT from " . ABAP_DB_TABLE_PROG::TRDIRT
                . " where NAME = ? and SPRSL = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU];  // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $Progname, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    /**
     * Text for field REPOSRC-LDBNAME (Logical database).
     * <pre>
     * SELECT LDBTEXT FROM abapprog.ldbt where LDBNAME = 'AAV' and spras = 'E';
     * </pre>
     */
    public static function LDBT($LdbName) {
        $sql = "select LDBTEXT from " . ABAP_DB_TABLE_PROG::LDBT
                . " where LDBNAME = ? and spras = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU];  // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $LdbName, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    /**
     * Report Attributes.
     * <pre>
     * SELECT * FROM abapprog.yreposrcmeta where PROGNAME = 'SAPLFMCA_INCORR_BOR';
     * </pre>
     */
    public static function YREPOSRCMETA($ProgName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $ProgName = $con->real_escape_string($ProgName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_PROG::YREPOSRCMETA . " WHERE PROGNAME = '" . $ProgName . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
    }

    /**
     * Text for field REPOSRC-APPL (Application).
     * <pre>
     * SELECT ATEXT FROM abapprog.ytaplt where sprsl = 'E' and appl = 'A'
     * </pre>
     */
    public static function YTAPLT($Appl) {
        $sql = "select ATEXT from " . ABAP_DB_TABLE_PROG::YTAPLT
                . " where APPL = ? and SPRSL = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU];
        $stmt->bind_param('ss', $Appl, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

}

/** Database table access for - SPRO - Customizing - Edit Project. */
class ABAP_DB_TABLE_SPRO {
    
    const TNODEIMG_NODE_TYPE_REF = 'REF';
    const TNODEIMG_NODE_TYPE_IMG = 'IMG';
    const TNODEIMG_NODE_TYPE_IMG0 = 'IMG0';
    const TNODEIMG_NODE_TYPE_IMG1 = 'IMG1';

    /**
     * IMG Activities.
     */
    const CUS_IMGACH = "cus_imgach";

    /**
     * Text Table for IMG Activity.
     */
    const CUS_IMGACT = "cus_imgact";

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

    public static function CUS_IMGACH_List() {
        $sql = 'select * from ' . ABAP_DB_TABLE_SPRO::CUS_IMGACH . ' order by activity ';
        return ABAP_DB_TABLE::select($sql);
    }

    public static function CUS_IMGACT($activity) {
        $sql = 'select * from ' . ABAP_DB_TABLE_SPRO::CUS_IMGACT
                . ' where `activity` = :activity and spras = :langu';
        $paras = array(
            'activity' => $activity,
            'langu' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]
        );
        $records = ABAP_DB_TABLE::select($sql, $paras);
        $record = current($records);
        return $record['TEXT'];
    }

    /**
     * Load TNODEIMG based on node_id.
     *
     * @return array Result list, could be empty
     */
    public static function TNODEIMG_NODE_ID($node_id) {
        $sql = 'select * from ' . ABAP_DB_TABLE_SPRO::TNODEIMG
                . ' where `node_id` = :id';
        $paras = array(
            'id' => $node_id
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Load TNODEIMG based on parent_id.
     *
     * @return array Result list, could be empty
     */
    public static function TNODEIMG_PARENT_ID($parent_id) {
        $sql = 'select * from ' . ABAP_DB_TABLE_SPRO::TNODEIMG
                . ' where `parent_id` = :id order by node_type';
        $paras = array(
            'id' => $parent_id
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Load TNODEIMG based on tree_id.
     *
     * @return array Result list, could be empty
     */
    public static function TNODEIMG_TREE_ID($tree_id) {
        $sql = 'select * from ' . ABAP_DB_TABLE_SPRO::TNODEIMG
                . ' where `tree_id` = :id';
        $paras = array(
            'id' => $tree_id
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    /**
     * Load TNODEIMG based on tree_id.
     *
     * @return array Result list, could be empty
     */
    public static function TNODEIMG_TREE_NODE_ID($tree_id, $node_id) {
        $sql = 'select * from ' . ABAP_DB_TABLE_SPRO::TNODEIMG
                . ' where `tree_id` = :tid and `node_id` <> :nid order by node_type';
        $paras = array(
            'tid' => $tree_id,
            'nid' => $node_id
        );
        return ABAP_DB_TABLE::select($sql, $paras);
    }

    public static function TNODEIMGR($node_id) {
        $sql = 'select * from ' . ABAP_DB_TABLE_SPRO::TNODEIMGR
                . ' where `node_id` = :id';
        $paras = array(
            'id' => $node_id
        );
        $records = ABAP_DB_TABLE::select($sql, $paras);
        return current($records);
    }

    public static function TNODEIMGT($node_id) {
        $sql = 'select * from ' . ABAP_DB_TABLE_SPRO::TNODEIMGT
                . ' where `node_id` = :id and spras = :langu';
        $paras = array(
            'id' => $node_id,
            'langu' => $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]
        );
        $records = ABAP_DB_TABLE::select($sql, $paras);
        $record = current($records);
        return $record['TEXT'];
    }

}

/** Database table access for - tables. */
class ABAP_DB_TABLE_TABL {

    /**
     * DD: Data Class in Technical Settings: Texts.
     */
    const DARTT = "dartt";

    /**
     * SAP Tables.
     */
    const DD02L = "dd02l";

    /**
     * SAP DD: SAP Table Texts.
     */
    const DD02T = "dd02t";

    /**
     * Table Fields.
     */
    const DD03L = "dd03l";

    /**
     * Foreign key fields.
     */
    const DD05S = "dd05s";

    /**
     * Pool/cluster structures.
     */
    const DD06L = "dd06l";

    /**
     * R/3 DD: texts on SQL tables.
     */
    const DD06T = "dd06t";

    /**
     * R/3 DD: relationship definitions.
     */
    const DD08L = "dd08l";

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
     * Table List.
     * <pre>
     * SELECT TABNAME, TABCLASS, CONTFLAG FROM dd02l WHERE tabname like 'A%' order by TABNAME
     * </pre>
     */
    public static function DD02L_List($index) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $index = $con->real_escape_string($index);
        if ($index == ABAP_DB_CONST::DD02L_TABCLASS_CLUSTER) {
            $sql = "SELECT TABNAME, TABCLASS, CONTFLAG FROM " . ABAP_DB_TABLE_TABL::DD02L
                    . " WHERE TABCLASS = '" . ABAP_DB_CONST::DD02L_TABCLASS_CLUSTER . "' order by TABNAME";
        } else if ($index == ABAP_DB_CONST::DD02L_TABCLASS_POOL) {
            $sql = "SELECT TABNAME, TABCLASS, CONTFLAG FROM " . ABAP_DB_TABLE_TABL::DD02L
                    . " WHERE TABCLASS = '" . ABAP_DB_CONST::DD02L_TABCLASS_POOL . "' order by TABNAME";
        } else {
            $sql = "SELECT TABNAME, TABCLASS, CONTFLAG FROM " . ABAP_DB_TABLE_TABL::DD02L
                    . " WHERE tabname like '" . $index . "%' and"
                    . " ( TABCLASS = '" . ABAP_DB_CONST::DD02L_TABCLASS_TRANSP
                    . "' OR TABCLASS = '" . ABAP_DB_CONST::DD02L_TABCLASS_CLUSTER
                    . "' OR TABCLASS = '" . ABAP_DB_CONST::DD02L_TABCLASS_POOL . "' ) order by TABNAME";
        }
        return $con->query($sql);
    }

    /**
     * DD02L Site Map.
     * <pre>
     * SELECT TABNAME FROM abaptabl.dd02l WHERE TABNAME NOT LIKE 'Y%' AND TABNAME NOT LIKE 'Z%'
     * </pre>
     */
    public static function DD02L_Sitemap() {
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "select TABNAME from " . ABAP_DB_TABLE_TABL::DD02L
                . " where TABNAME not like 'Y%' and TABNAME not like 'Z%'";
        return $con->query($sql);
    }

    /**
     * Table list for a SQLTAB.
     * <pre>
     * SELECT * FROM dd02l where sqltab = 'RFBLG' order by TABNAME
     * </pre>
     */
    public static function DD02L_SQLTAB($Sqltab) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $Sqltab = $con->real_escape_string($Sqltab);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD02L
                . " WHERE SQLTAB = '" . $Sqltab . "' order by TABNAME";
        return $con->query($sql);
    }

    /**
     * Table Attributes.
     * <pre>
     * SELECT * FROM dd02l WHERE tabname = 'BKPF'
     * </pre>
     */
    public static function DD02L($TableName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $TableName = $con->real_escape_string($TableName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD02L . " WHERE tabname = '" . $TableName . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
    }

    /**
     * Table text.
     * <pre>
     * SELECT DDTEXT FROM dd02t where tabname = 'BKPF' AND DDLANGUAGE = 'E'
     * </pre>
     */
    public static function DD02T($TableName) {
        if (strlen(trim($TableName)) < 1) {
            return '';
        }

        $sql = "select DDTEXT from " . ABAP_DB_TABLE_TABL::DD02T
                . " where tabname = ? and DDLANGUAGE = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU];  // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $TableName, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    /**
     * Table Field List.
     * <pre>
     * SELECT * FROM dd03l WHERE tabname = 'BKPF' order by POSITION;
     * </pre>
     */
    public static function DD03L_List($TableName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $TableName = $con->real_escape_string($TableName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD03L
                . " WHERE tabname = '" . $TableName . "' order by POSITION";
        return $con->query($sql);
    }

    /**
     * Table Field Sitemap.
     * <pre>
     * SELECT IF (CHAR_LENGTH(TRIM(PRECFIELD)) > 0, CONCAT(TABNAME, '-', POSITION), CONCAT(TABNAME, '-', FIELDNAME)) AS FIELD
     * FROM abaptabl.dd03l WHERE TABNAME NOT LIKE 'Y%' AND TABNAME NOT LIKE 'Z%'
     * </pre>
     */
    public static function DD03L_Sitemap() {
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "select IF (CHAR_LENGTH(TRIM(PRECFIELD)) > 0, CONCAT(TABNAME, '-', POSITION), CONCAT(TABNAME, '-', FIELDNAME)) AS FIELD from " . ABAP_DB_TABLE_TABL::DD03L
                . " where TABNAME NOT LIKE 'Y%' AND TABNAME NOT LIKE 'Z%'";
        return $con->query($sql);
    }

    /**
     * Table Field Attributes.
     * <pre>
     * SELECT * FROM abaptabl.dd03l where TABNAME = 'BKPF' and FIELDNAME = 'BUKRS'
     * </pre>
     */
    public static function DD03L($TableName, $FieldName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $TableName = $con->real_escape_string($TableName);
        $FieldName = $con->real_escape_string($FieldName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD03L
                . " WHERE TABNAME = '" . $TableName
                . "' AND FIELDNAME = '" . $FieldName . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
    }

    /**
     * Table Field Attributes, by position.
     * <pre>
     * SELECT * FROM abaptabl.dd03l where TABNAME = 'BKPF' and POSITION = '0076'
     * </pre>
     */
    public static function DD03L_POSITION($TableName, $Position) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $TableName = $con->real_escape_string($TableName);
        $Position = $con->real_escape_string($Position);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD03L
                . " WHERE TABNAME = '" . $TableName
                . "' AND POSITION = '" . $Position . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
    }

    /**
     * Foreign Key Fields.
     * <pre>
     * SELECT * FROM dd05s WHERE tabname = 'BKPF' order by FIELDNAME, PRIMPOS;
     * </pre>
     */
    public static function DD05S($TableName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $TableName = $con->real_escape_string($TableName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD05S
                . " WHERE tabname = '" . $TableName . "' order by FIELDNAME, PRIMPOS";
        return $con->query($sql);
    }

    /**
     * Cluster/Pool Table List.
     * <pre>
     * SELECT * FROM dd06l order by SQLTAB
     * </pre>
     */
    public static function DD06L_List() {
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD06L . " order by SQLTAB";
        return $con->query($sql);
    }

    /**
     * Cluster/Pool table.
     */
    public static function DD06L($Sqltab) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $Sqltab = $con->real_escape_string($Sqltab);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD06L . " where SQLTAB = '" . $Sqltab . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
    }

    /**
     * Cluster/Pool table text.
     */
    public static function DD06T($Sqltab) {
        $sql = "select DDTEXT from " . ABAP_DB_TABLE_TABL::DD06T . " where SQLTAB = ? and DDLANGUAGE = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU];  // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $Sqltab, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    /**
     * Data Element List.
     * <pre>
     * SELECT * FROM dd16s where SQLTAB = 'AABLG' order by position
     * </pre>
     */
    public static function DD16S($Sqltable) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $Sqltable = $con->real_escape_string($Sqltable);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD16S
                . " where SQLTAB = '" . $Sqltable . "' order by position";
        return $con->query($sql);
    }

    /**
     * Get index by field.
     * <pre>
     * SELECT * FROM abaptabl.dd17s where SQLTAB = 'BKPF' AND FIELDNAME = 'MANDT' ORDER BY INDEXNAME
     * </pre>
     */
    public static function DD17S_FIELDNAME($Sqltab, $FieldName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $Sqltab = $con->real_escape_string($Sqltab);
        $FieldName = $con->real_escape_string($FieldName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TABL::DD17S
                . " WHERE SQLTAB = '" . $Sqltab
                . "' AND FIELDNAME = '" . $FieldName . "' order by INDEXNAME";
        return $con->query($sql);
    }

}

/** Database table access for - transaction code. */
class ABAP_DB_TABLE_TRAN {

    /**
     * SAP Transaction Codes.
     */
    const TSTC = "tstc";

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
    public static function TSTC_List($index) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $index = $con->real_escape_string($index . '%');
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TRAN::TSTC
                . " where TCODE LIKE '" . $index . "' order by TCODE";
        return $con->query($sql);
    }

    /**
     * DD01L Site Map.
     * <pre>
     * SELECT TCODE FROM abaptran.tstc where TCODE not like 'Y%' and  TCODE not like 'Z%'
     * </pre>
     */
    public static function TSTC_Sitemap() {
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "select TCODE from " . ABAP_DB_TABLE_TRAN::TSTC
                . " where TCODE not like 'Y%' and TCODE not like 'Z%'";
        return $con->query($sql);
    }

    /**
     * Transaction Code attribute.
     * <pre>
     * SELECT * FROM tstc where TCODE  = 'FB01'
     * </pre>
     */
    public static function TSTC($tcode) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $tcode = $con->real_escape_string($tcode);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TRAN::TSTC . " where TCODE = '" . $tcode . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
    }

    /**
     * Transaction Code attribute - Authorization.
     * <pre>
     * SELECT * FROM tstca where TCODE  = 'FB01'
     * </pre>
     */
    public static function TSTCA_List($tcode) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $tcode = $con->real_escape_string($tcode);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TRAN::TSTCA
                . " where TCODE = '" . $tcode . "' order by OBJECT";
        return $con->query($sql);
    }

    /**
     * Transaction code refers to one program.
     * <pre>
     * SELECT TCODE FROM abaptran.tstc where PGMNA = '/AIN/SAPLUI_DOC' order by TCODE
     * </pre>
     */
    public static function TSTC_PGMNA($prog) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $prog = $con->real_escape_string($prog);
        $sql = "SELECT TCODE FROM " . ABAP_DB_TABLE_TRAN::TSTC
                . " where PGMNA = '" . $prog . "' order by TCODE";
        return $con->query($sql);
    }

    /**
     * Transaction Code attribute - Additional Attributes.
     * <pre>
     * SELECT * FROM tstcc WHERE TCODE = 'FB01'
     * </pre>
     */
    public static function TSTCC($tcode) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $tcode = $con->real_escape_string($tcode);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TRAN::TSTCC . " where TCODE = '" . $tcode . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
    }

    /**
     * Transaction Code attribute - Additional Attributes.
     * <pre>
     * SELECT * FROM tstcp WHERE TCODE = '/AIN/CS'
     * </pre>
     */
    public static function TSTCP($tcode) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $tcode = $con->real_escape_string($tcode);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_TRAN::TSTCP . " where TCODE = '" . $tcode . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
    }

    /**
     * Transaction Code text.
     * <pre>
     * SELECT ttext FROM tstct where tcode = 'FB03' AND SPRSL = 'E'
     * </pre>
     */
    public static function TSTCT($TCode) {
        $sql = "select ttext from " . ABAP_DB_TABLE_TRAN::TSTCT
                . " where TCODE = ? and SPRSL = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]; // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $TCode, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

}

/** Database table names - view. */
class ABAP_DB_TABLE_VIEW {

    /**
     * Aggregate Header (Views, MC Objects, Lock Objects).
     */
    const DD25L = "dd25l";

    /**
     * Short Texts for Views and Lock Objects.
     */
    const DD25T = "dd25t";

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
    public static function DD25L_List($index) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $index = $con->real_escape_string($index . '%');
        $sql = "SELECT VIEWNAME, VIEWCLASS, ROOTTAB FROM " . ABAP_DB_TABLE_VIEW::DD25L
                . " where VIEWNAME LIKE '" . $index . "' order by VIEWNAME";
        return $con->query($sql);
    }

    /**
     * DD25L Site Map.
     * <pre>
     * SELECT VIEWNAME FROM abapview.dd25l WHERE VIEWNAME <> '' AND VIEWNAME NOT LIKE 'Y%' AND VIEWNAME NOT LIKE 'Z%'
     * </pre>
     */
    public static function DD25L_Sitemap() {
        $con = ABAP_DB_SCHEMA::getConnection();
        $sql = "select VIEWNAME from " . ABAP_DB_TABLE_VIEW::DD25L
                . " where VIEWNAME <> '' AND VIEWNAME NOT LIKE 'Y%' AND VIEWNAME NOT LIKE 'Z%'";
        return $con->query($sql);
    }

    /**
     * View.
     */
    public static function DD25L($ViewName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $ViewName = $con->real_escape_string($ViewName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_VIEW::DD25L . " where VIEWNAME = '" . $ViewName . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
    }

    /**
     * View text.
     */
    public static function DD25T($ViewName) {
        $sql = "select DDTEXT from " . ABAP_DB_TABLE_VIEW::DD25T . " where VIEWNAME = ? and DDLANGUAGE = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]; // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $ViewName, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    /**
     * Base tables and foreign key relationships for a view.
     * <pre>
     * SELECT * FROM dd26s where viewname = 'AANL' order by TABPOS;
     * </pre>
     */
    public static function DD26S_List($ViewName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $ViewName = $con->real_escape_string($ViewName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_VIEW::DD26S
                . " where VIEWNAME = '" . $ViewName . "' order by TABPOS";
        return $con->query($sql);
    }

    /**
     * Fields in an Aggregate (View, MC Object, Lock Object).
     * <pre>
     * SELECT * FROM abapview.dd27s WHERE VIEWNAME = 'AANL' ORDER BY OBJPOS
     * </pre>
     */
    public static function DD27S_List($ViewName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $ViewName = $con->real_escape_string($ViewName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_VIEW::DD27S
                . " where VIEWNAME = '" . $ViewName . "' order by OBJPOS";
        return $con->query($sql);
    }

    /**
     * Lines of a selection condition.
     * <pre>
     * SELECT * FROM dd28s where CONDNAME = 'ANEKPV' order by POSITION
     * </pre>
     */
    public static function DD28S_List($ViewName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $ViewName = $con->real_escape_string($ViewName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_VIEW::DD28S
                . " where CONDNAME = '" . $ViewName . "' order by POSITION";
        return $con->query($sql);
    }

    /**
     * DM Entity Type Short Text.
     * <pre>
     * SELECT LANGBEZ FROM dm02t where SPRACHE = 'E' and entid = '12052'
     * </pre>
     */
    public static function DM02T($Entid) {
        $sql = "select LANGBEZ from " . ABAP_DB_TABLE_VIEW::DM02T . " where entid = ? and SPRACHE = ?";
        $stmt = ABAP_DB_SCHEMA::getConnection()->prepare($sql);
        $langu = $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU]; // ABAP_DB_CONST::LANGU_EN;
        $stmt->bind_param('ss', $Entid, $langu);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    /**
     * DM View-Entity Type Assignment.
     * <pre>
     * SELECT * FROM abapview.dm25l where VIEWNAME = 'ENT1003'
     * </pre>
     */
    public static function DM25L($ViewName) {
        $con = ABAP_DB_SCHEMA::getConnection();
        $ViewName = $con->real_escape_string($ViewName);
        $sql = "SELECT * FROM " . ABAP_DB_TABLE_VIEW::DM25L . " where VIEWNAME = '" . $ViewName . "'";
        $qry = $con->query($sql);
        return mysqli_fetch_array($qry);
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
     * Customizing Activity - Header Data.
     */
    const CUS_ACTH = "cus_acth";

    /**
     * Customizing Activity - Object List.
     */
    const CUS_ACTOBJ = "cus_actobj";

    /**
     * Customizing Activity - Object List.
     */
    const CUS_ACTOBT = "cus_actobt";

    /**
     * Customizing Activity Text Table.
     */
    const CUS_ACTT = "cus_actt";

    /**
     * Table use in programs. Table for Use Report and Tables.
     */
    const D010TAB = "d010tab";

    /**
     * Where-Used Table for ABAP INCLUDEs.
     */
    const D010INC = "d010inc";

    /**
     * Documentation: Headers.
     */
    const DOKHL = "dokhl";

    /**
     * Index for Documentation Table DOKH.
     */
    const DOKIL = "dokil";

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
     * Left part of the database table {@link #REPOSRC}.
     *
     * @see #REPOSRC
     */
    const YREPOSRCMETA = "yreposrcmeta";

    /**
     * Extracted string of the source code of database table {@link #REPOSRC}.
     *
     * @see #REPOSRC
     */
    const YREPOSRCDATA = "yreposrcdata";

    /** Database connection. */
    private static $conn = null;

    /**
     * Get a new Database connection
     *
     * @return mixed PDO Database Connection
     */
    public static function get_conn() {
        if (ABAP_DB_TABLE::$conn == null) {
            $dsn = 'mysql:host=127.0.0.1;dbname=' . ABAP_DB_SCHEMA::SCHEMA;
            ABAP_DB_TABLE::$conn = new PDO($dsn, ABAP_DB_CONN::$user, ABAP_DB_CONN::$pass);
        }

        return ABAP_DB_TABLE::$conn;
    }

    public static function close_conn() {
        return ABAP_DB_TABLE::$conn = null;                    # close the connection
    }

    /**
     * Run an Select statement.
     */
    public static function select($sql, $paras = null) {
        $conn = ABAP_DB_TABLE::get_conn();
        if ($paras === null) {
            $res = $conn->query($sql);
        } else {
            $stmt = $conn->prepare($sql);
            $stmt->execute($paras);
            $res = $stmt->fetchAll();
        }

        return $res;
    }

}
