<?php

class SITE_UI_CONST {

    const KEY_ABAP_OBJTYPE = 'abapobjtype';          // ABAP Object Type
    const KEY_ABAP_OBJNAME = 'abapobjname';          // ABAP Object Name
    const KEY_ABAP_DESC = 'description';             // ABAP Description
    const KEY_ABAP_DSLINK = 'abapdslink';            // ABAP Datasheet Link
    const KEY_ARRAY_DATA = 'data';                   // Array Data
    const KEY_CAPTION = 'caption';                   // HTML Hink Hint Caption
    const KEY_CSS_CLASS = 'class';                   // CSS Class
    const KEY_HIGHLIGHT = 'highlight';               // Flag to Highlight an item
    const KEY_HTML_ID = 'htmlid';                    // HTML id value
    const KEY_ICON_LINK = 'iconlink';                // Link for Icon link
    const KEY_LABEL = 'label';                       // Label/Name in a field
    const KEY_URL = 'url';                           // URL for <a> link
    const KEY_VALUE = 'value';                       // Count value of TCodes
    //
    const CSS_CLASS_ACTIVE = 'class="active"';
    //
    const JSON_NAME = 'name';
    const JSON_TILE = 'title';
    const JSON_GROUP = 'group';
    const JSON_URL = 'url';                          // https://www.sapdatasheet.org/abap/prog/name.html | #panel-ana-package
    const JSON_NEW_WINDOW = 'newwin';                // Yes / No
    const JSON_ICON_URL = 'icon_url';
    //
    const JSON_SOURCE = 'source';
    const JSON_TARGET = 'target';
    //
    const YES = 'Yes';
    const NO = 'No';

}

/** Web Site UI Class for Analytics Data */
class SITE_UI_ANALYTICS {

    public static function AnaComp_DB2UI($db_list) {
        $ui_list = array();
        foreach ($db_list as $item) {
            $cvers_desc = ABAP_DB_TABLE_HIER::CVERS_REF($item['SOFTCOMP']);
            $cvers_title = (strlen(trim($cvers_desc)) > 0) ? '(' . $cvers_desc . ')' : '';
            array_push($ui_list, array(
                SITE_UI_CONST::KEY_LABEL => $item['SOFTCOMP'],
                SITE_UI_CONST::KEY_VALUE => $item['COUNT'],
                SITE_UI_CONST::KEY_URL => ABAP_UI_TCODES_Navigation::AnalyticsCompPath($item['SOFTCOMP']),
                SITE_UI_CONST::KEY_CAPTION => 'TCodes in Component ' . $item['SOFTCOMP'] . ' ' . $cvers_title . ': ' . number_format($item['COUNT']),
                SITE_UI_CONST::KEY_ABAP_DESC => $cvers_desc,
            ));
        }

        return $ui_list;
    }

    public static function AnaCompModule_DB2UI($db_list) {
        $ui_list = array();
        foreach ($db_list as $item) {
            $abapbmfr = ABAPANA_DB_TABLE::ABAPBMFR_POSID($item['APPLPOSID']);
            $module_desc = htmlentities(ABAP_DB_TABLE_HIER::DF14T($abapbmfr['FCTR_ID']));
            $module_title = (strlen(trim($module_desc)) > 0) ? ' (' . $module_desc . ')' : '';
            array_push($ui_list, array(
                SITE_UI_CONST::KEY_LABEL => $item['APPLPOSID'],
                SITE_UI_CONST::KEY_VALUE => $item['COUNT'],
                SITE_UI_CONST::KEY_URL => ABAP_UI_TCODES_Navigation::AnalyticsModulePath($item['APPLPOSID']),
                SITE_UI_CONST::KEY_CAPTION => 'TCodes in Module ' . $item['APPLPOSID'] . $module_title . ': ' . number_format($item['COUNT']),
                SITE_UI_CONST::KEY_ABAP_DESC => $module_desc,
                SITE_UI_CONST::KEY_ABAP_OBJNAME => $abapbmfr['FCTR_ID'],
            ));
        }

        return $ui_list;
    }

