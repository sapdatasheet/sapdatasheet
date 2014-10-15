<?php
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
require_once (__ROOT__ . '/include/global.php');
require_once (__ROOT__ . '/include/abap_db.php');
require_once (__ROOT__ . '/include/abap_ui.php');

// Get Index
if (!isset($index)) {
    if (php_sapi_name() == 'cli') {
        $index = $argv[1];
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
$ob_fname = dirname(__FILE__) . "/index-" . strtolower($index) . ".html";
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
<!-- Program index -->
<?php
$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::PROG_DESC . " - Index " . $index . " ";

if ($index === ABAP_DB_CONST::INDEX_SLASH) {
    $index = '/';
}
$prog_list = ABAP_DB_TABLE_HIER::TADIR_PROG_List($index);
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::PROG_DESC ?>" />
        <meta name="description" content="<?php echo WEBSITE::META_DESC ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <!-- Header -->
        <?php require __ROOT__ . '/include/header.php' ?>

        <!-- Left -->
        <?php require __ROOT__ . '/include/abap_index_left.php' ?>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/prog/"><?php echo ABAP_OTYPE::PROG_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">        

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
                    <a href="index-slash.html">/</a>&nbsp;
                </div>

                <h4> <?php echo ABAP_OTYPE::PROG_DESC ?> - <?php echo $index ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> Program </th>
                        <th class="alv"> Package </th>
                        <th class="alv"> Software Component </th>
                        <th class="alv"> Short Description </th>
                    </tr>
                    <?php
                    while ($prog = mysqli_fetch_array($prog_list)) {
                        $prog_desc = ABAP_DB_TABLE_PROG::TRDIRT($prog['OBJ_NAME']);
                        ?>
                        <tr><td class="alv"><?php echo ABAP_Navigation::GetURLProgram($prog['OBJ_NAME'], '') ?> </td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLPackage($prog['DEVCLASS'], '') ?> </td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLSoftComp($prog['COMPONENT'], '') ?>&nbsp;</td>
                            <td class="alv"><?php echo htmlspecialchars($prog_desc) ?> &nbsp; </td>
                        </tr>
                    <?php } ?>
                </table>                

            </div>
        </div><!-- Content: End -->        
                
        <!-- Footer -->
        <?php include __ROOT__ . '/include/footer.html' ?>

    </body>
</html>
<?php
$ob_content = ob_get_contents();
ob_end_flush();
file_put_contents($ob_fname, $ob_content);

// Make default index file
if ($index === ABAP_DB_CONST::INDEX_A) {
    $ob_fname = dirname(__FILE__) . "/index.html";
    file_put_contents($ob_fname, $ob_content);
}       
?>
