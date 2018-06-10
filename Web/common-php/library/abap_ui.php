<?php

$__COMMON_ROOT__ = dirname(__FILE__, 2);
require_once($__COMMON_ROOT__ . '/library/global.php');
require_once($__COMMON_ROOT__ . '/library/erd.php');

class ABAP_UI_Buffer_Index {

    /** File name, without the '.html' suffix */
    const INDEX_FILENAME = 'index_filename';
    const LINK_TEXT = 'link_text';
    const LINK_TITLE = 'link_title';

    public static function ZBUFFER_INDEX_COUNTER(string $oType): array {
        $ui_index_list = array();
        $db_index_list = ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER($oType);
        foreach ($db_index_list as $db_index) {
            if ($db_index[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_LEFT1] == ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_LEFT1_SLASH) {
                $db_index[self::INDEX_FILENAME] = 'index-' . strtolower(ABAP_DB_CONST::INDEX_SLASH);
                $db_index[self::LINK_TEXT] = ABAP_DB_CONST::INDEX_SLASH;
            } else if ($oType == GLOBAL_ABAP_OTYPE::FUNC_NAME && $db_index[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_LEFT1] == ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_LEFT1_AT) {
                $db_index[self::INDEX_FILENAME] = 'index-' . strtolower(ABAP_DB_TABLE_FUNC::TFDIR_FMODE_RFC);
                $db_index[self::LINK_TEXT] = ABAP_DB_TABLE_FUNC::TFDIR_FMODE_RFC;
            } else {
                $db_index[self::INDEX_FILENAME] = 'index-' . strtolower($db_index[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_LEFT1]);
                $db_index[self::LINK_TEXT] = $db_index[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_LEFT1];
            }

            $db_index[self::LINK_TITLE] = "Object name starting with '" . $db_index[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_LEFT1] . "', "
                    . number_format($db_index[ABAP_DB_CONST::COUNTER]) . ' records';
            if ($db_index[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_PAGE_COUNT] > 1) {
                $db_index[self::LINK_TITLE] = $db_index[self::LINK_TITLE] . ', shown in ' . number_format($db_index[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_PAGE_COUNT]) . ' pages';
            }

            array_push($ui_index_list, $db_index);
        }

        return $ui_index_list;
    }

}

class ABAP_UI_CONST {

    const ANCHOR_VALUES = "values";                        // For domain
    const ANCHOR_DOCUMENT = "document";                    // For data element
    const ANCHOR_SEOMETAFL = "seometa-fulllist";           // For class/interface meta
    const ANCHOR_SEOMETARELFL = "seometarel-fulllist";     // For class/interface meta rel
    const LABEL_F1Help = 'Help Document on this Field';
    /**
     * SVG icon, for external link.
     */
    const ICON_EXTERNAL_LINK = 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%2212%22%3E %3Cpath fill=%22%23fff%22 stroke=%22%2336c%22 d=%22M1.5 4.518h5.982V10.5H1.5z%22/%3E %3Cpath fill=%22%2336c%22 d=%22M5.765 1H11v5.39L9.427 7.937l-1.31-1.31L5.393 9.35l-2.69-2.688 2.81-2.808L4.2 2.544z%22/%3E %3Cpath fill=%22%23fff%22 d=%22M9.995 2.004l.022 4.885L8.2 5.07 5.32 7.95 4.09 6.723l2.882-2.88-1.85-1.852z%22/%3E %3C/svg%3E';
    const WUL_ROW_MINIMAL = 10;                            // Add empty rows to make web page looks better

}

class ABAP_UI_CUS0 {

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
    public static function GetImgActivityTypeDesc(string $act_type): string {
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

class ABAP_UI_DS_Navigation {

    private static function GetHyperlink($objtype, $objname, $linkLabel, $linkTitle, bool $newwin = FALSE, string $anchor = ''): string {
        if (strlen(trim($objtype)) < 1 || strlen(trim($objname)) < 1 || strlen(trim($linkLabel)) < 1) {
            return '&nbsp;';
        }

        // With Anchor Tag, if provided
        $anchorTag = (strlen(trim($anchor)) > 0) ? '#' . $anchor : '';

        // Get the Path
        $path = self::GetObjectPath($objtype, $objname) . $anchorTag;

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

        // Speical logic: for the F1 help filed, we will show an Image as the label, so no html escape needed
        if ($linkTitle == ABAP_UI_CONST::LABEL_F1Help) {
            $finalLabel = $linkLabel;
        } else {
            $finalLabel = htmlentities($linkLabel);
        }

        $result = '<a href="' . strtolower($path)
                . '" title="' . htmlentities($sTitle) . '" '
                . $newWindow . '>'
                . $finalLabel . '</a>';
        return $result;
    }

    public static function GetHyperlink4Bmfr(string $fctr_id = NULL, string $posid = NULL, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::BMFR_NAME, $fctr_id, $posid, $desc, $newwin);
    }

    public static function GetHyperlink4Clas(string $class, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::CLAS_NAME, $class, $class, $desc, $newwin);
    }

