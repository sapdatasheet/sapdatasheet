<?php
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__ROOT__ . '/include/erd.php');
require_once ($__ROOT__ . '/include/site_tables_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$table_name = 'BKPF';

$query_pdf = array(
    SITE_TABLES_UI_CONST::HTTP_GET_TABLE => $table_name,
    SITE_TABLES_UI_CONST::HTTP_GET_FORMAT => ERD_Format::pdf,
);
$query_png = array(
    SITE_TABLES_UI_CONST::HTTP_GET_TABLE => $table_name,
    SITE_TABLES_UI_CONST::HTTP_GET_FORMAT => ERD_Format::png,
);

$title = 'ABAP Table Foreign Key'
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title ?></title>
        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
    </head>
    <body>

        <h1 class="pt-2"><?php echo $title ?></h1>

        <div class="container">
            <h2>The E-R file</h2>
            <textarea readonly rows="16" cols="100">
                <?php
                $erd = new ERD(ERD_Format::png, $table_name);
                echo $erd->process();
                ?>
            </textarea>

            <h2 class="pt-4">The E-R Diagram for ABAP Table</h2>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link bg-light" target="_blank"
                       href="/table/table-erd.php?<?php echo http_build_query($query_png) ?>">
                        <img src="https://www.sapdatasheet.org/abap/icon/s_wdvimg.gif"> View Full Image</a></li>
                <li class="nav-item">
                    <a class="nav-link bg-light" target="_blank"
                       href="/table/table-erd.php?<?php echo http_build_query($query_pdf) ?>">
                        <img src="https://www.sapdatasheet.org/abap/icon/s_x__pdf.gif"> View in PDF</a></li>
            </ul>

            <div class="pt-4">
                <img class="img-fluid img-thumbnail mx-auto d-block"
                     src="/table/table-erd.php?<?php echo http_build_query($query_png) ?>"
                     alt="Entity Relationship Diagram for Table Foreign Key">
            </div>
        </div>

        <br><br><br><br>
    </body>
</html>

