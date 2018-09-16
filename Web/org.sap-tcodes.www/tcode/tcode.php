<!DOCTYPE html>
<?php
$__WS_ROOT__ = dirname ( __FILE__, 3 ); // Root folder for the Workspace
$__ROOT__ = dirname ( __FILE__, 2 ); // Root folder for Current web site

require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__WS_ROOT__ . '/common-php/library/schemaorg.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu ();

if (empty ( $fb_ObjID )) {
	ABAP_UI_TOOL::Redirect404 ();
}

$abaptran = ABAPANA_DB_TABLE::ABAPTRAN ( strtoupper ( $fb_ObjID ) );
if (empty ( $abaptran ['TCODE'] ) || $abaptran ['TCODE'] == NULL) {
	ABAP_UI_TOOL::Redirect404 ();
}

$tstc_desc = ABAP_DB_TABLE_TRAN::TSTCT ( $abaptran ['TCODE'] );
$tstc_desc_all = ABAP_DB_TABLE_TRAN::TSTCT_All ( $abaptran ['TCODE'] );
$analytics_list = SITE_UI_TCODE::LoadAnalytics ( $abaptran );

$wil_list = SITE_UI_TCODE::LoadWil ( $abaptran ['TCODE'] );
$wul_list = SITE_UI_TCODE::LoadWul ( $abaptran ['TCODE'] );

$title = 'SAP ' . GLOBAL_ABAP_OTYPE::TRAN_DESC . ' ' . $abaptran ['TCODE'] . ' (' . $tstc_desc . ')';
$search = $abaptran ['TCODE'] . ' ' . $tstc_desc . ' ' . GLOBAL_WEBSITE::SAP_TCODES_ORG_NAME;

$json_ld = new \OrgSchema\Thing ();
$json_ld->name = $abaptran ['TCODE'];
$json_ld->alternateName = $tstc_desc;
$json_ld->description = $title;
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL ( GLOBAL_ABAP_ICON::OTYPE_TRAN, TRUE );
$json_ld->url = ABAP_UI_TCODES_Navigation::TCode ( $abaptran ['TCODE'], TRUE );
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
<meta name="description"
	content="<?php echo $title . GLOBAL_WEBSITE::SAP_TCODES_ORG_TITLE ?>">
<meta name="keywords"
	content="SAP,ABAP,TCode,Transaction Code,<?php echo $abaptran['TCODE'] ?>,<?php echo $tstc_desc ?>">
<link rel="icon" href="/favicon.ico">
<title><?php echo $title . GLOBAL_WEBSITE::SAP_TCODES_ORG_TITLE ?></title>
<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="/3rdparty/bootstrap/css/bootstrap.min.css">
<!-- Custom styles for this template -->
<link rel="stylesheet" href="/style.css">

