<!DOCTYPE html>
<?php require_once '../include/global.php'; ?>
<?php $GLOBALS['TITLE_TEXT'] = "SAP ABAP"; ?>
<html>
    <head>
        <link rel="stylesheet" href="../abap.css" type="text/css" >
        <title>SAP ABAP Objects <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP">
        <meta name="description" content="<?php echo WEBSITE::META_DESC ?>">
        <meta name="author" content="SAP Datasheet">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    </head>
    <body>

        <!-- Header -->
        <?php require '../include/header.php' ?>

        <!-- Left -->
        <?php require '../include/abap_index_left.php' ?>

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

                <h4> ABAP Object </h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> Object Type </th>
                        <th class="alv"> Object Name </th>
                    </tr>
                    <tr><td class="alv"><a href="/abap/cvers">CVERS</a></td><td class="alv"><?php echo ABAP_OTYPE::CVERS_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/bmfr">BMFR</a></td><td class="alv"><?php echo  ABAP_OTYPE::BMFR_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/devc">DEVC</a></td><td class="alv"><?php echo  ABAP_OTYPE::DEVC_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/tran">TRAN</a></td><td class="alv"><?php echo  ABAP_OTYPE::TRAN_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/prog">PROG</a></td><td class="alv"><?php echo  ABAP_OTYPE::PROG_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/func">FUNC</a></td><td class="alv"><?php echo  ABAP_OTYPE::FUNC_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/tabl">TABL</a></td><td class="alv"><?php echo  ABAP_OTYPE::TABL_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/sqlt">SQLT</a></td><td class="alv"><?php echo  ABAP_OTYPE::SQLT_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/view">VIEW</a></td><td class="alv"><?php echo  ABAP_OTYPE::VIEW_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/dtel">DTEL</a></td><td class="alv"><?php echo  ABAP_OTYPE::DTEL_DESC ?></td></tr>
                    <tr><td class="alv"><a href="/abap/doma">DOMA</a></td><td class="alv"><?php echo  ABAP_OTYPE::DOMA_DESC ?></td></tr>
                </table>   

            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php include '../include/footer.html' ?>

    </body>
</html>
