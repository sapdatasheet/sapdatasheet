<!DOCTYPE html>
<!-- Function Module index -->
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
$fm_list = ABAP_DB_TABLE_FUNC::TFDIR_List($index);
$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::FUNC_DESC;
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::FUNC_DESC ?>" />
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
                <a href="/abap/func/"><?php echo ABAP_OTYPE::FUNC_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">        

                <div>
                    <a href="index-rfc.html">RFC</a>&nbsp; - &nbsp;
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
                    <a href="index-0.html">0</a>&nbsp;
                    <a href="index-1.html">1</a>&nbsp;
                    <a href="index-2.html">2</a>&nbsp;
                    <a href="index-3.html">3</a>&nbsp;
                    <a href="index-4.html">4</a>&nbsp;
                    <a href="index-5.html">5</a>&nbsp;
                    <a href="index-6.html">6</a>&nbsp;
                    <a href="index-7.html">7</a>&nbsp;
                    <a href="index-8.html">8</a>&nbsp;
                    <a href="index-9.html">9</a>&nbsp;
                    <a href="index-/.html">/</a>&nbsp;
                </div>

                <h4> <?php echo ABAP_OTYPE::FUNC_DESC ?> - <?php echo $index ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> Function Module </th>
                        <th class="alv"> Mode </th>
                        <th class="alv"> Short Description </th>
                    </tr>
                    <?php
                    while ($fm = mysqli_fetch_array($fm_list)) {
                        $fm_desc = ABAP_DB_TABLE_FUNC::TFTIT($fm['FUNCNAME']);
                        ?>
                        <tr><td class="alv"><?php echo ABAP_Navigation::GetURLFuncModule($fm['FUNCNAME'], $fm_desc) ?> </td>
                            <td class="alv"><?php echo $fm['FMODE'] ?> </td>
                            <td class="alv"><?php echo $fm_desc ?>&nbsp;</td>
                        </tr>
                    <?php } ?>
                </table>                

            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php include __ROOT__ . '/include/footer.html' ?>

    </body>
</html>
