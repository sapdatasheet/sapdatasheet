<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

// Get Index
if (!isset($index)) {
    if (php_sapi_name() == 'cli') {
        $index = $argv[1];
        $GLOBALS[GLOBAL_UTIL::SAP_DESC_LANGU] = $argv[2];
    } else {
        $index = filter_input(INPUT_GET, 'index');
    }
}

if (strlen(trim($index)) == 0) {
    $index = ABAP_DB_CONST::INDEX_A;
} else {
    $index = strtoupper($index);
}

// Check Buffer
$ob_folder = GLOBAL_UTIL::GetObFolder(dirname(__FILE__));
$ob_fname = $ob_folder . "/index-" . strtolower($index) . ".html";
if (file_exists($ob_fname)) {
    $ob_file_content = file_get_contents($ob_fname);
    if ($ob_file_content !== FALSE) {
        echo $ob_file_content;
        exit();
    }
}
ob_start();
?>
<!DOCTYPE html>
<!-- Function Group index -->
<?php
$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . GLOBAL_ABAP_OTYPE::FUGR_DESC . " - Index " . $index . " ";

if ($index === ABAP_DB_CONST::INDEX_SLASH) {
    $index = '/';
}
$fugr_list = ABAP_DB_TABLE_HIER::TADIR_FUGR_List($index);
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo GLOBAL_ABAP_OTYPE::FUGR_DESC ?>" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

        <!-- Left -->
        <?php require $__ROOT__ . '/include/abap_index_left.php' ?>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/fugr/"><?php echo GLOBAL_ABAP_OTYPE::FUGR_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">        
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <div>
                    <a href="index-a.html">A</a>&nbsp;
                    <a href="index-b.html">B</a>&nbsp;
                    <a href="index-c.html">C</a>&nbsp;
                    <a href="index-d.html">D</a>&nbsp;
                    <a href="index-e.html">E</a>&nbsp;
                    <a href="index-f.html">F</a>&nbsp;
                    <a href="index-g.html">G</a>&nbsp;
                    <a href="index-h.html">H</a>&nbsp;
                    <a href="index-i.html">I</a>&nbsp;
                    <a href="index-j.html">J</a>&nbsp;
                    <a href="index-k.html">K</a>&nbsp;
                    <a href="index-l.html">L</a>&nbsp;
                    <a href="index-m.html">M</a>&nbsp;
                    <a href="index-n.html">N</a>&nbsp;
                    <a href="index-o.html">O</a>&nbsp;
                    <a href="index-p.html">P</a>&nbsp;
                    <a href="index-q.html">Q</a>&nbsp;
                    <a href="index-r.html">R</a>&nbsp;
                    <a href="index-s.html">S</a>&nbsp;
                    <a href="index-t.html">T</a>&nbsp;
                    <a href="index-u.html">U</a>&nbsp;
                    <a href="index-v.html">V</a>&nbsp;
                    <a href="index-w.html">W</a>&nbsp;
                    <a href="index-x.html">X</a>&nbsp;
                    <a href="index-0.html">0</a>&nbsp;
                    <a href="index-1.html">1</a>&nbsp;
                    <a href="index-2.html">2</a>&nbsp;
                    <a href="index-3.html">3</a>&nbsp;
                    <a href="index-4.html">4</a>&nbsp;
                    <a href="index-5.html">5</a>&nbsp;
                    <a href="index-6.html">6</a>&nbsp;
                    <a href="index-7.html">7</a>&nbsp;
                    <a href="index-8.html">8</a>&nbsp;
                    <a href="index-9.html">9</a>&nbsp;
                    <a href="index-slash.html">/</a>&nbsp;
                </div>

                <h4> <?php echo GLOBAL_ABAP_OTYPE::FUGR_DESC ?> - <?php echo $index ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv"> <?php echo GLOBAL_ABAP_OTYPE::FUGR_DESC ?> </th>
                        <th class="alv"> <?php echo GLOBAL_ABAP_OTYPE::DEVC_DESC ?> </th>
                        <th class="alv"> <?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?> </th>
                        <th class="alv"> Short Description </th>
                    </tr>
                    <tr>
                        <th class="alv"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_CONST::INDEX_SEQNO_DTEL, '?') ?></th>
                        <th class="alv"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_FUNC::TLIBG_AREA_DTEL, '?') ?></th>
                        <th class="alv"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_HIER::TDEVC_DEVCLASS_DTEL, '?') ?></th>
                        <th class="alv"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_HIER::CVERS_REF_DESC_TEXT_DTEL, '?') ?></th>
                        <th class="alv"> &nbsp; </th>
                    </tr>
                    <?php
                    $count = 0;
                    foreach ($fugr_list as $fugr) {
                        $count++;
                        $prog = ABAP_DB_TABLE_PROG::GET_PROG_FUGR($fugr['OBJ_NAME']);
                        $prog_desc = ABAP_DB_TABLE_FUNC::TLIBT($fugr['OBJ_NAME']);
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                            <td class="alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeFUGR() ?>
                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Prog($prog, '', $fugr['OBJ_NAME']) ?> </td>
                            <td class="alv"><?php echo (GLOBAL_UTIL::IsNotEmpty($fugr['DEVCLASS'])) ? GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() : '' ?>
                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($fugr['DEVCLASS'], '') ?> </td>
                            <td class="alv"><?php echo (GLOBAL_UTIL::IsNotEmpty($fugr['COMPONENT'])) ? GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() : '' ?>
                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($fugr['COMPONENT'], '') ?>&nbsp;</td>
                            <td class="alv"><?php echo htmlspecialchars($prog_desc) ?> &nbsp; </td>
                        </tr>
                    <?php } ?>
                </table>                

            </div>
        </div><!-- Content: End -->        
                
        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
file_put_contents($ob_fname, $ob_content);

// Make default index file
if ($index === ABAP_DB_CONST::INDEX_A) {
    $ob_fname = $ob_folder . "/index.html";
    file_put_contents($ob_fname, $ob_content);
}       

// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();