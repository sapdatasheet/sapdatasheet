<!DOCTYPE html>
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_global.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');

GLOBAL_UTIL::UpdateSAPDescLangu();

if (!isset($fb_ObjID)) {
    $fb_ObjID = filter_input(INPUT_GET, 'id');
}

if (empty($fb_ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$prefix = strtoupper($fb_ObjID);
$tcode_list = ABAPANA_DB_TABLE::ABAPTRAN_NAMEPATTERN_LOAD($prefix . '%');
$tcode_count = ABAPANA_DB_TABLE::ABAPTRAN_NAMEPATTERN_COUNT($prefix . '%');

$title = 'SAP TCodes Start with ' . $prefix;
$search = 'SAP TCode ' . $prefix;
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
        <meta name="keywords" content="SAP,ABAP,TCode,Transaction Code,<?php echo $prefix ?>">
        <link rel="icon" href="/favicon.ico">
        <title><?php echo $title ?><?php echo SITE_GLOBAL::TITLE_SUFFIX ?></title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="/include/3rdparty/bootstrap/css/bootstrap.min.css">
        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="/style.css">
    </head>
    <body>

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
                        <h3><?php echo $title ?></h3>
                    </div>
                    <div>
                        <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?><br/>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">TCode <strong><?php echo $prefix . '*' ?></strong></div>
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
        <script src="/include/3rdparty/datatables/media/js/jquery.dataTables.min.js"></script>
        <script src="/include/3rdparty/datatables/media/js/dataTables.bootstrap.min.js"></script>

        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip({animation: true, delay: {show: 100, hide: 100}, html: true});
                $('#data_main').dataTable({
                    "iDisplayLength": 50
                });
            });
        </script>

    </body>
</html>
