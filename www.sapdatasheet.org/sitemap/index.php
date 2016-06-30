<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once($__ROOT__ . '/include/common/global.php');
require_once($__ROOT__ . '/include/common/abap_db.php');

ob_start();
?>
<?xml version="1.0" encoding="UTF-8"?>
<?php
$sap_langus = array('', '/1', '/3', '/D', '/F'
    , '/I', '/J', '/L', '/M', '/N', '/P', '/R', '/S', '/T');
// a - x
$abap_index_a = array('a', 'b', 'c', 'd', 'e', 'f', 'g'
    , 'h', 'i', 'j', 'k', 'l', 'm', 'n'
    , 'o', 'p', 'q', 'r', 's', 't'
    , 'u', 'v', 'w', 'x');
// a - x, + slash
$abap_otpye_as = array('devc', 'prog', 'tabl', 'view', 'dtel', 'doma');
$abap_index_as = array('a', 'b', 'c', 'd', 'e', 'f', 'g'
    , 'h', 'i', 'j', 'k', 'l', 'm', 'n'
    , 'o', 'p', 'q', 'r', 's', 't'
    , 'u', 'v', 'w', 'x', 'slash');
// a - x, 0 - 9, + slash
$abap_otpye_a0s = array('tran', 'fugr', 'func');
$abap_index_a0s = array('a', 'b', 'c', 'd', 'e', 'f', 'g'
    , 'h', 'i', 'j', 'k', 'l', 'm', 'n'
    , 'o', 'p', 'q', 'r', 's', 't'
    , 'u', 'v', 'w', 'x', 'slash'
    , '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
// cus0 list
$abap_index_cus0 = array();
for ($count = 1; $count <= ABAP_DBDATA::CUS_IMGACT_INDEX_MAX; $count++) {
    array_push($abap_index_cus0, $count);
}
?>

<!-- Index files -->
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
    <url>
        <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/index.html</loc> 
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>

    <?php foreach ($sap_langus as $sap_langu) { ?>
        <!-- CLAS -->
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/clas<?php echo $sap_langu ?>/index.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php for ($abap_index = 1; $abap_index <= ABAP_DBDATA::SEOCLASS_CLAS_INDEX_MAX; $abap_index++) { ?>
            <url>
                <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/clas<?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        <?php } ?>
        <!-- INTF -->
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/intf<?php echo $sap_langu ?>/index.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php for ($abap_index = 1; $abap_index <= ABAP_DBDATA::SEOCLASS_INTF_INDEX_MAX; $abap_index++) { ?>
            <url>
                <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/intf<?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        <?php } ?>
        <!-- SHLP -->
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/shlp<?php echo $sap_langu ?>/index.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php for ($abap_index = 1; $abap_index <= ABAP_DBDATA::DD30L_INDEX_MAX; $abap_index++) { ?>
            <url>
                <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/shlp<?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        <?php } ?>
        
        <!-- Where Used List for ABAP -->
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/wul/abap<?php echo $sap_langu ?>/index.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php for ($abap_index = 1; $abap_index <= ABAP_DBDATA::WULCOUNTER_INDEX_MAX; $abap_index++) { ?>
            <url>
                <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/wul/abap<?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        <?php } ?>

        <!-- Where Using List for ABAP -->
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/wil/abap<?php echo $sap_langu ?>/index.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php for ($abap_index = 1; $abap_index <= ABAP_DBDATA::WILCOUNTER_INDEX_MAX; $abap_index++) { ?>
            <url>
                <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/wil/abap<?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        <?php } ?>
        
    <?php } ?>

    <!-- INTF -->
    <?php foreach ($sap_langus as $sap_langu) { ?>
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/intf<?php echo $sap_langu ?>/index.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php for ($abap_index = 1; $abap_index <= ABAP_DBDATA::SEOCLASS_INTF_INDEX_MAX; $abap_index++) { ?>
            <url>
                <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/intf<?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        <?php } ?>
    <?php } ?>    

    <!-- CUS0 -->
    <?php foreach ($sap_langus as $sap_langu) { ?>
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/cus0<?php echo $sap_langu ?>/index.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php foreach ($abap_index_cus0 as $abap_index) { ?>
            <url>
                <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/cus0<?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        <?php } ?>
    <?php } ?>
    <?php foreach ($sap_langus as $sap_langu) { ?>
        <!-- CVERS -->
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/cvers<?php echo $sap_langu ?>/index.html</loc> 
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <!-- MSAG -->
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/msag<?php echo $sap_langu ?>/index.html</loc> 
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <!-- SQLT -->
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/sqlt<?php echo $sap_langu ?>/index.html</loc> 
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
    <?php } ?>
    <!-- BMFR -->
    <?php foreach ($sap_langus as $sap_langu) { ?>
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/bmfr<?php echo $sap_langu ?>/index.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/bmfr<?php echo $sap_langu ?>/index-top.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php foreach ($abap_index_a as $abap_index) { ?>
            <url>
                <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/bmfr<?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc> 
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        <?php } ?>
    <?php } ?>
    <!-- DEVC, PROG, TABL, VIEW, DTEL -->
    <?php foreach ($sap_langus as $sap_langu) { ?>
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/tabl<?php echo $sap_langu ?>/index-cluster.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/tabl<?php echo $sap_langu ?>/index-pool.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php foreach ($abap_otpye_as as $abap_otype) { ?>
            <url>
                <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/<?php echo $abap_otype ?><?php echo $sap_langu ?>/index.html</loc>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
            <?php foreach ($abap_index_as as $abap_index) { ?>
                <url>
                    <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/<?php echo $abap_otype ?><?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc>
                    <changefreq>monthly</changefreq>
                    <priority>1.0</priority>
                </url>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <!-- TRAN, FUGR, FUNC -->
    <?php foreach ($sap_langus as $sap_langu) { ?>
        <url>
            <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/func<?php echo $sap_langu ?>/index-rfc.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php foreach ($abap_otpye_a0s as $abap_otype) { ?>
            <url>
                <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/<?php echo $abap_otype ?><?php echo $sap_langu ?>/index.html</loc>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
            <?php foreach ($abap_index_a0s as $abap_index) { ?>
                <url>
                    <loc><?php echo GLOBAL_WEBSITE::URLPREFIX_SAPDS_ORG ?>/abap/<?php echo $abap_otype ?><?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc>
                    <changefreq>monthly</changefreq>
                    <priority>1.0</priority>
                </url>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</urlset>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
$ob_fp = fopen("./index.xml", "w");
fwrite($ob_fp, $ob_content);
fclose($ob_fp);
