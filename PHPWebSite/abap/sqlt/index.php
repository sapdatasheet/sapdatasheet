<!DOCTYPE html>
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::SQLT_DESC;
$dd06l = ABAP_DB_TABLE_TABL::DD06L_List();
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="../../abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::SQLT_DESC ?>" />
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
                <a href="/abap/sqlt/"><?php echo ABAP_OTYPE::SQLT_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">        

                <h4> <?php echo ABAP_OTYPE::SQLT_DESC ?> </h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> Table Name </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> Table Category </th>
                        <th class="alv"> Created on </th>
                    </tr>
                    <?php
                    while ($dd06l_item = mysqli_fetch_array($dd06l)) {
                        $dd06l_item_t = ABAP_DB_TABLE_TABL::DD06T($dd06l_item['SQLTAB']);
                        $dd06l_sqlclass_t = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DD06L_SQLCLASS, $dd06l_item['SQLCLASS']);
                        ?>
                        <tr><td class="alv"><?php echo ABAP_Navigation::GetURLSqltable($dd06l_item['SQLTAB'], $dd06l_item_t) ?> </td>
                            <td class="alv"><?php echo ABAP_UI_TOOL::CheckText($dd06l_item_t) ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DD06L_SQLCLASS, $dd06l_item['SQLCLASS'], $dd06l_sqlclass_t) ?></td>
                            <td class="alv"><?php echo $dd06l_item['AS4DATE'] ?></td>
                        </tr>
                        <?php } ?>
                </table>

            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php include '../../include/footer.html' ?>

    </body>
</html>
