<?php

require_once 'global.php';

class ABAP_Navigation {

    public static function GetURLAppComp($appcompID, $appcomp, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::BMFR_NAME, $appcompID, $appcomp, $desc);
    }

    public static function GetURLDomain($domain, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DOMA_NAME, $domain, $domain, $desc);
    }

    public static function GetURLDomainValue($domain, $domainValue, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DOMA_NAME, $domain, $domainValue, $desc);
    }

    public static function GetURLPackage($package, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DEVC_NAME, $package, $package, $desc);
    }

    public static function GetURLSoftComp($compName, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::CVERS_NAME, $compName, $compName, $desc);
    }

    public static function GetURLTable($table, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::CVERS_NAME, $table, $table, $desc);
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
