<?php

$__WS_ROOT__ = dirname(__FILE__, 4);
$__ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

// Get Index
if (strlen(trim($index)) == 0) {
    $index = ABAP_DB_CONST::INDEX_A;
    $index_page = ABAP_DB_CONST::INDEX_PAGE_1;
} else {
    $index = strtoupper($index);
}

$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . GLOBAL_ABAP_OTYPE::BMFR_DESC . " - Index " . $index
        . (($index_page > 1) ? ', page ' . $index_page : '');

$bmfr = ABAP_DB_TABLE_HIER::DF14L_List($index, $index_page);
$index_counter_list = ABAP_UI_Buffer_Index::ZBUFFER_INDEX_COUNTER(GLOBAL_ABAP_OTYPE::BMFR_NAME);
?>
<!DOCTYPE html>
<!-- Application component index. -->
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo GLOBAL_ABAP_OTYPE::BMFR_DESC ?>" />
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
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/bmfr/"><?php echo GLOBAL_ABAP_OTYPE::BMFR_DESC ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                </div>

                <div>
                    <a href="index-<?php echo strtolower(ABAP_DB_CONST::INDEX_TOP) ?>.html">Top</a>&nbsp;- 

                    <?php
                    $index_page_count = 1;              // Total page nubmers
                    $index_counter_current = array();   // Current index, like: A, B, C, ...
                    foreach ($index_counter_list as $index_counter) {
                        if ($index === $index_counter[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_LEFT1]) {
                            $index_page_count = $index_counter[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_PAGE_COUNT];
                            $index_counter_current = $index_counter;
                        }
                        ?>
                        <a href="<?php echo $index_counter[ABAP_UI_Buffer_Index::INDEX_FILENAME] ?>.html"
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
                

                <h4> <?php echo GLOBAL_ABAP_OTYPE::BMFR_DESC ?> - <?php echo $index ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv"> Application Component ID </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> First Release Date </th>
                        <th class="alv"> First Release </th>
                        <th class="alv"> Application Component </th>
                    </tr>
                    <tr>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_HIER::DF14L_PS_POSID_DTEL, '?') ?></th>
                        <th class="alv"> &nbsp; </th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_HIER::DF14L_FSTDATE_DTEL, '?') ?></th>
                        <th class="alv"> &nbsp; </th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_HIER::DF14L_FCTR_ID_DTEL, '?') ?></th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($bmfr as $row){
                        $count++;
                        $bmfr_desc = ABAP_DB_TABLE_HIER::DF14T($row['FCTR_ID']);
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                            <td class="alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($row['FCTR_ID'], $row['PS_POSID'], $bmfr_desc); ?> </td>
                            <td class="alv"><?php echo htmlentities($bmfr_desc) ?></td>
                            <td class="alv"><?php echo $row['FSTDATE'] ?></td>
                            <td class="alv"><?php echo $row['RELE'] ?></td>
                            <td class="alv"><?php echo $row['FCTR_ID'] ?></td></tr>
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
