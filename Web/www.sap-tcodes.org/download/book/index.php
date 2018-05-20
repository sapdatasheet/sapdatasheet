<!DOCTYPE html>
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_global.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');

GLOBAL_UTIL::UpdateSAPDescLangu();

$search = 'Download SAP TCode Books (PDF)';
$title = $search . SITE_GLOBAL::TITLE_SUFFIX;
?>
<html lang="en">
    <head>
        <!-- 'Must have' top 3 meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Other meta -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="/favicon.ico">
        <title><?php echo $title ?></title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="/include/3rdparty/bootstrap/css/bootstrap.min.css">
        <!-- Custom styles for this template -->
        <link rel="stylesheet" href="/style.css">
    </head>
    <body>

        <!-- Navigation bar -->
        <?php require $__ROOT__ . '/include/site/site_ui_nav.php' ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">

                    <!-- Page Header -->
                    <div class="page-header">
                        <h3>SAP TCode Books Download</h3>
                    </div>
                    <div>
                        <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?><br/>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading"><span class="glyphicon glyphicon-book"></span>&nbsp;Books in PDF format</div>
                        <br />
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr><th class="text-right">#</th>
                                        <th>Download</th>
                                        <th>SAP Module</th>
                                        <th>Description</th>
                                        <th>Size</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    <?php foreach (SITE_UI_ANALYTICS::AnaModuleL1_DB2UI() as $appl_l1) { ?>
                                        <?php $i++; ?>
                                        <tr><td class="text-right"><?php echo number_format($i) ?></td>
                                            <td>
                                                <?php
                                                $bookName = ABAP_UI_TCODES_Navigation::BookName4Module($appl_l1[SITE_UI_CONST::KEY_LABEL]);
                                                $fname = ABAP_UI_TCODES_Navigation::DistPath($bookName);
                                                $fsize = file_exists($fname) ? filesize($fname) : 0;
                                                ?>
                                                <a href="<?php echo ABAP_UI_TCODES_Navigation::DownloadBookPath($bookName) ?>" target="_blank" class="btn btn-warning btn-xs" role="button">
                                                    <?php echo GLOBAL_ABAP_ICON::getIcon4FilePDF(TRUE) ?>
                                                    &nbsp; <?php echo $bookName ?>
                                                </a>
                                            </td>
                                            <td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?>
                                                <?php if ($appl_l1[SITE_UI_CONST::KEY_HIGHLIGHT]) { ?>
                                                    <span class="label label-warning">
                                                    <?php } ?>
                                                    <a href="<?php echo $appl_l1[SITE_UI_CONST::KEY_URL] ?>"
                                                       title="<?php echo $appl_l1[SITE_UI_CONST::KEY_CAPTION] ?>" target="_blank">
                                                        <?php echo $appl_l1[SITE_UI_CONST::KEY_LABEL] ?></a>
                                                    <?php if ($appl_l1[SITE_UI_CONST::KEY_HIGHLIGHT]) { ?>
                                                    </span>
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $appl_l1[SITE_UI_CONST::KEY_ABAP_DESC] ?></td>
                                            <td class="text-right"><?php echo GLOBAL_UTIL::FormatSizeUnits($fsize) ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div><!-- End of Main Content -->
                <div class="col-sm-1">&nbsp;</div>
            </div>
        </div>



        <!-- Footer -->
        <?php require $__ROOT__ . '/include/site/site_ui_footer.php' ?>

        <!-- Bootstrap core JavaScript -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/include/3rdparty/jquery/jquery.min.js"></script>
        <script src="/include/3rdparty/bootstrap/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip({animation: true, delay: {show: 100, hide: 100}, html: true});
            });
        </script>

    </body>
</html>