<?php ob_start(); ?>
<?xml version="1.0" encoding="UTF-8"?>
<!-- Index files -->
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"> 
    <url>
        <loc>http://www.sapdatasheet.org/index.html</loc> 
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>http://www.sapdatasheet.org/abap/index.html</loc> 
        <changefreq>monthly</changefreq>
        <priority>1.0</priority>
    </url>
    <?php
    $sap_langus = array('', '/1', '/3', '/D', '/F'
        , '/I', '/J', '/L', '/M', '/N', '/P', '/R', '/S', '/T');
    $abap_index_a = array('a', 'b', 'c', 'd', 'e', 'f', 'g'
        , 'h', 'i', 'j', 'k', 'l', 'm', 'n'
        , 'o', 'p', 'q', 'r', 's', 't'
        , 'u', 'v', 'w', 'x');
    $abap_otpye_as = array('devc', 'prog', 'tabl', 'view', 'dtel', 'doma');
    $abap_index_as = array('a', 'b', 'c', 'd', 'e', 'f', 'g'
        , 'h', 'i', 'j', 'k', 'l', 'm', 'n'
        , 'o', 'p', 'q', 'r', 's', 't'
        , 'u', 'v', 'w', 'x', 'slash');
    $abap_otpye_a0s = array('tran', 'fugr', 'func');
    $abap_index_a0s = array('a', 'b', 'c', 'd', 'e', 'f', 'g'
        , 'h', 'i', 'j', 'k', 'l', 'm', 'n'
        , 'o', 'p', 'q', 'r', 's', 't'
        , 'u', 'v', 'w', 'x', 'slash'
        , '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    ?>
    <!-- CVERS -->
    <?php foreach ($sap_langus as $sap_langu) { ?>
        <url>
            <loc>http://www.sapdatasheet.org/abap/cvers<?php echo $sap_langu ?>/index.html</loc> 
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
    <?php } ?>
    <!-- SQLT -->
    <?php foreach ($sap_langus as $sap_langu) { ?>
        <url>
            <loc>http://www.sapdatasheet.org/abap/sqlt<?php echo $sap_langu ?>/index.html</loc> 
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
    <?php } ?>
    <!-- BMFR -->
    <?php foreach ($sap_langus as $sap_langu) { ?>
        <url>
            <loc>http://www.sapdatasheet.org/abap/bmfr<?php echo $sap_langu ?>/index.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <url>
            <loc>http://www.sapdatasheet.org/abap/bmfr<?php echo $sap_langu ?>/index-top.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php foreach ($abap_index_a as $abap_index) { ?>
            <url>
                <loc>http://www.sapdatasheet.org/abap/bmfr<?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc> 
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
        <?php } ?>
    <?php } ?>
    <!-- DEVC, PROG, TABL, VIEW, DTEL -->
    <?php foreach ($sap_langus as $sap_langu) { ?>
        <url>
            <loc>http://www.sapdatasheet.org/abap/tabl<?php echo $sap_langu ?>/index-cluster.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <url>
            <loc>http://www.sapdatasheet.org/abap/tabl<?php echo $sap_langu ?>/index-pool.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php foreach ($abap_otpye_as as $abap_otype) { ?>
            <url>
                <loc>http://www.sapdatasheet.org/abap/<?php echo $abap_otype ?><?php echo $sap_langu ?>/index.html</loc>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
            <?php foreach ($abap_index_as as $abap_index) { ?>
                <url>
                    <loc>http://www.sapdatasheet.org/abap/<?php echo $abap_otype ?><?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc>
                    <changefreq>monthly</changefreq>
                    <priority>1.0</priority>
                </url>
            <?php } ?>
        <?php } ?>
    <?php } ?>

    <!-- TRAN, FUGR, FUNC -->
    <?php foreach ($sap_langus as $sap_langu) { ?>
        <url>
            <loc>http://www.sapdatasheet.org/abap/func<?php echo $sap_langu ?>/index-rfc.html</loc>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
        <?php foreach ($abap_otpye_a0s as $abap_otype) { ?>
            <url>
                <loc>http://www.sapdatasheet.org/abap/<?php echo $abap_otype ?><?php echo $sap_langu ?>/index.html</loc>
                <changefreq>monthly</changefreq>
                <priority>1.0</priority>
            </url>
            <?php foreach ($abap_index_a0s as $abap_index) { ?>
                <url>
                    <loc>http://www.sapdatasheet.org/abap/<?php echo $abap_otype ?><?php echo $sap_langu ?>/index-<?php echo $abap_index ?>.html</loc>
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
