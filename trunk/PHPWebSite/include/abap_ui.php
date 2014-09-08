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

        $domain = $domain . '#VALUES';
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DOMA_NAME, $domain, $domainValue, $desc);
    }

    public static function GetURLDtel($rollname, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DTEL_NAME, $rollname, $rollname, $desc);
    }

    public static function GetURLFuncModule($fm, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::FUNC_NAME, $fm, $fm, $desc);
    }

    public static function GetURLFuncGroup($fg, $desc) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::FUGR_NAME, $fg, $fg, $desc);
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

    public static function GetURLTableField($table, $field) {
       return "<a href=\"/abap/tabl/field.php?table=" . $table . "&field=" . $field 
               . "\" title=\"" . $field 
               . "\" target=\"_blank\"> " . $field . "</a>";
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
    public static function GetFunctionModuleParameterType($Type) {
        if ($Type == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_I) {
            return 'Importing';
        } else if ($Type == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_E) {
            return 'Exporting';
        } else if ($Type == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_C) {
            return 'Changing';
        } else if ($Type == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_T) {
            return 'Tables';
        } else if ($Type == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_X) {
            return 'Exception';
        } else {
            return 'Unknown Type';
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

/**
 * Function module processing type.
 */
class ABAP_TFDIR_ProcessingType {

    /**
     * Radio button - Normal Function Module.
     */
    public $CHK_NORMAL = FALSE;

    /**
     * Radio button - JAVA Module Callable from ABAP.
     */
    public $CHK_ABAP2JAVA = FALSE;

    /**
     * Radio button - Module Callable from JAVA.
     */
    public $CHK_JAVA2ABAP = FALSE;

    /**
     * Radio button - Remote-Enabled Module.
     */
    public $CHK_REMOTE = FALSE;

    /**
     * Radio button - Remote-Enabled JAVA Module.
     */
    public $CHK_REMOTE_JAVA = FALSE;

    /**
     * Check box - BasXML supported.
     */
    public $CHK_BASXML_ENABLED = FALSE;

    /**
     * Radio button - Update Module.
     */
    public $CHK_VERBUCHER = FALSE;

    /**
     * Radio button - Update Module - Start update immediately.
     */
    public $CHK_UKIND1 = FALSE;

    /**
     * Radio button - Update Module - Update is started immediately, no
     * restart possible.
     */
    public $CHK_UKIND3 = FALSE;

    /**
     * Radio button - Update Module - Start of update delayed.
     */
    public $CHK_UKIND2 = FALSE;

    /**
     * Radio button - Update Module - Update triggered by collector (For
     * internal use only).
     */
    public $CHK_UKIND4 = FALSE;

}
