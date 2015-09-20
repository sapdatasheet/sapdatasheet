<?php

$__ROOT__ = dirname(dirname(__FILE__));
require_once($__ROOT__ . '/include/global.php');

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

class ABAP_Navigation {

    public static function GetURLAppComp($fctr_id, $posid, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::BMFR_NAME, $fctr_id, $posid, $desc, $newwin);
    }

    public static function GetURLDomain($domain, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DOMA_NAME, $domain, $domain, $desc, $newwin);
    }

    public static function GetURLDomainValue($domain, $domainValue, $desc) {
        if (strlen(trim($domainValue)) < 1) {
            $domainValue = '&nbsp;';
        }

        return "<a href=\"/abap/" . strtolower(ABAP_OTYPE::DOMA_NAME)
                . "/" . strtolower($domain)
                . ".html#" . ABAP_UI_TOOL::ANCHOR_VALUES . "\" title=\"" . htmlentities($desc) . "\"> "
                . $domainValue . "</a>";
    }

    public static function GetURLDtel($rollname, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DTEL_NAME, $rollname, $rollname, $desc, $newwin);
    }

    public static function GetURLFuncModule($fm, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::FUNC_NAME, $fm, $fm, $desc, $newwin);
    }

    public static function GetURLFuncGroup($fg, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::FUGR_NAME, $fg, $fg, $desc, $newwin);
    }

    public static function GetURLPackage($package, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DEVC_NAME, $package, $package, $desc, $newwin);
    }

    public static function GetURLProgram($program, $desc, $value = "", $newwin = FALSE) {
        if ($value === "") {
            $value = $program;
        }
        return ABAP_Navigation::GetURL(ABAP_OTYPE::PROG_NAME, $program, $value, $desc, $newwin);
    }

    public static function GetURLSoftComp($compName, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::CVERS_NAME, $compName, $compName, $desc, $newwin);
    }

    public static function GetURLSproIMGActivity($img, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::SPRO_NAME, $img, $img, $desc, $newwin);
    }

    public static function GetURLSqltable($sqlTable, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::SQLT_NAME, $sqlTable, $sqlTable, $desc, $newwin);
    }

    public static function GetURLTable($table, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::TABL_NAME, $table, $table, $desc, $newwin);
    }

    public static function GetURLTableField($table, $field) {
        return "<a href=\"/abap/tabl/" . htmlentities(strtolower($table)) . "-" . htmlentities(strtolower($field))
                . ".html\" title=\"" . htmlentities($field)
                . "\" target=\"_blank\"> " . htmlentities($field) . "</a>";
    }

    public static function GetURLTableInclude($table, $field, $position) {
        return "<a href=\"/abap/tabl/" . htmlentities(strtolower($table)) . "-" . htmlentities($position)
                . ".html\" title=\"" . htmlentities($position)
                . "\" target=\"_blank\"> " . htmlentities($field) . "</a>";
    }

    public static function GetURLTransactionCode($tcode, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::TRAN_NAME, $tcode, $tcode, $desc, $newwin);
    }

    public static function GetURLView($view, $desc, $newwin = FALSE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::VIEW_NAME, $view, $view, $desc, $newwin);
    }

    private static function GetURL($objtype, $objname, $value, $title, $newwin = FALSE) {
        $result = "";
        if (strlen(trim($objname)) > 0) {
            $sTitle = (empty($title)) ? $value : $title;
            $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
            $result = "<a href=\"/abap/" . strtolower($objtype)
                    . "/" . htmlentities(strtolower($objname)) . ".html\" title=\""
                    . htmlentities($sTitle) . "\" . $newWindow> " . htmlentities($value) . "</a>";
        }
        return $result;
    }

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

class ABAP_UI_SPRO {

    public static function LoadImgNodes() {
        $nodeimg_list = ABAP_DB_TABLE_SPRO::TNODEIMG_PARENT_ID('368DDFAC3AB96CCFE10000009B38F976');
        foreach ($nodeimg_list as $nodeimg) {
            // Check reftree_id
            if (empty($nodeimg['REFTREE_ID']) === FALSE) {
                $check = ABAP_DB_TABLE_SPRO::TNODEIMG_TREE_ID($nodeimg['REFTREE_ID']);
                if (empty($check)) {
                    continue;
                }
            }

            // Check refnode_id
            if (empty($nodeimg['REFNODE_ID']) === FALSE) {
                $check = ABAP_DB_TABLE_SPRO::TNODEIMG_NODE_ID($nodeimg['REFNODE_ID']);
                if (empty($check)) {
                    continue;
                }
            }

            ABAP_UI_SPRO::echo_li($nodeimg);
        }
    }

