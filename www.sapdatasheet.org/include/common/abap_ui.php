<?php

$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once($__ROOT__ . '/include/common/global.php');

class ABAP_UI_Hierarchy {

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
     * Parent Package in upper 2 level. Parent packge of {@link #PARENTCL1}.
     * <p> Database field: TDEVC-PARENTCL. </p>
     */
    public $PARENTCL2 = '';

    /**
     * Text of {@link #PARENTCL2}.
     */
    public $PARENTCL2_T = '';

    /**
     * Parent Package in upper 1 level. Parent packge of {@link #DEVCLASS}.
     * <p> Database field: TDEVC-PARENTCL. </p>
     */
    public $PARENTCL1 = '';

    /**
     * Text of {@link #PARENTCL1}.
     */
    public $PARENTCL1_T = '';

    /**
     * Package. <p> Database field: TADIR-DEVCLASS or TDEVC-DEVCLASS. </p>
     */
    public $DEVCLASS = '';

    /**
     * Text of {@link #DEVCLASS}.
     */
    public $DEVCLASS_T = '';

    /**
     * Created since Release. <p> Database field: TADIR-CRELEASE. </p>
     */
    public $CRELEASE = '';

}

class ABAP_UI_DS_Navigation {

    private static function GetHyperlink($objtype, $objname, $linkLabel, $linkTitle, $newwin = FALSE, $anchor = '') {
        if (strlen(trim($objtype)) < 1 || strlen(trim($objname)) < 1 || strlen(trim($linkLabel)) < 1) {
            return '&nbsp;';
        }

        // With Anchor Tag, if provided
        $anchorTag = (strlen(trim($anchor)) > 0) ? '#' . $anchor : '';

        // Get the Path
        $path = ABAP_UI_DS_Navigation::GetObjectPath($objtype, $objname) . $anchorTag;

        // Open in a New Window or not
        $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';

        // Link Label, to be shown in the UI
        $linkLabel = trim($linkLabel);
        if (empty($linkTitle)) {
            $desc = ABAP_UI_TOOL::GetObjectDescr($objtype, $objname);
            $sTitle = (empty($desc)) ? $linkLabel : $desc;
        } else {
            $sTitle = $linkTitle;
        }

        $result = '<a href="' . strtolower($path)
                . '" title="' . htmlentities($sTitle) . '" '
                . $newWindow . '>'
                . htmlentities($linkLabel) . '</a>';
        return $result;
    }

    public static function GetHyperlink4Bmfr($fctr_id, $posid, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::BMFR_NAME, $fctr_id, $posid, $desc, $newwin);
    }

