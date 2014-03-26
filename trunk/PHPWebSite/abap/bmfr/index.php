<!DOCTYPE html>
<!-- Application component index. -->
<?php
require_once '../../include/global.php';
require_once '../../include/abap_db.php';
require_once '../../include/abap_ui.php';

$GLOBALS['TITLE_TEXT'] = "SAP ABAP " . ABAP_OTYPE::BMFR_DESC;

$index = filter_input(INPUT_GET, 'index');;
if (empty($index)) {
    $index = ABAP_DB_CONST::INDEX_TOP;
} else {
    $index = strtoupper($index);
}
$bmfr = ABAP_DB_TABLE_HIER::DF14L_List($index);
?>
<html>
    <head>
        <link rel="stylesheet" href="../../abap.css" type="text/css" >
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,ABAP,<?php echo ABAP_OTYPE::BMFR_DESC ?>">
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
                <a href="/abap/bmfr/"><?php echo ABAP_OTYPE::BMFR_DESC ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span>SAP ABAP <?php echo ABAP_OTYPE::BMFR_DESC ?></span></div>
            <div class="content_obj">

                <div>
                    <a href="index.php?index=top">Top</a>&nbsp;
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
                </div>

                <h4> <?php echo ABAP_OTYPE::BMFR_DESC ?> - <?php echo $index ?></h4>
                <table class="alv">
                    <tr>
                        <th class="alv"> Application Component ID </th>
                        <th class="alv"> Short Description </th>
                        <th class="alv"> First Release Date </th>
                        <th class="alv"> First Release </th>
                        <th class="alv"> Application Component </th></tr>
                    <?php
                    while ($row = mysqli_fetch_array($bmfr)) {
                        $bmfr_desc = ABAP_DB_TABLE_HIER::DF14T($row['FCTR_ID']);
                        ?>
                        <tr><td class="alv"><?php echo ABAP_Navigation::GetURLAppComp($row['FCTR_ID'], $row['PS_POSID'], $bmfr_desc); ?> </td>
                            <td class="alv"><?php echo $bmfr_desc ?></td>
                            <td class="alv"><?php echo $row['FSTDATE'] ?></td>
                            <td class="alv"><?php echo $row['RELE'] ?></td>
                            <td class="alv"><?php echo $row['FCTR_ID'] ?></td></tr>
                        <?php } ?>
                </table>

            </div>
        </div><!-- Content: End -->        

        <!-- Footer -->
        <?php include '../../include/footer.html' ?>

    </body>
</html>
