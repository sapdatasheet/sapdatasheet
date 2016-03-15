<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__ROOT__ . '/include/abap_db.php');

ob_start();
?>
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>http://www.sapdatasheet.org/sitemap/index.xml</loc>
        <lastmod><?php echo date("Y-m-d") ?></lastmod>
    </sitemap>
    <?php
    $abap_type_count = array(
        array("bmfr", 1),
        array("clas", 3),
        array("cus0", 2),
        array("cvers", 1),
        array("doma", 3),
        array("devc", 1),
        array("dtel", 11),
        array("fugr", 2),
        array("func", 11),
        array("intf", 1),
        array("msag", 1),
        array("msag-msgnr", 14),
        array("prog", 7),
        array("shlp", 1),
        array("sqlt", 1),
        array("tabl", 12),
        array("table-field", 199),
        array("tran", 3),
        array("view", 2),
    );
    ?>
    <?php foreach ($abap_type_count as $abap_type_item) { ?>
        <?php for ($i = 1; $i <= $abap_type_item[1]; $i++) { ?>
            <sitemap>
                <loc>http://www.sapdatasheet.org/sitemap/abap-<?php echo $abap_type_item[0] ?><?php echo $i ?>.xml</loc>
                <lastmod><?php echo date("Y-m-d") ?></lastmod>
            </sitemap>
        <?php } ?>
    <?php } ?>
</sitemapindex>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
$ob_fp = fopen("./sitemaps.xml", "w");
fwrite($ob_fp, $ob_content);
fclose($ob_fp);