    public static function GetHyperlink4Clas($class, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::CLAS_NAME, $class, $class, $desc, $newwin);
    }

    public static function GetHyperlink4Doma($domain, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::DOMA_NAME, $domain, $domain, $desc, $newwin);
    }

    public static function GetHyperlink4DomainValue($domain, $domainValue, $desc, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::DOMA_NAME, $domain, $domainValue, $desc, $newwin, ABAP_UI_CONST::ANCHOR_VALUES);
    }

    public static function GetHyperlink4Dtel($rollname, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::DTEL_NAME, $rollname, $rollname, $desc, $newwin);
    }

    public static function GetHyperlink4DtelDocument($rollname = NULL, $label = '?', $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::DTEL_NAME, $rollname, $label, ABAP_UI_CONST::LABEL_F1Help, $newwin, ABAP_UI_CONST::ANCHOR_DOCUMENT);
    }

    public static function GetHyperlink4Func($fm, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::FUNC_NAME, $fm, $fm, $desc, $newwin);
    }

    public static function GetHyperlink4Intf($intf, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::INTF_NAME, $intf, $intf, $desc, $newwin);
    }

    public static function GetHyperlink4Fugr($fg, $desc, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::FUGR_NAME, $fg, $fg, $desc, $newwin);
    }

    public static function GetHyperlink4Msag($msgcls, $desc = NULL, $newwin = TRUE) {
        if (GLOBAL_UTIL::Contains($msgcls, '/')) {
            $msgcls_url = $msgcls;
        } else {
            $msgcls_url = urlencode($msgcls);
        }
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::MSAG_NAME, $msgcls_url, $msgcls, $desc, $newwin);
    }

    public static function GetHyperlink4Msgnr($msgcls, $msgnr, $newwin = TRUE) {
        if (strlen(trim($msgcls)) < 1 || strlen(trim($msgnr)) < 1) {
            return '&nbsp;';
        }
        $objname = htmlentities(strtolower($msgcls)) . "-" . htmlentities(strtolower($msgnr));
        // $title = htmlentities($msgcls . ' - ' . $msgnr);
        $title = ABAP_DB_TABLE_MSAG::T100_NR($msgcls, $msgnr);
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::MSAG_NAME, $objname, $msgnr, $title, $newwin);
    }

    public static function GetHyperlink4Devc($package, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::DEVC_NAME, $package, $package, $desc, $newwin);
    }

    public static function GetHyperlink4Prog($program, $desc = NULL, $value = "", $newwin = TRUE) {
        if ($value === "") {
            $value = $program;
        }
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::PROG_NAME, $program, $value, $desc, $newwin);
    }

    public static function GetHyperlink4Shlp($shlp, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::SHLP_NAME, $shlp, $shlp, $desc, $newwin);
    }

    public static function GetHyperlink4Cvers($compName, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::CVERS_NAME, $compName, $compName, $desc, $newwin);
    }

    public static function GetHyperlink4Cus0IMGActivity($img, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::CUS0_NAME, $img, $img, $desc, $newwin);
    }

    public static function GetHyperlink4Sqlt($sqlTable, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::SQLT_NAME, $sqlTable, $sqlTable, $desc, $newwin);
    }

    public static function GetHyperlink4Tabl($table, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::TABL_NAME, $table, $table, $desc, $newwin);
    }

    public static function GetHyperlink4TablField($table, $field, $newwin = TRUE) {
        if (strlen(trim($table)) < 1 || strlen(trim($field)) < 1) {
            return '&nbsp;';
        }
        $objname = GLOBAL_UTIL::Clear4Url($table) . "-" . GLOBAL_UTIL::Clear4Url($field);
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::TABL_NAME, $objname, $field, $field, $newwin);
    }

    public static function GetHyperlink4TablInclude($table, $field, $position, $newwin = TRUE) {
        if (strlen(trim($table)) < 1 || strlen(trim($field)) < 1) {
            return '&nbsp;';
        }
        $objname = htmlentities(strtolower($table)) . "-" . htmlentities($position);
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::TABL_NAME, $objname, $field, $position, $newwin);
    }

    public static function GetHyperlink4Tran($tcode, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode, $tcode, $desc, $newwin);
    }

    public static function GetHyperlink4View($view, $desc = NULL, $newwin = TRUE) {
        return ABAP_UI_DS_Navigation::GetHyperlink(GLOBAL_ABAP_OTYPE::VIEW_NAME, $view, $view, $desc, $newwin);
    }

    /**
     * Get the domain name and the object path. Examples:
     * <pre>
     * http://www.sapdatasheet.org/abap/tabl/bkpf.html
     * http://www.sapdatasheet.org/abap/tabl/bkpf-mandt.html
     * </pre>
     */
    public static function GetObjectURL($objtype, $objname) {
        return GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . ABAP_UI_DS_Navigation::GetObjectPath($objtype, $objname);
    }

    /**
     * Get the Object path name.
     *
     * @param string $objtype ABAP Object Type, example: DOMA, TABL
     * @param string $objname ABAP Object Name, example: (tabl) BKPF, (tabl field) BKPF-BUKRS
     */
    public static function GetObjectPath($objtype, $objname) {
        return '/abap/' . strtolower($objtype) . '/' . GLOBAL_UTIL::Clear4Url($objname) . '.html';
    }

    /**
     * Get ABAP Object URL with for Datasheet, with domain name.
     */
    public static function GetObjectHyperlink4DS($oType, $oName, $subName = NULL, $withDesc = TRUE) {
        $objname = ($subName === NULL) ? GLOBAL_UTIL::Clear4Url($oName) : GLOBAL_UTIL::Clear4Url($oName) . '-' . GLOBAL_UTIL::Clear4Url($subName);
        $url = ABAP_UI_DS_Navigation::GetObjectURL($oType, $objname);
        $desc = ABAP_UI_TOOL::GetObjectDescr($oType, $oName, $subName);

        $result = '<sup>'
                . '<a href="' . strtolower($url)
                . '" title="' . $desc . ' - ' . GLOBAL_WEBSITE_SAPDS::NAME . '" '
                . 'target="_blank">ds</a>'    // data-toggle="tooltip" data-placement="bottom"
                . '&nearhk; </sup> &nbsp;';
        if ($withDesc && GLOBAL_UTIL::IsNotEmpty($desc)) {
            $result = $result . '(' . $desc . ')';
        }
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
    public static function GetObjectHyperlink($oType, $oName, $subName = NULL) {
        if (($oType == GLOBAL_ABAP_OTYPE::TABL_NAME && strlen(trim($subName)) > 0) || ($oType == GLOBAL_ABAP_OTYPE::DTF_NAME)) {
            return ABAP_UI_DS_Navigation::GetHyperlink4Tabl($oName)
                    . ' - '
                    . ABAP_UI_DS_Navigation::GetHyperlink4TablField($oName, $subName);
        } else if (array_key_exists($oType, GLOBAL_ABAP_OTYPE::$OTYPES)) {
            return ABAP_UI_DS_Navigation::GetHyperlink($oType, $oName, $oName, NULL, TRUE);
        } else if ($oType == GLOBAL_ABAP_OTYPE::OM_NAME) {
            return ABAP_UI_DS_Navigation::GetHyperlink4Clas($oName) . ' - ' . $subName;
        } else if ($oType == GLOBAL_ABAP_OTYPE::NN_NAME) {
            return ABAP_UI_DS_Navigation::GetHyperlink4Msag($oName)
                    . ' - '
                    . ABAP_UI_DS_Navigation::GetHyperlink4Msgnr($oName, $subName);
        } else if ($oType == GLOBAL_ABAP_OTYPE::SEOC_NAME) {
            $seoclass = ABAP_DB_TABLE_SEO::SEOCLASS($oName);
            if ($seoclass['CLSTYPE'] == ABAP_DB_TABLE_SEO::SEOCLASS_CLSTYPE_CLAS) {
                return ABAP_UI_DS_Navigation::GetHyperlink4Clas($oName);
            } else if ($seoclass['CLSTYPE'] == ABAP_DB_TABLE_SEO::SEOCLASS_CLSTYPE_INTF) {
                return ABAP_UI_DS_Navigation::GetHyperlink4Intf($oName);
            }
        }

        // If not found earlier, then we simply display the object name
        return $oName;
    }

    /**
     * Get ABAP Object Type URL.
     */
    public static function GetOTypeHyperlink($oType, $newwin = TRUE) {
        if (array_key_exists($oType, GLOBAL_ABAP_OTYPE::$OTYPES)) {
            $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
            $linkLabel = htmlentities(GLOBAL_ABAP_OTYPE::getOTypeDesc($oType));
            return '<a href="/abap/'
                    . strtolower($oType)
                    . '/"'
                    . 'title="' . $linkLabel . '" '
                    . $newWindow . ' >'
                    . $linkLabel
                    . '</a>';
        } else if (array_key_exists($oType, GLOBAL_ABAP_OTYPE::$OTYPES_OTHER)) {
            return GLOBAL_ABAP_OTYPE::getOTypeDesc($oType);
        } else {
            return $oType;
        }
    }

    /**
     * Get Where-Using-List URL.
     */
    public static function GetWilHyperlink($counter, $newwin = TRUE) {
        $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
        $linkLabel = GLOBAL_ABAP_OTYPE::getOTypeDesc($counter['SRC_OBJ_TYPE']);
        $path = ABAP_UI_DS_Navigation::GetWilPath($counter);
        return '<a href="' . $path . '" '
                . 'title="' . htmlentities($linkLabel) . '" '
                . $newWindow . ' >'
                . $linkLabel
                . ' (' . $counter['COUNTER'] . ')</a>';
    }

    public static function GetWilPath($counter) {
        $path = '/wil/abap/'
                . $counter['OBJ_TYPE']
                . '/' . GLOBAL_UTIL::Clear4Url($counter['OBJ_NAME'])
                . '/' . $counter['SRC_OBJ_TYPE']
                . '.html';
        return strtolower($path);
    }

    public static function GetWilURL($counter) {
        return GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . ABAP_UI_DS_Navigation::GetWilPath($counter);
    }

    /**
     * Get URLs list for pages.
     */
    public static function GetWilPaths($oType, $oName, $srcOType, $counter) {
        $paths = array();
        if ($counter > ABAP_DB_CONST::INDEX_PAGESIZE) {
            $pageCount = ceil($counter / ABAP_DB_CONST::INDEX_PAGESIZE);
            for ($i = 1; $i <= $pageCount; $i++) {
                $path = '/wil/abap/'
                        . $oType
                        . '/' . GLOBAL_UTIL::Clear4Url($oName)
                        . '/' . $srcOType . '-' . $i
                        . '.html';
                array_push($paths, strtolower($path));
            }
        }

        return $paths;
    }

    /**
     * Get Where-Using-List URL with pages.
     */
    public static function GetWilHyperlinks($oType, $oName, $srcOType, $counter, $newwin = TRUE) {
        $result = '';
        if ($counter > ABAP_DB_CONST::INDEX_PAGESIZE) {
            $pageCount = ceil($counter / ABAP_DB_CONST::INDEX_PAGESIZE);
            $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
            $result = $result . ' pages: ';
            $urls = ABAP_UI_DS_Navigation::GetWilPaths($oType, $oName, $srcOType, $counter);
            $i = 1;
            foreach ($urls as $url) {
                $title = 'title="' . 'Page ' . $i . ' of ' . $pageCount . '" ';
                $link = '<a href="' . $url . '" ' . $title . $newWindow . ' >' . $i . '</a>';
                $result = $result . $link . '&nbsp;';
                $i++;
            }
        }
        return $result;
    }

    /**
     * Get Where-Used-List URL.
     */
    public static function GetWulHyperlink($counter, $newwin = TRUE) {
        $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
        $linkLabel = GLOBAL_ABAP_OTYPE::getOTypeDesc($counter['OBJ_TYPE']);
        $url = ABAP_UI_DS_Navigation::GetWulPath($counter);
        return '<a href="' . $url . '" '
                . 'title="' . htmlentities($linkLabel) . '" '
                . $newWindow . ' >'
                . $linkLabel
                . ' (' . $counter['COUNTER'] . ')</a>';
    }

    public static function GetWulPath($counter) {
        $url_subobj = (strlen(trim($counter['SRC_SUBOBJ'])) > 0) ? '-' . GLOBAL_UTIL::Clear4Url($counter['SRC_SUBOBJ']) : '';
        $url = '/wul/abap/'
                . $counter['SRC_OBJ_TYPE']
                . '/' . GLOBAL_UTIL::Clear4Url($counter['SRC_OBJ_NAME']) . $url_subobj
                . '/' . $counter['OBJ_TYPE']
                . '.html';
        return strtolower($url);
    }

    public static function GetWulURL($counter) {
        return GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . ABAP_UI_DS_Navigation::GetWulPath($counter);
    }

    public static function GetWulPaths($srcOType, $srcOName, $srcSubobj, $oType, $counter) {
        $paths = array();
        if ($counter > ABAP_DB_CONST::INDEX_PAGESIZE) {
            $pageCount = ceil($counter / ABAP_DB_CONST::INDEX_PAGESIZE);
            for ($i = 1; $i <= $pageCount; $i++) {
                $urlObj = (strlen(trim($srcSubobj)) > 0) ? '-' . GLOBAL_UTIL::Clear4Url($srcSubobj) : '';
                $path = '/wul/abap/'
                        . $srcOType
                        . '/' . GLOBAL_UTIL::Clear4Url($srcOName) . $urlObj
                        . '/' . $oType . '-' . $i
                        . '.html';
                array_push($paths, strtolower($path));
            }
        }

        return $paths;
    }

    /**
     * Get Where-Used-List URL with pages.
     */
    public static function GetWulHyperlinks($srcOType, $srcOName, $srcSubobj, $oType, $counter, $newwin = TRUE) {
        $result = '';
        if ($counter > ABAP_DB_CONST::INDEX_PAGESIZE) {
            $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
            $pageCount = ceil($counter / ABAP_DB_CONST::INDEX_PAGESIZE);
            $result = $result . ' pages: ';
            $urls = ABAP_UI_DS_Navigation::GetWulPaths($srcOType, $srcOName, $srcSubobj, $oType, $counter);
            $i = 1;
            foreach ($urls as $url) {
                $title = 'title="' . 'Page ' . $i . ' of ' . $pageCount . '" ';
                $link = '<a href="' . $url . '" ' . $title . $newWindow . ' >' . $i . '</a>';
                $result = $result . $link . '&nbsp;';

                $i++;
            }
        }
        return $result;
    }

}

