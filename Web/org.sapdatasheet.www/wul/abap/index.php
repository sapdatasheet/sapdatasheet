<?php
$__WS_ROOT__ = dirname(__FILE__, 4);
$__ROOT__ = dirname(__FILE__, 3);

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE::SAPDS_ORG_TITLE ?>" />
        <meta name="keywords" content="SAP,ABAP,Where Used List" />

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
                            <li class="breadcrumb-item"><a href="/wul/">Where Used List (WUL)</a></li>
                            <li class="breadcrumb-item active"><a href="/wul/abap/">WUL for ABAP Object</a></li>
                        </ol>
                    </nav>

                    <div class="card shadow">
                        <div class="card-header sapds-card-header"><?php echo $GLOBALS['TITLE_TEXT'] ?></div>
                        <div class="card-body table-responsive sapds-card-body">
                            <div class="align-content-start"><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>
                            <?php require $__ROOT__ . '/include/abap_desc_language.php' ?>

                            <div>
                                <?php foreach ($index_pages as $i) { ?>
                                    <a href="index-<?php echo $i ?>.html"><?php echo $i ?></a>&nbsp;
                                <?php } ?>
                            </div>

                            <h5 class="pt-4"><?php echo $GLOBALS['TITLE_TEXT'] ?></h5>
                            <table class="table table-sm">
                                <tr>
                                    <th class="sapds-alv"><img src='/abap/icon/s_b_pvre.gif'></th>
                                    <th class="sapds-alv" colspan="2" > Where Used List for </th>
                                    <th class="sapds-alv"> Used by </th>
                                </tr>
                                <tr>
                                    <th class="sapds-alv"> # </th>
                                    <th class="sapds-alv">ABAP Type</th>
                                    <th class="sapds-alv">ABAP Object</th>
                                    <th class="sapds-alv">ABAP Type</th>
                                </tr>
                                <tr>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL) ?></th>
                                    <th class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('TROBJTYPE') ?></th>
                                    <th class="sapds-alv">&nbsp;</th>
                                    <th class="sapds-alv">&nbsp;</th>
                                </tr>
                                <?php
                                $count = 0;
                                foreach ($list as $item) {
                                    $count++;
                                    ?>
                                    <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                                        <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetOTypeHyperlink($item['SRC_OBJ_TYPE']) ?>&nbsp;</td>
                                        <td class="sapds-alv"><?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink($item['SRC_OBJ_TYPE'], $item['SRC_OBJ_NAME'], $item['SRC_SUBOBJ']) ?>&nbsp;</td>
                                        <td class="sapds-alv">
                                            <?php echo ABAP_UI_DS_Navigation::GetWulHyperlink($item) ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetWulHyperlinks($item['SRC_OBJ_TYPE'], $item['SRC_OBJ_NAME'], $item['SRC_SUBOBJ'], $item['OBJ_TYPE'], $item['COUNTER'], TRUE) ?>
                                            &nbsp;</td>
                                    </tr>
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
