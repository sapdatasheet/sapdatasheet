<!DOCTYPE html>
<!-- DDIC Domain object. -->
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/global.php');
require_once ($__ROOT__ . '/include/abap_db.php');
require_once ($__ROOT__ . '/include/abap_ui.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

if (!isset($ObjID)) {
    $ObjID = filter_input(INPUT_GET, 'id');
}

if (empty($ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$doma = ABAP_DB_TABLE_DOMA::DD01L(strtoupper($ObjID));
if (empty($doma['DOMNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}
$doma_desc = ABAP_DB_TABLE_DOMA::DD01T($doma['DOMNAME']);
$doma_datatype_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_CONST::DOMAIN_DATATYPE, $doma['DATATYPE']);
$doma_vall = ABAP_DB_TABLE_DOMA::DD07L($doma['DOMNAME']);
$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_CONST::TADIR_PGMID_R3TR, ABAP_OTYPE::DOMA_NAME, $doma['DOMNAME']);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::DOMA_DESC . ' ' . $doma['DOMNAME'];
?>

<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?> <?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::DOMA_DESC ?>,<?php echo $doma['DOMNAME'] ?>,<?php echo $doma_desc ?>" />
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
            <h5>Object Hierarchy</h5>
            <table class="content_obj">
                <tbody>
                    <tr><td>Software Component</td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Application Component ID</td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Package </td></tr>
                    <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                    <tr><td class="left_attribute"> Object type </td></tr>
                    <tr><td class="left_value"><a href="/abap/doma/"><?php echo ABAP_OTYPE::DOMA_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $doma_desc ?>"><?php echo $doma['DOMNAME'] ?></a> </td></tr>
                </tbody>
            </table>
            <?php if (strlen(trim($doma['ENTITYTAB'])) > 0) { ?>
                <h5>Relationship</h5>
                <table class="content_obj">
                    <tbody>
                        <tr><td>Value table</td></tr>
                        <tr><td class="left_value"><?php echo ABAP_Navigation::GetURLTable($doma['ENTITYTAB'], '') ?>&nbsp;</td></tr>
                    </tbody>
                </table>
            <?php } ?>

            <!-- Google Adsense: left -->
            <h5>&nbsp;</h5>
            <div>
                <?php include $__ROOT__ . '/include/google/adsense-left.html' ?>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/">Home page</a> &gt; 
                <a href="/abap/">ABAP Object</a> &gt; 
                <a href="/abap/doma/">Domain</a> &gt; 
                <a href="#"><?php echo $doma['DOMNAME'] ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <h4> Basic Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Domain Name       </td><td class="field"> <?php echo ABAP_Navigation::GetURLDomain($doma['DOMNAME'], $doma_desc) ?> </td></tr>
                        <tr><td class="content_label"> Short Description </td><td class="field"> <?php echo htmlentities($doma_desc) ?> &nbsp;</td></tr>
                    </tbody>
                </table>

                <h4> Definition </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Data Type          </td><td class="field"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_CONST::DOMAIN_DATATYPE, $doma['DATATYPE'], $doma_datatype_desc) ?> </td><td> <?php echo $doma_datatype_desc ?> </td></tr>
                        <tr><td class="content_label"> No. Characters     </td><td class="field_right"><?php echo intval($doma['LENG']) ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Decimal Places     </td><td class="field_right"><?php echo ABAP_UI_TOOL::ClearZero(intval($doma['DECIMALS'])) ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Output Length      </td><td class="field_right"><?php echo intval($doma['OUTPUTLEN']) ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Conversion Routine </td><td class="field"><?php echo $doma['CONVEXIT'] ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Sign               </td><td class="right"><?php echo ABAP_UI_TOOL::GetCheckBox('SIGNFLAG', $doma['SIGNFLAG']) ?></td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Lower Case         </td><td class="right"><?php echo ABAP_UI_TOOL::GetCheckBox('LOWERCASE', $doma['LOWERCASE']) ?></td><td>&nbsp;</td></tr>
                    </tbody>
                </table>

                <?php
                if (strlen(trim($doma['ENTITYTAB'])) > 0) {
                    $entitytab_desc = ABAP_DB_TABLE_TABL::DD02T($doma['ENTITYTAB']);
                    ?>
                    <h4> Value Table</h4>
                    <table class="content_obj">
                        <tbody>
                            <tr><td class="content_label"> Value Table </td>
                                <td class="field"> <?php echo ABAP_Navigation::GetURLTable($doma['ENTITYTAB'], $entitytab_desc) ?> &nbsp; </td>
                                <td><?php echo $entitytab_desc ?></td> </tr>
                        </tbody>
                    </table>
                <?php } ?>

                <?php if (mysqli_num_rows($doma_vall) > 0) { ?>
                    <h4>Value Range</h4>
                    <a id="<?php echo ABAP_UI_TOOL::ANCHOR_VALUES ?>"></a>
                    <table class="alv">
                        <tbody>
                            <tr><th class="alv">#</th>
                                <th class="alv">Lower Limit</th> 
                                <th class="alv">Upper Limit</th> 
                                <th class="alv">Short Description</th> </tr>
                            <?php
                            while ($doma_vall_item = mysqli_fetch_array($doma_vall)) {
                                $doma_vall_item_text = ABAP_DB_TABLE_DOMA::DD07T($doma['DOMNAME'], $doma_vall_item['DOMVALUE_L']);
                                ?>
                                <tr><td class="alv_center"> <?php echo intval($doma_vall_item['VALPOS']) ?> </td>
                                    <td class="alv_right"> <?php echo $doma_vall_item['DOMVALUE_L'] ?> &nbsp; </td>
                                    <td class="alv_right"> <?php echo $doma_vall_item['DOMVALUE_H'] ?> &nbsp; </td>
                                    <td class="alv"><?php echo htmlentities($doma_vall_item_text) ?></td> </tr>
                            <?php } ?>
                            <tr><td class="alv_center"> &nbsp; </td>
                                <td class="alv_right">  &nbsp; </td>
                                <td class="alv_right">  &nbsp; </td>
                                <td class="alv"> &nbsp; </td> </tr>
                        </tbody>
                    </table>
                <?php } ?>

                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $doma['AS4USER'] ?>&nbsp;</td><td> <?php echo $doma['AS4DATE'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td><td> <?php echo $hier->DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component   </td><td class="field"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;(<?php echo $hier->FCTR_ID ?>)</td><td> <?php echo $hier->POSID_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Package                 </td><td class="field"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?>&nbsp;</td><td> <?php echo $hier->DEVCLASS_T ?>&nbsp;</td></tr>
                    </tbody>
                </table>

            </div>
        </div><!-- Content: End -->

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
