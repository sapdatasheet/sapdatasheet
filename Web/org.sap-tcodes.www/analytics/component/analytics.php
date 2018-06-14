<!DOCTYPE html>
<?php
$__WS_ROOT__ = dirname(__FILE__, 4);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 3);              // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

if (empty($fb_ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$softcomp = strtoupper($fb_ObjID);
$softcomp_desc = ABAP_DB_TABLE_HIER::CVERS_REF($softcomp);
$search = 'SAP TCode in ' . $softcomp . ' (' . GLOBAL_ABAP_OTYPE::CVERS_DESC . ')';
$title = 'SAP TCodes in Component ' . $softcomp . ' (' . $softcomp_desc . ')';
?>
<html lang="en">
    <head>
        <!-- 'Must have' top 3 meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Other meta -->
        <meta name="author" content="<?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_URL_DISPLAY ?>">
        <meta name="description" content="<?php echo $title . GLOBAL_WEBSITE::SAP_TCODES_ORG_TITLE ?>">
        <meta name="keywords" content="SAP,ABAP,TCode,Transaction Code,<?php echo $softcomp ?>,<?php echo $softcomp_desc ?>">
        <link rel="icon" href="/favicon.ico">
        <title><?php echo $title . GLOBAL_WEBSITE::SAP_TCODES_ORG_TITLE ?></title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="/include/3rdparty/bootstrap/css/bootstrap.min.css">
        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="/style.css">
    </head>
    <body>
        <!-- Load Scripts -->
        <script src="/include/3rdparty/d3/d3.min.js"></script>
        <script src="/include/js/d3bubblechart.js"></script>

        <!-- Navigation bar -->
        <?php require $__ROOT__ . '/include/site/site_ui_nav.php' ?>

        <!-- Container: Start -->
        <div class="container-fluid">
            <!-- Row: Start, Row with two columns divided in 3:1 ratio-->
            <div class="row">
                <!-- Main Content: Start -->
                <div class="col-sm-9">

                    <!-- Page Header -->
                    <div class="page-header">
                        <h3><?php echo $title ?><?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::CVERS_NAME, $softcomp) ?></h3>
                    </div>
                    <div>
                        <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading"><?php echo GLOBAL_ABAP_ICON::getIcon4Analytics(TRUE) ?>&nbsp;Analytics Chart</div>
                        <div class="d3chartarea_main">
                            <script>
                                var chartWidth = (window.innerWidth || document.body.clientWidth) * 8 / 12;
                                // var chartWidth = window.screen.width * 8 / 12;
                                chartWidth = (chartWidth > 700) ? 700 : chartWidth;
                                drawBubbleChart("/analytics/component/json_comp_module.php?id=<?php echo $softcomp ?>", chartWidth);
                            </script>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <?php echo GLOBAL_ABAP_ICON::getIcon4Analytics(TRUE) ?>&nbsp;Analytics Data Details
                            <?php require $__ROOT__ . '/include/site/site_ui_backtotop.php'; ?>
                        </div>
                        <br>
                        <table id="chartdata_main" class="table table-hover">
                            <thead>
                                <tr><th>
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 col-md-4">Module</div>
                                            <div class="col-xs-5 col-sm-6 col-md-6">Module Description</div>
                                            <div class="col-xs-3 col-sm-2 col-md-2">Counter</div>
                                        </div>
                                    </th></tr>
                            </thead>
                            <tbody>
                                <?php foreach (SITE_UI_ANALYTICS::AnaCompModule_DB2UI(ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_SOFTCOMP_APPLPOSID($softcomp)) as $module_item) { ?>
                                    <tr><td>
                                            <div class="row">
                                                <div class="col-xs-4 col-sm-4 col-md-4">
                                                    <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?>
                                                    <a href="<?php echo $module_item[SITE_UI_CONST::KEY_URL] ?>" target="_blank" title="<?php echo $module_item[SITE_UI_CONST::KEY_CAPTION] ?>"><?php echo $module_item[SITE_UI_CONST::KEY_LABEL] ?></a>
                                                    <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::BMFR_NAME, $module_item[SITE_UI_CONST::KEY_ABAP_OBJNAME], NULL, FALSE) ?>
                                                </div>
                                                <div class="col-xs-5 col-sm-6  col-md-6"><?php echo $module_item[SITE_UI_CONST::KEY_ABAP_DESC] ?></div>
                                                <div class="col-xs-3 col-sm-2  col-md-2"><strong><?php echo number_format($module_item[SITE_UI_CONST::KEY_VALUE]) ?></strong></div>
                                            </div>
                                        </td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            TCode List in Component <strong><?php echo $softcomp ?></strong>
                            <?php require $__ROOT__ . '/include/site/site_ui_backtotop.php'; ?>
                        </div>
                        <br>
                        <?php
                        $table_id = 'data_main';
                        $tcode_count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT(ABAPANA_DB_TABLE::ABAPTRAN_SOFTCOMP, $softcomp);
                        $tcode_list = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(ABAPANA_DB_TABLE::ABAPTRAN_SOFTCOMP, $softcomp);
                        require $__ROOT__ . '/include/site/site_ui_tcodetable.php';
                        ?>
                    </div>

                </div><!-- Main Content: End -->

                <!-- Site Panel: Begin -->
                <div class="col-sm-3">

                    <!-- TCodes by Each Module -->
                    <?php require $__ROOT__ . '/include/site/site_ui_side_module.php'; ?>

                </div><!-- Site Panel: End -->
            </div><!-- Row: End -->
        </div><!-- Container:End -->


        <!-- Footer -->
        <?php require $__ROOT__ . '/include/site/site_ui_footer.php'; ?>

        <!-- Bootstrap core JavaScript -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/include/3rdparty/jquery/jquery.min.js"></script>
        <script src="/include/3rdparty/bootstrap/js/bootstrap.min.js"></script>
        <!-- Data Tables -->
        <script src="/include/3rdparty/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="/include/3rdparty/datatables/media/js/dataTables.bootstrap.min.js"></script>

        <script>
                                $(document).ready(function () {
                                    $('[data-toggle="tooltip"]').tooltip({animation: true, delay: {show: 100, hide: 100}, html: true});
                                    $('#chartdata_main').dataTable({
                                        "iDisplayLength": 50
                                    });
                                    $('#data_main').dataTable({
                                        "iDisplayLength": 50
                                    });
                                });
        </script>

    </body>
</html>