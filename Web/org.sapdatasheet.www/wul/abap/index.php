<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));

require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

// Get Index
if (strlen(trim($index)) == 0) {
    $index = ABAP_DB_CONST::INDEX_PAGE_1;
}

$GLOBALS['TITLE_TEXT'] = "SAP ABAP Where Used List - Index " . number_format($index) . " of " . number_format(ABAP_DBDATA::WULCOUNTER_INDEX_MAX);
$list = ABAPANA_DB_TABLE::WULCOUNTER_Index($index);
$index_pages = ABAP_UI_TOOL::GetPagingList($index, ABAP_DBDATA::WULCOUNTER_INDEX_MAX);
?>
<!DOCTYPE html>
<!-- Where Used List index -->
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,Where Used List" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC ?>" />
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
                <a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home page</a> &gt;
                <a href="/wul/">Where Used List (WUL)</a> &gt;
                <a href="/wul/abap/">WUL for ABAP Object</a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                </div>

                <br />
                <div>
                    <?php foreach ($index_pages as $i) { ?>
                        <a href="index-<?php echo $i ?>.html"><?php echo $i ?></a>&nbsp;
                    <?php } ?>
                </div>

                <h4><?php echo $GLOBALS['TITLE_TEXT'] ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"><img src='/abap/icon/s_b_pvre.gif'></th>
                        <th class="alv" colspan="2" > Where Used List for </th>
                        <th class="alv"> Used by </th>
                    </tr>
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv">ABAP Type</th>
                        <th class="alv">ABAP Object</th>
                        <th class="alv">ABAP Type</th>
                    </tr>
                    <tr>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('TROBJTYPE', '?') ?></th>
                        <th class="alv">&nbsp;</th>
                        <th class="alv">&nbsp;</th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($list as $item) {
                        $count++;
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                            <td class="alv"><?php echo ABAP_UI_DS_Navigation::GetOTypeHyperlink($item['SRC_OBJ_TYPE']) ?>&nbsp;</td>
                            <td class="alv"><?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink($item['SRC_OBJ_TYPE'], $item['SRC_OBJ_NAME'], $item['SRC_SUBOBJ']) ?>&nbsp;</td>
                            <td class="alv">
                                <?php echo ABAP_UI_DS_Navigation::GetWulHyperlink($item) ?>
                                <?php echo ABAP_UI_DS_Navigation::GetWulHyperlinks($item['SRC_OBJ_TYPE'], $item['SRC_OBJ_NAME'], $item['SRC_SUBOBJ'], $item['OBJ_TYPE'], $item['COUNTER'], TRUE) ?>
                                &nbsp;</td>
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