<!-- Other CSS needed by this page -->
<link rel="stylesheet"
	href="/3rdparty/datatables/css/dataTables.bootstrap4.min.css">
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
                <?php $title_bc_list = SITE_UI_TCODE::LoadBreadcrumbs ( $abaptran ); require $__ROOT__ . '/include/site/site_ui_breadcrumb.php'; ?>

                <!-- Page Header -->
				<div class="pb-2 mt-3 mb-2 border-bottom">
					<h4>Analytics for SAP TCode <?php echo $abaptran['TCODE'] ?> <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::TRAN_NAME, $abaptran['TCODE'], NULL, FALSE) ?>
                        <br /> <small class="text-secondary"><?php echo $tstc_desc ?></small>
					</h4>
				</div>

				<div><?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?></div>

				<div class="card mt-2">
					<div class="card-header bg-info"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN(TRUE) ?>&nbsp;<?php echo ABAP_UI_DS_Navigation::GetHyperlink4TranEx($abaptran['TCODE']) ?> Analytics</div>
					<div class="card-body">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs">
							<li class="nav-item"><a class="nav-link active" data-toggle="tab"
								href="#graph-sfdp">Network Layout</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab"
								href="#graph-dot">Tree Layout</a></li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div class="tab-pane container active" id="graph-sfdp">
								<object class="img-fluid" type="image/svg+xml"
									data="<?php echo ABAP_UI_TCODES_Navigation::TCodeGraph($abaptran['TCODE'], TCodeGraphviz::layout_sfdp) ?>">
									Your browser does not support SVG</object>
							</div>
							<div class="tab-pane container fade" id="graph-dot">
								<object class="img-fluid" type="image/svg+xml"
									data="<?php echo ABAP_UI_TCODES_Navigation::TCodeGraph($abaptran['TCODE'], TCodeGraphviz::layout_dot) ?>">
									Your browser does not support SVG</object>
							</div>
						</div>
					</div>
					<!-- End card-body -->
				</div>

				<!-- TCode Analytics -->
				<div class="card mt-4">
					<div class="card-header bg-info"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN(TRUE) ?>&nbsp;<?php echo ABAP_UI_DS_Navigation::GetHyperlink4TranEx($abaptran['TCODE']) ?> Analytics Data</div>
					<div class="card-body">
						<table class="table table-hover">
							<tbody>
                                <?php foreach ($analytics_list as $analytics) { ?>
                                    <tr>
									<td><div class="row">
											<div class="col-xs-4 col-sm-4 col-md-4"><?php echo $analytics[SITE_UI_CONST::KEY_LABEL] ?></div>
											<div class="col-xs-5 col-sm-6 col-md-6">
												<strong><?php echo $analytics[SITE_UI_CONST::KEY_ABAP_OBJNAME] ?></strong><?php echo $analytics[SITE_UI_CONST::KEY_ABAP_DSLINK] ?></div>
											<div class="col-xs-3 col-sm-2 col-md-2">
												<a href="#"><span class="label label-primary"><?php echo $analytics[SITE_UI_CONST::KEY_VALUE] ?></span></a>
											</div>
										</div></td>
								</tr>
                                <?php } ?>
                            </tbody>
						</table>
					</div>
					<!-- End card-body -->
				</div>

                    <?php
																				foreach ( $analytics_list as $analytics ) {
																					if (is_array ( $analytics [ABAP_UI_TCODES_Navigation::KEY_ARRAY_DATA] ) && $analytics [ABAP_UI_TCODES_Navigation::JSON_NEW_WINDOW] == ABAP_UI_TCODES_Navigation::NO) {
																						?>
               <div
					id="panel-<?php echo $analytics[SITE_UI_CONST::KEY_HTML_ID] ?>"
					class="card mt-4">
					<div class="card-header bg-info">
                                    <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN(TRUE) ?>&nbsp;
                                    <?php echo ABAP_UI_DS_Navigation::GetHyperlink4TranEx($abaptran['TCODE']) ?> Analytics - <?php echo $analytics[SITE_UI_CONST::KEY_LABEL] ?> <strong><?php echo $analytics[SITE_UI_CONST::KEY_ABAP_OBJNAME] ?></strong>
					</div>
					<div class="card-body">
                                <?php
																						$table_id = $analytics [SITE_UI_CONST::KEY_HTML_ID];
																						$tcode_list = $analytics [ABAP_UI_TCODES_Navigation::KEY_ARRAY_DATA];
																						$tcode_count = $analytics [SITE_UI_CONST::KEY_VALUE];
																						require $__ROOT__ . '/include/site/site_ui_tcodetable.php';
																						?>
                    </div>
					<!-- End card-body -->
				</div>
                            <?php
																					}
																				}
																				?>

                    <!-- Global Descriptions -->
                    <?php if (count($tstc_desc_all) > 0) { ?>
                    <div class="card mt-4">
					<div class="card-header bg-info"><?php echo $abaptran['TCODE'] ?> Global Descriptions</div>
					<div class="card-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Language</th>
									<th>Description</th>
								</tr>
							</thead>
							<tbody>
                                <?php foreach ($tstc_desc_all as $tstc_desc_item) { ?>
                                <tr>
									<td>
										<!-- We high-light English and Germany text, since they are the most commonly used or reliable -->
                                                <?php if ($tstc_desc_item['SPRSL'] == ABAP_DB_CONST::LANGU_EN || $tstc_desc_item['SPRSL'] == ABAP_DB_CONST::LANGU_DE) { ?>
                                                    <span
										class="badge badge-warning">
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
					<!-- end card-body -->
				</div>
                    <?php } ?>

                </div>
			<!-- Main Content: End -->

			<!-- Site Panel: Begin -->
			<div class="col-sm-3">

				<!-- Where Using List -->
                <?php if (count($wil_list) > 0) { ?>
                <div class="card">
					<div class="card-header bg-warning"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4TranEx($abaptran['TCODE']) ?> is Using ABAP Object</div>
					<div class="card-body">
						<table class="table table-hover">
							<tbody>
                                    <?php foreach ($wil_list as $item) { ?>
                                        <tr>
									<td><?php echo GLOBAL_ABAP_ICON::getIcon4Otype($item[SITE_UI_CONST::KEY_ABAP_OBJTYPE], TRUE) ?>
                                                <a
										href="<?php echo $item[SITE_UI_CONST::KEY_URL] ?>"
										title="<?php echo $item[SITE_UI_CONST::KEY_CAPTION] ?>"
										target="_blank">
                                                    <?php echo $item[SITE_UI_CONST::KEY_LABEL] ?></a></td>
									<td class="text-right"><a
										href="<?php echo $item[SITE_UI_CONST::KEY_URL] ?>"
										title="<?php echo $item[SITE_UI_CONST::KEY_CAPTION] ?>"
										target="_blank"><span class="label label-success"><?php echo number_format($item[SITE_UI_CONST::KEY_VALUE]) ?></span></a></td>
								</tr>
                                    <?php } ?>
                                </tbody>
						</table>
					</div>
					<!-- End card-body -->
				</div>
				<br />
                    <?php } ?>

                <!-- Where Used List -->
                <?php if (count($wul_list) > 0) { ?>
                <div class="card">
					<div class="card-header bg-warning"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4TranEx($abaptran['TCODE']) ?> is Used by ABAP Object</div>
					<div class="card-body">
						<table class="table table-hover">
							<tbody>
                            <?php foreach ($wul_list as $item) { ?>
                                        <tr>
									<td><?php echo GLOBAL_ABAP_ICON::getIcon4Otype($item[SITE_UI_CONST::KEY_ABAP_OBJTYPE], TRUE) ?>
                                                <a
										href="<?php echo $item[SITE_UI_CONST::KEY_URL] ?>"
										title="<?php echo $item[SITE_UI_CONST::KEY_CAPTION] ?>"
										target="_blank">
                                                    <?php echo $item[SITE_UI_CONST::KEY_LABEL] ?></a></td>
									<td class="text-right"><a
										href="<?php echo $item[SITE_UI_CONST::KEY_URL] ?>"
										title="<?php echo $item[SITE_UI_CONST::KEY_CAPTION] ?>"
										target="_blank"><span class="label label-success"><?php echo number_format($item[SITE_UI_CONST::KEY_VALUE]) ?></span></a></td>
								</tr>
                            <?php } ?>
                            </tbody>
						</table>
					</div>
					<!-- End card-body -->
				</div>
				<br />
                    <?php } ?>

                    <!-- TCodes by Each Module -->
                    <?php require $__ROOT__ . '/include/site/site_ui_side_module.php' ?>

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
<?php
foreach ( $analytics_list as $analytics ) {
	if (is_array ( $analytics [ABAP_UI_TCODES_Navigation::KEY_ARRAY_DATA] ) && $analytics [SITE_UI_CONST::KEY_VALUE] > 20) {
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
