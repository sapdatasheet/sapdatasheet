<?php
$__WS_ROOT__ = dirname(__FILE__, 4);
$__ROOT__ = dirname(__FILE__, 3);

require_once($__WS_ROOT__ . '/common-php/library/global.php');
require_once($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

// Variables from Dispatcher
//   $dpSrcOType         - Source Object Type, like: TABL
//   $dpMiddle           - Source Object Name + '-' + Source Sub-Object name, like: BKPF-MANDT
//   $dpSrcOName         - Source Object Name, like: BKPF, BSEG
//   $dpSrcSubobj        - Source Sub-Object, like: Table Field Name
//   $dpOType            - Target Object Type
//   $dpPage             - Target Result Page Number, in case there are too many results

$counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List($dpSrcOType, $dpSrcOName, $dpSrcSubobj);
$counter_value = ABAPANA_DB_TABLE::WULCOUNTER($dpSrcOType, $dpSrcOName, $dpOType, $dpSrcSubobj);
$wul_list = ABAP_DB_TABLE_CREF::YWUL($dpSrcOType, $dpSrcOName, $dpSrcSubobj, $dpOType, $dpPage);

$srcObjDesc = ABAP_UI_TOOL::GetObjectDescr($dpSrcOType, $dpSrcOName);
$title_name = ABAP_UI_TOOL::GetObjectTitle($dpSrcOType, $dpSrcOName, $dpMiddle);
$GLOBALS['TITLE_TEXT'] = "Where Used List for " . $title_name;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_URL_TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL_META_DESC ?>" />
        <meta name="keywords" content="SAP,ABAP,<?php $dpSrcOType ?>,<?php $dpSrcOName ?>,<?php $srcObjDesc ?>" />

        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css"  href="/sapdatasheet.css"/>
    </head>
    <body>
        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

        <div class="container-fluid">
            <div class="row">
                <div  class="col-xl-2 col-lg-2 col-md-3  col-sm-3    bd-sidebar bg-light">
                    <!-- Left Side bar -->
                    <?php require $__ROOT__ . '/include/abap_index_left.php' ?>
                </div>

                <main class="col-xl-8 col-lg-8 col-md-6  col-sm-9    col-12 bd-content" role="main">
                    <nav class="pt-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home</a></li>
                            <li class="breadcrumb-item active"><a href="/abap/">ABAP Object Types</a></li>
                        </ol>
                    </nav>

                    <div class="card shadow">
                        <div class="card-header sapds-card-header"><?php echo $GLOBALS['TITLE_TEXT'] ?></div>
                        <div class="card-body table-responsive sapds-card-body">
                            <div class="align-content-start"><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>
                            <?php require $__ROOT__ . '/include/abap_desc_language.php' ?>

                            <?php
                            $wulSrcTitle = 'SAP ABAP ' . GLOBAL_ABAP_OTYPE::getOTypeDesc($dpSrcOType) . ' '
                                    . GLOBAL_ABAP_ICON::getIcon4Otype($dpSrcOType)
                                    . ABAP_UI_DS_Navigation::GetObjectHyperlink($dpSrcOType, $dpSrcOName, $dpSrcSubobj);
                            if (!empty($srcObjDesc)) {
                                $wulSrcTitle = $wulSrcTitle . ' (' . $srcObjDesc . ')';
                            }
                            ?>
                            <h5><?php echo $wulSrcTitle ?> is used by</h5>
                            <ul class="nav nav-pills">
                                <?php foreach ($counter_list as $counter) { ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($dpOType == $counter['OBJ_TYPE']) ? 'active' : '' ?>"
                                       href="<?php echo ABAP_UI_DS_Navigation::GetWulPath($counter) ?>">
                                        <?php echo GLOBAL_ABAP_ICON::getIcon4Otype($counter['OBJ_TYPE']) ?>
                                        <?php echo ABAP_UI_DS_Navigation::GetWulLabel($counter) ?></a>
                                </li>
                                <?php } ?>
                            </ul>

                            <h5><?php echo ABAP_UI_DS_Navigation::GetWulHyperlinks($dpSrcOType, $dpSrcOName, $dpSrcSubobj, $dpOType, $counter_value, FALSE) ?></h5>
                            <table class="table table-sm">
                                <tr>
                                    <th class="sapds-alv"> # </th>
                                    <th class="sapds-alv"> Object Type </th>
                                    <th class="sapds-alv"> Object Name </th>
                                    <th class="sapds-alv"> Object Description </th>
                                    <th class="sapds-alv"> Package  </th>
                                    <th class="sapds-alv"> Structure Package </th>
                                    <th class="sapds-alv"> Software Component </th>
                                </tr>
                                <tr>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL) ?></th>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('TROBJTYPE') ?></th>
                                    <th class="sapds-alv">&nbsp;</th>
                                    <th class="sapds-alv">&nbsp;</th>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('DEVCLASS') ?></th>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('DEVCLASS') ?></th>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('DLVUNIT') ?></th>
                                </tr>
                                <?php
                                $count = 0;
                                foreach ($wul_list as $wul) {
                                    $count++;
                                    ?>
                                    <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                                        <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4Otype($wul['OBJ_TYPE']) ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetOTypeHyperlink($wul['OBJ_TYPE']) ?>&nbsp;</td>
                                        <td class="sapds-alv">
                                            <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink($wul['OBJ_TYPE'], $wul['OBJ_NAME'], $wul['SUB_NAME']) ?>
                                            <?php if ($wul['OBJ_TYPE'] == GLOBAL_ABAP_OTYPE::FUNC_NAME && strlen($wul['SOURCE']) > 0) { ?>
                                                <br /><code><?php echo $wul['SOURCE'] ?></code>
                                                <?php
                                            } else if ($wul['OBJ_TYPE'] == GLOBAL_ABAP_OTYPE::CLAS_NAME && $wul['SUB_TYPE'] == ABAP_DB_TABLE_CREF::YWUL_SUB_TYPE_METH && strlen($wul['SUB_NAME']) > 0) {
                                                $cpdname = ABAP_DB_TABLE_CREF::YSEOPROG_CPDNAME($wul['OBJ_NAME'], $wul['SUB_NAME']);
                                                if (strlen($cpdname) > 0) {
                                                    ?>
                                                    <br /><code>Method: <?php echo $cpdname ?></code>
                                                    <?php
                                                }
                                            } else if ($wul['OBJ_TYPE'] == GLOBAL_ABAP_OTYPE::VIEW_NAME && $wul['SUB_TYPE'] == ABAP_DB_TABLE_CREF::YWUL_SUB_TYPE_VIED && strlen($wul['SUB_NAME']) > 0) {
                                                ?>
                                                - <?php echo $wul['SUB_NAME'] ?>
                                            <?php } ?>
                                        </td>
                                        <td class="sapds-alv"><?php echo ABAP_UI_TOOL::GetObjectDescr($wul['OBJ_TYPE'], $wul['OBJ_NAME']) ?></td>
                                        <td class="sapds-alv"><?php echo (GLOBAL_UTIL::IsNotEmpty($wul['APPL_NAME'])) ? GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() : '' ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($wul['APPL_NAME']) ?>&nbsp;</td>
                                        <td class="sapds-alv"><?php echo (GLOBAL_UTIL::IsNotEmpty($wul['APPL_PACKET'])) ? GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() : '' ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($wul['APPL_PACKET']) ?>&nbsp;</td>
                                        <td class="sapds-alv"><?php echo (GLOBAL_UTIL::IsNotEmpty($wul['APPL_DLVUNIT'])) ? GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() : '' ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($wul['APPL_DLVUNIT']) ?>&nbsp;</td>
                                    </tr>
                                    <?php
                                }
                                while ($count <= ABAP_UI_CONST::WUL_ROW_MINIMAL) {
                                    $count++;
                                    ?>
                                    <tr><td colspan="7">&nbsp;</td></tr>
                                <?php } ?>

                            </table>

                        </div>
                    </div><!-- End Card -->
                </main>

                <div  class="col-xl-2 col-lg-2 d-md-3    col-sm-none" >
                    <!-- Right Side bar -->
                    <?php require $__ROOT__ . '/include/abap_relatedlinks.php' ?>
                </div>
            </div><!-- End of row -->
            <hr>
        </div><!-- End container-fluid, main content -->

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>
    </body>
</html>
<?php
// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();
