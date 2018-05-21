<!DOCTYPE html>
<?php
$__ROOT__ = dirname(dirname(__FILE__));
require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/schemaorg.php');
require_once ($__ROOT__ . '/include/site/site_global.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');

GLOBAL_UTIL::UpdateSAPDescLangu();

if (!isset($fb_ObjID)) {
    $fb_ObjID = filter_input(INPUT_GET, 'id');
}
if (empty($fb_ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}

$abaptran = ABAPANA_DB_TABLE::ABAPTRAN(strtoupper($fb_ObjID));
if (empty($abaptran['TCODE'])) {
    ABAP_UI_TOOL::Redirect404();
}

$tstc_desc = ABAP_DB_TABLE_TRAN::TSTCT($abaptran['TCODE']);
$tstc_desc_all = ABAP_DB_TABLE_TRAN::TSTCT_All($abaptran['TCODE']);
$analytics_list = SITE_UI_TCODE::LoadAnalytics($abaptran);

$wil_list = SITE_UI_TCODE::LoadWil($abaptran['TCODE']);
$wul_list = SITE_UI_TCODE::LoadWul($abaptran['TCODE']);

$title = 'SAP TCode ' . $abaptran['TCODE'] . ' - ' . $tstc_desc;
$search = $abaptran['TCODE'] . ' ' . $tstc_desc . ' ' . SITE_GLOBAL::NAME;

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $abaptran['TCODE'];
$json_ld->alternateName = $tstc_desc;
$json_ld->description = $title;
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_TRAN, TRUE);
$json_ld->url = ABAP_UI_TCODES_Navigation::TCode($abaptran['TCODE'], TRUE);
?>
<html lang="en">
    <head>
        <!-- 'Must have' top 3 meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Other meta -->
        <meta name="author" content="<?php echo SITE_GLOBAL::URL_DISPLAY ?>">
        <meta name="description" content="<?php echo $title ?>">
        <meta name="keywords" content="SAP,ABAP,TCode,Transaction Code,<?php echo $abaptran['TCODE'] ?>,<?php echo $tstc_desc ?>">
        <link rel="icon" href="/favicon.ico">
        <title><?php echo $title ?><?php echo SITE_GLOBAL::TITLE_SUFFIX ?></title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="/include/3rdparty/bootstrap/css/bootstrap.min.css">
        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="/style.css">

        <!-- Other CSS needed by this page -->
        <link rel="stylesheet" href="/include/3rdparty/datatables/media/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="/include/3rdparty/datatables/media/css/jquery.dataTables.min.css">
        <script type="application/ld+json"><?php echo $json_ld->toJson() ?></script>
        <style>
            .link {
                stroke: #ccc;
            }
            .node text {
                pointer-events: none;
                font: 10px sans-serif;
            }
        </style>      
    </head>
    <body>
        <!-- Load Scripts -->
        <script src="/include/3rdparty/d3/d3.min.js"></script>
        <script src="/include/js/d3forcedirectedgraph.js"></script>

        <!-- Navigation bar -->
        <?php require $__ROOT__ . '/include/site/site_ui_nav.php' ?>

        <!-- Container: Start -->
        <div class="container-fluid">
            <!-- Row: Start, Row with two columns divided in 3:1 ratio-->
            <div class="row">
                <!-- Main Content: Start -->
                <div class="col-sm-9">
                    <!-- Bread crumb (Hierarchy Levels) -->
                    <?php
                    $title_bc_list = SITE_UI_TCODE::LoadBreadcrumbs($abaptran);
                    require $__ROOT__ . '/include/site/site_ui_breadcrumb.php';
                    ?>

                    <!-- Page Header -->
                    <div class="page-header">
                        <h3>Analytics for SAP TCode <?php echo $abaptran['TCODE'] ?> <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::TRAN_NAME, $abaptran['TCODE'], NULL, FALSE) ?>
                            <br/><small><?php echo $tstc_desc ?></small></h3>
                    </div>
                    <div>
                        <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?><br/>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN(TRUE) ?>&nbsp;<?php echo ABAP_UI_DS_Navigation::GetHyperlink4TranEx($abaptran['TCODE']) ?> Analytics</div>
                        <div class="d3chartarea_main">
                            <script>
                                var chartWidth = (window.innerWidth || document.body.clientWidth) * 8 / 12;
                                chartWidth = (chartWidth > 700) ? 700 : chartWidth;
                                drawForceDirectedGraph("/tcode/json_tcode.php?id=<?php echo $abaptran['TCODE'] ?>", chartWidth);
                            </script>
                        </div>
                    </div>

                    <!-- TCode Analytics -->
                    <div class="panel panel-info">
                        <div class="panel-heading"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN(TRUE) ?>&nbsp;<?php echo ABAP_UI_DS_Navigation::GetHyperlink4TranEx($abaptran['TCODE']) ?> Analytics Data</div>
                        <table class="table table-striped table-hover">
                            <tbody>
                                <?php foreach ($analytics_list as $analytics) { ?>
                                    <tr><td><div class="row">
                                                <div class="col-xs-4 col-sm-4 col-md-4"><?php echo $analytics[SITE_UI_CONST::KEY_LABEL] ?></div>
                                                <div class="col-xs-5 col-sm-6 col-md-6"><strong><?php echo $analytics[SITE_UI_CONST::KEY_ABAP_OBJNAME] ?></strong><?php echo $analytics[SITE_UI_CONST::KEY_ABAP_DSLINK] ?></div>
                                                <div class="col-xs-3 col-sm-2 col-md-2"><a href="#"><span class="label label-primary"><?php echo $analytics[SITE_UI_CONST::KEY_VALUE] ?></span></a></div>
                                            </div>
                                        </td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <?php
                    foreach ($analytics_list as $analytics) {
                        if (is_array($analytics[SITE_UI_CONST::KEY_ARRAY_DATA]) && $analytics[SITE_UI_CONST::JSON_NEW_WINDOW] == SITE_UI_CONST::NO) {
                            ?>
                            <div id="panel-<?php echo $analytics[SITE_UI_CONST::KEY_HTML_ID] ?>" class="panel panel-info">
                                <div class="panel-heading">
                                    <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN(TRUE) ?>&nbsp;
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4TranEx($abaptran['TCODE']) ?> Analytics - <?php echo $analytics[SITE_UI_CONST::KEY_LABEL] ?> <strong><?php echo $analytics[SITE_UI_CONST::KEY_ABAP_OBJNAME] ?></strong>
                                    <?php require $__ROOT__ . '/include/site/site_ui_backtotop.php'; ?>
                                </div>
                                <br />
                                <?php
                                $table_id = $analytics[SITE_UI_CONST::KEY_HTML_ID];
                                $tcode_list = $analytics[SITE_UI_CONST::KEY_ARRAY_DATA];
                                $tcode_count = $analytics[SITE_UI_CONST::KEY_VALUE];
                                require $__ROOT__ . '/include/site/site_ui_tcodetable.php';
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <!-- Global Descriptions -->
                    <?php if (count($tstc_desc_all) > 0) { ?>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <?php echo $abaptran['TCODE'] ?> Global Descriptions
                                <?php require $__ROOT__ . '/include/site/site_ui_backtotop.php'; ?>
                            </div>
                            <table class="table table-hover">
                                <thead><tr><th>Language</th><th>Description</th></tr></thead>
                                <tbody>
                                    <?php foreach ($tstc_desc_all as $tstc_desc_item) { ?>
                                        <tr><td>
                                                <!-- We high-light English and Germany text, since they are the most commonly used or reliable -->
                                                <?php if ($tstc_desc_item['SPRSL'] == ABAP_DB_CONST::LANGU_EN || $tstc_desc_item['SPRSL'] == ABAP_DB_CONST::LANGU_DE) { ?>
                                                    <span class="label label-warning">
                                                    <?php } ?>
                                                    <?php echo $tstc_desc_item['SPTXT']; ?>
                                                    <?php if ($tstc_desc_item['SPRSL'] == ABAP_DB_CONST::LANGU_EN || $tstc_desc_item['SPRSL'] == ABAP_DB_CONST::LANGU_DE) { ?>
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $tstc_desc_item['TTEXT'] ?>&nbsp;</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                </div><!-- Main Content: End -->

                <!-- Site Panel: Begin -->
                <div class="col-sm-3">

                    <!-- Where Using List -->
                    <?php if (count($wil_list) > 0) { ?>
                        <div class="panel panel-success">
                            <div class="panel-heading"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4TranEx($abaptran['TCODE']) ?> is Using ABAP Object</div>
                            <table class="table table-hover table-condensed">
                                <tbody>
                                    <?php foreach ($wil_list as $item) { ?>
                                        <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4Otype($item[SITE_UI_CONST::KEY_ABAP_OBJTYPE], TRUE) ?>
                                                <a href="<?php echo $item[SITE_UI_CONST::KEY_URL] ?>"
                                                   title="<?php echo $item[SITE_UI_CONST::KEY_CAPTION] ?>"
                                                   target="_blank">
                                                    <?php echo $item[SITE_UI_CONST::KEY_LABEL] ?></a></td>
                                            <td class="text-right">
                                                <a href="<?php echo $item[SITE_UI_CONST::KEY_URL] ?>"
                                                   title="<?php echo $item[SITE_UI_CONST::KEY_CAPTION] ?>"
                                                   target="_blank"><span class="label label-success"><?php echo number_format($item[SITE_UI_CONST::KEY_VALUE]) ?></span></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                    <!-- Where Used List -->
                    <?php if (count($wul_list) > 0) { ?>
                        <div class="panel panel-success">
                            <div class="panel-heading"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4TranEx($abaptran['TCODE']) ?> is Used by ABAP Object</div>
                            <table class="table table-hover table-condensed">
                                <tbody>
                                    <?php foreach ($wul_list as $item) { ?>
                                        <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4Otype($item[SITE_UI_CONST::KEY_ABAP_OBJTYPE], TRUE) ?>
                                                <a href="<?php echo $item[SITE_UI_CONST::KEY_URL] ?>"
                                                   title="<?php echo $item[SITE_UI_CONST::KEY_CAPTION] ?>"
                                                   target="_blank">
                                                    <?php echo $item[SITE_UI_CONST::KEY_LABEL] ?></a></td>
                                            <td class="text-right">
                                                <a href="<?php echo $item[SITE_UI_CONST::KEY_URL] ?>"
                                                   title="<?php echo $item[SITE_UI_CONST::KEY_CAPTION] ?>"
                                                   target="_blank"><span class="label label-success"><?php echo number_format($item[SITE_UI_CONST::KEY_VALUE]) ?></span></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>

                    <!-- TCodes by Each Module -->
                    <?php require $__ROOT__ . '/include/site/site_ui_side_module.php' ?>

                </div><!-- Site Panel: End -->
            </div><!-- Row: End -->
        </div><!-- Container:End -->

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/site/site_ui_footer.php' ?>

        <!-- Bootstrap core JavaScript -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/include/3rdparty/jquery/jquery.min.js"></script>
        <script src="/include/3rdparty/bootstrap/js/bootstrap.min.js"></script>
        <!-- Data Tables -->
        <script src="/include/3rdparty/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="/include/3rdparty/datatables/media/js/dataTables.bootstrap.min.js"></script>

        <!-- Export Button -->
        <!--
        <script src="/include/3rdparty/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
        <script src="/include/3rdparty/jszip/jszip.min.js"></script>
        <script src="/include/3rdparty/pdfmake/pdfmake.min.js"></script>
        <script src="/include/3rdparty/pdfmake/vfs_fonts.js"></script>
        <script src="/include/3rdparty/datatables/extensions/Buttons/js/buttons.html5.min.js"></script>
        -->

        <script>

                                $(document).ready(function () {
                                    $('[data-toggle="tooltip"]').tooltip({animation: true, delay: {show: 100, hide: 100}, html: true});
<?php
foreach ($analytics_list as $analytics) {
    if (is_array($analytics[SITE_UI_CONST::KEY_ARRAY_DATA]) && $analytics[SITE_UI_CONST::KEY_VALUE] > 20) {
        ?>
                                            $('#<?php echo $analytics[SITE_UI_CONST::KEY_HTML_ID] ?>').dataTable({
                                                "iDisplayLength": 20
                                            });
        <?php
    }
}
?>
                                });
        </script>
    </body>
</html>
