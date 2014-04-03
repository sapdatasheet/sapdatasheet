<?php

require_once 'global.php';

class ABAP_Navigation {

    public static function GetURLAppComp($fctr_id, $posid, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::BMFR_NAME, $fctr_id, $posid, $desc);
    }

    public static function GetURLDomain($domain, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DOMA_NAME, $domain, $domain, $desc);
    }

    public static function GetURLDomainValue($domain, $domainValue, $desc) {
        if (strlen(trim($domainValue)) < 1) {
            $domainValue = '&nbsp;';
        }
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DOMA_NAME, $domain, $domainValue, $desc);
    }

    public static function GetURLDtel($rollname, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DTEL_NAME, $rollname, $rollname, $desc);
    }

    public static function GetURLPackage($package, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DEVC_NAME, $package, $package, $desc);
    }

    public static function GetURLSoftComp($compName, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::CVERS_NAME, $compName, $compName, $desc);
    }

    public static function GetURLSqltable($sqlTable, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::SQLT_NAME, $sqlTable, $sqlTable, $desc);
    }

    public static function GetURLTable($table, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::TABL_NAME, $table, $table, $desc);
    }

    public static function GetURLTransactionCode($tcode, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::CVERS_NAME, $tcode, $tcode, $desc);
    }

    private static function GetURL($objtype, $objname, $value, $title) {
        $objtype = strtolower($objtype);
        $result = "";
        if (!empty($objname)) {
            $sTitle = (empty($title)) ? $value : $title;
            $result = "<a href=\"/abap/" . $objtype . "/" . $objtype . ".php?id=" . $objname . "\" title=\"" . $sTitle . "\"> " . $value . " </a>";
        }
        return $result;
    }

}

class ABAP_UI_TOOL {

    public static function Redirect404() {
        header(HTTP_STATUS::STATUS_404);
        header("Location: /abap/page404.php");
    }

    public static function CheckText($Text) {
        if (empty($Text)) {
            return '(Not Set)';
        } else {
            return $Text;
        }
    }

    public static function CheckInt($Int) {
        if ($Int == 0) {
            return '&nbsp;';
        } else {
            return $Int;
        }
    }

    /**
     * Get check box UI control.
     */
    public static function GetCheckBox($Name, $CheckedValue) {
        if ($CheckedValue == ABAP_DB_CONST::FLAG_TRUE) {
            return "<input type=\"checkbox\" name=\"" . $Name . "\"  disabled=\"disabled\" checked=\"checked\" />";
        } else {
            return "<input type=\"checkbox\" name=\"" . $Name . "\"  disabled=\"disabled\" />";
        }
    }
    
    /**
     * Get check box UI control.
     */
    public static function GetSqltDesc($Sqlclass) {
        if ($Sqlclass == 'POOL') {
            return 'Table pool';
        } else {
            return 'Table cluster';
        }
    }

}

class ABAP_Hierarchy {

    /**
     * Package. <p> Database field: TADIR-DEVCLASS or TDEVC-DEVCLASS. </p>
     */
    public $DEVCLASS = '';

    /**
     * Text of {@link #DEVCLASS}.
     */
    public $DEVCLASS_T = '';

    /**
     * Software Component. <p> Database field: TDEVC-DLVUNIT. </p>
     */
    public $DLVUNIT = '';

    /**
     * Text of {@link #DLVUNIT}. <p> Database field: CVERS_REF-DESC_TEXT. </p>
     */
    public $DLVUNIT_T = '';

    /**
     * Application Component. <p> Database field: DF14L-FCTR_ID. </p>
     */
    public $FCTR_ID = '';

    /**
     * Application component ID. <p> Database field: DF14L-PS_POSID. </p>
     */
    public $POSID = '';

    /**
     * Text of {@link #POSID}.
     */
    public $POSID_T = '';

    /**
     * SAP Release. <p> Database field: TADIR-CRELEASE. </p>
     */
    public $CRELEASE = '';

}