class ABAP_UI_TCODES_Navigation {

    const PATH_ANALYTICS_COMP = '/analytics/component/';
    const PATH_ANALYTICS_MODULE = '/analytics/module/';
    const PATH_ANALYTICS_NAME = '/analytics/name/';
    const PATH_TCODE = '/tcode/';

    /**
     * Create HTML Link (&lta&gt) to an software component.
     */
    public static function AnalyticsCompHyperlink($comp, $url = FALSE) {
        $buf_key = GLOBAL_BUFFER::KEYPREFIX_TCODES_UINAV_COMP . $comp;
        $buf_value = GLOBAL_BUFFER::Get($buf_key);
        if ($buf_value == FALSE) {
            $href = ABAP_UI_TCODES_Navigation::AnalyticsCompPath($comp, $url);
            $title = ABAP_DB_TABLE_HIER::CVERS_REF($comp);
            $buf_value = '<a href="' . $href . '" title="' . $title . '" target="_blank">' . $comp . '</a>';

            // Add to bufer
            GLOBAL_BUFFER::Set($buf_key, $buf_value);
        }

        return $buf_value;
    }    
    

    /**
     * Get Path for Analytics by Component.
     * Example:
     * <pre>
     *   /analytics/component/sap_basis.html
     *   /analytics/component/dmis.html
     * </pre>
     *
     * @param string $comp Software Component
     * @param boolean $url Add prefix for URL
     */
    public static function AnalyticsCompPath($comp, $url = FALSE) {
        $path = ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_COMP . strtolower($comp) . '.html';
        return ($url) ? GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . $path : $path;
    }

