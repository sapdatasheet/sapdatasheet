<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');
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
    $index = ABAP_DB_CONST::INDEX_PAGE_1;
} else {
    $index = strtoupper($index);
}

// Check Buffer
$ob_folder = GLOBAL_UTIL::GetObFolder(dirname(__FILE__));
if (file_exists($ob_folder) == FALSE) {
    mkdir($ob_folder);
}
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
<!-- Function Module index -->
<?php
$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::CUS0_DESC . " - Index " . $index . " ";
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::CUS0_DESC ?>" />
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
                <a href="/abap/">ABAP Object</a> &gt;
                <a href="/abap/cus0/"><?php echo ABAP_OTYPE::CUS0_DESC ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <div>
                    <a href="index-<?php echo strtolower(ABAP_DB_CONST::INDEX_HIER) ?>.html">Hierarchy</a>&nbsp; - &nbsp;
                    <?php for ($count = 1; $count <= ABAP_DBDATA::CUS_IMGACT_INDEX_MAX; $count++) { ?>
                        <a href="index-<?php echo $count ?>.html"><?php echo $count ?></a>&nbsp;
                    <?php } ?>
                    <!--<a href="index-roadmap.html">Road map</a>&nbsp;-->
                </div>

                <h4> <?php echo ABAP_OTYPE::CUS0_DESC ?> - <?php echo $index ?></h4>
                <?php if ($index === ABAP_DB_CONST::INDEX_HIER) { ?>
                    <ol type="1">
                        <?php ABAP_UI_CUS0::LoadImgNodes(); ?>
                    </ol>
                <?php } else { ?>
                    <table class="alv">
                        <tr>
                            <th class="alv"> # </th>
                            <th class="alv"> IMG Activity </th>
                            <th class="alv"> Transaction Code </th>
                            <th class="alv"> Short Description </th>
                        </tr>
                        <tr>
                            <th class="alv"> <?php echo ABAP_Navigation::GetURLDtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL, '?') ?></th>
                            <th class="alv"> &nbsp; </th>
                            <th class="alv"> <?php echo ABAP_Navigation::GetURLDtelDocument(ABAP_DB_TABLE_CUS0::CUS_IMGACH_TCODE_DTEL, '?') ?></th>
                            <th class="alv"> &nbsp; </th>
                        </tr>
                        <?php
                        $img_list = ABAP_DB_TABLE_CUS0::CUS_IMGACH_List($index);
                        $count = 0;
                        foreach ($img_list as $img) {
                            $count ++;
                            $img_desc = ABAP_DB_TABLE_CUS0::CUS_IMGACT($img['ACTIVITY']);
                            ?>
                            <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLSproIMGActivity($img['ACTIVITY'], $img_desc, TRUE) ?> </td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLTransactionCode($img['TCODE'], '', TRUE) ?> </td>
                                <td class="alv"><?php echo htmlentities($img_desc) ?>&nbsp;</td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>

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
if ($index == ABAP_DB_CONST::INDEX_HIER) {
    $ob_fname = $ob_folder . "/index.html";
    file_put_contents($ob_fname, $ob_content);
}

// Close Database Connection
ABAP_DB_TABLE::close_conn();
