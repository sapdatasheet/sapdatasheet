<!DOCTYPE html>
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once($__ROOT__ . '/include/global.php');
require_once($__ROOT__ . '/include/abap_db.php');
require_once($__ROOT__ . '/include/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

// Variables from Dispatcher
//   $dpSrcOType;
//   $dpSrcOName;
//   $dpOType;
//   $dpPage;

$counter_list = ABAPANA_DB_TABLE::COUNTER_List($dpSrcOType, $dpSrcOName);
$wul_list = ABAP_DB_TABLE_WUL::YWUL($dpSrcOType, $dpSrcOName, $dpOType, $dpPage);

$srcObjDesc = ABAP_UI_TOOL::GetObjectDescr($dpSrcOType, $dpSrcOName);
$title_name = ABAP_UI_TOOL::GetObjectTitle($dpSrcOType, $dpSrcOName);
$GLOBALS['TITLE_TEXT'] = "Where Used List for " . $title_name;
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php $dpSrcOType ?>,<?php $dpSrcOName ?>,<?php $srcObjDesc ?>" />
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
                <a href="/abap/">ABAP Object</a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <h4><?php echo $title_name ?> is used by</h4>
                <?php foreach ($counter_list as $counter) { ?>
                <a href="/wul/abap/<?php echo strtolower($counter['SRC_OBJ_TYPE']) ?>/<?php echo strtolower($counter['SRC_OBJ_NAME']) ?>-<?php echo strtolower($counter['OBJ_TYPE']) ?>.html">
                        <?php echo ABAP_OTYPE::getOTypeDesc($counter['OBJ_TYPE']) ?> (<?php echo $counter['COUNTER'] ?>)</a>&nbsp;
                <?php } ?>

                <h4> ABAP Object </h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv"> Object Type </th>
                        <th class="alv"> Object Name </th>
                        <th class="alv"> Object Description </th>
                        <th class="alv"> Package  </th>
                        <th class="alv"> Structure Package </th>
                        <th class="alv"> Software Component </th>
                    </tr>
                    <tr>
                        <th class="alv"><?php echo ABAP_Navigation::GetURLDtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL) ?></th>
                        <th class="alv"><?php echo ABAP_Navigation::GetURLDtelDocument('TROBJTYPE') ?></th>
                        <th class="alv">&nbsp;</th>
                        <th class="alv">&nbsp;</th>
                        <th class="alv"><?php echo ABAP_Navigation::GetURLDtelDocument('DEVCLASS') ?></th>
                        <th class="alv"><?php echo ABAP_Navigation::GetURLDtelDocument('DEVCLASS') ?></th>
                        <th class="alv"><?php echo ABAP_Navigation::GetURLDtelDocument('DLVUNIT') ?></th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($wul_list as $wul) {
                        $count++;
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                            <td class="alv"><a href="/abap/" target="_blank"><?php echo ABAP_OTYPE::getOTypeDesc($wul['OBJ_TYPE']) ?></a>&nbsp;</td>
                            <td class="alv"><?php echo ABAP_UI_TOOL::GetObjectURL($wul['OBJ_TYPE'], $wul['OBJ_NAME']) ?></td>
                            <td class="alv"><?php echo ABAP_UI_TOOL::GetObjectDescr($wul['OBJ_TYPE'], $wul['OBJ_NAME']) ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLPackage($wul['APPL_NAME']) ?>&nbsp;</td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLPackage($wul['APPL_PACKET']) ?>&nbsp;</td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLSoftComp($wul['APPL_DLVUNIT']) ?>&nbsp;</td>
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
