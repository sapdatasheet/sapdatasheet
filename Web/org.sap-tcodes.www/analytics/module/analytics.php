<!DOCTYPE html>
<?php
$__WS_ROOT__ = dirname(__FILE__, 4);           // Root folder for the Workspace
$__ROOT__ = dirname(__FILE__, 3);              // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');

GLOBAL_UTIL::UpdateSAPDescLangu();

if (!isset($fb_ObjID)) {
    $fb_ObjID = filter_input(INPUT_GET, 'id');
}

if (empty($fb_ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$appl_posid = strtoupper($fb_ObjID);
$level = ABAPANA_DB_TABLE::ABAPBMFR_POSID_LEVEL($appl_posid);
$abapbmfr = ABAPANA_DB_TABLE::ABAPBMFR_POSID($appl_posid);
$appl_desc = ABAPANA_DB_TABLE::ABAPBMFR_TEXT($appl_posid);
if ($level == 1) {
    $tcode_list = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(ABAPANA_DB_TABLE::ABAPTRAN_PS_POSID_L1, $appl_posid);
    $tcode_count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT(ABAPANA_DB_TABLE::ABAPTRAN_PS_POSID_L1, $appl_posid);
} else if ($level == 2) {
    $tcode_list = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(ABAPANA_DB_TABLE::ABAPTRAN_PS_POSID_L2, $appl_posid);
    $tcode_count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT(ABAPANA_DB_TABLE::ABAPTRAN_PS_POSID_L2, $appl_posid);
} else {
    $tcode_list = ABAPANA_DB_TABLE::ABAPTRAN_LOAD(ABAPANA_DB_TABLE::ABAPTRAN_APPLPOSID, $appl_posid);
    $tcode_count = ABAPANA_DB_TABLE::ABAPTRAN_COUNT(ABAPANA_DB_TABLE::ABAPTRAN_APPLPOSID, $appl_posid);
}

$search = 'SAP Module ' . $appl_posid;
$title = 'SAP TCodes in Module ' . $appl_posid . '(' . $appl_desc . ')';
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
        <meta name="keywords" content="SAP,ABAP,TCode,Transaction Code,<?php echo $appl_posid ?>,<?php echo $appl_desc ?>">
        <link rel="icon" href="/favicon.ico">
        <title><?php echo $title . GLOBAL_WEBSITE::SAP_TCODES_ORG_TITLE ?></title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="/3rdparty/bootstrap/css/bootstrap.min.css">
        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="/style.css">
    </head>
    <body>
        <!-- Load Scripts -->
        <script src="/include/3rdparty/d3/d3.min.js"></script>
        <script src="/include/3rdparty/d3pie/d3pie.min.js"></script>

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
                    $title_bc_list = SITE_UI_ANALYTICS::AnaModuleBreadcrumbs($appl_posid);
                    require $__ROOT__ . '/include/site/site_ui_breadcrumb.php';
                    ?>

                    <!-- Page Header -->
                    <div class="page-header">
                        <h3><?php echo $title ?><?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::BMFR_NAME, $abapbmfr['FCTR_ID']) ?></h3>
                    </div>
                    <div>
                        <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                    </div>

                    <?php
                    if ($level == 1) {
                        $modulel2_list = SITE_UI_ANALYTICS::AnaModuleL2_DB2UI($appl_posid);
                        $modulel2_count = count($modulel2_list);
                        ?>
                        <div class="panel panel-info">
                            <div class="panel-heading"><?php echo GLOBAL_ABAP_ICON::getIcon4Analytics(TRUE) ?>&nbsp;Sub-Modules in <strong><?php echo $appl_posid ?></strong></div>
                            <div id="d3pie_main"></div>
                            <script>
                                var chartWidth = (window.innerWidth || document.body.clientWidth) * 8 / 12;
                                // var chartWidth = window.screen.width * 8 / 12;
                                chartWidth = (chartWidth > 700) ? 700 : chartWidth;

                                var pie = new d3pie("d3pie_main", {
                                    header: {
                                        title: {
                                            text: "<?php echo $appl_posid ?>"
                                        },
                                        location: "pie-center"
                                    },
                                    size: {
                                        canvasHeight: chartWidth,
                                        canvasWidth: chartWidth,
                                        pieInnerRadius: "30%"
                                    },
                                    tooltips: {
                                        enabled: true,
                                        type: "caption",
                                    },
                                    labels: {
                                        "inner": {
                                            "hideWhenLessThanPercentage": 3
                                        }
                                    },
                                    callbacks: {
                                        onClickSegment: function (a) {
                                            var win = window.open(a.data.url, '_blank');
                                            win.focus();
                                        }
                                    },
                                    data: <?php echo SITE_UI_ANALYTICS::List2Json_D3PieChart($modulel2_list) ?>
                                });</script>
                        </div>

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <?php echo GLOBAL_ABAP_ICON::getIcon4Analytics(TRUE) ?>&nbsp;Analytics Data Details
                                <?php require $__ROOT__ . '/include/site/site_ui_backtotop.php'; ?>
                            </div>
                            <br>
                            <table id="table_module_l1" class="table table-striped table-hover">
                                <thead>
                                    <tr><th><div class="row">
                                                <div class="col-xs-4 col-sm-4 col-md-4">Module</div>
                                                <div class="col-xs-5 col-sm-6 col-md-6">Module Description</div>
                                                <div class="col-xs-3 col-sm-2 col-md-2">Counter</div>
                                            </div>
                                        </th></tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($modulel2_list as $module_item) { ?>
                                        <tr><td><div class="row">
                                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?>
                                                        <a href="<?php echo $module_item[SITE_UI_CONST::KEY_URL] ?>"
                                                           target="_blank" title="<?php echo $module_item[SITE_UI_CONST::KEY_CAPTION] ?>">
                                                            <?php echo $module_item[SITE_UI_CONST::KEY_LABEL] ?></a>
                                                        <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::BMFR_NAME, $module_item[SITE_UI_CONST::KEY_ABAP_OBJNAME], NULL, FALSE) ?>
                                                    </div>
                                                    <div class="col-xs-5 col-sm-6 col-md-6"><?php echo $module_item[SITE_UI_CONST::KEY_ABAP_DESC] ?></div>
                                                    <div class="col-xs-3 col-sm-2 col-md-2"><strong><?php echo number_format($module_item[SITE_UI_CONST::KEY_VALUE]) ?></strong></div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>


                    <?php } // End ($level == 1) ?>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            TCode List
                            <?php require $__ROOT__ . '/include/site/site_ui_backtotop.php'; ?>
                        </div>
                        <br />
                        <?php
                        $table_id = 'data_main';
                        require $__ROOT__ . '/include/site/site_ui_tcodetable.php';
                        ?>
                    </div>

                </div><!-- Main Content: End -->

                <!-- Site Panel: Begin -->
                <div class="col-sm-3">

                    <!-- TCodes by Each Module -->
                    <?php require $__ROOT__ . '/include/site/site_ui_side_module.php' ?>

                </div><!-- Site Panel: End -->
            </div><!-- Row: End -->
        </div><!-- Container:End -->


        <!-- Footer -->
        <?php require $__ROOT__ . '/include/site/site_ui_footer.php' ?>

        <!-- Bootstrap core JavaScript -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/3rdparty/bootstrap/require/jquery.js"></script>
        <script src="/3rdparty/bootstrap/require/popper.min.js"></script>
        <script src="/3rdparty/bootstrap/js/bootstrap.min.js"></script>
        <script src="/include/3rdparty/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="/include/3rdparty/datatables/media/js/dataTables.bootstrap.min.js"></script>

        <script>
                                $(document).ready(function () {
                                    $('[data-toggle="tooltip"]').tooltip({animation: true, delay: {show: 100, hide: 100}, html: true});
                                    $('#data_main').dataTable({
                                        "iDisplayLength": 50
                                    });
<?php if ($level == 1 && $modulel2_count > 25) { ?>
                                        $('#table_module_l1').dataTable({
                                            "iDisplayLength": 25
                                        });
<?php } ?>
                                });
        </script>

    </body>
</html>
