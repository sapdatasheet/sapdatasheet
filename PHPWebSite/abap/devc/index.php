<!DOCTYPE html>
<!-- Package index. -->
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::DEVC_DESC;

$index = filter_input(INPUT_GET, 'index');
if (empty($index)) {
    $index = ABAP_DB_CONST::INDEX_A;
} else {
    $index = strtoupper($index);
}
$devc = ABAP_DB_TABLE_HIER::TDEVC_List($index);
?>

<html>
    <head>
        <link rel="stylesheet" href="../../abap.css" type="text/css" >
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::DEVC_DESC ?>">
        <meta name="description" content="<?php echo WEBSITE::META_DESC ?>">
        <meta name="author" content="SAP Datasheet">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    </head>
    <body>

        <!-- Header -->
        <?php require '../../include/header.php' ?>

        <!-- Left -->
        <?php require '../../include/abap_index_left.php' ?>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/devc/"><?php echo ABAP_OTYPE::DEVC_DESC ?></a> 
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">

                <div>
                    <a href="index.php?index=a">A</a>&nbsp;
                    <a href="index.php?index=b">B</a>&nbsp;
                    <a href="index.php?index=c">C</a>&nbsp;
                    <a href="index.php?index=d">D</a>&nbsp;
                    <a href="index.php?index=e">E</a>&nbsp;
                    <a href="index.php?index=f">F</a>&nbsp;
                    <a href="index.php?index=g">G</a>&nbsp;
                    <a href="index.php?index=h">H</a>&nbsp;
                    <a href="index.php?index=i">I</a>&nbsp;
                    <a href="index.php?index=j">J</a>&nbsp;
                    <a href="index.php?index=k">K</a>&nbsp;
                    <a href="index.php?index=l">L</a>&nbsp;
                    <a href="index.php?index=m">M</a>&nbsp;
                    <a href="index.php?index=n">N</a>&nbsp;
                    <a href="index.php?index=o">O</a>&nbsp;
                    <a href="index.php?index=p">P</a>&nbsp;
                    <a href="index.php?index=q">Q</a>&nbsp;
                    <a href="index.php?index=r">R</a>&nbsp;
                    <a href="index.php?index=s">S</a>&nbsp;
                    <a href="index.php?index=t">T</a>&nbsp;
                    <a href="index.php?index=u">U</a>&nbsp;
                    <a href="index.php?index=v">V</a>&nbsp;
                    <a href="index.php?index=w">W</a>&nbsp;
                    <a href="index.php?index=x">X</a>&nbsp;
                    <a href="index.php?index=/">/</a>&nbsp;
                </div>

                <h4> <?php echo ABAP_OTYPE::DEVC_DESC ?> - <?php echo $index ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> <?php echo ABAP_OTYPE::DEVC_DESC ?> </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> Super package </th>
                        <th class="alv"> <?php echo ABAP_OTYPE::CVERS_DESC ?> </th>
                        <th class="alv"> <?php echo ABAP_OTYPE::BMFR_DESC ?> </th>
                    </tr>
                    <?php
                    foreach ($devc as $row) {
                        $devc_desc = ABAP_DB_TABLE_HIER::TDEVCT($row['DEVCLASS']);
                        $devc_ps_posid = ABAP_DB_TABLE_HIER::DF14L_PS_POSID($row['COMPONENT']);
                        ?>
                        <tr><td class="alv"><?php echo ABAP_Navigation::GetURLPackage($row['DEVCLASS'], $devc_desc) ?> </td>
                            <td class="alv"><?php echo $devc_desc ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLPackage($row['PARENTCL'], '') ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLSoftComp($row['DLVUNIT'], '') ?></td>
                            <td class="alv"><?php echo ABAP_Navigation::GetURLAppComp($row['COMPONENT'], $devc_ps_posid, '') ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php include '../../include/footer.html' ?>

    </body>
</html>
