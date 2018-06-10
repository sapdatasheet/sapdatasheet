<?php

$__WS_ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/sitemap.php');

/**
 * Generate site map for Function Group, which is a short cut for PROG.
 */
function sitemap4_fugr(array &$result, string $column_name, array $list) {
    $fname = 'abap-' . strtolower(GLOBAL_ABAP_OTYPE::FUGR_NAME);

    $sitemap_otype = new SITEMAP($fname);
    $sitemap_otype->StartOB();
    foreach ($list as $row) {
        if (strlen(trim($row[$column_name])) > 0) {
            $prog = ABAP_DB_TABLE_PROG::GET_PROG_FUGR($row[$column_name]);
            $prog_meta = ABAP_DB_TABLE_PROG::YREPOSRCMETA(strtoupper($prog));
            if (!empty($prog_meta['PROGNAME'])) {
                $abapurl = GLOBAL_WEBSITE::SAPDS_ORG_URL . ABAP_UI_DS_Navigation::GetObjectPath(GLOBAL_ABAP_OTYPE::PROG_NAME, $prog);
                $sitemap_otype->EchoUrl($abapurl);
            }
        }
    }
    $sitemap_otype->EndOB();

    $result[$fname] = $sitemap_otype->GetFilenameSeq();
}

/**
 * Site map for Index.
 */
function sitemap4index(array &$result) {

    $fname = 'index';
    $sitemap_index = new SITEMAP($fname);
    $sitemap_index->StartOB();

    // ABAP index pages did not use zbuffer_index_counter table
    $abap_index_no_buffertable = array();
    array_push($abap_index_no_buffertable, GLOBAL_WEBSITE::SAPDS_ORG_URL . '/abap/');
    array_push($abap_index_no_buffertable, GLOBAL_WEBSITE::SAPDS_ORG_URL . '/abap/' . strtolower(GLOBAL_ABAP_OTYPE::CVERS_NAME) . '/');
    array_push($abap_index_no_buffertable, GLOBAL_WEBSITE::SAPDS_ORG_URL . '/abap/' . strtolower(GLOBAL_ABAP_OTYPE::BMFR_NAME) . '/index-' . strtolower(ABAP_DB_CONST::INDEX_TOP) . '.html');
    array_push($abap_index_no_buffertable, GLOBAL_WEBSITE::SAPDS_ORG_URL . '/abap/' . strtolower(GLOBAL_ABAP_OTYPE::TABL_NAME) . '/index-' . strtolower(ABAP_DB_CONST::DD02L_TABCLASS_CLUSTER) . '.html');
    array_push($abap_index_no_buffertable, GLOBAL_WEBSITE::SAPDS_ORG_URL . '/abap/' . strtolower(GLOBAL_ABAP_OTYPE::TABL_NAME) . '/index-' . strtolower(ABAP_DB_CONST::DD02L_TABCLASS_POOL) . '.html');
    array_push($abap_index_no_buffertable, GLOBAL_WEBSITE::SAPDS_ORG_URL . '/abap/' . strtolower(GLOBAL_ABAP_OTYPE::SQLT_NAME) . '/');


    foreach ($abap_index_no_buffertable as $item) {
        $sitemap_index->EchoUrl($item, SITEMAP::changefreq_monthly);
    }

    // ABAP index pages use the zbuffer_index_counter table
    $abap_buffered_otypes = array(
        GLOBAL_ABAP_OTYPE::BMFR_NAME,
        GLOBAL_ABAP_OTYPE::DEVC_NAME,
        GLOBAL_ABAP_OTYPE::MSAG_NAME,
        GLOBAL_ABAP_OTYPE::CUS0_NAME,
        GLOBAL_ABAP_OTYPE::TRAN_NAME,
        GLOBAL_ABAP_OTYPE::PROG_NAME,
        GLOBAL_ABAP_OTYPE::FUGR_NAME,
        GLOBAL_ABAP_OTYPE::FUNC_NAME,
        GLOBAL_ABAP_OTYPE::CLAS_NAME,
        GLOBAL_ABAP_OTYPE::INTF_NAME,
        GLOBAL_ABAP_OTYPE::SHLP_NAME,
        GLOBAL_ABAP_OTYPE::TABL_NAME,
        GLOBAL_ABAP_OTYPE::VIEW_NAME,
        GLOBAL_ABAP_OTYPE::DTEL_NAME,
        GLOBAL_ABAP_OTYPE::DOMA_NAME
    );
    foreach ($abap_buffered_otypes as $otype) {
        $sitemap_index->EchoUrl(GLOBAL_WEBSITE::SAPDS_ORG_URL . '/abap/' . strtolower($otype) . '/', SITEMAP::changefreq_monthly);
        foreach (ABAP_UI_Buffer_Index::ZBUFFER_INDEX_COUNTER($otype) as $index_counter) {
            $sitemap_index->EchoUrl(GLOBAL_WEBSITE::SAPDS_ORG_URL . '/abap/' . strtolower($otype) . '/' . $index_counter[ABAP_UI_Buffer_Index::INDEX_FILENAME] . '.html', SITEMAP::changefreq_monthly);
            $index_page_count = $index_counter[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_PAGE_COUNT];
            if ($index_page_count > 1) {
                for ($page_loop = 1; $page_loop <= $index_page_count; $page_loop++) {
                    $sitemap_index->EchoUrl(GLOBAL_WEBSITE::SAPDS_ORG_URL . '/abap/' . strtolower($otype) . '/' . $index_counter[ABAP_UI_Buffer_Index::INDEX_FILENAME] . '-' . $page_loop . '.html', SITEMAP::changefreq_monthly);
                }
            }
        }
    }

    // Index pages for Where Using List
    $url = GLOBAL_WEBSITE::SAPDS_ORG_URL . '/wil/abap/';
    $sitemap_index->EchoUrl($url, SITEMAP::changefreq_monthly);
    for ($wil_index = 1; $wil_index <= ABAP_DBDATA::WILCOUNTER_INDEX_MAX; $wil_index++) {
        $url = GLOBAL_WEBSITE::SAPDS_ORG_URL . '/wil/abap/index-' . $wil_index . '.html';
        $sitemap_index->EchoUrl($url, SITEMAP::changefreq_monthly);
    }

    // Index pages for Where Used List
    $url = GLOBAL_WEBSITE::SAPDS_ORG_URL . '/wul/abap/';
    $sitemap_index->EchoUrl($url, SITEMAP::changefreq_monthly);
    for ($wul_index = 1; $wul_index <= ABAP_DBDATA::WULCOUNTER_INDEX_MAX; $wul_index++) {
        $url = GLOBAL_WEBSITE::SAPDS_ORG_URL . '/wul/abap/index-' . $wul_index . '.html';
        $sitemap_index->EchoUrl($url, SITEMAP::changefreq_monthly);
    }

    $sitemap_index->EndOB();

    $result[$fname] = $sitemap_index->GetFilenameSeq();
}

