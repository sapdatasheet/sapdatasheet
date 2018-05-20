<!DOCTYPE html>
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_global.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');

GLOBAL_UTIL::UpdateSAPDescLangu();

$search = 'SAP TCode Analytics by Component';
$title = $search . SITE_GLOBAL::TITLE_SUFFIX;
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
        <meta name="keywords" content="SAP,ABAP,TCode,Transaction Code">
        <link rel="icon" href="/favicon.ico">
        <title><?php echo $title ?></title>
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
                        <h3>SAP TCode Analytics by Component</h3>
                    </div>
                    <div>
                        <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?><br/>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading"><?php echo GLOBAL_ABAP_ICON::getIcon4Analytics(TRUE) ?>&nbsp;Analytics Chart</div>
                        <div class="d3chartarea_main">
                            <script>
                                var chartWidth = (window.innerWidth || document.body.clientWidth) * 8 / 12;
                                // var chartWidth = window.screen.width * 8 / 12;
                                chartWidth = (chartWidth > 700) ? 700 : chartWidth;
                                drawBubbleChart("/analytics/component/json_comp.php", chartWidth);
                            </script>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading"><?php echo GLOBAL_ABAP_ICON::getIcon4Analytics(TRUE) ?>&nbsp;Analytics Data Details</div>
                        <br />
                        <table id="chartdata_main" class="table table-hover">
                            <thead>
                                <tr><th>
                                        <div class="row">
                                            <div class="col-xs-4 col-sm-4 col-md-4">Software Component</div>
                                            <div class="col-xs-5 col-sm-6 col-md-6">Description</div>
                                            <div class="col-xs-3 col-sm-2 col-md-2">Counter</div>
                                        </div>
                                    </th></tr>
                            </thead>
                            <tbody>
                                <?php foreach (SITE_UI_ANALYTICS::AnaComp_DB2UI(ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_SOFTCOMP()) as $comp_item) { ?>
                                    <tr><td>
                                            <div class="row">
                                                <div class="col-xs-4 col-sm-4 col-md-4">
                                                    <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?>
                                                    <a href="<?php echo $comp_item[SITE_UI_CONST::KEY_URL] ?>" target="_blank" title="<?php echo $comp_item[SITE_UI_CONST::KEY_CAPTION] ?>"><?php echo $comp_item[SITE_UI_CONST::KEY_LABEL] ?></a>
                                                    <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::CVERS_NAME, $comp_item[SITE_UI_CONST::KEY_LABEL], NULL, FALSE) ?>
                                                </div>
                                                <div class="col-xs-5 col-sm-6  col-md-6"><?php echo $comp_item[SITE_UI_CONST::KEY_ABAP_DESC] ?></div>
                                                <div class="col-xs-3 col-sm-2  col-md-2"><?php echo number_format($comp_item[SITE_UI_CONST::KEY_VALUE]) ?></div>
                                            </div>
                                        </td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
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
        <script src="/include/3rdparty/jquery/jquery.min.js"></script>
        <script src="/include/3rdparty/bootstrap/js/bootstrap.min.js"></script>
        <!-- Data Tables -->
        <script src="/include/3rdparty/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="/include/3rdparty/datatables/media/js/dataTables.bootstrap.min.js"></script>
        <script>
                                $(document).ready(function () {
                                    $('[data-toggle="tooltip"]').tooltip({
                                        animation: true,
                                        delay: {show: 100, hide: 100}, html: true
                                    });
                                    $('#chartdata_main').dataTable({
                                        "iDisplayLength": 50
                                    });
                                });
        </script>

    </body>
</html>