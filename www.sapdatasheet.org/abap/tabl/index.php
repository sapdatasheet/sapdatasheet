<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

// Get Index
if (!isset($index)) {
    if (php_sapi_name() == 'cli') {
        $index = $argv[1];
        $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] = $argv[2];
    } else {
        $index = filter_input(INPUT_GET, 'index');
    }
}

if (strlen(trim($index)) == 0) {
    $index = ABAP_DB_CONST::INDEX_A;
} else {
    $index = strtoupper($index);
}

// Check Buffer
$ob_folder = GLOBAL_UTIL::GetObFolder(dirname(__FILE__));
$ob_fname = $ob_folder . "/index-" . strtolower($index) . ".html";
if (file_exists($ob_fname)) {
    $ob_file_content = file_get_contents($ob_fname);
    if ($ob_file_content !== FALSE) {
        echo $ob_file_content;
        exit();
    }
}
ob_start();
?>
<!DOCTYPE html>
<!-- DDIC Table index. -->
<?php
$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . GLOBAL_ABAP_OTYPE::TABL_DESC . " - Index " . $index . " ";

if ($index === ABAP_DB_CONST::INDEX_SLASH) {
    $index = '/';
}
$dd02l = ABAP_DB_TABLE_TABL::DD02L_List($index);
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo GLOBAL_ABAP_OTYPE::TABL_DESC ?>" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

        <!-- Left -->
        <?php require $__ROOT__ . '/include/abap_index_left.php' ?>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/tabl/"><?php echo GLOBAL_ABAP_OTYPE::TABL_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">        
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <div>
                    <a href="index-cluster.html">CLUSTER</a>&nbsp;
                    <a href="index-pool.html">POOL</a>&nbsp; - &nbsp;
                    <a href="index-a.html">A</a>&nbsp;
                    <a href="index-b.html">B</a>&nbsp;
                    <a href="index-c.html">C</a>&nbsp;
                    <a href="index-d.html">D</a>&nbsp;
                    <a href="index-e.html">E</a>&nbsp;
                    <a href="index-f.html">F</a>&nbsp;
                    <a href="index-g.html">G</a>&nbsp;
                    <a href="index-h.html">H</a>&nbsp;
                    <a href="index-i.html">I</a>&nbsp;
                    <a href="index-j.html">J</a>&nbsp;
                    <a href="index-k.html">K</a>&nbsp;
                    <a href="index-l.html">L</a>&nbsp;
                    <a href="index-m.html">M</a>&nbsp;
                    <a href="index-n.html">N</a>&nbsp;
                    <a href="index-o.html">O</a>&nbsp;
                    <a href="index-p.html">P</a>&nbsp;
                    <a href="index-q.html">Q</a>&nbsp;
                    <a href="index-r.html">R</a>&nbsp;
                    <a href="index-s.html">S</a>&nbsp;
                    <a href="index-t.html">T</a>&nbsp;
                    <a href="index-u.html">U</a>&nbsp;
                    <a href="index-v.html">V</a>&nbsp;
                    <a href="index-w.html">W</a>&nbsp;
                    <a href="index-x.html">X</a>&nbsp;
                    <a href="index-slash.html">/</a>&nbsp;
                </div>

                <h4> <?php echo GLOBAL_ABAP_OTYPE::TABL_DESC ?> - <?php echo $index ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv"> Table name </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> Table Category </th>
                        <th class="alv"> Delivery Class </th>
                    </tr>
                    <tr>
                        <th class="alv"><?php echo ABAP_UI_Navigation::GetURL4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_Navigation::GetURL4DtelDocument(ABAP_DB_TABLE_TABL::DD02L_TABNAME_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_Navigation::GetURL4DtelDocument(ABAP_DB_TABLE_TABL::DD02T_DDTEXT_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_Navigation::GetURL4DtelDocument(ABAP_DB_TABLE_TABL::DD02L_TABCLASS_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_Navigation::GetURL4DtelDocument(ABAP_DB_TABLE_TABL::DD02L_CONTFLAG_DTEL, '?') ?></th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($dd02l as $dd02l_item) {
                        $count++;
                        $dd02l_item_desc = ABAP_DB_TABLE_TABL::DD02T($dd02l_item['TABNAME']);
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                            <td class="alv"><?php echo ABAP_UI_Navigation::GetURL4Tabl($dd02l_item['TABNAME'], $dd02l_item_desc); ?> </td>
                            <td class="alv"><?php echo htmlentities($dd02l_item_desc) ?></td>
                            <td class="alv"><?php echo ABAP_UI_Navigation::GetURL4DomainValue(ABAP_DB_TABLE_TABL::DD02L_TABCLASS_DOMAIN, $dd02l_item['TABCLASS'], '') ?></td>
                            <td class="alv"><?php echo ABAP_UI_Navigation::GetURL4DomainValue(ABAP_DB_TABLE_TABL::DD02L_CONTFLAG_DOMAIN, $dd02l_item['CONTFLAG'], '') ?></td></tr>
                        <?php } ?>
                </table>

            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
file_put_contents($ob_fname, $ob_content);

// Make default index file
if ($index === ABAP_DB_CONST::INDEX_A) {
    $ob_fname = $ob_folder . "/index.html";
    file_put_contents($ob_fname, $ob_content);
}

// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();
