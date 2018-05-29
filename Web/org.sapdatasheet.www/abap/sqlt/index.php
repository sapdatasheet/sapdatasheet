<?php
$__WS_ROOT__ = dirname(__FILE__, 4);
$__ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . GLOBAL_ABAP_OTYPE::SQLT_DESC;
$dd06l = ABAP_DB_TABLE_TABL::DD06L_List();
?>
<!DOCTYPE html>
<!-- SQLT index. -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC ?>" />
        <meta name="keywords" content="SAP,ABAP,<?php echo GLOBAL_ABAP_OTYPE::SQLT_DESC ?>" />

        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css"  href="/sapdatasheet.css"/>
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
                <a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/sqlt/"><?php echo GLOBAL_ABAP_OTYPE::SQLT_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">        
                <div>
                    <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                </div>

                <h4> <?php echo GLOBAL_ABAP_OTYPE::SQLT_DESC ?> </h4>
                <table class="table table-sm">
                    <tr>
                        <th class="sapds-alv"> # </th>
                        <th class="sapds-alv"> Table Name </th>
                        <th class="sapds-alv"> Short Description </th>
                        <th class="sapds-alv"> Table Category </th>
                        <th class="sapds-alv"> Created on </th>
                    </tr>
                    <tr>
                        <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL) ?></th>
                        <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_TABL::DD06L_SQLTAB_DTEL) ?></th>
                        <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_TABL::DD06T_DDTEXT_DTEL) ?></th>
                        <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_TABL::DD06L_SQLCLASS_DTEL) ?></th>
                        <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_TABL::DD06L_AS4DATE_DTEL) ?></th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($dd06l as $dd06l_item) {
                        $count++;
                        $dd06l_item_t = ABAP_DB_TABLE_TABL::DD06T($dd06l_item['SQLTAB']);
                        $dd06l_sqlclass_t = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_TABL::DD06L_SQLCLASS_DOMAIN, $dd06l_item['SQLCLASS']);
                        ?>
                        <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                            <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeSQLT() ?>
                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Sqlt($dd06l_item['SQLTAB'], $dd06l_item_t) ?> </td>
                            <td class="sapds-alv"><?php echo htmlentities($dd06l_item_t) ?></td>
                            <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_TABL::DD06L_SQLCLASS_DOMAIN, $dd06l_item['SQLCLASS'], $dd06l_sqlclass_t) ?></td>
                            <td class="sapds-alv"><?php echo $dd06l_item['AS4DATE'] ?></td>
                        </tr>
                        <?php } ?>
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
