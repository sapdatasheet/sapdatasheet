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

    public static function GetURLAppComp($fctr_id, $posid, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::BMFR_NAME, $fctr_id, $posid, $desc, $newwin);
    }

    public static function GetURLClass($class, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::CLAS_NAME, $class, $class, $desc, $newwin);
    }

    public static function GetURLDomain($domain, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DOMA_NAME, $domain, $domain, $desc, $newwin);
    }

    public static function GetURLDomainValue($domain, $domainValue, $desc, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DOMA_NAME, $domain, $domainValue, $desc, $newwin, ABAP_UI_CONST::ANCHOR_VALUES);
    }

    public static function GetURLDtel($rollname, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DTEL_NAME, $rollname, $rollname, $desc, $newwin);
    }

    public static function GetURLDtelDocument($rollname = NULL, $label = '?', $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DTEL_NAME, $rollname, $label, ABAP_UI_CONST::LABEL_F1Help, $newwin, ABAP_UI_CONST::ANCHOR_DOCUMENT);
    }

    public static function GetURLFuncModule($fm, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::FUNC_NAME, $fm, $fm, $desc, $newwin);
    }

    public static function GetURLInterface($intf, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::INTF_NAME, $intf, $intf, $desc, $newwin);
    }

    public static function GetURLFuncGroup($fg, $desc, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::FUGR_NAME, $fg, $fg, $desc, $newwin);
    }

    public static function GetURLMessageClass($msgcls, $desc = NULL, $newwin = TRUE) {
        // $msgcls = htmlentities(strtolower($msgcls));
        return ABAP_Navigation::GetURL(ABAP_OTYPE::MSAG_NAME, $msgcls, $msgcls, $desc, $newwin);
    }

    public static function GetURLMessageNumber($msgcls, $msgnr, $newwin = TRUE) {
        if (strlen(trim($msgcls)) < 1 || strlen(trim($msgnr)) < 1) {
            return '&nbsp;';
        }
        $objname = htmlentities(strtolower($msgcls)) . "-" . htmlentities(strtolower($msgnr));
        $title = htmlentities($msgcls . ' - ' . $msgnr);
        return ABAP_Navigation::GetURL(ABAP_OTYPE::MSAG_NAME, $objname, $msgnr, $title, $newwin);
    }

    public static function GetURLPackage($package, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::DEVC_NAME, $package, $package, $desc, $newwin);
    }

    public static function GetURLProgram($program, $desc = NULL, $value = "", $newwin = TRUE) {
        if ($value === "") {
            $value = $program;
        }
        return ABAP_Navigation::GetURL(ABAP_OTYPE::PROG_NAME, $program, $value, $desc, $newwin);
    }

    public static function GetURLSearchHelp($shlp, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::SHLP_NAME, $shlp, $shlp, $desc, $newwin);
    }

    public static function GetURLSoftComp($compName, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::CVERS_NAME, $compName, $compName, $desc, $newwin);
    }

    public static function GetURLSproIMGActivity($img, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::CUS0_NAME, $img, $img, $desc, $newwin);
    }

    public static function GetURLSqltable($sqlTable, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::SQLT_NAME, $sqlTable, $sqlTable, $desc, $newwin);
    }

    public static function GetURLTable($table, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::TABL_NAME, $table, $table, $desc, $newwin);
    }

    public static function GetURLTableField($table, $field, $newwin = TRUE) {
        if (strlen(trim($table)) < 1 || strlen(trim($field)) < 1) {
            return '&nbsp;';
        }
        $objname = htmlentities(strtolower($table)) . "-" . htmlentities(strtolower($field));
        return ABAP_Navigation::GetURL(ABAP_OTYPE::TABL_NAME, $objname, $field, $field, $newwin);
    }

    public static function GetURLTableInclude($table, $field, $position, $newwin = TRUE) {
        if (strlen(trim($table)) < 1 || strlen(trim($field)) < 1) {
            return '&nbsp;';
        }
        $objname = htmlentities(strtolower($table)) . "-" . htmlentities($position);
        return ABAP_Navigation::GetURL(ABAP_OTYPE::TABL_NAME, $objname, $field, $position, $newwin);
    }

    public static function GetURLTransactionCode($tcode, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::TRAN_NAME, $tcode, $tcode, $desc, $newwin);
    }

    public static function GetURLView($view, $desc = NULL, $newwin = TRUE) {
        return ABAP_Navigation::GetURL(ABAP_OTYPE::VIEW_NAME, $view, $view, $desc, $newwin);
    }

    private static function GetURL($objtype, $objname, $linkLabel, $linkTitle, $newwin = FALSE, $anchor = '') {
        if (strlen(trim($objtype)) < 1 || strlen(trim($objname)) < 1 || strlen(trim($linkLabel)) < 1) {
            return '&nbsp;';
        }

        $linkLabel = trim($linkLabel);
        if (empty(trim($linkTitle))) {
            $desc = ABAP_UI_TOOL::GetObjectDescr($objtype, $objname);
            $sTitle = (empty($desc)) ? $linkLabel : $desc;
        } else {
            $sTitle = $linkTitle;
        }
        $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
        $anchorTag = (strlen(trim($anchor)) > 0) ? '#' . $anchor : '';
        $url = '/abap/' . $objtype . '/' . htmlentities(strtolower($objname)) . '.html' . $anchorTag;
        $result = '<a href="' . strtolower($url)
                . '" title="' . htmlentities($sTitle) . '" '
                . $newWindow . '>'
                . htmlentities($linkLabel) . '</a>';
        return $result;
    }

    /**
     * Get ABAP Object URL.
     * 
     * @param string $oType Object Type, example: DOMA, DTEL
     * @param string $oName Object name, example: MANDT, BUKRS
     * @param string $subName Object sub name, example: Message number, Class method
     * @return string Object URL for supported object type, or else return object Name
     */
    public static function GetObjectURL($oType, $oName, $subName = NULL) {
        if (($oType == ABAP_OTYPE::TABL_NAME && strlen(trim($subName)) > 0) || ($oType == ABAP_OTYPE::DTF_NAME)) {
            return ABAP_Navigation::GetURLTable($oName)
                    . ' - '
                    . ABAP_Navigation::GetURLTableField($oName, $subName);
        } else if (array_key_exists($oType, ABAP_OTYPE::$OTYPES)) {
            return ABAP_Navigation::GetURL($oType, $oName, $oName, NULL, TRUE);
        } else if ($oType == ABAP_OTYPE::OM_NAME) {
            return ABAP_Navigation::GetURLClass($oName) . ' - ' . $subName;
        } else if ($oType == ABAP_OTYPE::NN_NAME) {
            return ABAP_Navigation::GetURLMessageClass($oName)
                    . ' - '
                    . ABAP_Navigation::GetURLMessageNumber($oName, $subName);
        } else {
            return $oName;
        }
    }

    /**
     * Get ABAP Object Type URL.
     */
    public static function GetOTypeURL($oType, $newwin = TRUE) {
        if (array_key_exists($oType, ABAP_OTYPE::$OTYPES)) {
            $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
            $linkLabel = htmlentities(ABAP_OTYPE::getOTypeDesc($oType));
            return '<a href="/abap/'
                    . strtolower($oType)
                    . '/"'
                    . 'title="' . $linkLabel . '" '
                    . $newWindow . ' >'
                    . $linkLabel
                    . '</a>';
        } else if (array_key_exists($oType, ABAP_OTYPE::$OTYPES_OTHER)) {
            return ABAP_OTYPE::getOTypeDesc($oType);
        } else {
            return $oType;
        }
    }

    /**
     * Get Where-Used-List URL.
     */
    public static function GetWulURLLink($counter, $newwin = TRUE) {
        $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
        $linkLabel = ABAP_OTYPE::getOTypeDesc($counter['OBJ_TYPE']);
        $url = ABAP_Navigation::getWulURL($counter);
        return '<a href="' . $url . '" '
                . 'title="' . htmlentities($linkLabel) . '" '
                . $newWindow . ' >'
                . $linkLabel
                . ' (' . $counter['COUNTER'] . ')</a>';
    }

    public static function getWulURL($counter) {
        $url_subobj = (strlen(trim($counter['SRC_SUBOBJ'])) > 0) ? '-' . strtolower($counter['SRC_SUBOBJ']) : '';
        $url = '/wul/abap/'
                . $counter['SRC_OBJ_TYPE']
                . '/' . htmlentities($counter['SRC_OBJ_NAME']) . $url_subobj
                . '/' . $counter['OBJ_TYPE']
                . '.html';
        return strtolower($url);
    }

    /**
     * Get Where-Used-List URL with pages.
     */
    public static function GetWulPagesURL($srcOType, $srcOName, $srcSubobj, $oType, $counter, $newwin = TRUE) {
        $result = '';
        if ($counter > ABAP_DB_CONST::INDEX_PAGESIZE) {
            $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
            $pageCount = ceil($counter / ABAP_DB_CONST::INDEX_PAGESIZE);
            $result = $result . ' pages: ';
            for ($i = 1; $i <= $pageCount; $i++) {
                $title = 'title="' . 'Page ' . $i . ' of ' . $pageCount . '" ';
                $urlObj = (strlen(trim($srcSubobj)) > 0) ? '-' . $srcSubobj : '';
                $url = '/wul/abap/' . strtolower($srcOType) . '/'
                        . strtolower($srcOName) . $urlObj
                        . '/' . strtolower($oType) . '-' . $i
                        . '.html';
                $link = '<a href="' . htmlentities(strtolower($url)) . '" ' . $title . $newWindow . ' >' . $i . '</a>';
                $result = $result . $link . '&nbsp;';
            }
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

class ABAP_UI_CONST {

    const ANCHOR_VALUES = "values";
    const ANCHOR_DOCUMENT = "document";
    const LABEL_F1Help = 'Help Document on this Field';

}

class ABAP_UI_CUS0 {

    /**
     * Generate IMG Tree.
     */
    public static function LoadImgNodes() {
        $nodeimg_list = ABAP_DB_TABLE_CUS0::TNODEIMG_PARENT_ID('368DDFAC3AB96CCFE10000009B38F976');
        foreach ($nodeimg_list as $nodeimg) {
            // Check reftree_id
            if (empty($nodeimg['REFTREE_ID']) === FALSE) {
                $check = ABAP_DB_TABLE_CUS0::TNODEIMG_TREE_ID($nodeimg['REFTREE_ID']);
                if (empty($check)) {
                    continue;
                }
            }

            // Check refnode_id
            if (empty($nodeimg['REFNODE_ID']) === FALSE) {
                $check = ABAP_DB_TABLE_CUS0::TNODEIMG_NODE_ID($nodeimg['REFNODE_ID']);
                if (empty($check)) {
                    continue;
                }
            }

            ABAP_UI_CUS0::echo_li($nodeimg);
        }
    }

    private static function write_child_tree($tree_id, $node_id, $level) {
        $child_list = ABAP_DB_TABLE_CUS0::TNODEIMG_TREE_NODE_ID($tree_id, $node_id);
        foreach ($child_list as $child) {
            ABAP_UI_CUS0::echo_li($child, $level);
        }
    }

    private static function write_child_node($node_id, $level) {
        $child_list = ABAP_DB_TABLE_CUS0::TNODEIMG_PARENT_ID($node_id);
        foreach ($child_list as $child) {
            ABAP_UI_CUS0::echo_li($child, $level);
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
        //$html_li = $html_li . $nodeimg['NODE_ID'] . ' - ' . $nodeimg['NODE_TYPE'];

        $text = ABAP_DB_TABLE_CUS0::TNODEIMGT($nodeimg['NODE_ID']);
        if (empty($text) === FALSE) {
            $html_li = $html_li . $text;
        }

        // Add Reference Node
        if ($nodeimg['NODE_TYPE'] === ABAP_DB_TABLE_CUS0::TNODEIMG_NODE_TYPE_IMG || $nodeimg['NODE_TYPE'] === ABAP_DB_TABLE_CUS0::TNODEIMG_NODE_TYPE_IMG1) {
            $imgr = ABAP_DB_TABLE_CUS0::TNODEIMGR($nodeimg['NODE_ID']);
            if (empty($imgr)) {
                $html_li = $html_li . 'No Reference Found';
                $skip = TRUE;
            } else {
                $imgr_t = ABAP_DB_TABLE_CUS0::CUS_IMGACT($imgr['REF_OBJECT']);
                //$html_li = $html_li . ' - ' . $imgr['REF_TYPE'] . ' - ' . $imgr['REF_OBJECT'];
                $html_li = $html_li . ABAP_Navigation::GetURLSproIMGActivity($imgr['REF_OBJECT'], $imgr_t, TRUE);
                if (empty($imgr_t) == FALSE) {
                    $html_li = $html_li . ' - ' . $imgr_t;
                }
            }
        }

        $html_li = $html_li . "</li>\n";
        if ($skip === FALSE) {
            print_r($html_li);
        }

        // Load Lower Level Nodes
        $level++;
        if ($nodeimg['NODE_TYPE'] === ABAP_DB_TABLE_CUS0::TNODEIMG_NODE_TYPE_REF && empty($nodeimg['REFTREE_ID']) === FALSE && empty($nodeimg['REFNODE_ID']) === FALSE) {
            ABAP_UI_CUS0::write_child_tree($nodeimg['REFTREE_ID'], $nodeimg['REFNODE_ID'], $level);
        } else if ($nodeimg['NODE_TYPE'] === ABAP_DB_TABLE_CUS0::TNODEIMG_NODE_TYPE_IMG0) {
            ABAP_UI_CUS0::write_child_node($nodeimg['NODE_ID'], $level);
        }
    }

    /**
     * Get the IMG Paths for one activity.
     * One activty could exist in several IMG tree nodes.
     *
     * @return Array IMG Paths
     */
    public static function GetActivityPaths() {
        
    }

    /**
     * Get description text for CUS_ACTH-ACT_TYPE.
     *
     * @return string IMG Activity Type Description
     */
    public static function GetImgActivityTypeDesc($act_type) {
        $desc = '';
        if ($act_type === ABAP_DB_CONST::CUS_ACTH_ACT_TYPE_C) {
            $desc = 'Customizing Object';
        } else if ($act_type === ABAP_DB_CONST::CUS_ACTH_ACT_TYPE_E) {
            $desc = 'Business Add-In - Definition';
        } else if ($act_type === ABAP_DB_CONST::CUS_ACTH_ACT_TYPE_I) {
            $desc = 'Business Add-In - Implementation';
        }
        return $desc;
    }

}

class ABAP_UI_TOOL {

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
     * Get Class Method Anchor name.
     */
    public static function GetClassMethodAnchorName($method) {
        return strtolower(ABAP_DB_TABLE_SEO::SEOCOMPO . '-' . $method);
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
     * Get ABAP Object description.
     * 
     * @param string $oType Object Type, example: DOMA, DTEL
     * @param string $oName Object name, example: MANDT, BUKRS
     * @return string Object description text, or '' for un-recognized object type
     */
    public static function GetObjectDescr($oType, $oName) {
        switch ($oType) {
            case ABAP_OTYPE::BMFR_NAME:
                $desc = ABAP_DB_TABLE_HIER::DF14T($oName);
                break;
            case ABAP_OTYPE::CLAS_NAME:
            case ABAP_OTYPE::INTF_NAME:
                $desc = ABAP_DB_TABLE_SEO::SEOCLASSTX($oName);
                break;
            case ABAP_OTYPE::CUS0_NAME:
                $desc = ABAP_DB_TABLE_CUS0::CUS_IMGACT($oName);
                break;
            case ABAP_OTYPE::CVERS_NAME:
                $desc = ABAP_DB_TABLE_HIER::CVERS_REF($oName);
                break;
            case ABAP_OTYPE::DEVC_NAME:
                $desc = ABAP_DB_TABLE_HIER::TDEVCT($oName);
                break;
            case ABAP_OTYPE::DOMA_NAME:
                $desc = ABAP_DB_TABLE_DOMA::DD01T($oName);
                break;
            case ABAP_OTYPE::DTEL_NAME:
                $desc = ABAP_DB_TABLE_DTEL::DD04T($oName);
                break;
            case ABAP_OTYPE::FUNC_NAME:
                $desc = ABAP_DB_TABLE_FUNC::TFTIT($oName);
                break;
            case ABAP_OTYPE::MSAG_NAME:
                $desc = ABAP_DB_TABLE_MSAG::T100T($oName);
                break;
            case ABAP_OTYPE::PROG_NAME:
                $desc = ABAP_DB_TABLE_PROG::TRDIRT($oName);
                break;
            case ABAP_OTYPE::SHLP_NAME:
                $desc = ABAP_DB_TABLE_SHLP::DD30T($oName);
                break;
            case ABAP_OTYPE::SQLT_NAME:
                $desc = ABAP_DB_TABLE_TABL::DD06T($oName);
                break;
            case ABAP_OTYPE::TABL_NAME:
                $desc = ABAP_DB_TABLE_TABL::DD02T($oName);
                break;
            case ABAP_OTYPE::TRAN_NAME:
                $desc = ABAP_DB_TABLE_TRAN::TSTCT($oName);
                break;
            case ABAP_OTYPE::VIEW_NAME:
                $desc = ABAP_DB_TABLE_VIEW::DD25T($oName);
                break;
            default:
                $desc = '';
                break;
        }

        return htmlentities($desc);
    }

    /**
     * Get object title.
     * 
     * <pre>
     * Input : TABL, BKPF
     * Output: Table BKPF (Accounting Document Header)
     * </pre>
     * 
     * @param string $oType Object Type, example: DOMA, DTEL, TABL
     * @param string $oName Object name, example: MANDT, BUKRS, BKPF
     * @param string $oNameDisp Objec name desplay, for 'Application Component', Table field, etc
     * @return string Object title text
     */
    public static function GetObjectTitle($oType, $oName, $oNameDisp = NULL) {
        $title_name = ($oNameDisp === NULL) ? $oName : $oNameDisp;
        $title_name = 'SAP ABAP ' . ABAP_OTYPE::getOTypeDesc($oType) . ' ' . $title_name;
        $srcObjDesc = ABAP_UI_TOOL::GetObjectDescr($oType, $oName);
        if (!empty($srcObjDesc)) {
            $title_name = $title_name . ' (' . $srcObjDesc . ')';
        }

        return $title_name;
    }

    /**
     * Get check box UI control.
     * 
     * @param string $Sqlclass SQL table class
     * @return string SQL table class description
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
                // For system variable, change 'SY' as structure name 'SYST'
                if (strtoupper($Table) == 'SY') {
                    $Table = 'SYST';
                }
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
