<?php
$__WS_ROOT__ = dirname(__FILE__, 4);
$__ROOT__ = dirname(__FILE__, 3);

require_once($__WS_ROOT__ . '/common-php/library/global.php');
require_once($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

// Variables from Dispatcher
//   $dpOType            - Source Object Type, like: TABL
//   $dpOName            - Source Object Name, like: BKPF, BSEG
//   $dpSrcOType         - Target Object Type
//   $dpPage             - Target Result Page Number, in case there are too many results

$counter_list = ABAPANA_DB_TABLE::WILCOUNTER_List($dpOType, $dpOName);
$counter_value = ABAPANA_DB_TABLE::WILCOUNTER($dpOType, $dpOName, $dpSrcOType);
$wil_list = ABAP_DB_TABLE_CREF::YWIL($dpOType, $dpOName, $dpSrcOType, $dpPage);

$objDesc = ABAP_UI_TOOL::GetObjectDescr($dpOType, $dpOName);
$title_name = ABAP_UI_TOOL::GetObjectTitle($dpOType, $dpOName);
$GLOBALS['TITLE_TEXT'] = "Where Using List for " . $title_name;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php $dpOType ?>,<?php $dpOName ?>,<?php $objDesc ?>" />
        <meta name="description" content="<?php echo $title_name . ' - ' . GLOBAL_WEBSITE_SAPDS::META_DESC ?>" />
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
                <a href="/abap/">ABAP Object</a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                </div>

                <?php
                $wilTitle = 'SAP ABAP ' . GLOBAL_ABAP_OTYPE::getOTypeDesc($dpOType) . ' '
                        . GLOBAL_ABAP_ICON::getIcon4Otype($dpOType) . ' '
                        . ABAP_UI_DS_Navigation::GetObjectHyperlink($dpOType, $dpOName);
                if (!empty($objDesc)) {
                    $wilTitle = $wilTitle . ' (' . $objDesc . ')';
                }
                ?>
                <h4><?php echo $wilTitle ?> is using</h4>
                <?php

                foreach ($counter_list as $counter) {
                    echo GLOBAL_ABAP_ICON::getIcon4Otype($counter['SRC_OBJ_TYPE']) . ' ';
                    echo ABAP_UI_DS_Navigation::GetWilHyperlink($counter, FALSE);
                    echo '&nbsp;';
                }
                ?>

                <h4><?php echo GLOBAL_ABAP_OTYPE::getOTypeDesc($dpOType) ?>
                    <?php echo ABAP_UI_DS_Navigation::GetWilHyperlinks($dpOType, $dpOName, $dpSrcOType, $counter_value, FALSE) ?>
                </h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv"> Object Type </th>
                        <th class="alv"> Object Name </th>
                        <th class="alv"> Object Description </th>
                        <th class="alv"> Note </th>
                    </tr>
                    <tr>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL) ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('TROBJTYPE') ?></th>
                        <th class="alv">&nbsp;</th>
                        <th class="alv">&nbsp;</th>
                        <th class="alv">&nbsp;</th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($wil_list as $wil) {
                        $count++;
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                            <td class="alv"><?php echo GLOBAL_ABAP_ICON::getIcon4Otype($wil['SRC_OBJ_TYPE']) ?>
                                <?php echo ABAP_UI_DS_Navigation::GetOTypeHyperlink($wil['SRC_OBJ_TYPE']) ?>&nbsp;</td>
                            <td class="alv"><?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink($wil['SRC_OBJ_TYPE'], $wil['SRC_OBJ_NAME'], $wil['SRC_SUBOBJ']) ?></td>
                            <td class="alv"><?php echo ABAP_UI_TOOL::GetObjectDescr($wil['SRC_OBJ_TYPE'], $wil['SRC_OBJ_NAME'], $wil['SRC_SUBOBJ']) ?></td>
                            <td class="alv"><?php
                                if (empty(trim($wil['SOURCE'])) === FALSE) {
                                    echo '<code>SOURCE</code> ' . $wil['SOURCE'];
                                }
                                ?></td>
                        </tr>
                        <?php
                    }
                    while ($count <= ABAP_UI_CONST::WUL_ROW_MINIMAL) {
                        $count++;
                        ?>
                        <tr><td colspan="5">&nbsp;</td></tr>
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
