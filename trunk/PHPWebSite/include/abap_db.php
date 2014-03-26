<?php

require_once 'config.php';

class ABAP_DB_CONST {

    const INDEX_TOP = "TOP";
    const INDEX_A = "A";
    const LANGU_EN = "E";
    
    /** Domain names. */
    const DD01L_DATATYPE_DOMAIN = "DATATYPE";
    const TADIR_COMP_TYPE_DOMAIN = "RELC_TYPE";
    const TADIR_PGMID_R3TR = "R3TR";
    const TDEVC_MAINPACK_DOMAIN = "MAINPACK";

}

/** Database schema & connection. */
class ABAP_DB_SCHEMA {

    /** Database schema type: QAS - QA System (local testing web), PRD - Production System (online web) */
    const TYPE_QAS = 'QAS';
    const TYPE_PRD = 'PRD';

    /** Database schema profix for PRD schema name. */
    const PREFIX_PRD = 'A943634_';

    /** Domain. */
    const DOMA = 'abapdoma';

    /** Data element. */
    const DTEL = 'abapdtel';

    /** Function module. */
    const FUNC = 'abapfunc';

    /** Hierarchy. */
    const HIER = 'abaphier';

    /** Program. */
    const PROG = 'abapprog';

    /** Table. */
    const TABL = 'abaptabl';

    /** Transaction code. */
    const TRAN = 'abaptran';

    /** View. */
    const VIEW = 'abapview';

    private static $conn_doma = null;
    private static $conn_dtel = null;
    private static $conn_func = null;
    private static $conn_hier = null;
    private static $conn_prog = null;
    private static $conn_tabl = null;
    private static $conn_tran = null;
    private static $conn_view = null;

    public static function Schema($schema) {
        $result = $schema;
        if ($GLOBALS['ABAP_DB_SCHEMA_TYPE'] == ABAP_DB_SCHEMA::TYPE_PRD) {
            $result = ABAP_DB_SCHEMA::PREFIX_PRD . $schema;
        }

        return $result;
    }

    /** Get database connection for domain. */
    public static function getConnDoma() {
        if (ABAP_DB_SCHEMA::$conn_doma == null) {
            ABAP_DB_SCHEMA::$conn_doma = ABAP_DB_SCHEMA::getConn(ABAP_DB_SCHEMA::Schema(ABAP_DB_SCHEMA::DOMA));
        }
        return ABAP_DB_SCHEMA::$conn_doma;
    }

    /** Get database connection for data element. */
    public static function getConnDtel() {
        if (is_null(ABAP_DB_SCHEMA::$conn_dtel)) {
            ABAP_DB_SCHEMA::$conn_dtel = ABAP_DB_SCHEMA::getConn(ABAP_DB_SCHEMA::Schema(ABAP_DB_SCHEMA::DTEL));
        }
        return ABAP_DB_SCHEMA::$conn_dtel;
    }

    /** Get database connection for function module. */
    public static function getConnFunc() {
        if (is_null(ABAP_DB_SCHEMA::$conn_func)) {
            ABAP_DB_SCHEMA::$conn_func = ABAP_DB_SCHEMA::getConn(ABAP_DB_SCHEMA::Schema(ABAP_DB_SCHEMA::FUNC));
        }
        return ABAP_DB_SCHEMA::$conn_func;
    }

    /** Get database connection for hierarchy. */
    public static function getConnHier() {
        if (is_null(ABAP_DB_SCHEMA::$conn_hier)) {
            ABAP_DB_SCHEMA::$conn_hier = ABAP_DB_SCHEMA::getConn(ABAP_DB_SCHEMA::Schema(ABAP_DB_SCHEMA::HIER));
        }
        return ABAP_DB_SCHEMA::$conn_hier;
    }

    /** Get database connection for program. */
    public static function getConnProg() {
        if (is_null(ABAP_DB_SCHEMA::$conn_prog)) {
            ABAP_DB_SCHEMA::$conn_prog = ABAP_DB_SCHEMA::getConn(ABAP_DB_SCHEMA::Schema(ABAP_DB_SCHEMA::PROG));
        }
        return ABAP_DB_SCHEMA::$conn_prog;
    }

