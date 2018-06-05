<?php
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__ROOT__ . '/include/erd.php');
require_once ($__ROOT__ . '/include/site_tables_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$table_name = $fbk_table_name;
$table_desc = ABAP_DB_TABLE_TABL::DD02T($table_name);

$uri_erd_pdf = SITE_TABLES_UI_CONST::uri_table_erd_pdf($table_name);
$uri_erd_png = SITE_TABLES_UI_CONST::uri_table_erd_png($table_name);

$title = 'SAP ABAP Table ' . $table_name . ' (' . $table_desc .  ')'
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title ?><?php echo GLOBAL_WEBSITE::SAP_TABLES_ORG_TITLE ?></title>
        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
    </head>
    <body>

        <div class="container-fluid">
            <h2 class="pt-4">ABAP Table <code><abbr title="<?php echo htmlentities($table_desc) ?>"><?php echo $table_name ?></abbr></code> <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::TABL_NAME, $table_name, NULL, FALSE) ?><br><small></small></h2>
        
            <!-- The E-R file, the text area bellow is invisible, for debugging purpose only -->
            <textarea  class="d-none" readonly rows="16" cols="100">
                <?php
                $erd = new ERD(ERD_Format::png, $table_name);
                echo $erd->process();
                ?>
            </textarea>

            <h4 class="pt-4">The E-R Diagram</h4>
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link bg-light" target="_blank"
                       href="<?php echo $uri_erd_png ?>">
                        <img src="https://www.sapdatasheet.org/abap/icon/s_wdvimg.gif"> View Full Image</a></li>
                <li class="nav-item">
                    <a class="nav-link bg-light" target="_blank"
                       href="<?php echo $uri_erd_pdf ?>">
                        <img src="https://www.sapdatasheet.org/abap/icon/s_x__pdf.gif"> View in PDF</a></li>
            </ul>
            
            <div class="pt-2">
            <?php if (count(ABAP_DB_TABLE_TABL::DD08L_Erd($table_name)) < 1) { ?>
                <div class="alert alert-warning" role="alert">
                    The table <code><?php echo $table_name ?></code> does not have foreign key table.
                </div>
            <?php } ?>
                
                <img class="img-fluid img-thumbnail mx-auto d-block"
                     src="<?php echo $uri_erd_png ?>"
                     alt="Entity Relationship Diagram for Table Foreign Key">
            </div>
        </div>

        <br><br><br><br>
    </body>
</html>