/**
 * Generate site map for each ABAP Object Type.
 */
function sitemap4otype(array &$result, string $otype, string $column_name, array $list, string $fname_prefix = NULL) {
    $prefix = ($fname_prefix === NULL) ? $otype : $fname_prefix;
    $fname = 'abap-' . $prefix;

    $sitemap_otype = new SITEMAP($fname);
    $sitemap_otype->StartOB();
    foreach ($list as $row) {
        $obj_name = trim($row[$column_name]);
        if (strlen($obj_name) > 0) {
            $abapurl = GLOBAL_WEBSITE::SAPDS_ORG_URL . ABAP_UI_DS_Navigation::GetObjectPath($otype, $obj_name);
            $sitemap_otype->EchoUrl($abapurl, SITEMAP::changefreq_monthly);     // TODO - change to yearly after the code is stable
        }
    }
    $sitemap_otype->EndOB();

    $result[$fname] = $sitemap_otype->GetFilenameSeq();
}

function sitemap4wil(array &$result) {
    $fname = 'wil-abap';

    $sitemap_wil = new SITEMAP($fname);
    $sitemap_wil->StartOB();
    foreach (ABAPANA_DB_TABLE::WILCOUNTER_Sitemap() as $row) {

        $wilurl = GLOBAL_WEBSITE::SAPDS_ORG_URL . ABAP_UI_DS_Navigation::GetWilPath($row);
        $sitemap_wil->EchoUrl($wilurl, SITEMAP::changefreq_yearly, SITEMAP::priority_04);

        // If several pages exists ...
        if ($row['COUNTER'] > ABAP_DB_CONST::MAX_ROWS_LIMIT) {
            $urls = ABAP_UI_DS_Navigation::GetWilPaths($row['OBJ_TYPE'], $row['OBJ_NAME'], $row['SRC_OBJ_TYPE'], $row['COUNTER']);
            foreach ($urls as $wilurl) {
                $sitemap_wil->EchoUrl($wilurl, SITEMAP::changefreq_yearly, SITEMAP::priority_04);
            }
        }
    }
    $sitemap_wil->EndOB();

    $result[$fname] = $sitemap_wil->GetFilenameSeq();
}

