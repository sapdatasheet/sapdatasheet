<?php
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
require_once (__ROOT__ . '/include/global.php');
require_once (__ROOT__ . '/include/abap_db.php');
require_once (__ROOT__ . '/include/abap_ui.php');

// Get Index
if (!isset($index)) {
    $index = filter_input(INPUT_GET, 'index');
}

if (strlen(trim($index)) == 0) {
    $index = ABAP_DB_CONST::INDEX_A;
} else {
    $index = strtoupper($index);
}

// Check Buffer
$ob_fname = dirname(__FILE__) . "/index-" . strtolower($index) . ".html";
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
<!-- DDIC Data Element index. -->
<?php
$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::DTEL_DESC . " - Index " . $index . " ";

if ($index === ABAP_DB_CONST::INDEX_SLASH) {
    $index = '/';
}
$dd04l = ABAP_DB_TABLE_DTEL::DD04L_List($index);
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::DTEL_DESC ?>" />
        <meta name="description" content="<?php echo WEBSITE::META_DESC ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <!-- Header -->
        <?php require __ROOT__ . '/include/header.php' ?>

        <!-- Left -->
        <?php require __ROOT__ . '/include/abap_index_left.php' ?>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/dtel/"><?php echo ABAP_OTYPE::DTEL_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">        

                <div>
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

                <h4> <?php echo ABAP_OTYPE::DTEL_DESC ?> - <?php echo $index ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> Data Element </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> Domain </th>
                        <th class="alv"> Data Type </th></tr>
                    <?php
                    while ($dd04l_item = mysqli_fetch_array($dd04l)) {
                        $dd04l_item_t = ABAP_DB_TABLE_DTEL::DD04T($dd04l_item['ROLLNAME']);
                        ?>
                        <tr><td class="alv"><?php echo ABAP_Navigation::GetURLDtel($dd04l_item['ROLLNAME'], $dd04l_item_t) ?> </td>
                            <td class="alv"><?php echo htmlentities($dd04l_item_t) ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLDomain($dd04l_item['DOMNAME'], '') ?> </td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $dd04l_item['DATATYPE'], '') ?>&nbsp;</td>
                        </tr>
                    <?php } ?>
                </table>                

            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php include __ROOT__ . '/include/footer.html' ?>

    </body>
</html>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
file_put_contents($ob_fname, $ob_content);

// Make default index file
if ($index === ABAP_DB_CONST::INDEX_A) {
    $ob_fname = dirname(__FILE__) . "/index.html";
    file_put_contents($ob_fname, $ob_content);
}       
?>