    public static function AnaModuleBreadcrumbs($posid) {
        $abapbmfr = ABAPANA_DB_TABLE::ABAPBMFR_POSID($posid);

        $result = array();
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abapbmfr['FCTR_ID_L1'], $abapbmfr['PS_POSID_L1'], $abapbmfr['PS_POSID_LMAX'] == 1);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abapbmfr['FCTR_ID_L2'], $abapbmfr['PS_POSID_L2'], $abapbmfr['PS_POSID_LMAX'] == 2);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abapbmfr['FCTR_ID_L3'], $abapbmfr['PS_POSID_L3'], $abapbmfr['PS_POSID_LMAX'] == 3);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abapbmfr['FCTR_ID_L4'], $abapbmfr['PS_POSID_L4'], $abapbmfr['PS_POSID_LMAX'] == 4);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abapbmfr['FCTR_ID_L5'], $abapbmfr['PS_POSID_L5'], $abapbmfr['PS_POSID_LMAX'] == 5);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abapbmfr['FCTR_ID_L6'], $abapbmfr['PS_POSID_L6'], $abapbmfr['PS_POSID_LMAX'] == 6);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abapbmfr['FCTR_ID_L7'], $abapbmfr['PS_POSID_L7'], $abapbmfr['PS_POSID_LMAX'] == 7);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abapbmfr['FCTR_ID_L8'], $abapbmfr['PS_POSID_L8'], $abapbmfr['PS_POSID_LMAX'] == 8);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abapbmfr['FCTR_ID_L9'], $abapbmfr['PS_POSID_L9'], $abapbmfr['PS_POSID_LMAX'] == 9);

        return $result;
    }

    /**
     * Load Application Component Level 1 analytics data.
     *
     * @return array Application Component Level 1 data: {link, title, label, count}
     */
    public static function AnaModuleL1_DB2UI() {
        $result = array();
        $APPCOMP_L1_HIGHLIGHT = array('FI', 'CO', 'SD', 'MM', 'PP', 'BC');

        $appl_list = ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_PS_POSID_L1();
        foreach ($appl_list as $appl_item) {
            $appl_l1 = ABAPANA_DB_TABLE::ABAPBMFRL1_POSID($appl_item['PS_POSID_L1']);
            array_push($result, array(
                SITE_UI_CONST::KEY_HIGHLIGHT => in_array($appl_item['PS_POSID_L1'], $APPCOMP_L1_HIGHLIGHT),
                SITE_UI_CONST::KEY_LABEL => $appl_item['PS_POSID_L1'],
                SITE_UI_CONST::KEY_VALUE => $appl_item['COUNT'],
                SITE_UI_CONST::KEY_URL => ABAP_UI_TCODES_Navigation::AnalyticsModulePath($appl_item['PS_POSID_L1']),
                SITE_UI_CONST::KEY_CAPTION => 'SAP TCodes in Module ' . $appl_item['PS_POSID_L1'] . ' (' . $appl_l1['TEXT'] . '): ' . number_format($appl_item['COUNT']),
                SITE_UI_CONST::KEY_ABAP_DESC => $appl_l1['TEXT'],
                SITE_UI_CONST::KEY_ABAP_OBJNAME => $appl_l1['FCTR_ID_L1'],
            ));
        }

        return $result;
    }

    /**
     * Get tcoe analytics data in JSON format on Level 2 appl-comp for a specifield Level 1 appl-comp.
     */
    public static function AnaModuleL2_DB2UI($posid_l1) {
        $db_list = ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_PS_POSID_L2($posid_l1);
        $ui_list = array();
        foreach ($db_list as $item) {
            $posid = strlen(trim($item['PS_POSID_L2'])) > 0 ? $item['PS_POSID_L2'] : $posid_l1;

            $abapbmfr = ABAPANA_DB_TABLE::ABAPBMFR_POSID($posid);
            $module_desc = htmlentities(ABAP_DB_TABLE_HIER::DF14T($abapbmfr['FCTR_ID']));
            $module_title = (strlen(trim($module_desc)) > 0) ? ' (' . $module_desc . ')' : '';
            array_push($ui_list, array(
                SITE_UI_CONST::KEY_LABEL => $posid,
                SITE_UI_CONST::KEY_VALUE => intval($item['COUNT']),
                SITE_UI_CONST::KEY_URL => ABAP_UI_TCODES_Navigation::AnalyticsModulePath($posid),
                SITE_UI_CONST::KEY_CAPTION => $posid . $module_title . ': ' . number_format($item['COUNT']),
                SITE_UI_CONST::KEY_ABAP_OBJNAME => $abapbmfr['FCTR_ID'],
                SITE_UI_CONST::KEY_ABAP_DESC => $module_desc,
            ));
        }

        return $ui_list;
    }

    public static function AnaName_DB2UI($db_list) {
        $ui_list = array();
        foreach ($db_list as $item) {
            array_push($ui_list, array(
                SITE_UI_CONST::KEY_LABEL => $item['TCODEPREFIX'],
                SITE_UI_CONST::KEY_VALUE => $item['COUNT'],
                SITE_UI_CONST::KEY_URL => ABAP_UI_TCODES_Navigation::AnalyticsNamePath($item['TCODEPREFIX']),
                SITE_UI_CONST::KEY_CAPTION => 'TCode name starts with ' . $item['TCODEPREFIX'] . ': ' . number_format($item['COUNT']),
            ));
        }

        return $ui_list;
    }

    /**
     * Return PHP list to JSON for D3 buttle chart.
     */
    public static function List2Json_D3BubbleChart($list) {
        $alphabet = array(
            'name' => 'TCode',
            'children' => $list,
        );

        return json_encode($alphabet);
    }

    /**
     * Return PHP list to JSON for D3 pie chart.
     */
    public static function List2Json_D3PieChart($list) {
        $json = array(
            "sortOrder" => "value-desc",
            "content" => $list,
        );

        return json_encode($json);
    }

}

/** Web Site UI Class for TCode Page. */
class SITE_UI_TCODE {

