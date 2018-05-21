<!DOCTYPE html>
<?php
$__ROOT__ = dirname(__FILE__);
require_once ($__WS_ROOT__ . '/common-php/library/global.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_db.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
require_once ($__ROOT__ . '/include/site/site_global.php');
require_once ($__ROOT__ . '/include/site/site_ui.php');

GLOBAL_UTIL::UpdateSAPDescLangu();

$search = 'SAP TCode Analytics';
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
        <!-- Load Scripts -->
        <script src="/include/3rdparty/d3/d3.min.js"></script>
        <script src="d3bubblechart.js"></script>

        <!-- Navigation bar -->
        <?php require $__ROOT__ . '/include/site/site_ui_nav.php' ?>

        <div class="container-fluid">
            <div class="jumbotron">
                <h1><?php echo SITE_GLOBAL::NAME ?></h1>      
                <p><?php echo SITE_GLOBAL::DESC ?>; 
                    Analytic on SAP TCodes by Module, by Component, by Name; Download SAP TCode Books and Sheets.
                </p>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <h3><a href="/analytics/module/">TCodes Analytics by Module</a></h3>
                    <p>SAP TCodes analytics by Application Modules, examples:
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?> <a href="/analytics/module/fi.html" target="_blank">FI (Financial Accounting)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?> <a href="/analytics/module/co.html" target="_blank">CO (Controlling)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?> <a href="/analytics/module/sd.html" target="_blank">SD (Sales and Distribution)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?> <a href="/analytics/module/mm.html" target="_blank">MM (Materials Management)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?> <a href="/analytics/module/pp.html" target="_blank">PP (Production Planning and Control)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?> <a href="/analytics/module/bc.html" target="_blank">BASIS (Basis Components)</a>, 
                        etc.
                    </p>
                </div>
                <div class="col-sm-4">
                    <h3><a href="/analytics/module/">TCodes Analytics by Component</a></h3>
                    <p>SAP TCodes analytics by Software Components, examples: 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?> <a href="/analytics/component/sap_appl.html" target="_blank">SAP_APPL (Logistics and Accounting)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?> <a href="/analytics/component/sap_fin.html" target="_blank">SAP_FIN (SAP Financial)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?> <a href="/analytics/component/sap_hr.html" target="_blank">SAP_HR (Human Resources)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?> <a href="/analytics/component/sap_bw.html" target="_blank">SAP_BW (SAP Business Warehouse)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?> <a href="/analytics/component/sap_basis.html" target="_blank">SAP_BASIS (SAP Basis Component)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?> <a href="/analytics/component/sap_ap.html" target="_blank">SAP_AP (SAP Application Platform)</a>, 
                        etc.
                    </p>
                </div>
                <div class="col-sm-4">
                    <h3><a href="/analytics/module/">TCodes Analytics by Name</a></h3>
                    <p>SAP TCodes analytics by TCode Name, examples: 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4NamePrefix(TRUE) ?> <a href="/analytics/name//sapsll/.html" target="_blank">/SAPSLL/ (SAP Global Trade Services)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4NamePrefix(TRUE) ?> <a href="/analytics/name//sapsrm/.html" target="_blank">/SAPSRM/ (SAP Customer Relationship Management)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4NamePrefix(TRUE) ?> <a href="/analytics/name/bc.html" target="_blank">BC (SAP Business Partner)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4NamePrefix(TRUE) ?> <a href="/analytics/name/se.html" target="_blank">SE (SAP ABAP Development)</a>, 
                        <?php echo GLOBAL_ABAP_ICON::getIcon4NamePrefix(TRUE) ?> <a href="/analytics/name/co.html" target="_blank">CO (SAP Production Order)</a>, 
                        etc.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <h3><a href="/download/book/">Download SAP TCode Books</a></h3>
                    <p>Download SAP TCodes Books for each module, examples:
                        <?php echo GLOBAL_ABAP_ICON::getIcon4FilePDF(TRUE) ?>
                        <a href="/download/book/dist/SAP-TCodes_Module_BC-EN.pdf" target="_blank">SAP-TCodes_Module_BC-EN.pdf (Basis Components)</a>,
                        <?php echo GLOBAL_ABAP_ICON::getIcon4FilePDF(TRUE) ?>
                        <a href="/download/book/dist/SAP-TCodes_Module_CO-EN.pdf" target="_blank">SAP-TCodes_Module_CO-EN.pdf (Controlling)</a>,
                        <?php echo GLOBAL_ABAP_ICON::getIcon4FilePDF(TRUE) ?>
                        <a href="/download/book/dist/SAP-TCodes_Module_FI-EN.pdf" target="_blank">SAP-TCodes_Module_FI-EN.pdf (Financial Accounting)</a>,
                        <?php echo GLOBAL_ABAP_ICON::getIcon4FilePDF(TRUE) ?>
                        <a href="/download/book/dist/SAP-TCodes_Module_MM-EN.pdf" target="_blank">SAP-TCodes_Module_MM-EN.pdf (Materials Management)</a>,
                        <?php echo GLOBAL_ABAP_ICON::getIcon4FilePDF(TRUE) ?>
                        <a href="/download/book/dist/SAP-TCodes_Module_SD-EN.pdf" target="_blank">SAP-TCodes_Module_SD-EN.pdf (Sales and Distribution)</a>,
                        etc.
                    </p>
                </div>
                <div class="col-sm-4">
                    <h3><a href="/download/sheet/">Download SAP TCode Sheets</a></h3>
                    <p>Download SAP TCodes Sheets for each module, examples:
                        <?php echo GLOBAL_ABAP_ICON::getIcon4FileXLSX(TRUE) ?>
                        <a href="/download/sheet/dist/SAP-TCodes_Module_CA-EN.xlsx" target="_blank">SAP-TCodes_Module_CA-EN.xlsx (Cross-Application Components)</a>,
                        <?php echo GLOBAL_ABAP_ICON::getIcon4FileXLSX(TRUE) ?>
                        <a href="/download/sheet/dist/SAP-TCodes_Module_CO-EN.xlsx" target="_blank">SAP-TCodes_Module_CO-EN.xlsx (Controlling)</a>,
                        <?php echo GLOBAL_ABAP_ICON::getIcon4FileXLSX(TRUE) ?>
                        <a href="/download/sheet/dist/SAP-TCodes_Module_FI-EN.xlsx" target="_blank">SAP-TCodes_Module_FI-EN.xlsx (Financial Accounting)</a>,
                        <?php echo GLOBAL_ABAP_ICON::getIcon4FileXLSX(TRUE) ?>
                        <a href="/download/sheet/dist/SAP-TCodes_Module_CRM-EN.xlsx" target="_blank">SAP-TCodes_Module_CO-CRM.xlsx (Customer Relationship Management)</a>,
                        <?php echo GLOBAL_ABAP_ICON::getIcon4FileXLSX(TRUE) ?>
                        <a href="/download/sheet/dist/SAP-TCodes_Module_PY-EN.xlsx" target="_blank">SAP-TCodes_Module_PY-EN.xlsx (Payroll)</a>,
                        etc.
                    </p>
                </div>
                <div class="col-sm-4">&nbsp;</div>
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