    /**
     * Create HTML Link (&lta&gt) to an application module.
     */
    public static function AnalyticsModuleHyperlink($posid, $url = FALSE) {
        $buf_key = GLOBAL_BUFFER::KEYPREFIX_TCODES_UINAV_MODULE . $posid;
        $buf_value = GLOBAL_BUFFER::Get($buf_key);
        if ($buf_value == FALSE) {
            $fctr = ABAPANA_DB_TABLE::ABAPBMFR_POSID_2_FCTR($posid);
            $href = ABAP_UI_TCODES_Navigation::AnalyticsModulePath($posid, $url);
            $title = ABAP_DB_TABLE_HIER::DF14T($fctr);
            $buf_value = '<a href="' . $href . '" title="' . $title . '" target="_blank">' . $posid . '</a>';

            // Add to bufer
            GLOBAL_BUFFER::Set($buf_key, $buf_value);
        }

        return $buf_value;
    }

    /**
     * Get Path for Analytics by Component.
     * Example:
     * <pre>
     *   /analytics/module/bc-bw.html
     *   /analytics/module/bc-srv-brf.html
     * </pre>
     *
     * @param string $posid Application Component POSID
     * @param boolean $url Add prefix for URL
     */
    public static function AnalyticsModulePath($posid, $url = FALSE) {
        $path = ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_MODULE . strtolower($posid) . '.html';
        return ($url) ? GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . $path : $path;
    }


