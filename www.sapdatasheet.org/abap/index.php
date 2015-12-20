<!DOCTYPE html>
<!-- ABAP Object Types List -->
<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once($__ROOT__ . '/include/global.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$GLOBALS['TITLE_TEXT'] = "SAP ABAP";
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title>SAP ABAP Objects <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP" />
        <meta name="description" content="<?php echo WEBSITE::META_DESC ?>" />
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
                <a href="/abap/">ABAP Object</a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span>SAP ABAP Objects</span></div>
            <div class="content_obj">        
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>
                <h4> ABAP Object </h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv"> Object Type </th>
                        <th class="alv"> Object Name </th>
                    </tr>
                    <?php 
                    $count = 0;
                    foreach (array_keys(ABAP_OTYPE::$OTYPES) as $oType) { 
                        $count++;
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                            <td class="alv"><a href="/abap/<?php echo strtolower($oType) ?>/"><?php echo $oType ?></a></td>
                            <td class="alv"><?php echo ABAP_OTYPE::$OTYPES[$oType] ?></td>
                        </tr>
                    <?php } ?>
                        <tr><td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                            <td class="alv">&nbsp;</td>
                        </tr>
                </table>
            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