    /** Get database connection for table. */
    public static function getConnTabl() {
        if (is_null(ABAP_DB_SCHEMA::$conn_tabl)) {
            ABAP_DB_SCHEMA::$conn_tabl = ABAP_DB_SCHEMA::getConn(ABAP_DB_SCHEMA::Schema(ABAP_DB_SCHEMA::TABL));
        }
        return ABAP_DB_SCHEMA::$conn_tabl;
    }

    /** Get database connection for transaction codes. */
    public static function getConnTran() {
        if (is_null(ABAP_DB_SCHEMA::$conn_tran)) {
            ABAP_DB_SCHEMA::$conn_tran = ABAP_DB_SCHEMA::getConn(ABAP_DB_SCHEMA::Schema(ABAP_DB_SCHEMA::TRAN));
        }
        return ABAP_DB_SCHEMA::$conn_tran;
    }

    /** Get database connection for view. */
    public static function getConnView() {
        if (is_null(ABAP_DB_SCHEMA::$conn_view)) {
            ABAP_DB_SCHEMA::$conn_view = ABAP_DB_SCHEMA::getConn(ABAP_DB_SCHEMA::Schema(ABAP_DB_SCHEMA::VIEW));
        }
        return ABAP_DB_SCHEMA::$conn_view;
    }

    /** Get database conection object. */
    private static function getConn($schema) {
        $msqli = new mysqli(ABAP_DB_CONN::$host, ABAP_DB_CONN::$user, ABAP_DB_CONN::$pass, $schema);
        $msqli->set_charset("utf8");
        return $msqli;
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
        $con = ABAP_DB_SCHEMA::getConnDoma();
        $index = $con->real_escape_string($index . '%');
        $sql = "SELECT DOMNAME, DATATYPE, LENG, DECIMALS, AS4DATE FROM " . ABAP_DB_TABLE_DOMA::DD01L 
                . " where DOMNAME LIKE '" . $index . "' order by DOMNAME";
        return $con->query($sql);
    }