function sitemap4wul(array &$result) {
    $fname = 'wul-abap';

    $sitemap_wul = new SITEMAP($fname);
    $sitemap_wul->StartOB();
    foreach (ABAPANA_DB_TABLE::WULCOUNTER_Sitemap() as $row) {

        $wulurl = GLOBAL_WEBSITE::SAPDS_ORG_URL . ABAP_UI_DS_Navigation::GetWulPath($row);
        $sitemap_wul->EchoUrl($wulurl, SITEMAP::changefreq_yearly, SITEMAP::priority_04);

        // If several pages exists ...
        if ($row['COUNTER'] > ABAP_DB_CONST::MAX_ROWS_LIMIT) {
            $urls = ABAP_UI_DS_Navigation::GetWulPaths($row['SRC_OBJ_TYPE'], $row['SRC_OBJ_NAME'], $row['SRC_SUBOBJ'], $row['OBJ_TYPE'], $row['COUNTER']);
            foreach ($urls as $wulurl) {
                $sitemap_wul->EchoUrl($wulurl, SITEMAP::changefreq_yearly, SITEMAP::priority_04);
            }
        }
    }
    $sitemap_wul->EndOB();

    $result[$fname] = $sitemap_wul->GetFilenameSeq();
}

// Collect Sitemaps Contents
$sitemaps = array();

// - Sitemaps for Index
sitemap4index($sitemaps);

// - Sitemaps for each OType
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::BMFR_NAME), 'FCTR_ID', ABAP_DB_TABLE_HIER::DF14L_Sitemap());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::CLAS_NAME), 'CLSNAME', ABAP_DB_TABLE_SEO::SEOCLASS_Sitemap(ABAP_DB_TABLE_SEO::SEOCLASS_CLSTYPE_CLAS));
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::CUS0_NAME), 'ACTIVITY', ABAP_DB_TABLE_CUS0::CUS_IMGACH_Sitemap());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::CVERS_NAME), 'COMPONENT', ABAP_DB_TABLE_HIER::CVERS_List());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::DEVC_NAME), 'DEVCLASS', ABAP_DB_TABLE_HIER::TDEVC_Sitemap());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::DOMA_NAME), 'DOMNAME', ABAP_DB_TABLE_DOMA::DD01L_Sitemap());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::DTEL_NAME), 'ROLLNAME', ABAP_DB_TABLE_DTEL::DD04L_Sitemap());
sitemap4_fugr($sitemaps, 'OBJ_NAME', ABAP_DB_TABLE_HIER::TADIR_FUGR_Sitemap());                                                     // FUGR - Function Group
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::FUNC_NAME), 'FUNCNAME', ABAP_DB_TABLE_FUNC::TFDIR_Sitemap());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::INTF_NAME), 'CLSNAME', ABAP_DB_TABLE_SEO::SEOCLASS_Sitemap(ABAP_DB_TABLE_SEO::SEOCLASS_CLSTYPE_INTF));
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::MSAG_NAME), 'MSGNBR', ABAP_DB_TABLE_MSAG::T100_Sitemap(), 'msag-msgnr');    // Message number
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::MSAG_NAME), 'ARBGB', ABAP_DB_TABLE_MSAG::T100A_Sitemap());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::PROG_NAME), 'OBJ_NAME', ABAP_DB_TABLE_HIER::TADIR_PROG_Sitemap());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::SHLP_NAME), 'SHLPNAME', ABAP_DB_TABLE_SHLP::DD30L_Sitemap());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::SQLT_NAME), 'SQLTAB', ABAP_DB_TABLE_TABL::DD06L_List());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::TABL_NAME), 'TABNAME', ABAP_DB_TABLE_TABL::DD02L_Sitemap());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::TABL_NAME), 'FIELD', ABAP_DB_TABLE_TABL::DD03L_Sitemap(), 'table-field');   // Table Field
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::TRAN_NAME), 'TCODE', ABAP_DB_TABLE_TRAN::TSTC_Sitemap());
sitemap4otype($sitemaps, strtolower(GLOBAL_ABAP_OTYPE::VIEW_NAME), 'VIEWNAME', ABAP_DB_TABLE_VIEW::DD25L_Sitemap());

// - WIL and WUL
sitemap4wil($sitemaps);
sitemap4wul($sitemaps);

// 
//
// Sitemaps list
//
$sitemapIndex = new SITEMAP_Index('sitemap');
$sitemapIndex->StartOB();
foreach ($sitemaps as $key => $value) {
    for ($i = 1; $i <= $value; $i++) {
        $url = GLOBAL_WEBSITE::SAPDS_ORG_URL . '/sitemap/' . SITEMAP::GetSitemapFilename($key, $i);
        $sitemapIndex->EchoUrl4Index($url);
    }
}
$sitemapIndex->EndOB();

echo PHP_EOL . PHP_EOL . 'Finished' . PHP_EOL;
