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
                    <a href="index.php?index=RFC">RFC</a>&nbsp; - &nbsp;
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
                    <a href="index.php?index=0">0</a>&nbsp;
                    <a href="index.php?index=1">1</a>&nbsp;
                    <a href="index.php?index=2">2</a>&nbsp;
                    <a href="index.php?index=3">3</a>&nbsp;
                    <a href="index.php?index=4">4</a>&nbsp;
                    <a href="index.php?index=5">5</a>&nbsp;
                    <a href="index.php?index=6">6</a>&nbsp;
                    <a href="index.php?index=7">7</a>&nbsp;
                    <a href="index.php?index=8">8</a>&nbsp;
                    <a href="index.php?index=9">9</a>&nbsp;
                    <a href="index.php?index=/">/</a>&nbsp;
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