    /**
     * Domain.
     */
    public static function DD01L($DomName) {
        $con = ABAP_DB_SCHEMA::getConnDoma();
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
        $stmt = ABAP_DB_SCHEMA::getConnDoma()->prepare($sql);
        $stmt->bind_param('ss', $Domain, $langu = ABAP_DB_CONST::LANGU_EN);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

    /**
     * Get Domain Value Text.
     */
    public static function DD07T($Domain, $ValueL) {
        $sql = "select DDTEXT from " . ABAP_DB_TABLE_DOMA::DD07T . " where DOMNAME = ? and DDLANGUAGE = ? and DOMVALUE_L = ?";
        $stmt = ABAP_DB_SCHEMA::getConnDoma()->prepare($sql);
        $stmt->bind_param("sss", $Domain, $langu = ABAP_DB_CONST::LANGU_EN, $ValueL);
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
    const FUNCT_D = "funct_d";
    const FUNCT_E = "funct_e";

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
        $dbc = ABAP_DB_SCHEMA::getConnHier();
        $sql = "select * from " . ABAP_DB_TABLE_HIER::CVERS . " order by COMPONENT";
        $result = $dbc->query($sql);
        return $result;
    }

    /**
     * Software Component.
     */
    public static function CVERS($SoftComp) {
        $con = ABAP_DB_SCHEMA::getConnHier();
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
        $dbc = ABAP_DB_SCHEMA::getConnHier();
        $sql = "select desc_text from " . ABAP_DB_TABLE_HIER::CVERS_REF . " where COMPONENT = ? and LANGU = ?";
        $stmt = $dbc->prepare($sql);
        $stmt->bind_param('ss', $SoftComp, $langu = ABAP_DB_CONST::LANGU_EN);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
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
        $con = ABAP_DB_SCHEMA::getConnHier();
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
        $con = ABAP_DB_SCHEMA::getConnHier();
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
        $con = ABAP_DB_SCHEMA::getConnHier();
        $Fctr_id = $con->real_escape_string($Fctr_id);
        $sql = "select FCTR_ID, PS_POSID, (length(PS_POSID) - LENGTH(REPLACE(PS_POSID, '-', '')) + 1) AS LEVEL "
                . " from " . ABAP_DB_TABLE_HIER::DF14L . " where fctr_id = '" . $Fctr_id . "' AND trim(coalesce(PS_POSID, '')) <>'' order by PS_POSID ";
        return $con->query($sql);
    }

    public static function DF14L_ID($Fctr_id) {
        $con = ABAP_DB_SCHEMA::getConnHier();
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
        $stmt = ABAP_DB_SCHEMA::getConnHier()->prepare($sql);
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
        $con = ABAP_DB_SCHEMA::getConnHier();
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
        $sql = "select name from " . ABAP_DB_TABLE_HIER::DF14T . " where FCTR_ID = ? and LANGU = ?";
        $stmt = ABAP_DB_SCHEMA::getConnHier()->prepare($sql);
        $stmt->bind_param('ss', $AppComp, $langu = ABAP_DB_CONST::LANGU_EN);
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
        $con = ABAP_DB_SCHEMA::getConnHier();
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
        $con = ABAP_DB_SCHEMA::getConnHier();
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
     * Package List, of an index.
     * <pre>
     * SELECT * FROM tdevc where DEVCLASS LIKE 'A%' order by devclass
     * </pre>
     */
    public static function TDEVC_List($index) {
        $con = ABAP_DB_SCHEMA::getConnHier();
        $index = $con->real_escape_string($index);
        $sql = "select * from " . ABAP_DB_TABLE_HIER::TDEVC 
                . " where devclass like '" . $index . "%' order by devclass";
        return $con->query($sql);
    }

    /**
     * Package.
     */
    public static function TDEVC($Package) {
        $con = ABAP_DB_SCHEMA::getConnHier();
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
        $con = ABAP_DB_SCHEMA::getConnHier();
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
        $con = ABAP_DB_SCHEMA::getConnHier();
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
        $sql = "select ctext from " . ABAP_DB_TABLE_HIER::TDEVCT . " where devclass = ? and spras = ?";
        $stmt = ABAP_DB_SCHEMA::getConnHier()->prepare($sql);
        $stmt->bind_param('ss', $Package, $langu = ABAP_DB_CONST::LANGU_EN);
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

    /**
     * Menu Painter: Texts.
     */
    const RSMPTEXTS = "rsmptexts";
    const RSMPTEXTS_D = "rsmptexts_d";
    const RSMPTEXTS_E = "rsmptexts_e";

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
     */
    const YTAPLT = "ytaplt";

}

/** Database table names - table. */
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
     * Table text.
     * <pre>
     * SELECT DDTEXT FROM dd02t where tabname = 'BKPF' AND DDLANGUAGE = 'E'
     * </pre>
     */
    public static function DD02T($TableName) {
        $sql = "select DDTEXT from " . ABAP_DB_TABLE_TABL::DD02T
                . " where tabname = ? and DDLANGUAGE = ?";
        $stmt = ABAP_DB_SCHEMA::getConnTabl()->prepare($sql);
        $stmt->bind_param('ss', $TableName, $langu = ABAP_DB_CONST::LANGU_EN);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        return $result;
    }

}

/** Database table names - transaction code. */
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
     * Transaction Code text.
     * <pre>
     * SELECT ttext FROM tstct where tcode = 'FB03' AND SPRSL = 'E'
     * </pre>
     */
    public static function TSTCT($TCode) {
        $sql = "select ttext from " . ABAP_DB_TABLE_TRAN::TSTCT
                . " where TCODE = ? and SPRSL = ?";
        $stmt = ABAP_DB_SCHEMA::getConnTran()->prepare($sql);
        $stmt->bind_param('ss', $TCode, $langu = ABAP_DB_CONST::LANGU_EN);
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
     * IMG Activities.
     */
    const CUS_IMGACH = "cus_imgach";

    /**
     * Text Table for IMG Activity.
     */
    const CUS_IMGACT = "cus_imgact";

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

}
