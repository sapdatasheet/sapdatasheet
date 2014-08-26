<!DOCTYPE html>
<!-- DDIC Data Element index. -->
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::DTEL_DESC;

$index = filter_input(INPUT_GET, 'index');
if (empty($index)) {
    $index = ABAP_DB_CONST::INDEX_A;
} else {
    $index = strtoupper($index);
}
$dd04l = ABAP_DB_TABLE_DTEL::DD04L_List($index);
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../../abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::DTEL_DESC ?>" />
        <meta name="description" content="<?php echo WEBSITE::META_DESC ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <!-- Header -->
        <?php require '../../include/header.php' ?>

        <!-- Left -->
        <?php require '../../include/abap_index_left.php' ?>

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
                    <a href="index.php?index=a">A</a>&nbsp;
                    <a href="index.php?index=b">B</a>&nbsp;
                    <a href="index.php?index=c">C</a>&nbsp;
                    <a href="index.php?index=d">D</a>&nbsp;
                    <a href="index.php?index=e">E</a>&nbsp;
                    <a href="index.php?index=f">F</a>&nbsp;
                    <a href="index.php?index=g">G</a>&nbsp;
                    <a href="index.php?index=h">H</a>&nbsp;
                    <a href="index.php?index=i">I</a>&nbsp;
                    <a href="index.php?index=j">J</a>&nbsp;
                    <a href="index.php?index=k">K</a>&nbsp;
                    <a href="index.php?index=l">L</a>&nbsp;
                    <a href="index.php?index=m">M</a>&nbsp;
                    <a href="index.php?index=n">N</a>&nbsp;
                    <a href="index.php?index=o">O</a>&nbsp;
                    <a href="index.php?index=p">P</a>&nbsp;
                    <a href="index.php?index=q">Q</a>&nbsp;
                    <a href="index.php?index=r">R</a>&nbsp;
                    <a href="index.php?index=s">S</a>&nbsp;
                    <a href="index.php?index=t">T</a>&nbsp;
                    <a href="index.php?index=u">U</a>&nbsp;
                    <a href="index.php?index=v">V</a>&nbsp;
                    <a href="index.php?index=w">W</a>&nbsp;
                    <a href="index.php?index=x">X</a>&nbsp;
                    <a href="index.php?index=/">/</a>&nbsp;
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
                            <td class="alv"><?php echo ABAP_UI_TOOL::CheckText($dd04l_item_t) ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLDomain($dd04l_item['DOMNAME'], '') ?> </td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $dd04l_item['DATATYPE'], '') ?>&nbsp;</td>
                        </tr>
                    <?php } ?>
                </table>                

            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php include '../../include/footer.html' ?>

    </body>
</html>
