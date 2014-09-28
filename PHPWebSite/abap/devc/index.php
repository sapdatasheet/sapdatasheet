<!DOCTYPE html>
<!-- Package index. -->
<?php
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
require_once (__ROOT__ . '/include/global.php');
require_once (__ROOT__ . '/include/abap_db.php');
require_once (__ROOT__ . '/include/abap_ui.php');

$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::DEVC_DESC;

if (!isset($index)) {
    $index = filter_input(INPUT_GET, 'index');
}

if (empty($index)) {
    $index = ABAP_DB_CONST::INDEX_A;
} else {
    $index = strtoupper($index);
}
$devc = ABAP_DB_TABLE_HIER::TDEVC_List($index);
?>

<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::DEVC_DESC ?>" />
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
                <a href="/abap/devc/"><?php echo ABAP_OTYPE::DEVC_DESC ?></a> 
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
                    <a href="index-/.html">/</a>&nbsp;
                </div>

                <h4> <?php echo ABAP_OTYPE::DEVC_DESC ?> - <?php echo $index ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> <?php echo ABAP_OTYPE::DEVC_DESC ?> </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> Super package </th>
                        <th class="alv"> <?php echo ABAP_OTYPE::CVERS_DESC ?> </th>
                        <th class="alv"> <?php echo ABAP_OTYPE::BMFR_DESC ?> </th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($devc)) {
                        $devc_desc = ABAP_DB_TABLE_HIER::TDEVCT($row['DEVCLASS']);
                        $devc_ps_posid = ABAP_DB_TABLE_HIER::DF14L_PS_POSID($row['COMPONENT']);
                        ?>
                        <tr><td class="alv"><?php echo ABAP_Navigation::GetURLPackage($row['DEVCLASS'], $devc_desc) ?> </td>
                            <td class="alv"><?php echo $devc_desc ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLPackage($row['PARENTCL'], '') ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLSoftComp($row['DLVUNIT'], '') ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLAppComp($row['COMPONENT'], $devc_ps_posid, '') ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php include __ROOT__ . '/include/footer.html' ?>

    </body>
</html>