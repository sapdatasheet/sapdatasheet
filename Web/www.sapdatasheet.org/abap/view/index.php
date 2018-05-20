<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

// Get Index
if (!isset($index)) {
    if (php_sapi_name() == 'cli') {
        $index = $argv[1];
        $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] = $argv[2];
    } else {
        $index = filter_input(INPUT_GET, 'index');
    }
}

if (strlen(trim($index)) == 0) {
    $index = ABAP_DB_CONST::INDEX_SLASH;
    $index_page = ABAP_DB_CONST::INDEX_PAGE_1;
} else {
    $index = strtoupper($index);
}

// Check Buffer
$ob_folder = GLOBAL_UTIL::GetObFolder(dirname(__FILE__));
$ob_fname = $ob_folder . "/index-" . strtolower($index) . ".html";
if (file_exists($ob_fname)) {
    $ob_file_content = file_get_contents($ob_fname);
    if ($ob_file_content !== FALSE) {
        echo $ob_file_content;
        exit();
    }
}
ob_start();
?>
<!DOCTYPE html>
<!-- DDIC View index. -->
<?php
$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . GLOBAL_ABAP_OTYPE::VIEW_DESC . " - Index " . $index
        . (($index_page > 1) ? ', page ' . $index_page : '');

if ($index === ABAP_DB_CONST::INDEX_SLASH) {
    $index = '/';
}
$dd25l_list = ABAP_DB_TABLE_VIEW::DD25L_List($index, $index_page);
$index_counter_list = ABAP_UI_Buffer_Index::ZBUFFER_INDEX_COUNTER(GLOBAL_ABAP_OTYPE::VIEW_NAME);
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo GLOBAL_ABAP_OTYPE::VIEW_DESC ?>" />
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
                <a href="/abap/view/"><?php echo GLOBAL_ABAP_OTYPE::VIEW_DESC ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <div>
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


                <h4> <?php echo GLOBAL_ABAP_OTYPE::VIEW_DESC ?> - <?php echo $index ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv"> View Name </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> View Type </th>
                        <th class="alv"> Basis Table </th>
                    </tr>
                    <tr>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_VIEW::DD25L_VIEWNAME_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_VIEW::DD25T_DDTEXT_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_VIEW::DD25L_VIEWCLASS_DTEL, '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_VIEW::DD25L_ROOTTAB_DTEL, '?') ?></th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($dd25l_list as $dd25l) {
                        $count++;
                        $dd25l_desc = ABAP_DB_TABLE_VIEW::DD25T($dd25l['VIEWNAME']);
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                            <td class="alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeVIEW() ?>
                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4View($dd25l['VIEWNAME'], $dd25l_desc) ?> </td>
                            <td class="alv"><?php echo htmlentities($dd25l_desc) ?></td>
                            <td class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_CONST::DOMAIN_DD25L_VIEWCLASS, $dd25l['VIEWCLASS'], '') ?> </td>
                            <td class="alv"><?php echo (GLOBAL_UTIL::IsNotEmpty($dd25l['ROOTTAB'])) ? GLOBAL_ABAP_ICON::getIcon4OtypeTABL() : '' ?>
                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd25l['ROOTTAB'], '') ?>&nbsp;</td></tr>
                        <?php } ?>
                </table>

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
file_put_contents($ob_fname, $ob_content);

// Make default index file
if ($index === ABAP_DB_CONST::INDEX_A) {
    $ob_fname = $ob_folder . "/index.html";
    file_put_contents($ob_fname, $ob_content);
}

// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();
