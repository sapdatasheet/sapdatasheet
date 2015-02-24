<!DOCTYPE html>
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');
require_once ($__ROOT__ . '/include/abapana_db.php');

if (!isset($ObjID)) {
    $ObjID = filter_input(INPUT_GET, 'id');
}

if (empty($ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$ana_tran = ABAPANA_DB_TABLE::TRAN(strtoupper($ObjID));

if (empty($ana_tran['tcode'])) {
    ABAP_UI_TOOL::Redirect404();
}

$tran_desc = ABAP_DB_TABLE_TRAN::TSTCT($ana_tran['tcode']);
$program_desc = ABAP_DB_TABLE_PROG::TRDIRT($ana_tran['progname']);
$package_desc = ABAP_DB_TABLE_HIER::TDEVCT($ana_tran['package']);
$appcomp_desc = ABAP_DB_TABLE_HIER::DF14T($ana_tran['applfctr']);
$softcomp_desc = ABAP_DB_TABLE_HIER::CVERS_REF($ana_tran['softcomp']);
$calledtcode_desc = ABAP_DB_TABLE_TRAN::TSTCT($ana_tran['calledtcode']);
$calledview_desc = ABAP_DB_TABLE_VIEW::DD25T($ana_tran['calledview']);
$calledprogname_desc = ABAP_DB_TABLE_PROG::TRDIRT($ana_tran['calledprogname']);

$trans_progname = ABAPANA_DB_TABLE::TRAN_Rela('progname', $ana_tran['progname']);
$trans_package = ABAPANA_DB_TABLE::TRAN_Rela('package', $ana_tran['package']);
$trans_calledview = ABAPANA_DB_TABLE::TRAN_Rela('calledview', $ana_tran['calledview']);
$trans_calledtcode = ABAPANA_DB_TABLE::TRAN_Rela('calledtcode', $ana_tran['calledtcode']);
$trans_appcomp = ABAPANA_DB_TABLE::TRAN_Rela('applfctr', $ana_tran['applfctr']);

$GLOBALS['TITLE_TEXT'] = 'Analytics for SAP ' . ABAP_OTYPE::TRAN_DESC . ' ' . $ana_tran['tcode'] . ' ' . ABAP_UI_TOOL::CheckDesc($tran_desc);
?>

<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::TRAN_DESC ?>,<?php echo $ana_tran['tcode']; ?>,<?php echo $tran_desc ?>" />
        <meta name="description" content="<?php echo WEBSITE::META_DESC; ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

        <!-- Header -->
        <?php require $__ROOT__ . '/include/header.php' ?>

        <!-- Left -->
        <div class="left">
            <h5>&nbsp;</h5>
            <h5>Direct Relations</h5>
            <table class="content_obj">
                <tbody>
                    <tr><td>Software Component</td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLSoftComp($ana_tran['softcomp'], $softcomp_desc, TRUE) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Application Component ID</td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLAppComp($ana_tran['applfctr'], $ana_tran['applposid'], $appcomp_desc, TRUE) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Package </td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLPackage($ana_tran['package'], $package_desc, TRUE) ?></td></tr>
                    <tr><td class="left_attribute"> Object type </td></tr>
                    <tr><td class="left_value"><a href="/abap/tran/"><?php echo ABAP_OTYPE::TRAN_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $tran_desc ?>"><?php echo $ana_tran['tcode'] ?></a> </td></tr>
                </tbody>
            </table>

            <h5>Most Related &nbsp;</h5>

        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/tran/"><?php echo ABAP_OTYPE::TRAN_DESC ?></a> &gt; 
                <a href="#"><?php echo $ana_tran['tcode'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <h4> Basic Analysis </h4>
                <p>
                    Here is the analysis result for transaction code 
                    <?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['tcode'], $tran_desc, TRUE) ?>
                    <?php echo ABAP_UI_TOOL::CheckDesc($tran_desc) ?>:
                </p>
                <ul>
                    <?php if (!empty($ana_tran['progname'])) { ?>
                        <li>The transaction code <?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['tcode'], $tran_desc, TRUE) ?>
                            is based on program <strong><?php echo ABAP_Navigation::GetURLProgram($ana_tran['progname'], $program_desc, $ana_tran['progname'], TRUE) ?></strong>
                            <?php echo ABAP_UI_TOOL::CheckDesc($program_desc) ?>
                            <?php if (!empty($ana_tran['dypno'])) { ?>
                                , via screen number <strong><?php echo $ana_tran['dypno'] ?></strong>
                            <?php } ?>
                            <?php if (!empty($ana_tran['variant'])) { ?>
                                , with variant <strong><?php echo $ana_tran['variant'] ?></strong>
                            <?php } ?>
                        </li>
                    <?php } ?>
                    <?php if (!empty($ana_tran['package'])) { ?>
                        <li>The transaction code <?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['tcode'], $tran_desc, TRUE) ?>
                            is organized in package <strong><?php echo ABAP_Navigation::GetURLPackage($ana_tran['package'], $package_desc, TRUE) ?></strong>
                            <?php echo ABAP_UI_TOOL::CheckDesc($package_desc) ?>
                        </li>
                    <?php } ?>
                    <?php if (!empty($ana_tran['applfctr'])) { ?>
                        <li>The transaction code <?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['tcode'], $tran_desc, TRUE) ?>
                            is contained in application component <strong><?php echo ABAP_Navigation::GetURLAppComp($ana_tran['applfctr'], $ana_tran['applposid'], $appcomp_desc, TRUE) ?></strong>
                            <?php echo ABAP_UI_TOOL::CheckDesc($appcomp_desc) ?>
                        </li>
                    <?php } ?>
                    <?php if (!empty($ana_tran['softcomp'])) { ?>
                        <li>The transaction code <?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['tcode'], $tran_desc, TRUE) ?>
                            is delivered in software component <strong><?php echo ABAP_Navigation::GetURLSoftComp($ana_tran['softcomp'], $softcomp_desc, TRUE) ?></strong>
                            <?php echo ABAP_UI_TOOL::CheckDesc($softcomp_desc) ?>
                        </li>
                    <?php } ?>
                    <?php if (!empty($ana_tran['calledtcode'])) { ?>
                        <li>In fact, the transaction code <?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['tcode'], $tran_desc, TRUE) ?>
                            is calling another transaction code <strong><?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['calledtcode'], $calledtcode_desc, TRUE) ?></strong>
                            <?php echo ABAP_UI_TOOL::CheckDesc($calledtcode_desc) ?>
                        </li>
                    <?php } ?>
                    <?php if (!empty($ana_tran['calledview'])) { ?>
                        <li>The maintenance view <strong><?php echo ABAP_Navigation::GetURLView($ana_tran['calledview'], $calledview_desc, TRUE) ?></strong>
                            <?php echo ABAP_UI_TOOL::CheckDesc($calledview_desc) ?> will be started by the transaction code 
                            <?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['tcode'], $tran_desc, TRUE) ?>
                            <?php if (!empty($ana_tran['updateflag']) and strtoupper($ana_tran['updateflag']) === ABAP_DB_CONST::FLAG_TRUE) { ?>
                                , in <strong>UPDATE</strong> mode
                            <?php } else { ?>
                                , in <strong>DISPLAY</strong> mode
                            <?php } ?>
                        </li>
                    <?php } ?>
                    <?php if (!empty($ana_tran['calledviewc'])) { ?>
                        <li>The maintenance view cluster <strong><?php echo $ana_tran['calledviewc'] ?></strong>
                            will be started by the transaction code 
                            <?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['tcode'], $tran_desc, TRUE) ?>,
                            <?php if (!empty($ana_tran['updateflag']) and strtoupper($ana_tran['updateflag']) === ABAP_DB_CONST::FLAG_TRUE) { ?>
                                , in <strong>UPDATE</strong> mode
                            <?php } else { ?>
                                , in <strong>DISPLAY</strong> mode
                            <?php } ?>
                        </li>
                    <?php } ?>
                    <?php if (!empty($ana_tran['calledclass']) and ! empty($ana_tran['calledmethod'])) { ?>
                        <li>Start transaction code <?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['tcode'], $tran_desc, TRUE) ?>
                            will call class  <strong><?php echo $ana_tran['calledclass'] ?></strong> method <strong><?php echo $ana_tran['calledmethod'] ?></strong>
                            <?php if (!empty($ana_tran['calledprogname'])) { ?>
                                , which is contained in program <strong><?php echo ABAP_Navigation::GetURLProgram($ana_tran['calledprogname'], $calledprogname_desc, $ana_tran['calledprogname'], TRUE) ?></strong>
                                <?php echo ABAP_UI_TOOL::CheckDesc($calledprogname_desc) ?>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>

                <!-- Related tcode - Same Program name -->
                <?php if ($trans_progname != null && mysqli_num_rows($trans_progname) > 1) { ?>
                    <h4> Relations: Transaction codes with the same program 
                        <?php echo ABAP_Navigation::GetURLPackage($ana_tran['progname'], $package_desc, TRUE) ?>
                        as <?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['tcode'], $tran_desc, TRUE) ?>
                    </h4>
                    <table class="alv">
                        <caption class="right">&nbsp;</caption>
                        <thead>
                            <tr>
                                <th class="alv"> <img src='/abap/icon/s_b_pvre.gif'> </th>
                                <th class="alv"> T-Code </th>
                                <th class="alv"> Short Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $trans_count = 0;
                            while ($trans_item = mysqli_fetch_array($trans_progname)) {
                                $trans_count++;
                                $trans_item_desc = ABAP_DB_TABLE_TRAN::TSTCT($trans_item['tcode']);
                                ?>
                                <tr>
                                    <td class="alv"> <?php echo $trans_count ?> </td>
                                    <td class="alv"> <?php echo ABAP_Navigation::GetURLTransactionCode($trans_item['tcode'], $trans_item_desc, TRUE) ?> </td>
                                    <td class="alv"> <?php echo $trans_item_desc ?> </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>

                <h4> The following transaction codes contained in the same package 
                    <?php echo ABAP_Navigation::GetURLPackage($ana_tran['package'], $package_desc, TRUE) ?>
                    as <?php echo ABAP_Navigation::GetURLTransactionCode($ana_tran['tcode'], $tran_desc, TRUE) ?>
                </h4>


            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