    private static function write_child_tree($tree_id, $node_id, $level) {
        $child_list = ABAP_DB_TABLE_SPRO::TNODEIMG_TREE_NODE_ID($tree_id, $node_id);
        foreach ($child_list as $child) {
            ABAP_UI_SPRO::echo_li($child, $level);
        }
    }

    private static function write_child_node($node_id, $level) {
        $child_list = ABAP_DB_TABLE_SPRO::TNODEIMG_PARENT_ID($node_id);
        foreach ($child_list as $child) {
            ABAP_UI_SPRO::echo_li($child, $level);
        }
    }

    private static function echo_li($nodeimg, $level = 0) {

        // Add a New Line
        $skip = FALSE;         // If the node has no TNODEIMGR item, skip it
        $html_li = '<li>';
        $i = $level;
        while ($i > 0) {
            $i--;
            $html_li = $html_li . '&nbsp;&nbsp;&nbsp;&nbsp;';
        }
        $html_li = $html_li . $nodeimg['NODE_ID'] . ' - ' . $nodeimg['NODE_TYPE'];

        $text = ABAP_DB_TABLE_SPRO::TNODEIMGT($nodeimg['NODE_ID']);
        if (empty($text) === FALSE) {
            $html_li = $html_li . ' - ' . $text;
        }

        // Add Reference Node
        if ($nodeimg['NODE_TYPE'] === ABAP_DB_TABLE_SPRO::TNODEIMG_NODE_TYPE_IMG || $nodeimg['NODE_TYPE'] === ABAP_DB_TABLE_SPRO::TNODEIMG_NODE_TYPE_IMG1) {
            $imgr = ABAP_DB_TABLE_SPRO::TNODEIMGR($nodeimg['NODE_ID']);
            if (empty($imgr)) {
                $html_li = $html_li . 'No Reference Found';
                $skip = TRUE;
            } else {
                $html_li = $html_li . ' - ' . $imgr['REF_TYPE'];
                $imgr_t = ABAP_DB_TABLE_SPRO::CUS_IMGACT($imgr['REF_OBJECT']);
                if (empty($imgr_t) == FALSE) {
                    $html_li = $html_li . ' - ' . $imgr_t;
                }
            }
        }

        $html_li = $html_li . '</li>';
        if ($skip === FALSE) {
            print_r($html_li);
        }

        // Load Lower Level Nodes
        $level++;
        if ($nodeimg['NODE_TYPE'] === ABAP_DB_TABLE_SPRO::TNODEIMG_NODE_TYPE_REF && empty($nodeimg['REFTREE_ID']) === FALSE && empty($nodeimg['REFNODE_ID']) === FALSE) {
            ABAP_UI_SPRO::write_child_tree($nodeimg['REFTREE_ID'], $nodeimg['REFNODE_ID'], $level);
        } else if ($nodeimg['NODE_TYPE'] === ABAP_DB_TABLE_SPRO::TNODEIMG_NODE_TYPE_IMG0) {
            ABAP_UI_SPRO::write_child_node($nodeimg['NODE_ID'], $level);
        }
    }

}

class ABAP_UI_TOOL {

    const ANCHOR_VALUES = "values";

    public static function Redirect404() {
        header(HTTP_STATUS::STATUS_404);
        header("Location: /page404.php");
    }

    /**
     * Clear zero value from UI.
     */
    public static function ClearZero($Int) {
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
     * Get Table Filed description.
     */
    public static function GetTablFieldDesc($PrecField, $RollName) {
        if (strlen(trim($PrecField)) > 0) {
            return ABAP_DB_TABLE_TABL::DD02T($PrecField);
        } else {
            return ABAP_DB_TABLE_DTEL::DD04T($RollName);
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

    public static function GetFuncParamLink($ParamType, $Structure) {
        $result = $Structure;

        if ($ParamType == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_T) {
            $result = ABAP_Navigation::GetURLTable($Structure, '');
        } else if ($ParamType == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_X) {
            $result = $Structure;
        } else if ($ParamType == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_I || $ParamType == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_E || $ParamType == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_C) {
            if (strpos($Structure, '-') !== false) {
                // We have checked the database,
                //   the '-' is always in the middle
                //   the '-' will not located at beginning or end
                list($Table, $Field) = explode('-', $Structure, 2);
                $link_table = ABAP_Navigation::GetURLTable($Table, '');
                $link_field = ABAP_Navigation::GetURLTableField($Table, $Field);
                $result = $link_table . '-' . $link_field;
            }
        }

        return $result;
    }

    /**
     * Check if the desription string exsit or not
     *
     * @return (description) or emtpy string
     */
    public static function CheckDesc($desc) {
        if (!empty($desc)) {
            return '(' . htmlentities($desc) . ')';
        } else {
            return '';
        }
    }

}
