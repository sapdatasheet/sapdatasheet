<!DOCTYPE html>
<!-- DDIC Table index. -->
<?php
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
require_once (__ROOT__ . '/include/global.php');
require_once (__ROOT__ . '/include/abap_db.php');
require_once (__ROOT__ . '/include/abap_ui.php');

if (!isset($index)) {
    $index = filter_input(INPUT_GET, 'index');
}

if (empty($index)) {
    $index = ABAP_DB_CONST::INDEX_A;
} else {
    $index = strtoupper($index);
}
$dd02l = ABAP_DB_TABLE_TABL::DD02L_List($index);
$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::TABL_DESC;
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::TABL_DESC ?>" />
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
                <a href="/abap/tabl/"><?php echo ABAP_OTYPE::TABL_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">        

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
                    <a href="index-/.html">/</a>&nbsp;
                </div>

                <h4> <?php echo ABAP_OTYPE::TABL_DESC ?> - <?php echo $index ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> Table name </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> Table Category </th>
                        <th class="alv"> Delivery Class </th></tr>
                    <?php
                    while ($dd02l_item = mysqli_fetch_array($dd02l)) {
                        $dd02l_item_desc = ABAP_DB_TABLE_TABL::DD02T($dd02l_item['TABNAME']);
                        ?>
                        <tr><td class="alv"><?php echo ABAP_Navigation::GetURLTable($dd02l_item['TABNAME'], $dd02l_item_desc); ?> </td>
                            <td class="alv"><?php echo ABAP_UI_TOOL::CheckText($dd02l_item_desc) ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD02L_TABCLASS, $dd02l_item['TABCLASS'], '') ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD02L_CONTFLAG, $dd02l_item['CONTFLAG'], '') ?></td></tr>
                        <?php } ?>
                </table>

            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php include __ROOT__ . '/include/footer.html' ?>

    </body>
</html>