    /**
     * Get Path for Analytics by Name.
     * Example:
     * <pre>
     *   /analytics/name/se.html
     *   /analytics/name//ain/.html
     * </pre>
     *
     * @param string $prefix Prefix of T-Code Name
     * @param boolean $url Add prefix for URL
     */
    public static function AnalyticsNamePath($prefix, $url = FALSE) {
        $path = ABAP_UI_TCODES_Navigation::PATH_ANALYTICS_NAME . strtolower($prefix) . '.html';
        return ($url) ? GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . $path : $path;
    }


    /**
     * Get Path for a Transaction Code.
     * Example:
     * <pre>
     *   /tcode/se11.html
     *   /tcode//ain/15000001.html
     * </pre>
     *
     * @param string $tcode T-Code
     * @param boolean $url Add prefix for URL
     */
    public static function TCode($tcode, $url = FALSE){
        $path = ABAP_UI_TCODES_Navigation::PATH_TCODE . htmlentities(strtolower($tcode)) . '.html';
        return ($url) ? GLOBAL_WEBSITE::URLPREFIX_SAPTCODES_ORG . $path : $path;
    }

    /**
     * Get hyperlink for a Transaction Code.
     * Example:
     * <pre>
     *   <a href="/tcode/se11.html" target="_blank" title="Description">SE11</a>
     * </pre>
     *
     * @param string $tcode T-Code
     * @param boolean $url Add prefix for URL
     */
    public static function TCodeHyperlink($tcode, $url = FALSE){
        $href = ABAP_UI_TCODES_Navigation::TCode($tcode, $url);
        $title = htmlentities(ABAP_DB_TABLE_TRAN::TSTCT($tcode));
        if (GLOBAL_UTIL::IsEmpty($title)) {
            $title = htmlentities($tcode);
        }
        return '<a href="' . $href . '" target="_blank" title="' . $title . '">'
                . htmlentities($tcode) . '</a>';
    }


}

