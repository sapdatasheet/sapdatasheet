<!DOCTYPE html>
<?php
$__WS_ROOT__ = dirname ( __FILE__, 4 ); // Root folder for the Workspace
$__ROOT__ = dirname ( __FILE__, 3 ); // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu ();

$search = 'SAP TCode Analytics by Module';
$title = $search . GLOBAL_WEBSITE::SAP_TCODES_ORG_TITLE;
?>
<html lang="en">
<head>
<!-- 'Must have' top 3 meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Other meta -->
<meta name="author"
	content="<?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_URL_DISPLAY ?>">
<meta name="description" content="<?php echo $title ?>">
<meta name="keywords" content="SAP,ABAP,TCode,Transaction Code">
<link rel="icon" href="/favicon.ico">
<title><?php echo $title ?></title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="/3rdparty/bootstrap/css/bootstrap.min.css">
<!-- Custom styles for this template -->
<link rel="stylesheet" href="/style.css">
<!-- Data Tables CSS -->
<link rel="stylesheet"
	href="/3rdparty/datatables/css/dataTables.bootstrap4.min.css">
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

				<!-- Page Header, https://stackoverflow.com/questions/49707845 -->
				<div class="pb-2 mt-3 mb-2 border-bottom">
					<h4>SAP TCode Analytics by Module</h4>
				</div>

				<div><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>

				<div class="card mt-2">
					<div class="card-header bg-info"><?php echo GLOBAL_ABAP_ICON::getIcon4Analytics(TRUE) ?>&nbsp;Analytics Chart</div>
					<div class="d3chartarea_main">
						<script>
                        var chartWidth = (window.innerWidth || document.body.clientWidth) * 8 / 12;
                        // var chartWidth = window.screen.width * 8 / 12;
                        chartWidth = (chartWidth > 700) ? 700 : chartWidth;
                        drawBubbleChart("/analytics/module/json_module.php", chartWidth);
                    </script>
					</div>
				</div>

				<div class="card mt-4">
					<div class="card-header bg-info"><?php echo GLOBAL_ABAP_ICON::getIcon4Analytics(TRUE) ?>&nbsp;Analytics Data Details</div>
					<div class="card-body">

						<table id="chartdata_main" class="table table-hover">
							<thead>
								<tr>
									<th><div class="row">
											<div class="col">Software Component</div>
											<div class="col">Description</div>
											<div class="col">Counter</div>
										</div></th>
								</tr>
							</thead>
							<tbody>
                                <?php foreach (SITE_UI_ANALYTICS::AnaModuleL1_DB2UI(ABAPANA_DB_TABLE::ABAPTRAN_ANALYTICS_PS_POSID_L1()) as $module_item) { ?>
                                    <tr>
									<td><div class="row">
											<div class="col">
                                                    <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?>
                                                    <a
													href="<?php echo $module_item[SITE_UI_CONST::KEY_URL] ?>"
													target="_blank"
													title="<?php echo $module_item[SITE_UI_CONST::KEY_CAPTION] ?>"><?php echo $module_item[SITE_UI_CONST::KEY_LABEL] ?></a>
                                                    <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::CVERS_NAME, $module_item[SITE_UI_CONST::KEY_LABEL], NULL, FALSE) ?>
                                                </div>
											<div class="col"><?php echo $module_item[SITE_UI_CONST::KEY_ABAP_DESC] ?></div>
											<div class="col text-right"><?php echo number_format($module_item[SITE_UI_CONST::KEY_VALUE]) ?></div>
										</div></td>
								</tr>
                                <?php } ?>
                            </tbody>
						</table>

					</div>
				</div>

			</div>
			<!-- Main Content: End -->

			<!-- Site Panel: Begin -->
			<div class="col-sm-3">
				<!-- TCodes by Each Module -->
                <?php require $__ROOT__ . '/include/site/site_ui_side_component.php' ?>
            </div>
			<!-- Site Panel: End -->
		</div>
		<!-- Row: End -->
	</div>
	<!-- Container:End -->

	<!-- Footer -->
    <?php require $__ROOT__ . '/include/site/site_ui_footer.php' ?>

    <!-- Bootstrap core JavaScript -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="/3rdparty/bootstrap/require/jquery.js"></script>
	<script src="/3rdparty/bootstrap/require/popper.min.js"></script>
	<script src="/3rdparty/bootstrap/js/bootstrap.min.js"></script>
	<!-- Data Tables -->
	<script src="/3rdparty/datatables/js/jquery.dataTables.min.js"></script>
	<script src="/3rdparty/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script>
        $(document).ready(function () {
            $('#chartdata_main').dataTable({
                "iDisplayLength": 50
            });
        });
    </script>

</body>
</html>