    public static function List2Json($tcode, $analytics_list) {
        // Array Item Index
        //  0          - The Source Transaction Code
        //  1...$count - The Middle Object
        //  $count+1   - Eacho of the link; 
        //
        $count = count($analytics_list);

        $nodes = array();
        $links = array();

        // The Source Transaction Code
        array_push($nodes, array(
            SITE_UI_CONST::JSON_NAME => $tcode,
            SITE_UI_CONST::JSON_TILE => GLOBAL_ABAP_OTYPE::TRAN_DESC . ' ' . html_entity_decode(ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode)),
            SITE_UI_CONST::JSON_GROUP => $tcode,
            SITE_UI_CONST::JSON_URL => ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode),
            SITE_UI_CONST::JSON_NEW_WINDOW => SITE_UI_CONST::YES,
            SITE_UI_CONST::JSON_ICON_URL => GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::WORK_CENTER, TRUE),
        ));

        // The Middle Objects
        $index = 0;
        foreach ($analytics_list as $analytics) {
            $index++;

            array_push($nodes, array(
                SITE_UI_CONST::JSON_NAME => $analytics[SITE_UI_CONST::JSON_NAME],
                SITE_UI_CONST::JSON_TILE => $analytics[SITE_UI_CONST::JSON_TILE],
                SITE_UI_CONST::JSON_GROUP => $tcode,
                SITE_UI_CONST::JSON_URL => $analytics[SITE_UI_CONST::JSON_URL],
                SITE_UI_CONST::JSON_NEW_WINDOW => $analytics[SITE_UI_CONST::JSON_NEW_WINDOW],
                SITE_UI_CONST::JSON_ICON_URL => $analytics[SITE_UI_CONST::JSON_ICON_URL],
            ));

            array_push($links, array(
                SITE_UI_CONST::JSON_SOURCE => $index,
                SITE_UI_CONST::JSON_TARGET => 0,
            ));
        }

        // The Target Transaction Codes
        $index = 0;
        foreach ($analytics_list as $analytics) {
            $index++;

            if (is_array($analytics[SITE_UI_CONST::KEY_ARRAY_DATA])) {
                $data_index = 0;
                foreach ($analytics[SITE_UI_CONST::KEY_ARRAY_DATA] as $tcode_item) {
                    $data_index++;
                    // We only add limited number of tcodes to the diagram
                    if ($data_index > 10) {
                        break;
                    }

                    array_push($nodes, array(
                        SITE_UI_CONST::JSON_NAME => $tcode_item['TCODE'],
                        SITE_UI_CONST::JSON_TILE => GLOBAL_ABAP_OTYPE::TRAN_DESC . ' ' .  html_entity_decode(ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode_item['TCODE'])),
                        SITE_UI_CONST::JSON_GROUP => $index,
                        SITE_UI_CONST::JSON_URL => ABAP_UI_TCODES_Navigation::TCode($tcode_item['TCODE']),
                        SITE_UI_CONST::JSON_NEW_WINDOW => SITE_UI_CONST::YES,
                        SITE_UI_CONST::JSON_ICON_URL => GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_TRAN, TRUE),
                    ));

                    $nodes_count = count($nodes);
                    array_push($links, array(
                        SITE_UI_CONST::JSON_SOURCE => $nodes_count - 1,
                        SITE_UI_CONST::JSON_TARGET => $index,
                    ));
                }
            }
        }

        $json = array(
            "nodes" => $nodes,
            "links" => $links,
        );

        return json_encode($json);
    }

    /**
     * Load T-Code Analytics data.
     *
     * @param string $abaptran Transaction Code Analytics Data
     * @return array Analytics data list: {label: value}
     */
    public static function LoadAnalytics($abaptran) {
        $result = array();
        $count = 0;

        // Program
        if (GLOBAL_UTIL::IsNotEmpty($abaptran['PGMNA'])) {
            $count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT(ABAPANA_DB_TABLE::ABAPTRAN_PGMNA, $abaptran['PGMNA']);
            if ($count > 1) {
                $html_id = 'ana-pgmna';
                $url = '#panel-' . $html_id;
                $data = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(ABAPANA_DB_TABLE::ABAPTRAN_PGMNA, $abaptran['PGMNA']);
                array_push($result, array(
                    SITE_UI_CONST::KEY_LABEL => GLOBAL_ABAP_OTYPE::PROG_DESC,
                    SITE_UI_CONST::KEY_ABAP_OBJNAME => GLOBAL_ABAP_ICON::getIcon4OtypePROG(TRUE) . ' <a href="' . $url . '">' . $abaptran['PGMNA'] . '</a>',
                    SITE_UI_CONST::KEY_ABAP_DSLINK => ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::PROG_NAME, $abaptran['PGMNA']),
                    SITE_UI_CONST::KEY_VALUE => $count,
                    SITE_UI_CONST::KEY_ARRAY_DATA => $data,
                    SITE_UI_CONST::KEY_HTML_ID => $html_id,
                    //
                    SITE_UI_CONST::JSON_NAME => $abaptran['PGMNA'],
                    SITE_UI_CONST::JSON_TILE => GLOBAL_ABAP_OTYPE::PROG_DESC . ' ' . ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::PROG_NAME, $abaptran['PGMNA']),
                    SITE_UI_CONST::JSON_URL => $url,
                    SITE_UI_CONST::JSON_NEW_WINDOW => SITE_UI_CONST::NO,
                    SITE_UI_CONST::JSON_ICON_URL => GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_PROG, TRUE),
                ));
            }
        }

        // Called T-Code
        if (GLOBAL_UTIL::IsNotEmpty($abaptran['CALLEDTCODE'])) {
            $count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT(ABAPANA_DB_TABLE::ABAPTRAN_CALLEDTCODE, $abaptran['CALLEDTCODE']);
            if ($count > 1) {
                $html_id = 'ana-ctcode';
                $data = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(ABAPANA_DB_TABLE::ABAPTRAN_CALLEDTCODE, $abaptran['CALLEDTCODE']);
                array_push($result, array(
                    SITE_UI_CONST::KEY_LABEL => 'Called TCode',
                    SITE_UI_CONST::KEY_ABAP_OBJNAME => GLOBAL_ABAP_ICON::getIcon4OtypeTRAN(TRUE) . ' <a href="#panel-' . $html_id . '">' . $abaptran['CALLEDTCODE'] . '</a>',
                    SITE_UI_CONST::KEY_ABAP_DSLINK => ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::TRAN_NAME, $abaptran['CALLEDTCODE']),
                    SITE_UI_CONST::KEY_VALUE => $count,
                    SITE_UI_CONST::KEY_ARRAY_DATA => $data,
                    SITE_UI_CONST::KEY_HTML_ID => $html_id,
                    //
                    SITE_UI_CONST::JSON_NAME => $abaptran['CALLEDTCODE'],
                    SITE_UI_CONST::JSON_TILE => 'Called TCode ' . ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::TRAN_NAME, $abaptran['CALLEDTCODE']),
                    SITE_UI_CONST::JSON_URL => ABAP_UI_TCODES_Navigation::TCode($abaptran['CALLEDTCODE'], TRUE),
                    SITE_UI_CONST::JSON_NEW_WINDOW => SITE_UI_CONST::NO,
                    SITE_UI_CONST::JSON_ICON_URL => GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_TRAN, TRUE),
                ));
            }
        }

        // Called View
        if (GLOBAL_UTIL::IsNotEmpty($abaptran['CALLEDVIEW'])) {
            $count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT(ABAPANA_DB_TABLE::ABAPTRAN_CALLEDVIEW, $abaptran['CALLEDVIEW']);
            if ($count > 1) {
                $html_id = 'ana-cview';
                $url = '#panel-' . $html_id;
                $data = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(ABAPANA_DB_TABLE::ABAPTRAN_CALLEDVIEW, $abaptran['CALLEDVIEW']);
                array_push($result, array(
                    SITE_UI_CONST::KEY_LABEL => 'Called View',
                    SITE_UI_CONST::KEY_ABAP_OBJNAME => GLOBAL_ABAP_ICON::getIcon4OtypeVIEW(TRUE) . ' <a href="' . $url . '">' . $abaptran['CALLEDVIEW'] . '</a>',
                    SITE_UI_CONST::KEY_ABAP_DSLINK => ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::VIEW_NAME, $abaptran['CALLEDVIEW']),
                    SITE_UI_CONST::KEY_VALUE => $count,
                    SITE_UI_CONST::KEY_ARRAY_DATA => $data,
                    SITE_UI_CONST::KEY_HTML_ID => $html_id,
                    //
                    SITE_UI_CONST::JSON_NAME => $abaptran['CALLEDVIEW'],
                    SITE_UI_CONST::JSON_TILE => 'Called View ' . ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::VIEW_NAME, $abaptran['CALLEDVIEW']),
                    SITE_UI_CONST::JSON_URL => $url,
                    SITE_UI_CONST::JSON_NEW_WINDOW => SITE_UI_CONST::NO,
                    SITE_UI_CONST::JSON_ICON_URL => GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_VIEW, TRUE),
                ));
            }
        }

        // Called View Cluster
        if (GLOBAL_UTIL::IsNotEmpty($abaptran['CALLEDVIEWC'])) {
            $count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT(ABAPANA_DB_TABLE::ABAPTRAN_CALLEDVIEWC, $abaptran['CALLEDVIEWC']);
            if ($count > 1) {
                $html_id = 'ana-cviewc';
                $url = '#panel-' . $html_id;
                $data = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(ABAPANA_DB_TABLE::ABAPTRAN_CALLEDVIEWC, $abaptran['CALLEDVIEWC']);
                array_push($result, array(
                    SITE_UI_CONST::KEY_LABEL => 'Called View Cluster',
                    SITE_UI_CONST::KEY_ABAP_OBJNAME => GLOBAL_ABAP_ICON::getIcon4OtypeVIEW(TRUE) . ' <a href="' . $url . '">' . $abaptran['CALLEDVIEWC'] . '</a>',
                    SITE_UI_CONST::KEY_ABAP_DSLINK => '',
                    SITE_UI_CONST::KEY_VALUE => $count,
                    SITE_UI_CONST::KEY_ARRAY_DATA => $data,
                    SITE_UI_CONST::KEY_HTML_ID => $html_id,
                    //
                    SITE_UI_CONST::JSON_NAME => $abaptran['CALLEDVIEWC'],
                    SITE_UI_CONST::JSON_TILE => 'Called View Cluster ' . htmlentities($abaptran['CALLEDVIEWC']),
                    SITE_UI_CONST::JSON_URL => $url,
                    SITE_UI_CONST::JSON_NEW_WINDOW => SITE_UI_CONST::NO,
                    SITE_UI_CONST::JSON_ICON_URL => GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_VIEW, TRUE),
                ));
            }
        }

        // Package
        if (GLOBAL_UTIL::IsNotEmpty($abaptran['PACKAGE'])) {
            $count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT(ABAPANA_DB_TABLE::ABAPTRAN_PACKAGE, $abaptran['PACKAGE']);
            if ($count > 1) {
                $html_id = 'ana-package';
                $url = '#panel-' . $html_id;
                $data = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(ABAPANA_DB_TABLE::ABAPTRAN_PACKAGE, $abaptran['PACKAGE']);
                array_push($result, array(
                    SITE_UI_CONST::KEY_LABEL => GLOBAL_ABAP_OTYPE::DEVC_DESC,
                    SITE_UI_CONST::KEY_ABAP_OBJNAME => GLOBAL_ABAP_ICON::getIcon4OtypeDEVC(TRUE) . ' <a href="' . $url . '">' . $abaptran['PACKAGE'] . '</a>',
                    SITE_UI_CONST::KEY_ABAP_DSLINK => ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::DEVC_NAME, $abaptran['PACKAGE']),
                    SITE_UI_CONST::KEY_VALUE => $count,
                    SITE_UI_CONST::KEY_ARRAY_DATA => $data,
                    SITE_UI_CONST::KEY_HTML_ID => $html_id,
                    //
                    SITE_UI_CONST::JSON_NAME => $abaptran['PACKAGE'],
                    SITE_UI_CONST::JSON_TILE => GLOBAL_ABAP_OTYPE::DEVC_DESC . ' ' . ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::DEVC_NAME, $abaptran['PACKAGE']),
                    SITE_UI_CONST::JSON_URL => $url,
                    SITE_UI_CONST::JSON_NEW_WINDOW => SITE_UI_CONST::NO,
                    SITE_UI_CONST::JSON_ICON_URL => GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_DEVC, TRUE),
                ));
            }
        }

        // Name Pattern: SE11 --> SE11_OLD
        SITE_UI_TCODE::LoadAnalytics4NamePattern($result, $abaptran['TCODE'], strlen($abaptran['TCODE']), 'ana-npmatch');

        // Name Pattern: CHARnn
        preg_match_all("/.*?(\d+)$/", $abaptran['TCODE'], $matches);
        if (count($matches) == 2 && is_array($matches[1]) && count($matches[1]) > 0) {              // In case of SE11, there will be: SE11, 11
            $pos_end = strlen($abaptran['TCODE']) - strlen($matches[1][0]);
            SITE_UI_TCODE::LoadAnalytics4NamePattern($result, $abaptran['TCODE'], $pos_end, 'ana-npcharnn');
        }

        // Simple Name Pattern: ABC-def, ABC_def, ABC.def
        SITE_UI_TCODE::LoadAnalytics4SimpleNamePattern($result, $abaptran['TCODE'], '-');
        SITE_UI_TCODE::LoadAnalytics4SimpleNamePattern($result, $abaptran['TCODE'], '_');
        SITE_UI_TCODE::LoadAnalytics4SimpleNamePattern($result, $abaptran['TCODE'], '.');

        // Parent Packge
        if (GLOBAL_UTIL::IsNotEmpty($abaptran['PACKAGEP'])) {
            $count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT(ABAPANA_DB_TABLE::ABAPTRAN_PACKAGEP, $abaptran['PACKAGEP']);
            if ($count > 1) {
                $html_id = 'ana-packagep';
                $url = '#panel-' . $html_id;
                $data = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(ABAPANA_DB_TABLE::ABAPTRAN_PACKAGEP, $abaptran['PACKAGEP']);
                array_push($result, array(
                    SITE_UI_CONST::KEY_LABEL => 'Parant Package',
                    SITE_UI_CONST::KEY_ABAP_OBJNAME => GLOBAL_ABAP_ICON::getIcon4OtypeDEVC(TRUE) . ' <a href="' . $url . '">' . $abaptran['PACKAGEP'] . '</a>',
                    SITE_UI_CONST::KEY_ABAP_DSLINK => ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::DEVC_NAME, $abaptran['PACKAGEP']),
                    SITE_UI_CONST::KEY_VALUE => $count,
                    SITE_UI_CONST::KEY_ARRAY_DATA => $data,
                    SITE_UI_CONST::KEY_HTML_ID => $html_id,
                    //
                    SITE_UI_CONST::JSON_NAME => $abaptran['PACKAGEP'],
                    SITE_UI_CONST::JSON_TILE => 'Parant Package ' . ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::DEVC_NAME, $abaptran['PACKAGEP']),
                    SITE_UI_CONST::JSON_URL => $url,
                    SITE_UI_CONST::JSON_NEW_WINDOW => SITE_UI_CONST::NO,
                    SITE_UI_CONST::JSON_ICON_URL => GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_DEVC, TRUE),
                ));
            }
        }

        // Application Components
        SITE_UI_TCODE::LoadAnalytics4ApplComp(
                $result, $abaptran['FCTR_ID_L9'], $abaptran['PS_POSID_L9'], ABAPANA_DB_TABLE::ABAPTRAN_FCTR_ID_L9);
        SITE_UI_TCODE::LoadAnalytics4ApplComp(
                $result, $abaptran['FCTR_ID_L8'], $abaptran['PS_POSID_L8'], ABAPANA_DB_TABLE::ABAPTRAN_FCTR_ID_L8);
        SITE_UI_TCODE::LoadAnalytics4ApplComp(
                $result, $abaptran['FCTR_ID_L7'], $abaptran['PS_POSID_L7'], ABAPANA_DB_TABLE::ABAPTRAN_FCTR_ID_L7);
        SITE_UI_TCODE::LoadAnalytics4ApplComp(
                $result, $abaptran['FCTR_ID_L6'], $abaptran['PS_POSID_L6'], ABAPANA_DB_TABLE::ABAPTRAN_FCTR_ID_L6);
        SITE_UI_TCODE::LoadAnalytics4ApplComp(
                $result, $abaptran['FCTR_ID_L5'], $abaptran['PS_POSID_L5'], ABAPANA_DB_TABLE::ABAPTRAN_FCTR_ID_L5);
        SITE_UI_TCODE::LoadAnalytics4ApplComp(
                $result, $abaptran['FCTR_ID_L4'], $abaptran['PS_POSID_L4'], ABAPANA_DB_TABLE::ABAPTRAN_FCTR_ID_L4);
        SITE_UI_TCODE::LoadAnalytics4ApplComp(
                $result, $abaptran['FCTR_ID_L3'], $abaptran['PS_POSID_L3'], ABAPANA_DB_TABLE::ABAPTRAN_FCTR_ID_L3);
        SITE_UI_TCODE::LoadAnalytics4ApplComp(
                $result, $abaptran['FCTR_ID_L2'], $abaptran['PS_POSID_L2'], ABAPANA_DB_TABLE::ABAPTRAN_FCTR_ID_L2);
        SITE_UI_TCODE::LoadAnalytics4ApplComp(
                $result, $abaptran['FCTR_ID_L1'], $abaptran['PS_POSID_L1'], ABAPANA_DB_TABLE::ABAPTRAN_FCTR_ID_L1);

        // Software Component
        if (GLOBAL_UTIL::IsNotEmpty($abaptran['SOFTCOMP'])) {
            $count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT(ABAPANA_DB_TABLE::ABAPTRAN_SOFTCOMP, $abaptran['SOFTCOMP']);
            if ($count > 1) {
                array_push($result, array(
                    SITE_UI_CONST::KEY_LABEL => GLOBAL_ABAP_OTYPE::CVERS_DESC,
                    SITE_UI_CONST::KEY_ABAP_OBJNAME => GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) . ' ' . ABAP_UI_TCODES_Navigation::AnalyticsCompHyperlink($abaptran['SOFTCOMP']),
                    SITE_UI_CONST::KEY_ABAP_DSLINK => ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::CVERS_NAME, $abaptran['SOFTCOMP']),
                    SITE_UI_CONST::KEY_VALUE => $count,
                    SITE_UI_CONST::KEY_ARRAY_DATA => '',
                    SITE_UI_CONST::KEY_HTML_ID => 'ana-softcomp',
                    //
                    SITE_UI_CONST::JSON_NAME => $abaptran['SOFTCOMP'],
                    SITE_UI_CONST::JSON_TILE => GLOBAL_ABAP_OTYPE::CVERS_DESC . ' ' . ABAP_UI_TOOL::GetObjectDescr(GLOBAL_ABAP_OTYPE::CVERS_NAME, $abaptran['SOFTCOMP']),
                    SITE_UI_CONST::JSON_URL => ABAP_UI_TCODES_Navigation::AnalyticsCompPath($abaptran['SOFTCOMP'], TRUE),
                    SITE_UI_CONST::JSON_NEW_WINDOW => SITE_UI_CONST::YES,
                    SITE_UI_CONST::JSON_ICON_URL => GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_CVERS, TRUE),
                ));
            }
        }

        return $result;
    }

    private static function LoadAnalytics4ApplComp(&$result, $fctr, $posid, $column) {
        if (GLOBAL_UTIL::IsNotEmpty($fctr)) {
            $count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT($column, $fctr);
            if ($count > 1) {
                array_push($result, array(
                    SITE_UI_CONST::KEY_LABEL => GLOBAL_ABAP_OTYPE::BMFR_DESC,
                    SITE_UI_CONST::KEY_ABAP_OBJNAME => GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) . ' ' . ABAP_UI_TCODES_Navigation::AnalyticsModuleHyperlink($posid),
                    SITE_UI_CONST::KEY_ABAP_DSLINK => ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::BMFR_NAME, $fctr),
                    SITE_UI_CONST::KEY_VALUE => $count,
                    SITE_UI_CONST::KEY_ARRAY_DATA => '',
                    SITE_UI_CONST::KEY_HTML_ID => 'ana-' . strtolower($column),
                    //
                    SITE_UI_CONST::JSON_NAME => $posid,
                    SITE_UI_CONST::JSON_TILE => GLOBAL_ABAP_OTYPE::BMFR_DESC . ' ' . ABAP_DB_TABLE_HIER::DF14T($fctr),
                    SITE_UI_CONST::JSON_URL => ABAP_UI_TCODES_Navigation::AnalyticsModulePath($posid, TRUE),
                    SITE_UI_CONST::JSON_NEW_WINDOW => SITE_UI_CONST::YES,
                    SITE_UI_CONST::JSON_ICON_URL => GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_BMFR, TRUE),
                ));
            }
        }
    }

    private static function LoadAnalytics4NamePattern(&$result, $tcode, $pos_end, $html_id) {
        $prefix = substr($tcode, 0, $pos_end);
        $pattern = $prefix . '%';
        $count = ABAPANA_DB_TABLE::ABAPTRAN_NAMEPATTERN_COUNT($pattern);
        if ($count > 1) {
            $url = '#panel-' . $html_id;
            $data = ABAPANA_DB_TABLE::ABAPTRAN_NAMEPATTERN_LOAD($pattern);
            array_push($result, array(
                SITE_UI_CONST::KEY_LABEL => 'Name Starts With',
                SITE_UI_CONST::KEY_ABAP_OBJNAME => GLOBAL_ABAP_ICON::getIcon4NamePrefix(TRUE) . ' <a href="' . $url . '">' . $pattern . '</a>',
                SITE_UI_CONST::KEY_ABAP_DSLINK => '',
                SITE_UI_CONST::KEY_VALUE => $count,
                SITE_UI_CONST::KEY_ARRAY_DATA => $data,
                SITE_UI_CONST::KEY_HTML_ID => $html_id,
                //
                SITE_UI_CONST::JSON_NAME => $pattern,
                SITE_UI_CONST::JSON_TILE => 'Name Starts With ' . htmlentities($pattern),
                SITE_UI_CONST::JSON_URL => $url,
                SITE_UI_CONST::JSON_NEW_WINDOW => SITE_UI_CONST::NO,
                SITE_UI_CONST::JSON_ICON_URL => GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::NAMEPREFIX, TRUE),
            ));
        }
    }

    private static function LoadAnalytics4SimpleNamePattern(&$result, $tcode, $needle) {
        $np_pos = strrpos($tcode, $needle);
        if ((!($np_pos === FALSE)) && (is_numeric(substr($tcode, $np_pos + 1)) == FALSE)) {
            $html_id = 'ana-npprefix' . $needle . 'match';
            SITE_UI_TCODE::LoadAnalytics4NamePattern($result, $tcode, $np_pos + 1, $html_id);
        }
    }

    /**
     * Load Breadcrumbs for the T-Code. Logic:
     * <pre>
     *   Software Component
     *     -> Application Component Level 1
     *     -> Application Component Level 2
     *     -> Application Component Level ...
     *     -> Application Component Level N
     *    --> Package
     *    --> T-Code
     * </pre>
     *
     * @param string $abaptran Transaction Code Analytics Data
     * @return array Breadcrumbs list: {class, link, title, label}
     */
    public static function LoadBreadcrumbs($abaptran) {
        $result = array();

        // Software Component
        $title = ABAP_DB_TABLE_HIER::CVERS_REF($abaptran['SOFTCOMP'])
                . '<br /> (' . GLOBAL_ABAP_OTYPE::CVERS_DESC . ')';
        $link = ABAP_UI_TCODES_Navigation::AnalyticsCompPath($abaptran['SOFTCOMP']);
        array_push($result, array(
            SITE_UI_CONST::KEY_CSS_CLASS => '',
            SITE_UI_CONST::KEY_ICON_LINK => GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE),
            SITE_UI_CONST::KEY_URL => $link,
            SITE_UI_CONST::KEY_CAPTION => $title,
            SITE_UI_CONST::KEY_LABEL => $abaptran['SOFTCOMP']
        ));

        // Application Components
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abaptran['FCTR_ID_L1'], $abaptran['PS_POSID_L1'], FALSE);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abaptran['FCTR_ID_L2'], $abaptran['PS_POSID_L2'], FALSE);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abaptran['FCTR_ID_L3'], $abaptran['PS_POSID_L3'], FALSE);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abaptran['FCTR_ID_L4'], $abaptran['PS_POSID_L4'], FALSE);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abaptran['FCTR_ID_L5'], $abaptran['PS_POSID_L5'], FALSE);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abaptran['FCTR_ID_L6'], $abaptran['PS_POSID_L6'], FALSE);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abaptran['FCTR_ID_L7'], $abaptran['PS_POSID_L7'], FALSE);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abaptran['FCTR_ID_L8'], $abaptran['PS_POSID_L8'], FALSE);
        SITE_UI_TCODE::LoadBreadcrumbs4AppComp($result, $abaptran['FCTR_ID_L9'], $abaptran['PS_POSID_L9'], FALSE);

        // Package
        if (GLOBAL_UTIL::IsNotEmpty($abaptran['PACKAGE'])) {
            $title = ABAP_DB_TABLE_HIER::DF14T($abaptran['PACKAGE'])
                    . ' (' . GLOBAL_ABAP_OTYPE::DEVC_DESC . ')';
            $link = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::DEVC_NAME, $abaptran['PACKAGE']);
            array_push($result, array(
                SITE_UI_CONST::KEY_CSS_CLASS => '',
                SITE_UI_CONST::KEY_ICON_LINK => GLOBAL_ABAP_ICON::getIcon4OtypeDEVC(TRUE),
                SITE_UI_CONST::KEY_URL => $link,
                SITE_UI_CONST::KEY_CAPTION => $title,
                SITE_UI_CONST::KEY_LABEL => $abaptran['PACKAGE']
            ));
        }

        // TCode
        $title = ABAP_DB_TABLE_HIER::DF14T($abaptran['TCODE'])
                . ' (' . GLOBAL_ABAP_OTYPE::TRAN_DESC . ')';
        $link = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::TRAN_NAME, $abaptran['TCODE']);
        array_push($result, array(
            SITE_UI_CONST::KEY_CSS_CLASS => SITE_UI_CONST::CSS_CLASS_ACTIVE,
            SITE_UI_CONST::KEY_ICON_LINK => GLOBAL_ABAP_ICON::getIcon4OtypeTRAN(TRUE),
            SITE_UI_CONST::KEY_URL => $link,
            SITE_UI_CONST::KEY_CAPTION => $title,
            SITE_UI_CONST::KEY_LABEL => $abaptran['TCODE']
        ));

        return $result;
    }

    /**
     * Create an Bootstrap Breadcrumbs iteam for an appl-comp.
     * 
     * @param array $result Breadcrumbs result list
     * @param string $fctr Appl-comp FCTR id
     * @param string $posid Appl-comp POSID
     * @param boolean $active Flag for active Breadcrumbs or not
     */
    public static function LoadBreadcrumbs4AppComp(&$result, $fctr, $posid, $active) {
        if (GLOBAL_UTIL::IsNotEmpty($fctr)) {
            $link = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::BMFR_NAME, $fctr);
            $title = ABAP_DB_TABLE_HIER::DF14T($fctr) . '<br /> (' . GLOBAL_ABAP_OTYPE::BMFR_DESC . ')';
            array_push($result, array(
                SITE_UI_CONST::KEY_CSS_CLASS => ($active == TRUE) ? SITE_UI_CONST::CSS_CLASS_ACTIVE : '',
                SITE_UI_CONST::KEY_ICON_LINK => GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE),
                SITE_UI_CONST::KEY_URL => $link,
                SITE_UI_CONST::KEY_CAPTION => $title,
                SITE_UI_CONST::KEY_LABEL => $posid
            ));
        }
    }

    /**
     * Load Related T-Codes for the T-Code. Logic:
     * <pre>
     *    --> SPRO Items (TO DO)
     *    --> T-Code Program
     *    --> T-Code Name Pattern
     *    --> Package
     *    --> Parent Package
     *    --> Application Component Level N
     *    --> Application Component Level ...
     *    --> Application Component Level 2
     *    --> Application Component Level 1
     *    --> Software Component
     * </pre>
     *
     * @param string $abaptran Transaction Code Analytics Data
     * @return array Breadcrumbs list: {link, title, label, count}
     */
    public static function LoadRelatedTCodes($abaptran) {
        $result = array();


        return $result;
    }

    /**
     * Load WIL list.
     *
     * @param string $tcode Transaction Code
     * @return array Breadcrumbs list: {link, title, label, count}
     */
    public static function LoadWil($tcode) {
        $result = array();

        $wil_counter_list = ABAPANA_DB_TABLE::WILCOUNTER_List(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode);
        if (empty($wil_counter_list) === FALSE) {
            foreach ($wil_counter_list as $item) {
                $label = GLOBAL_ABAP_OTYPE::getOTypeDesc($item['SRC_OBJ_TYPE']);
                $title = 'TCode ' . $tcode . ' is using ' . $label;
                array_push($result, array(
                    SITE_UI_CONST::KEY_ABAP_OBJTYPE => $item['SRC_OBJ_TYPE'],
                    SITE_UI_CONST::KEY_URL => ABAP_UI_DS_Navigation::GetWilURL($item),
                    SITE_UI_CONST::KEY_CAPTION => $title,
                    SITE_UI_CONST::KEY_LABEL => $label,
                    SITE_UI_CONST::KEY_VALUE => $item['COUNTER'],
                ));
            }
        }

        return $result;
    }

    /**
     * Load WUL list.
     *
     * @param string $tcode Transaction Code
     * @return array Breadcrumbs list: {link, title, label, count}
     */
    public static function LoadWul($tcode) {
        $result = array();

        $wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::TRAN_NAME, $tcode);
        if (empty($wul_counter_list) === FALSE) {
            foreach ($wul_counter_list as $item) {
                $label = GLOBAL_ABAP_OTYPE::getOTypeDesc($item['OBJ_TYPE']);
                $title = 'TCode ' . $tcode . ' is used by ' . $label;
                array_push($result, array(
                    SITE_UI_CONST::KEY_ABAP_OBJTYPE => $item['OBJ_TYPE'],
                    SITE_UI_CONST::KEY_URL => ABAP_UI_DS_Navigation::GetWulURL($item),
                    SITE_UI_CONST::KEY_CAPTION => $title,
                    SITE_UI_CONST::KEY_LABEL => $label,
                    SITE_UI_CONST::KEY_VALUE => $item['COUNTER'],
                ));
            }
        }

        return $result;
    }

}
