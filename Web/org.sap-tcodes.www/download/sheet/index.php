<!DOCTYPE html>
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/download.php');
require_once ($__ROOT__ . '/include/site/site_global.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');

GLOBAL_UTIL::UpdateSAPDescLangu();

$search = 'Download SAP TCode Data Sheets (CSV, Excel)';
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

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#dlsheet-module"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?> Sheets by Module</a></li>
                        <li><a data-toggle="tab" href="#dlsheet-component"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?> Sheets by Component</a></li>
                        <li><a data-toggle="tab" href="#dlsheet-name"><?php echo GLOBAL_ABAP_ICON::getIcon4NamePrefix(TRUE) ?> Sheets by Name</a></li>
                        <!-- <li><a data-toggle="tab" href="#dlsheet-expert">Expert Mode</a></li> -->
                    </ul>
                    <br>
                    <div>
                        <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                    </div>

                    <div class="tab-content">
                        <div id="dlsheet-module" class="tab-pane fade in active">

                            <h3>Download TCode Sheets by Module</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-condensed">
                                    <thead>
                                        <tr><th class="text-right">#</th>
                                            <th>Download as</th>
                                            <th>SAP Module</th>
                                            <th>Description</th>
                                            <th>TCode Count</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        <?php foreach (SITE_UI_ANALYTICS::AnaModuleL1_DB2UI() as $appl_l1) { ?>
                                            <?php $i++; ?>
                                            <tr><td class="text-right"><?php echo number_format($i) ?></td>
                                                <td>
                                                    <a class="btn btn-warning btn-xs" role="button" target="_blank" 
                                                       href="<?php echo ABAP_UI_TCODES_Navigation::DownloadSheetPath(ABAP_UI_TCODES_Navigation::SheetName(ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_MODULE, $appl_l1[SITE_UI_CONST::KEY_LABEL], DOWNLOAD::FORMAT_CSV)) ?>" 
                                                       title="Download as <?php echo DOWNLOAD::FORMAT_CSV_Title ?>">
                                                        <img src='/include/icon/s_wdvtxe.gif'> <?php echo DOWNLOAD::FORMAT_CSV ?>
                                                    </a>&nbsp;
                                                    <a class="btn btn-warning btn-xs" role="button" target="_blank" 
                                                       href="<?php echo ABAP_UI_TCODES_Navigation::DownloadSheetPath(ABAP_UI_TCODES_Navigation::SheetName(ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_MODULE, $appl_l1[SITE_UI_CONST::KEY_LABEL], DOWNLOAD::FORMAT_XLS)) ?>" 
                                                       title="Download as <?php echo DOWNLOAD::FORMAT_XLS_Title ?>">
                                                        <img src='/include/icon/s_x__xls.gif'> <?php echo DOWNLOAD::FORMAT_XLS ?>
                                                    </a>&nbsp;
                                                    <a class="btn btn-warning btn-xs" role="button" target="_blank" 
                                                       href="<?php echo ABAP_UI_TCODES_Navigation::DownloadSheetPath(ABAP_UI_TCODES_Navigation::SheetName(ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_MODULE, $appl_l1[SITE_UI_CONST::KEY_LABEL], DOWNLOAD::FORMAT_XLSX)) ?>" 
                                                       title="Download as <?php echo DOWNLOAD::FORMAT_XLSX_Title ?>">
                                                        <img src='/include/icon/s_x__xlv.gif'> <?php echo DOWNLOAD::FORMAT_XLSX ?>
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
                                                    <?php } ?></td>
                                                <td><?php echo $appl_l1[SITE_UI_CONST::KEY_ABAP_DESC] ?></td>
                                                <td><?php echo number_format($appl_l1[SITE_UI_CONST::KEY_VALUE]) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- End Tab Module -->
                        <div id="dlsheet-component" class="tab-pane fade">

                            <h3>Download TCode Sheets by Component</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-condensed">
                                    <thead>
                                        <tr><th class="text-right">#</th>
                                            <th>Download as</th>
                                            <th>SAP Component</th>
                                            <th>Description</th>
                                            <th>TCode Count</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach (SITE_UI_ANALYTICS::AnaComp_DB2UI(ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_SOFTCOMP()) as $comp) {
                                            $i++;
                                            ?>
                                            <tr><td class="text-right"><?php echo number_format($i) ?></td>
                                                <td>
                                                    <a class="btn btn-warning btn-xs" role="button" target="_blank" 
                                                       href="<?php echo ABAP_UI_TCODES_Navigation::DownloadSheetPath(ABAP_UI_TCODES_Navigation::SheetName(ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_COMPONENT, $comp[SITE_UI_CONST::KEY_LABEL], DOWNLOAD::FORMAT_CSV)) ?>" 
                                                       title="Download as <?php echo DOWNLOAD::FORMAT_CSV_Title ?>">
                                                        <img src='/include/icon/s_wdvtxe.gif'> <?php echo DOWNLOAD::FORMAT_CSV ?>
                                                    </a>&nbsp;
                                                    <a class="btn btn-warning btn-xs" role="button" target="_blank" 
                                                       href="<?php echo ABAP_UI_TCODES_Navigation::DownloadSheetPath(ABAP_UI_TCODES_Navigation::SheetName(ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_COMPONENT, $comp[SITE_UI_CONST::KEY_LABEL], DOWNLOAD::FORMAT_XLS)) ?>" 
                                                       title="Download as <?php echo DOWNLOAD::FORMAT_XLS_Title ?>">
                                                        <img src='/include/icon/s_x__xls.gif'> <?php echo DOWNLOAD::FORMAT_XLS ?>
                                                    </a>&nbsp;
                                                    <a class="btn btn-warning btn-xs" role="button" target="_blank" 
                                                       href="<?php echo ABAP_UI_TCODES_Navigation::DownloadSheetPath(ABAP_UI_TCODES_Navigation::SheetName(ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_COMPONENT, $comp[SITE_UI_CONST::KEY_LABEL], DOWNLOAD::FORMAT_XLSX)) ?>" 
                                                       title="Download as <?php echo DOWNLOAD::FORMAT_XLSX_Title ?>">
                                                        <img src='/include/icon/s_x__xlv.gif'> <?php echo DOWNLOAD::FORMAT_XLSX ?>
                                                    </a>
                                                </td>
                                                <td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?>
                                                    <a href="<?php echo $comp[SITE_UI_CONST::KEY_URL] ?>"
                                                       title="<?php echo $comp[SITE_UI_CONST::KEY_CAPTION] ?>" target="_blank">
                                                        <?php echo $comp[SITE_UI_CONST::KEY_LABEL] ?></a>
                                                <td><?php echo $comp[SITE_UI_CONST::KEY_ABAP_DESC] ?></td>
                                                <td><?php echo number_format($comp[SITE_UI_CONST::KEY_VALUE]) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div><!-- End Tab Component -->
                        <div id="dlsheet-name" class="tab-pane fade">

                            <h3>Download TCode Sheets by Name</h3>
                            <div class="table-responsive">
                                <table id="chartdata_main" class="table table-striped table-hover table-condensed">
                                    <thead>
                                        <tr><th class="text-right">#</th>
                                            <th>Download as</th>
                                            <th>Name Prefix / Namespace</th>
                                            <th>TCode Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach (SITE_UI_ANALYTICS::AnaName_DB2UI(ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_NAME_LEFT2()) as $name_item) {
                                            if ($name_item[SITE_UI_CONST::KEY_VALUE] >= ABAP_UI_TCODES_Navigation::DOWNLOAD_NAME_ROW_MIN) { // Download Sheets for Bigger Number Records
                                                $i++;
                                                ?>
                                                <tr><td class="text-right"><?php echo number_format($i) ?></td>
                                                    <td>
                                                        <a class="btn btn-warning btn-xs" role="button" target="_blank" 
                                                           href="<?php echo ABAP_UI_TCODES_Navigation::DownloadSheetPath(ABAP_UI_TCODES_Navigation::SheetName(ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_NAME, $name_item[SITE_UI_CONST::KEY_LABEL], DOWNLOAD::FORMAT_CSV)) ?>" 
                                                           title="Download as <?php echo DOWNLOAD::FORMAT_CSV_Title ?>">
                                                            <img src='/include/icon/s_wdvtxe.gif'> <?php echo DOWNLOAD::FORMAT_CSV ?>
                                                        </a>&nbsp;
                                                        <a class="btn btn-warning btn-xs" role="button" target="_blank" 
                                                           href="<?php echo ABAP_UI_TCODES_Navigation::DownloadSheetPath(ABAP_UI_TCODES_Navigation::SheetName(ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_NAME, $name_item[SITE_UI_CONST::KEY_LABEL], DOWNLOAD::FORMAT_XLS)) ?>" 
                                                           title="Download as <?php echo DOWNLOAD::FORMAT_XLS_Title ?>">
                                                            <img src='/include/icon/s_x__xls.gif'> <?php echo DOWNLOAD::FORMAT_XLS ?>
                                                        </a>&nbsp;
                                                        <a class="btn btn-warning btn-xs" role="button" target="_blank" 
                                                           href="<?php echo ABAP_UI_TCODES_Navigation::DownloadSheetPath(ABAP_UI_TCODES_Navigation::SheetName(ABAP_UI_TCODES_Navigation::SHEET_PARAMETER_FILTER_NAME, $name_item[SITE_UI_CONST::KEY_LABEL], DOWNLOAD::FORMAT_XLSX)) ?>" 
                                                           title="Download as <?php echo DOWNLOAD::FORMAT_XLSX_Title ?>">
                                                            <img src='/include/icon/s_x__xlv.gif'> <?php echo DOWNLOAD::FORMAT_XLSX ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo GLOBAL_ABAP_ICON::getIcon4NamePrefix(TRUE) ?>
                                                        <a href="<?php echo $name_item[SITE_UI_CONST::KEY_URL] ?>"
                                                           target="_blank" title="<?php echo $name_item[SITE_UI_CONST::KEY_CAPTION] ?>">
                                                            <?php echo $name_item[SITE_UI_CONST::KEY_LABEL] ?></a></td>
                                                    <td><?php echo number_format($name_item[SITE_UI_CONST::KEY_VALUE]) ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div><!-- End Tab Name -->
                        <!--
                        <div id="dlsheet-expert" class="tab-pane fade">
                            <h3>Download TCode Sheets as Will</h3>
                            <select class="selectpicker" data-live-search="true" title="Choose one Component">
                                <option value="bb">Mustard</option>
                                <option value="aa" data-subtext="SAP Financials">Ketchup</option>
                                <option value="cc">Relish</option>
                            </select>
                        </div>
                        -->
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