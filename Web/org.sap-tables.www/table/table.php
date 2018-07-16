<?php
$__WS_ROOT__ = dirname(__FILE__, 3);
$__ROOT__ = dirname(__FILE__, 2);

require_once ($__WS_ROOT__ . '/common-php/library/erd.php');
require_once ($__WS_ROOT__ . '/common-php/library/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

$table_name = $fbk_table_name;
$table_desc = ABAP_DB_TABLE_TABL::DD02T($table_name);

$uri_erd_pdf = ABAP_UI_TABLES_Navigation::uri_table_erd_pdf($table_name);
$uri_erd_png = ABAP_UI_TABLES_Navigation::uri_table_erd_png($table_name);

$title = 'SAP ABAP Table ' . $table_name . ' (' . $table_desc . ')';
$img_desc = ABAP_UI_TABLES_Navigation::desc_erd_png($table_name);

// Foreign Key tables
$dd08l_list = ABAP_DB_TABLE_TABL::DD08L_Erd($table_name);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <title><?php echo $title . GLOBAL_WEBSITE::SAP_TABLES_ORG_TITLE ?></title>
        <meta name="author" content="SAP Datasheet" />
        <meta name="description" content="<?php echo $title . GLOBAL_WEBSITE::SAP_TABLES_ORG_TITLE ?>" />
        <meta name="keywords" content="SAP,ABAP,<?php echo $table_name ?>,<?php echo $table_desc ?>" />

        <link rel="stylesheet" type="text/css"  href="/3rdparty/bootstrap/css/bootstrap.min.css"/>
    </head>
    <body>
        <div class="container-fluid bg-light">
            <div class="clearfix">
                <span class="float-left">
                    <h3 class="text-monospace pt-4">SAP ABAP Table <code><abbr title="<?php echo htmlentities($table_desc) ?>"><?php echo $table_name ?></abbr></code> 
                        <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::TABL_NAME, $table_name, NULL, FALSE) ?>
                        <small>{<?php echo $table_desc ?>}</small>
                    </h3>
                </span>
                <span class="float-right">
                    <ul class="nav pt-3">
                        <li class="nav-item"><a class="nav-link" href="/" title="Back to home page">Home</a></li>
                    </ul>                    
                </span>
            </div>            
            <hr>

            <!-- The E-R file, the text area bellow is invisible, for debugging purpose only -->
            <textarea  class="d-none" readonly rows="16" cols="100">
                <?php
                $erd = new ERD(ERD_Format::png, $table_name);
                echo $erd->process();
                ?>
            </textarea>
        </div>

        <main class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <!-- Adver Here -->
                    <div class="bg-light" title="Advertisement">
                        <?php include $__WS_ROOT__ . '/common-php/google/adsense-content-top.html' ?>
                    </div>

                    <ul class="nav nav-pills pt-2">
                        <li class="nav-item">
                            <a class="nav-link bg-light" target="_blank" href="<?php echo $uri_erd_png ?>">
                                <img src="https://www.sapdatasheet.org/abap/icon/s_wdvimg.gif"> View Full Image</a></li>&nbsp;&nbsp;
                        <li class="nav-item">
                            <a class="nav-link bg-light" target="_blank" href="<?php echo $uri_erd_pdf ?>">
                                <img src="https://www.sapdatasheet.org/abap/icon/s_x__pdf.gif"> View in PDF</a></li>
                    </ul>

                    <div class="pt-2">
                        <?php if (count(ABAP_DB_TABLE_TABL::DD08L_Erd($table_name)) < 1) { ?>
                            <div class="alert alert-warning" role="alert">
                                The table <code><?php echo $table_name ?></code> does not have foreign key table.
                            </div>
                        <?php } ?>

                        <a href="<?php echo $uri_erd_pdf ?>">
                            <img class="img-fluid img-thumbnail mx-auto d-block"
                                 src="<?php echo $uri_erd_png ?>"
                                 alt="<?php echo $img_desc ?>"
                                 title="<?php echo $img_desc ?>">
                        </a>
                    </div><!-- End Image -->
                </div><!-- End col left -->
                <div class="col-md-3">
                    <?php if (count($dd08l_list)) { ?>
                        <div class="card border-0">
                            <div class="card-body p-0">
                                <h5 class="pt-4">Foreign Key tables (<?php echo count($dd08l_list) ?>)</h5>
                                <ul class="list-group mt-0 ml-0 pt-0 pl-0">
                                    <?php
                                    foreach ($dd08l_list as $dd08l_item) {
                                        $checktable_desc = ABAP_DB_TABLE_TABL::DD02T($dd08l_item['CHECKTABLE']);
                                        $checktable_desc_brackets = (empty(trim($checktable_desc))) ? '' : ' {' . $checktable_desc . '}';
                                        $checktable_hint = 'ABAP Table ' . $dd08l_item['CHECKTABLE'] . $checktable_desc_brackets;
                                        ?>
                                        <li class="list-group-item list-group-item-action text-monospace border-0"
                                            title="<?php echo $checktable_hint ?>">
                                                <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL(TRUE) ?>
                                            <a href="<?php echo ABAP_UI_TABLES_Navigation::url_table($dd08l_item['CHECKTABLE']) ?>">
                                                <span class="text-danger"><?php echo $dd08l_item['CHECKTABLE'] ?></span></a>
                                                <?php echo ABAP_UI_DS_Navigation::GetObjectHyperlink4DS(GLOBAL_ABAP_OTYPE::TABL_NAME, $dd08l_item['CHECKTABLE'], NULL, FALSE) ?>
                                                <?php echo $checktable_desc_brackets ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div></div>
                    <?php } ?>

                    <!-- TODO: Add Used By Table List (top 10 only) -->
                    <!-- TODO: Add TCode Books links -->
                </div><!-- End col right -->
            </div>

            <br><br><br><br>
        </main>

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>
    </body>
</html>

