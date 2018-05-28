<?php
$__WS_ROOT__ = dirname(__FILE__, 4);
$__ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

// Get Index
if (strlen(trim($index)) == 0) {
    $index = ABAP_DB_CONST::INDEX_SLASH;
    $index_page = ABAP_DB_CONST::INDEX_PAGE_1;
} else {
    $index = strtoupper($index);
}

$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . GLOBAL_ABAP_OTYPE::TABL_DESC . " - Index " . $index
        . (($index_page > 1) ? ', page ' . $index_page : '');

if ($index === ABAP_DB_CONST::INDEX_SLASH) {
    $index = '/';
}
$dd02l = ABAP_DB_TABLE_TABL::DD02L_List($index, $index_page);
$index_counter_list = ABAP_UI_Buffer_Index::ZBUFFER_INDEX_COUNTER(GLOBAL_ABAP_OTYPE::TABL_NAME);
?>
<!DOCTYPE html>
<!-- DDIC Table index. -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC ?>" />
        <meta name="keywords" content="SAP,ABAP,<?php echo GLOBAL_ABAP_OTYPE::TABL_DESC ?>" />

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
                <a href="/abap/tabl/"><?php echo GLOBAL_ABAP_OTYPE::TABL_DESC ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                </div>


                <div>
                    <a href="index-<?php echo strtolower(ABAP_DB_CONST::DD02L_TABCLASS_CLUSTER) ?>.html"><?php echo ABAP_DB_CONST::DD02L_TABCLASS_CLUSTER ?></a>&nbsp;
                    <a href="index-<?php echo strtolower(ABAP_DB_CONST::DD02L_TABCLASS_POOL) ?>.html"><?php echo ABAP_DB_CONST::DD02L_TABCLASS_POOL ?></a>&nbsp; - &nbsp;

                    <?php
                    $index_page_count = 1;              // Total page nubmers
                    $index_counter_current = array();   // Current index, like: A, B, C, ...
                    foreach ($index_counter_list as $index_counter) {
                        if ($index === $index_counter[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_LEFT1]) {
                            $index_page_count = $index_counter[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_PAGE_COUNT];
                            $index_counter_current = $index_counter;
                        }
                        ?>
                        <a class="page-link" href="<?php echo $index_counter[ABAP_UI_Buffer_Index::INDEX_FILENAME] ?>.html"
                           title="<?php echo $index_counter[ABAP_UI_Buffer_Index::LINK_TITLE] ?>" >
                            <?php echo $index_counter[ABAP_UI_Buffer_Index::LINK_TEXT] ?></a>&nbsp;
                    <?php } ?>
                </div>
                <?php if ($index_page_count > 1) { ?>
                <div><ul><li>
                        <?php for ($page_loop = 1; $page_loop <= $index_counter_current[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_PAGE_COUNT]; $page_loop++) { ?>
                            <a href="<?php echo $index_counter_current[ABAP_UI_Buffer_Index::INDEX_FILENAME] . '-' . $page_loop ?>.html"
                               title="Page <?php echo $page_loop ?> of <?php echo $index_page_count ?>" >
                                <?php echo $index_counter_current[ABAP_UI_Buffer_Index::LINK_TEXT] . '-' . $page_loop ?></a>&nbsp;
                        <?php } ?>
                    </li></ul></div>
                <?php } ?>


                <h4> <?php echo GLOBAL_ABAP_OTYPE::TABL_DESC ?> - <?php echo $index ?></h4>
                <table class="table table-sm">
                    <tr>
                        <th class="sapds-alv"> # </th>
                        <th class="sapds-alv"> Table name </th>
                        <th class="sapds-alv"> Short Description </th>
                        <th class="sapds-alv"> Table Category </th>
                        <th class="sapds-alv"> Delivery Class </th>
                    </tr>
                    <tr>
                        <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL, '?') ?></th>
                        <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_TABL::DD02L_TABNAME_DTEL, '?') ?></th>
                        <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_TABL::DD02T_DDTEXT_DTEL, '?') ?></th>
                        <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_TABL::DD02L_TABCLASS_DTEL, '?') ?></th>
                        <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_TABL::DD02L_CONTFLAG_DTEL, '?') ?></th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($dd02l as $dd02l_item) {
                        $count++;
                        $dd02l_item_desc = ABAP_DB_TABLE_TABL::DD02T($dd02l_item['TABNAME']);
                        ?>
                        <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                            <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?>
                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd02l_item['TABNAME'], $dd02l_item_desc); ?> </td>
                            <td class="sapds-alv"><?php echo htmlentities($dd02l_item_desc) ?></td>
                            <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_TABL::DD02L_TABCLASS_DOMAIN, $dd02l_item['TABCLASS'], '') ?></td>
                            <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_TABL::DD02L_CONTFLAG_DOMAIN, $dd02l_item['CONTFLAG'], '') ?></td></tr>
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
