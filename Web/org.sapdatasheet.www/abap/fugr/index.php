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

$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . GLOBAL_ABAP_OTYPE::FUGR_DESC . " - Index " . $index
        . (($index_page > 1) ? ', page ' . $index_page : '');

if ($index === ABAP_DB_CONST::INDEX_SLASH) {
    $index = '/';
}
$fugr_list = ABAP_DB_TABLE_HIER::TADIR_FUGR_List($index, $index_page);
$index_counter_list = ABAP_UI_Buffer_Index::ZBUFFER_INDEX_COUNTER(GLOBAL_ABAP_OTYPE::FUGR_NAME);
?>
<!DOCTYPE html>
<!-- Function Group index -->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC ?>" />
        <meta name="keywords" content="SAP,ABAP,<?php echo GLOBAL_ABAP_OTYPE::FUGR_DESC ?>" />

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
                    <nav class="pt-2" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home</a></li>
                            <li class="breadcrumb-item"><a href="/abap/">ABAP Object Types</a></li>
                            <li class="breadcrumb-item active"><a href="/abap/fugr/"><?php echo GLOBAL_ABAP_OTYPE::FUGR_DESC ?></a></li>
                        </ol>
                    </nav>

                    <div class="card shadow">
                        <div class="card-header sapds-card-header">$GLOBALS['TITLE_TEXT']</div>
                        <div class="card-body table-responsive sapds-card-body">
                            <div><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>
                            <?php require $__ROOT__ . '/include/abap_desc_language.php' ?>

                            <ul class="pagination pagination-sm">
                                <?php
                                $index_page_count = 1;              // Total page nubmers
                                $index_counter_current = array();   // Current index, like: A, B, C, ...
                                foreach ($index_counter_list as $index_counter) {
                                    if ($index === $index_counter[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_LEFT1]) {
                                        $index_page_count = $index_counter[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_PAGE_COUNT];
                                        $index_counter_current = $index_counter;
                                        $pagination_active = ' active';
                                    } else {
                                        $pagination_active = '';
                                    }
                                    ?>
                                    <li class="page-item <?php echo $pagination_active ?>">
                                        <a class="page-link" href="<?php echo $index_counter[ABAP_UI_Buffer_Index::INDEX_FILENAME] ?>.html"
                                           title="<?php echo $index_counter[ABAP_UI_Buffer_Index::LINK_TITLE] ?>" >
                                            <?php echo $index_counter[ABAP_UI_Buffer_Index::LINK_TEXT] ?></a></li>
                                <?php } ?>
                            </ul>
                            <?php if ($index_page_count > 1) { ?>
                                <div><ul><li>
                                            <?php for ($page_loop = 1; $page_loop <= $index_counter_current[ABAP_DB_TABLE_BASIS::ZBUFFER_INDEX_COUNTER_PAGE_COUNT]; $page_loop++) { ?>
                                                <a href="<?php echo $index_counter_current[ABAP_UI_Buffer_Index::INDEX_FILENAME] . '-' . $page_loop ?>.html"
                                                   title="Page <?php echo $page_loop ?> of <?php echo $index_page_count ?>" >
                                                    <?php echo $index_counter_current[ABAP_UI_Buffer_Index::LINK_TEXT] . '-' . $page_loop ?></a>&nbsp;
                                            <?php } ?>
                                        </li></ul></div>
                            <?php } ?>



                            <h5 class="pt-2"> <?php echo GLOBAL_ABAP_OTYPE::FUGR_DESC ?> - <?php echo $index ?> </h5>
                            <table class="table table-sm">
                                <tr>
                                    <th class="sapds-alv"> # </th>
                                    <th class="sapds-alv"> <?php echo GLOBAL_ABAP_OTYPE::FUGR_DESC ?> </th>
                                    <th class="sapds-alv"> <?php echo GLOBAL_ABAP_OTYPE::DEVC_DESC ?> </th>
                                    <th class="sapds-alv"> <?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?> </th>
                                    <th class="sapds-alv"> Short Description </th>
                                </tr>
                                <tr>
                                    <th class="sapds-alv"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL) ?></th>
                                    <th class="sapds-alv"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_FUNC::TLIBG_AREA_DTEL) ?></th>
                                    <th class="sapds-alv"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_HIER::TDEVC_DEVCLASS_DTEL) ?></th>
                                    <th class="sapds-alv"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_HIER::CVERS_REF_DESC_TEXT_DTEL) ?></th>
                                    <th class="sapds-alv"> &nbsp; </th>
                                </tr>
                                <?php
                                $count = 0;
                                foreach ($fugr_list as $fugr) {
                                    $count++;
                                    $prog = ABAP_DB_TABLE_PROG::GET_PROG_FUGR($fugr['OBJ_NAME']);
                                    $prog_desc = ABAP_DB_TABLE_FUNC::TLIBT($fugr['OBJ_NAME']);
                                    ?>
                                    <tr><td class="sapds-alv text-right"><?php echo number_format($count) ?> </td>
                                        <td class="sapds-alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeFUGR() ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Prog($prog, '', $fugr['OBJ_NAME']) ?> </td>
                                        <td class="sapds-alv"><?php echo (GLOBAL_UTIL::IsNotEmpty($fugr['DEVCLASS'])) ? GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() : '' ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($fugr['DEVCLASS'], '') ?> </td>
                                        <td class="sapds-alv"><?php echo (GLOBAL_UTIL::IsNotEmpty($fugr['COMPONENT'])) ? GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() : '' ?>
                                            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($fugr['COMPONENT'], '') ?>&nbsp;</td>
                                        <td class="sapds-alv"><?php echo htmlspecialchars($prog_desc) ?> &nbsp; </td>
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
