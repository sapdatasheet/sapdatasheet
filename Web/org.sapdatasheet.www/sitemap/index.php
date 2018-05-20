<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once($__ROOT__ . '/include/common/global.php');
require_once($__ROOT__ . '/include/common/abap_db.php');
require_once($__ROOT__ . '/include/common/abap_ui.php');

// Index files
// ABAP Object Types in the zbuffer_index_counter table
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


ob_start();
?>
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/</loc><changefreq>monthly</changefreq><priority>1.0</priority></url>

    <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . '/abap/' . strtolower(GLOBAL_ABAP_OTYPE::CVERS_NAME) . '/' ?></loc><changefreq>monthly</changefreq><priority>1.0</priority></url>
    <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . '/abap/' . strtolower(GLOBAL_ABAP_OTYPE::BMFR_NAME) . '/' ?>index-<?php echo strtolower(ABAP_DB_CONST::INDEX_TOP) ?>.html</loc><changefreq>monthly</changefreq><priority>1.0</priority></url>
    <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . '/abap/' . strtolower(GLOBAL_ABAP_OTYPE::TABL_NAME) . '/' ?>index-<?php echo strtolower(ABAP_DB_CONST::DD02L_TABCLASS_CLUSTER) ?>.html</loc><changefreq>monthly</changefreq><priority>1.0</priority></url>
    <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . '/abap/' . strtolower(GLOBAL_ABAP_OTYPE::TABL_NAME) . '/' ?>index-<?php echo strtolower(ABAP_DB_CONST::DD02L_TABCLASS_POOL) ?>.html</loc><changefreq>monthly</changefreq><priority>1.0</priority></url>
    <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . '/abap/' . strtolower(GLOBAL_ABAP_OTYPE::SQLT_NAME) . '/' ?></loc><changefreq>monthly</changefreq><priority>1.0</priority></url>

    <?php foreach ($abap_buffered_otypes as $otype) { ?>
    <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . '/abap/' . strtolower($otype) . '/' ?></loc><changefreq>monthly</changefreq><priority>1.0</priority></url>
        <?php
        $index_counter_list = ABAP_UI_Buffer_Index::ZBUFFER_INDEX_COUNTER($otype);
        foreach ($index_counter_list as $index_counter) {
            $index_page_count = $index_counter[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_PAGE_COUNT];
            ?>
            <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . '/abap/' . strtolower($otype) . '/' . $index_counter[ABAP_UI_Buffer_Index::INDEX_FILENAME] ?>.html</loc><changefreq>monthly</changefreq><priority>1.0</priority></url>
            <?php
            if ($index_page_count > 1) {
                for ($page_loop = 1; $page_loop <= $index_page_count; $page_loop++) {
                    ?>
                    <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG . '/abap/' . strtolower($otype) . '/' . $index_counter[ABAP_UI_Buffer_Index::INDEX_FILENAME] . '-' . $page_loop ?>.html</loc><changefreq>monthly</changefreq><priority>1.0</priority></url>
                    <?php
                }
            }
        }
    }
    ?>

    <!-- Where Used List for ABAP -->
    <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/wul/abap/</loc><changefreq>monthly</changefreq><priority>1.0</priority></url>
    <?php for ($abap_index = 1; $abap_index <= ABAP_DBDATA::WULCOUNTER_INDEX_MAX; $abap_index++) { ?>
        <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/wul/abap/index-<?php echo $abap_index ?>.html</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>
    <?php } ?>

    <!-- Where Using List for ABAP -->
    <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/wil/abap/index.html</loc><changefreq>monthly</changefreq><priority>1.0</priority></url>
    <?php for ($abap_index = 1; $abap_index <= ABAP_DBDATA::WILCOUNTER_INDEX_MAX; $abap_index++) { ?>
        <url><loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/wil/abap/index-<?php echo $abap_index ?>.html</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>
    <?php } ?>

</urlset>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
$ob_fp = fopen("./index.xml", "w");
fwrite($ob_fp, $ob_content);
fclose($ob_fp);
