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

    public static function GetURLFuncModule($fm, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::FUNC_NAME, $fm, $fm, $desc);
    }

    public static function GetURLPackage($package, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DEVC_NAME, $package, $package, $desc);
    }

    public static function GetURLProgram($program, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::PROG_NAME, $program, $program, $desc);
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
        return ABAP_Navigation::GetURL(ABAP_OTYPE::TRAN_NAME, $tcode, $tcode, $desc);
    }

    public static function GetURLView($view, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::VIEW_NAME, $view, $view, $desc);
    }

    private static function GetURL($objtype, $objname, $value, $title) {
        $objtype = strtolower($objtype);
        $result = "";
        if (!empty($objname)) {
            $sTitle = (empty($title)) ? $value : $title;
            $result = "<a href=\"/abap/" . $objtype . "/" . $objtype . ".php?id=" . $objname . "\" title=\"" . $sTitle . "\"> " . $value . "</a>";
        }
        return $result;
    }

}

class ABAP_UI_TOOL {

    public static function Redirect404() {
        header(HTTP_STATUS::STATUS_404);
        header("Location: /page404.php");
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
        if ($CheckedValue == ABAP_DB_CONST::FLAG_TRUE ||
                $CheckedValue == ABAP_DB_CONST::TSTCC_S_WEBGUI_1 ||
                $CheckedValue == ABAP_DB_CONST::TSTCC_S_WEBGUI_2) {
            return "<input type=\"checkbox\" name=\"" . $Name . "\"  disabled=\"disabled\" checked=\"checked\" />";
        } else {
            return "<input type=\"checkbox\" name=\"" . $Name . "\"  disabled=\"disabled\" />";
        }
    }

    /**
     * Get radio box UI control.
     */
    public static function GetRadioBox($Name, $Flag) {
        if ($Flag) {
            return "<input type=\"radio\" name=\"" . $Name . "\"  disabled=\"disabled\" checked=\"checked\" />";
        } else {
            return "<input type=\"radio\" name=\"" . $Name . "\"  disabled=\"disabled\" />";
        }
    }

    /**
     * Function Module parameter Typing. Type assignment.
     * <p> Related table field FUPARAREF-REF_CLASS. </p>
     * <pre>
     *   Value 'X' - TYPE REF TO;
     *   Value '' - TYPE. 
     * </pre>
     * <p> Related table RSFBTYPEIN.</p>
     *
     */
    public static function GetFunctionModuleTyping($RefClass) {
        if ($RefClass == ABAP_DB_CONST::FLAG_TRUE) {
            return 'TYPE REF TO';
        } else {
            return 'TYPE';
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

    /**
     * Get transaction code type.
     */
    public static function GetTCodeTypeDesc($TCodeType) {
        $desc = 'Transaction Code Type';
        if ($TCodeType == '00') {
            
        } else if ($TCodeType == '01') {
            
        } else if ($TCodeType == '02') {
            
        } else if ($TCodeType == '04') {
            
        } else if ($TCodeType == '05') {
            
        } else if ($TCodeType == '06') {
            
        } else if ($TCodeType == '08') {
            
        } else if ($TCodeType == '0c') {
            
        } else if ($TCodeType == '21') {
            
        } else if ($TCodeType == '22') {
            
        } else if ($TCodeType == '44') {
            
        } else if ($TCodeType == '80') {
            
        } else if ($TCodeType == '84') {
            
        } else if ($TCodeType == '90') {
            
        } else if ($TCodeType == '94') {
            
        } else if ($TCodeType == 'a0') {
            
        }

        return $desc;
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
