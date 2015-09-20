<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

// Get Index
if (!isset($index)) {
    $index = filter_input(INPUT_GET, 'index');
}

if (strlen(trim($index)) == 0) {
    $index = ABAP_DB_CONST::INDEX_LIST;
} else {
    $index = strtoupper($index);
}
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
                    <a href="index-hierarchy.html">Hierarchy</a>&nbsp; - &nbsp;
                    <a href="index-list.html">List</a>&nbsp;
                </div>

                <h4> <?php echo ABAP_OTYPE::CUS0_DESC ?> - <?php echo $index ?></h4>
                <?php if ($index === ABAP_DB_CONST::INDEX_LIST) { ?>
                    <table class="alv">
                        <tr>
                            <th class="alv"> IMG Activity </th>
                            <th class="alv"> Transaction Code </th>
                            <th class="alv"> Short Description </th>
                        </tr>
                        <?php
                        $img_list = ABAP_DB_TABLE_CUS0::CUS_IMGACH_List();
                        foreach ($img_list as $img) {
                            $img_desc = ABAP_DB_TABLE_CUS0::CUS_IMGACT($img['ACTIVITY']);
                            ?>
                            <tr><td class="alv"><?php echo ABAP_Navigation::GetURLSproIMGActivity($img['ACTIVITY'], $img_desc, TRUE) ?> </td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLTransactionCode($img['TCODE'], '', TRUE) ?> </td>
                                <td class="alv"><?php echo htmlentities($img_desc) ?>&nbsp;</td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else if ($index === ABAP_DB_CONST::INDEX_HIER) { ?>
                    <ol type="1">
                        <?php ABAP_UI_CUS0::LoadImgNodes(); ?>
                    </ol>
                <?php } ?>

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
ABAP_DB_TABLE::close_conn();
?>