    public static function GetHyperlink4Doma(string $domain, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::DOMA_NAME, $domain, $domain, $desc, $newwin);
    }

    public static function GetHyperlink4DomainValue(string $domain, $domainValue, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::DOMA_NAME, $domain, $domainValue, $desc, $newwin, ABAP_UI_CONST::ANCHOR_VALUES);
    }

    public static function GetHyperlink4Dtel(string $rollname, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::DTEL_NAME, $rollname, $rollname, $desc, $newwin);
    }

    public static function GetHyperlink4DtelDocument(string $rollname = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::DTEL_NAME, $rollname, GLOBAL_ABAP_ICON::getIcon4SystemHelp(), ABAP_UI_CONST::LABEL_F1Help, $newwin, ABAP_UI_CONST::ANCHOR_DOCUMENT);
    }

    public static function GetHyperlink4Func(string $fm, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::FUNC_NAME, $fm, $fm, $desc, $newwin);
    }

    public static function GetHyperlink4Intf(string $intf, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::INTF_NAME, $intf, $intf, $desc, $newwin);
    }

    public static function GetHyperlink4Fugr(string $fg, string $desc, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::FUGR_NAME, $fg, $fg, $desc, $newwin);
    }

    public static function GetHyperlink4Msag(string $msgcls, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::MSAG_NAME, $msgcls, $msgcls, $desc, $newwin);
    }

    public static function GetHyperlink4Msgnr(string $msgcls, $msgnr, bool $newwin = TRUE): string {
        if (strlen(trim($msgcls)) < 1 || strlen(trim($msgnr)) < 1) {
            return '&nbsp;';
        }
        $objname = $msgcls . "-" . $msgnr;
        $title = ABAP_DB_TABLE_MSAG::T100_NR($msgcls, $msgnr);
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::MSAG_NAME, $objname, $msgnr, $title, $newwin);
    }

    public static function GetHyperlink4Devc(string $package = NULL, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::DEVC_NAME, $package, $package, $desc, $newwin);
    }

    public static function GetHyperlink4Prog(string $program, string $desc = NULL, $value = "", bool $newwin = TRUE): string {
        if ($value === "") {
            $value = $program;
        }
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::PROG_NAME, $program, $value, $desc, $newwin);
    }

    public static function GetHyperlink4Shlp(string $shlp, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::SHLP_NAME, $shlp, $shlp, $desc, $newwin);
    }

    public static function GetHyperlink4Cvers(string $compName = NULL, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::CVERS_NAME, $compName, $compName, $desc, $newwin);
    }

    public static function GetHyperlink4Cus0IMGActivity(string $img, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::CUS0_NAME, $img, $img, $desc, $newwin);
    }

    public static function GetHyperlink4Sqlt(string $sqlTable, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::SQLT_NAME, $sqlTable, $sqlTable, $desc, $newwin);
    }

    public static function GetHyperlink4Tabl(string $table, string $desc = NULL, $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::TABL_NAME, $table, $table, $desc, $newwin);
    }

    public static function GetHyperlink4TablField(string $table, string $field, bool $newwin = TRUE): string {
        if (strlen(trim($table)) < 1 || strlen(trim($field)) < 1) {
            return '&nbsp;';
        }
        $objname = GLOBAL_UTIL::Clear4Url($table) . "-" . GLOBAL_UTIL::Clear4Url($field);
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::TABL_NAME, $objname, $field, $field, $newwin);
    }

    public static function GetHyperlink4TablInclude(string $table, $field, $position, bool $newwin = TRUE): string {
        if (strlen(trim($table)) < 1 || strlen(trim($field)) < 1) {
            return '&nbsp;';
        }
        $objname = htmlentities(strtolower($table)) . "-" . htmlentities($position);
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::TABL_NAME, $objname, $field, $position, $newwin);
    }

    public static function GetHyperlink4Tran(string $tcode, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode, $tcode, $desc, $newwin);
    }

    public static function GetHyperlink4TranEx(string $tcode, bool $newwin = TRUE): string {
        $url = self::GetObjectURL(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode);
        $desc = ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode);
        $title = (empty($desc)) ? $tcode : $desc;
        $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';

        $result = '<a href="' . strtolower($url)
                . '" title="' . htmlentities($title) . '" '
                . $newWindow . '>'
                . htmlentities($tcode) . '</a>';
        return $result;
    }

    public static function GetHyperlink4View(string $view, string $desc = NULL, bool $newwin = TRUE): string {
        return self::GetHyperlink(GLOBAL_ABAP_OTYPE::VIEW_NAME, $view, $view, $desc, $newwin);
    }

    /**
     * Get the domain name and the object path. Examples:
     * <pre>
     * https://www.sapdatasheet.org/abap/tabl/bkpf.html
     * https://www.sapdatasheet.org/abap/tabl/bkpf-mandt.html
     * </pre>
     */
    public static function GetObjectURL(string $objtype, string $objname): string {
        return GLOBAL_WEBSITE::SAPDS_ORG_URL . self::GetObjectPath($objtype, $objname);
    }

    /**
     * Get the Object path name.
     *
     * @param string $objtype ABAP Object Type, example: DOMA, TABL
     * @param string $objname ABAP Object Name, example: (tabl) BKPF, (tabl field) BKPF-BUKRS
     */
    public static function GetObjectPath(string $objtype, string $objname): string {
        return '/abap/' . strtolower($objtype) . '/' . GLOBAL_UTIL::Clear4Url($objname) . '.html';
    }

    /**
     * Get ABAP Object URL with for Datasheet, with domain name.
     */
    public static function GetObjectHyperlink4DS(string $oType, string $oName, string $subName = NULL, bool $withDesc = TRUE): string {
        $objname = ($subName === NULL) ? GLOBAL_UTIL::Clear4Url($oName) : GLOBAL_UTIL::Clear4Url($oName) . '-' . GLOBAL_UTIL::Clear4Url($subName);
        $url = self::GetObjectURL($oType, $objname);
        $desc = ABAP_UI_TOOL::GetObjectDescr($oType, $oName, $subName);

        $result = '<sup>'
                . '<a href="' . strtolower($url)
                . '" title="' . $desc . ' - ' . GLOBAL_WEBSITE::SAPDS_ORG_URL_NAME . '"'
                . ' target="_blank">'
                . '<img src="' . ABAP_UI_CONST::ICON_EXTERNAL_LINK . '">'
                . '</a>'    // data-toggle="tooltip" data-placement="bottom"
                . '</sup>&nbsp;';
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
    public static function GetObjectHyperlink(string $oType, string $oName, string $subName = NULL) {
        if (($oType == GLOBAL_ABAP_OTYPE::TABL_NAME && strlen(trim($subName)) > 0) || ($oType == GLOBAL_ABAP_OTYPE::DTF_NAME)) {
            return self::GetHyperlink4Tabl($oName)
                    . ' - '
                    . self::GetHyperlink4TablField($oName, $subName);
        } else if (array_key_exists($oType, GLOBAL_ABAP_OTYPE::$OTYPES)) {
            return self::GetHyperlink($oType, $oName, $oName, NULL, TRUE);
        } else if ($oType == GLOBAL_ABAP_OTYPE::OM_NAME) {
            return self::GetHyperlink4Clas($oName) . ' - ' . $subName;
        } else if ($oType == GLOBAL_ABAP_OTYPE::NN_NAME) {
            return self::GetHyperlink4Msag($oName)
                    . ' - '
                    . self::GetHyperlink4Msgnr($oName, $subName);
        } else if ($oType == GLOBAL_ABAP_OTYPE::SEOC_NAME) {
            $seoclass = ABAP_DB_TABLE_SEO::SEOCLASS($oName);
            if ($seoclass['CLSTYPE'] == ABAP_DB_TABLE_SEO::SEOCLASS_CLSTYPE_CLAS) {
                return self::GetHyperlink4Clas($oName);
            } else if ($seoclass['CLSTYPE'] == ABAP_DB_TABLE_SEO::SEOCLASS_CLSTYPE_INTF) {
                return self::GetHyperlink4Intf($oName);
            }
        }

        // If not found earlier, then we simply display the object name
        return $oName;
    }

    /**
     * Get ABAP Object Type URL.
     */
    public static function GetOTypeHyperlink(string $oType, bool $newwin = TRUE): string {
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
    public static function GetWilHyperlink(array $counter, bool $newwin = TRUE): string {
        $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
        $linkLabel = self::GetWilLabel($counter);
        $path = self::GetWilPath($counter);
        return GLOBAL_ABAP_ICON::getIcon4Otype($counter['SRC_OBJ_TYPE']) .
                ' <a href="' . $path . '" '
                . 'title="' . htmlentities($linkLabel) . '" '
                . $newWindow . ' >'
                . $linkLabel . '</a>';
    }

    /**
     * Get Where-Using-List URL with pages.
     */
    public static function GetWilHyperlinks(string $oType, string $oName, string $srcOType, int $counter, bool $newwin = TRUE): string {
        $result = '';
        if ($counter > ABAP_DB_CONST::MAX_ROWS_LIMIT) {
            $pageCount = ceil($counter / ABAP_DB_CONST::MAX_ROWS_LIMIT);
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

    public static function GetWilLabel(array $counter): string {
        return GLOBAL_ABAP_OTYPE::getOTypeDesc($counter['SRC_OBJ_TYPE']) . ' (' . $counter['COUNTER'] . ')';
    }

    public static function GetWilPath(array $counter): string {
        $path = '/wil/abap/'
                . $counter['OBJ_TYPE']
                . '/' . GLOBAL_UTIL::Clear4Url($counter['OBJ_NAME'])
                . '/' . $counter['SRC_OBJ_TYPE']
                . '.html';
        return strtolower($path);
    }

    /**
     * Get URLs list for pages.
     */
    public static function GetWilPaths(string $oType, string $oName, string $srcOType, int $counter): array {
        $paths = array();
        if ($counter > ABAP_DB_CONST::MAX_ROWS_LIMIT) {
            $pageCount = ceil($counter / ABAP_DB_CONST::MAX_ROWS_LIMIT);
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

    public static function GetWilURL(array $counter): string {
        return GLOBAL_WEBSITE::SAPDS_ORG_URL . self::GetWilPath($counter);
    }

    /**
     * Get Where-Used-List URL.
     */
    public static function GetWulHyperlink(array $counter, $newwin = TRUE): string {
        $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
        $linkLabel = self::GetWulLabel($counter);
        $url = self::GetWulPath($counter);
        return GLOBAL_ABAP_ICON::getIcon4Otype($counter['OBJ_TYPE'])
                . ' <a href="' . $url . '" '
                . 'title="' . htmlentities($linkLabel) . '" '
                . $newWindow . ' >' . $linkLabel . '</a>';
    }

    /**
     * Get Where-Used-List URL with pages.
     */
    public static function GetWulHyperlinks(
    string $srcOType, string $srcOName, string $srcSubobj, string $oType, int $counter, bool $newwin = TRUE): string {
        $result = '';
        if ($counter > ABAP_DB_CONST::MAX_ROWS_LIMIT) {
            $newWindow = ($newwin === TRUE) ? 'target="_blank"' : '';
            $pageCount = ceil($counter / ABAP_DB_CONST::MAX_ROWS_LIMIT);
            $result = $result . ' pages: ';
            $urls = self::GetWulPaths($srcOType, $srcOName, $srcSubobj, $oType, $counter);
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

    public static function GetWulLabel(array $counter): string {
        return GLOBAL_ABAP_OTYPE::getOTypeDesc($counter['OBJ_TYPE']) . ' (' . $counter['COUNTER'] . ')';
    }

    public static function GetWulPath(array $counter): string {
        $url_subobj = (strlen(trim($counter['SRC_SUBOBJ'])) > 0) ? '-' . GLOBAL_UTIL::Clear4Url($counter['SRC_SUBOBJ']) : '';
        $url = '/wul/abap/'
                . $counter['SRC_OBJ_TYPE']
                . '/' . GLOBAL_UTIL::Clear4Url($counter['SRC_OBJ_NAME']) . $url_subobj
                . '/' . $counter['OBJ_TYPE']
                . '.html';
        return strtolower($url);
    }

    public static function GetWulPaths(
    string $srcOType, string $srcOName, string $srcSubobj, string $oType, int $counter): array {
        $paths = array();
        if ($counter > ABAP_DB_CONST::MAX_ROWS_LIMIT) {
            $pageCount = ceil($counter / ABAP_DB_CONST::MAX_ROWS_LIMIT);
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

    public static function GetWulURL(array $counter): string {
        return GLOBAL_WEBSITE::SAPDS_ORG_URL . self::GetWulPath($counter);
    }

}

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

class ABAP_UI_TABLES_Navigation {

    const HTTP_GET_TABLE = 'table';
    const HTTP_GET_FORMAT = 'format';
    const URI_PREFIX_TABLE = '/table/';
    const ERD_FILENAME_PREFIX = '/sap-table-';
    const URI_SUFFIX_ERD_PDF = '-erd.pdf';
    const URI_SUFFIX_ERD_PNG = '-erd.png';
    const URI_SUFFIX_HTML = '.html';

    public static function uri_table_erd_pdf(string $table_name, bool $with_domain = FALSE): string {
        $url = self::URI_PREFIX_TABLE . strtolower(GLOBAL_UTIL::Clear4Url($table_name))
                . self:: ERD_FILENAME_PREFIX . GLOBAL_UTIL::SlashEscape($table_name) . self::URI_SUFFIX_ERD_PDF;
        return ($with_domain) ? GLOBAL_WEBSITE::SAP_TABLES_ORG_URL . $url : $url;
    }

    public static function uri_table_erd_png(string $table_name, bool $with_domain = FALSE): string {
        $url = self::URI_PREFIX_TABLE . strtolower(GLOBAL_UTIL::Clear4Url($table_name))
                . self:: ERD_FILENAME_PREFIX . GLOBAL_UTIL::SlashEscape($table_name) . self::URI_SUFFIX_ERD_PNG;
        return ($with_domain) ? GLOBAL_WEBSITE::SAP_TABLES_ORG_URL . $url : $url;
    }

    public static function url_table(string $table_name, bool $with_domain = FALSE): string {
        $url = self::URI_PREFIX_TABLE . strtolower(GLOBAL_UTIL::Clear4Url($table_name)) . self::URI_SUFFIX_HTML;
        return ($with_domain) ? GLOBAL_WEBSITE::SAP_TABLES_ORG_URL . $url : $url;
    }

}

class ABAP_UI_TCODES_Navigation {

    const BOOK_PREFIX_MODULE = 'SAP-TCodes_Module_';
    const DOWNLOAD_NAME_ROW_MIN = 200;                   // Only download
    const PATH_ANALYTICS_COMP = '/analytics/component/';
    const PATH_ANALYTICS_MODULE = '/analytics/module/';
    const PATH_ANALYTICS_NAME = '/analytics/name/';
    const PATH_DOWNLOAD_BOOK = '/download/book/';
    const PATH_DOWNLOAD_BOOK_DIST = '/download/book/dist/';
    const PATH_DOWNLOAD_SHEET = '/download/sheet/';
    const PATH_DOWNLOAD_SHEET_DIST = '/download/sheet/dist/';
    const PATH_TCODE = '/tcode/';
    const SHEET_PARAMETER_FILTER = 'filter';
    const SHEET_PARAMETER_FILTER_MODULE = 'module';
    const SHEET_PARAMETER_FILTER_COMPONENT = 'component';
    const SHEET_PARAMETER_FILTER_NAME = 'name';
    const SHEET_PARAMETER_ID = 'id';
    const SHEET_PARAMETER_FORMAT = 'format';
    const SHEET_PREFIX = 'SAP-TCodes_';

    /**
     * Create HTML Link (&lta&gt) to an software component.
     */
    public static function AnalyticsCompHyperlink(string $comp, bool $url = FALSE): string {
        $buf_key = GLOBAL_BUFFER::KEYPREFIX_TCODES_UINAV_COMP . $comp;
        $buf_value = GLOBAL_BUFFER::Get($buf_key);
        if ($buf_value == FALSE) {
            $href = self::AnalyticsCompPath($comp, $url);
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
    public static function AnalyticsCompPath(string $comp, bool $url = FALSE): string {
        $path = self::PATH_ANALYTICS_COMP . GLOBAL_UTIL::Clear4Url($comp) . '.html';
        return ($url) ? GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . $path : $path;
    }

    /**
     * Create HTML Link (&lta&gt) to an application module.
     */
    public static function AnalyticsModuleHyperlink(string $posid, bool $url = FALSE): string {
        $buf_key = GLOBAL_BUFFER::KEYPREFIX_TCODES_UINAV_MODULE . $posid;
        $buf_value = GLOBAL_BUFFER::Get($buf_key);
        if ($buf_value == FALSE) {
            $fctr = ABAPANA_DB_TABLE::ABAPBMFR_POSID_2_FCTR($posid);
            $href = self::AnalyticsModulePath($posid, $url);
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
    public static function AnalyticsModulePath(string $posid, bool $url = FALSE): string {
        $path = self::PATH_ANALYTICS_MODULE . GLOBAL_UTIL::Clear4Url($posid) . '.html';
        return ($url) ? GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . $path : $path;
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
    public static function AnalyticsNamePath(string $prefix, bool $url = FALSE): string {
        $path = self::PATH_ANALYTICS_NAME . GLOBAL_UTIL::Clear4Url($prefix) . '.html';
        return ($url) ? GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . $path : $path;
    }

    /**
     * Get book name for an module.
     */
    public static function BookName4Module(string $module): string {
        return self::BOOK_PREFIX_MODULE . strtoupper($module) . '-EN.pdf';
    }

    /**
     * Get relative Distribution path.
     */
    public static function DistPath(string $fileName): string {
        return 'dist' . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * Get Path for downloading a book.
     * Example:
     * <pre>
     *   /download/book/dist/dist/SAP-TCodes_Module_AC.pdf
     * </pre>
     */
    public static function DownloadBookPath(string $bookName, bool $url = FALSE): string {
        $path = self::PATH_DOWNLOAD_BOOK_DIST . $bookName;
        return ($url) ? GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . $path : $path;
    }

    /**
     * Get Path for downloading books.
     * Example:
     * <pre>
     *   /download/book/
     *   https://www.sap-tcodes.org/download/book/
     * </pre>
     */
    public static function DownloadBooks(bool $url = FALSE): string {
        return ($url) ? GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . self::PATH_DOWNLOAD_BOOK : self::PATH_DOWNLOAD_BOOK;
    }

    /**
     * Get path for download an sheet.
     * Example:
     * <pre>
     *   download.php?filter=module&id=fi&format=csv
     * </pre>
     */
    public static function DownloadSheetPath(string $sheetName, bool $url = FALSE): string {
        $path = self::PATH_DOWNLOAD_SHEET_DIST . $sheetName;
        return ($url) ? GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . $path : $path;
    }

    /**
     * Get Path for downloading sheets.
     * Example:
     * <pre>
     *   /download/sheet/
     *   https://www.sap-tcodes.org/download/sheet/
     * </pre>
     */
    public static function DownloadSheets(bool $url = FALSE): string {
        return ($url) ? GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . self::PATH_DOWNLOAD_SHEET : self::PATH_DOWNLOAD_SHEET;
    }

    /**
     * Get Sheet file name (no suffix).
     */
    public static function SheetName(string $filter, string $id, string $format): string {
        $name = GLOBAL_UTIL::SlashClear($id);
        return self::SHEET_PREFIX
                . ucfirst(strtolower($filter)) . '_'
                . strtoupper($name)
                . '-EN.' . strtolower($format);
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
    public static function TCode(string $tcode, bool $url = FALSE): string {
        $path = self::PATH_TCODE . GLOBAL_UTIL::Clear4Url($tcode) . '.html';
        return ($url) ? GLOBAL_WEBSITE::SAP_TCODES_ORG_URL . $path : $path;
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
    public static function TCodeHyperlink(string $tcode, bool $url = FALSE): string {
        $href = self::TCode($tcode, $url);
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

class ABAP_UI_TOOL {

    public static function Redirect404() {
        header(GLOBAL_HTTP_STATUS::STATUS_404);
        header("Location: /page404.php");
    }

    /**
     * Clear zero value from UI.
     */
    public static function ClearZero(int $Int = NULL) {
        if ($Int == 0) {
            return '&nbsp;';
        } else {
            return $Int;
        }
    }

    /**
     * Get check box UI control.
     */
    public static function GetCheckBox(string $Name, string $CheckedValue = null): string {
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
    public static function GetClassMethodAnchorName(string $method): string {
        return strtolower(ABAP_DB_TABLE_SEO::SEOCOMPO . '-' . $method);
    }

    /**
     * Get page number index.
     */
    public static function GetPagingList(int $currentPage, int $maxPage): array {
        $min = $currentPage - 10;
        $min = ($min < 1) ? 1 : $min;
        $max = $currentPage + 10;
        $max = ($max > $maxPage) ? $maxPage : $max;

        $list = array();
        for ($i = $min; $i <= $max; $i++) {
            array_push($list, $i);
        }

        return $list;
    }

    /**
     * Get radio box UI control.
     */
    public static function GetRadioBox(string $Name, bool $Flag): string {
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
    public static function GetFunctionModuleParameterType(string $Type = null): string {
        if ($Type == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_I) {
            return GLOBAL_ABAP_ICON::getIcon4ParameterImport() . ' Importing';
        } else if ($Type == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_E) {
            return GLOBAL_ABAP_ICON::getIcon4ParameterExport() . ' Exporting';
        } else if ($Type == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_C) {
            return GLOBAL_ABAP_ICON::getIcon4ParameterChanging() . ' Changing';
        } else if ($Type == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_T) {
            return GLOBAL_ABAP_ICON::getIcon4ParameterTable() . ' Tables';
        } else if ($Type == ABAP_DB_CONST::FUPARAREF_PARAMTYPE_X) {
            return GLOBAL_ABAP_ICON::getIcon4Alert() . ' Exception';
        } else {
            return GLOBAL_ABAP_ICON::getIcon4Abap() . ' Unknown Type';
        }
    }

    /**
     * ABAP OO Paratmer Type icon.
     */
    public static function GetOOParameterIcon(int $Type = null): string {
        if ($Type == ABAP_DB_TABLE_SEO::SEOSUBCODF_PARDECLTYP_0) {
            return GLOBAL_ABAP_ICON::getIcon4ParameterImport();
        } else if ($Type == ABAP_DB_TABLE_SEO::SEOSUBCODF_PARDECLTYP_1) {
            return GLOBAL_ABAP_ICON::getIcon4ParameterExport();
        } else if ($Type == ABAP_DB_TABLE_SEO::SEOSUBCODF_PARDECLTYP_2) {
            return GLOBAL_ABAP_ICON::getIcon4ParameterChanging();
        } else if ($Type == ABAP_DB_TABLE_SEO::SEOSUBCODF_PARDECLTYP_3) {
            return GLOBAL_ABAP_ICON::getIcon4ParameterResult();
        } else {
            return GLOBAL_ABAP_ICON::getIcon4Abap();
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
    public static function GetFunctionModuleTyping(string $RefClass = null): string {
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
    public static function GetObjectDescr(string $oType, string $oName, string $subName = NULL): string {
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
    public static function GetObjectTitle(string $oType, string $oName, string $oNameDisp = NULL): string {
        $title_name = ($oNameDisp === NULL) ? $oName : $oNameDisp;
        $title_name = 'SAP ABAP ' . GLOBAL_ABAP_OTYPE::getOTypeDesc($oType) . ' ' . htmlentities($title_name);
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
    public static function GetSqltDesc($Sqlclass): string {
        if ($Sqlclass == 'POOL') {
            return 'Table pool';
        } else {
            return 'Table cluster';
        }
    }

    /**
     * Get Table Filed description.
     */
    public static function GetTablFieldDesc($PrecField, $RollName): string {
        if (strlen(trim($PrecField)) > 0) {
            return ABAP_DB_TABLE_TABL::DD02T($PrecField);
        } else {
            return ABAP_DB_TABLE_DTEL::DD04T($RollName);
        }
    }

    /**
     * Get Table Filed description directly.
     */
    public static function GetTablFieldDescDirect($table, $field): string {
        $dd03l = ABAP_DB_TABLE_TABL::DD03L(strtoupper($table), strtoupper($field));
        return htmlentities(ABAP_UI_TOOL::GetTablFieldDesc($dd03l['PRECFIELD'], $dd03l['ROLLNAME']));
    }

    /**
     * Get transaction code type.
     * TODO
     */
    public static function GetTCodeTypeDesc($TCodeType): string {
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
    public static function CheckDesc(string $desc = null): string {
        if (!empty($desc)) {
            return '(' . htmlentities($desc) . ')';
        } else {
            return '';
        }
    }

}