/**
 * Function module processing type.
 */
class ABAP_UI_TFDIR_ProcessingType {

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

    const ANCHOR_VALUES = "values";                        // For domain
    const ANCHOR_DOCUMENT = "document";                    // For data element
    const ANCHOR_SEOMETAFL = "seometa-fulllist";           // For class/interface meta
    const ANCHOR_SEOMETARELFL = "seometarel-fulllist";     // For class/interface meta rel
    const LABEL_F1Help = 'Help Document on this Field';
    const WUL_ROW_MINIMAL = 10;                            // Add empty rows to make web page looks better

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
                $html_li = $html_li . ABAP_UI_DS_Navigation::GetHyperlink4Cus0IMGActivity($imgr['REF_OBJECT'], $imgr_t, TRUE);
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
        header(GLOBAL_HTTP_STATUS::STATUS_404);
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
    public static function GetObjectDescr($oType, $oName, $subName = NULL) {
        switch ($oType) {
            case GLOBAL_ABAP_OTYPE::BMFR_NAME:
                $desc = ABAP_DB_TABLE_HIER::DF14T($oName);
                break;
            case GLOBAL_ABAP_OTYPE::CLAS_NAME:
            case GLOBAL_ABAP_OTYPE::INTF_NAME:
            case GLOBAL_ABAP_OTYPE::OM_NAME:
                $desc = ABAP_DB_TABLE_SEO::SEOCLASSTX($oName);
                break;
            case GLOBAL_ABAP_OTYPE::CUS0_NAME:
                $desc = ABAP_DB_TABLE_CUS0::CUS_IMGACT($oName);
                break;
            case GLOBAL_ABAP_OTYPE::CVERS_NAME:
                $desc = ABAP_DB_TABLE_HIER::CVERS_REF($oName);
                break;
            case GLOBAL_ABAP_OTYPE::DEVC_NAME:
                $desc = ABAP_DB_TABLE_HIER::TDEVCT($oName);
                break;
            case GLOBAL_ABAP_OTYPE::DOMA_NAME:
                $desc = ABAP_DB_TABLE_DOMA::DD01T($oName);
                break;
            case GLOBAL_ABAP_OTYPE::DTEL_NAME:
                $desc = ABAP_DB_TABLE_DTEL::DD04T($oName);
                break;
            case GLOBAL_ABAP_OTYPE::DTF_NAME:
                $desc = ABAP_UI_TOOL::GetTablFieldDescDirect($oName, $subName);
                break;
            case GLOBAL_ABAP_OTYPE::FUNC_NAME:
                $desc = ABAP_DB_TABLE_FUNC::TFTIT($oName);
                break;
            case GLOBAL_ABAP_OTYPE::MSAG_NAME:
                $desc = ABAP_DB_TABLE_MSAG::T100T($oName);
                break;
            case GLOBAL_ABAP_OTYPE::NN_NAME:
                $desc = ABAP_DB_TABLE_MSAG::T100_NR($oName, $subName);
                break;
            case GLOBAL_ABAP_OTYPE::PROG_NAME:
                $desc = ABAP_DB_TABLE_PROG::TRDIRT($oName);
                break;
            case GLOBAL_ABAP_OTYPE::SHLP_NAME:
                $desc = ABAP_DB_TABLE_SHLP::DD30T($oName);
                break;
            case GLOBAL_ABAP_OTYPE::SQLT_NAME:
                $desc = ABAP_DB_TABLE_TABL::DD06T($oName);
                break;
            case GLOBAL_ABAP_OTYPE::TABL_NAME:
                $desc = ABAP_DB_TABLE_TABL::DD02T($oName);
                break;
            case GLOBAL_ABAP_OTYPE::TRAN_NAME:
                $desc = ABAP_DB_TABLE_TRAN::TSTCT($oName);
                break;
            case GLOBAL_ABAP_OTYPE::VIEW_NAME:
                $desc = ABAP_DB_TABLE_VIEW::DD25T($oName);
                break;
            default:
                $desc = '';
                break;
        }

        if (GLOBAL_UTIL::IsEmpty($desc)) {
            $desc = ($subName === NULL) ? $oName : $oName . '-' . $subName;
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
        $title_name = 'SAP ABAP ' . GLOBAL_ABAP_OTYPE::getOTypeDesc($oType) . ' ' . $title_name;
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
     * Get Table Filed description directly.
     */
    public static function GetTablFieldDescDirect($table, $field) {
        $dd03l = ABAP_DB_TABLE_TABL::DD03L(strtoupper($table), strtoupper($field));
        return htmlentities(ABAP_UI_TOOL::GetTablFieldDesc($dd03l['PRECFIELD'], $dd03l['ROLLNAME']));
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
            $result = ABAP_UI_DS_Navigation::GetHyperlink4Tabl($Structure, '');
        } else if ($ParamType == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_X) {
            $result = $Structure;
        } else if ($ParamType == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_I || $ParamType == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_E || $ParamType == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_C) {
            if (strpos($Structure, '-') !== false) {
                // We have checked the database,
                //   the '-' is always in the middle
                //   the '-' will not located at beginning or end
                list($Table, $Field) = explode('-', $Structure, 2);
                $Table = strtoupper($Table);
                // For system variable, change 'SY' as structure name 'SYST'
                if ($Table == 'SY') {
                    $Table = 'SYST';
                }
                // Check the Table exist or not before generate the URL
                $dd02l = ABAP_DB_TABLE_TABL::DD02L($Table);
                if (empty($dd02l['TABNAME'])) {
                    $link_table = $Table;
                    $link_field = $Field;
                } else {
                    $link_table = ABAP_UI_DS_Navigation::GetHyperlink4Tabl($Table, '');
                    $link_field = ABAP_UI_DS_Navigation::GetHyperlink4TablField($Table, $Field);
                }
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
