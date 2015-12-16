<!DOCTYPE html>
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once($__ROOT__ . '/include/global.php');
require_once($__ROOT__ . '/include/abap_db.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$GLOBALS['TITLE_TEXT'] = "SAP ABAP";
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title>SAP Where Used List Report <?php echo WEBSITE::TITLE ?> </title>
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
            <div class="content_obj_title"><span>SAP Where Used List Report</span></div>
            <div class="content_obj">        
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>
                <h4> ABAP Object </h4>
                <?php 
        /* Debug Only
        echo '$dpSrcOType = ' . $dpSrcOType . '<br />';
        echo '$dpSrcOName = ' . $dpSrcOName . '<br />';
        echo '$dpOType    = ' . $dpOType . '<br />';
        echo '$dpPage     = ' . $dpPage . '<br />';
        exit();
         */                
                ?>
                $dpSrcOType = <?php echo $dpSrcOType ?><br />
                $dpSrcOName = <?php echo $dpSrcOName ?><br />
                $dpOType = <?php echo $dpOType ?><br />
                $dpPage = <?php echo $dpPage ?><br />
                <h4> ABAP Object </h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> Object Type </th>
                        <th class="alv"> Object Name </th>
                    </tr>
                    <tr><td class="alv"><a href="/abap/cvers/"><?php echo ABAP_OTYPE::CVERS_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::CVERS_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/bmfr/"><?php echo ABAP_OTYPE::BMFR_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::BMFR_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/devc/"><?php echo ABAP_OTYPE::DEVC_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::DEVC_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/msag/"><?php echo ABAP_OTYPE::MSAG_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::MSAG_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/cus0/"><?php echo ABAP_OTYPE::CUS0_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::CUS0_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/tran/"><?php echo ABAP_OTYPE::TRAN_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::TRAN_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/prog/"><?php echo ABAP_OTYPE::PROG_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::PROG_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/fugr/"><?php echo ABAP_OTYPE::FUGR_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::FUGR_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/func/"><?php echo ABAP_OTYPE::FUNC_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::FUNC_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/clas/"><?php echo ABAP_OTYPE::CLAS_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::CLAS_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/intf/"><?php echo ABAP_OTYPE::INTF_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::INTF_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/shlp/"><?php echo ABAP_OTYPE::SHLP_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::SHLP_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/tabl/"><?php echo ABAP_OTYPE::TABL_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::TABL_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/sqlt/"><?php echo ABAP_OTYPE::SQLT_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::SQLT_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/view/"><?php echo ABAP_OTYPE::VIEW_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::VIEW_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/dtel/"><?php echo ABAP_OTYPE::DTEL_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::DTEL_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/doma/"><?php echo ABAP_OTYPE::DOMA_NAME ?></a></td><td class="alv"><?php echo ABAP_OTYPE::DOMA_DESC ?></td></tr>
                </table>

            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();
