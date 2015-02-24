<?php

$__ROOT__ = dirname(dirname(__FILE__));
require_once($__ROOT__ . '/include/config.php');

class ABAPANA_DB_CONN {
    
    /** Data limit. */
    const LIMIT = 1000;

    /** Schema Name. */
    const SCHEMA = 'abapanalytics';

    /** Database connection. */
    private static $conn = null;

    /** Get database connection. */
    public static function get() {
        if (ABAPANA_DB_CONN::$conn == null) {
            ABAPANA_DB_CONN::$conn = new mysqli(
                    ABAP_DB_CONN::$host, ABAP_DB_CONN::$user, ABAP_DB_CONN::$pass, ABAPANA_DB_CONN::SCHEMA);
            ABAPANA_DB_CONN::$conn->set_charset("utf8");
        }
        return ABAPANA_DB_CONN::$conn;
    }

}

class ABAPANA_DB_TABLE {

    /**
     * Transaction Codes.
     */
    const TRAN = "tran";

    /**
     * Load Transaction Code
     */
    public static function TRAN($tran) {
        $con = ABAPANA_DB_CONN::get();
        $tran = $con->real_escape_string($tran);
        $sql = "SELECT * FROM " . ABAPANA_DB_TABLE::TRAN . " where TCODE = '" . $tran . "'";
        $qry = $con->query($sql);
        $result = mysqli_fetch_array($qry);
        return $result;
    }

    public static function TRAN_Rela($column, $value, $limit = FALSE) {
        if (empty($column) or empty($value)) {
            return null;
        }
        $con = ABAPANA_DB_CONN::get();
        $column = $con->real_escape_string($column);
        $value = $con->real_escape_string($value);
        $sql = "SELECT tcode FROM " . ABAPANA_DB_TABLE::TRAN
                . " where " . $column . " = '" . $value . "'"
                . " order by tcode";
        if ($limit == TRUE) {
            $sql = $sql . ' limit ' . ABAPANA_DB_CONN::LIMIT;
        }
        return $con->query($sql);
    }

}
