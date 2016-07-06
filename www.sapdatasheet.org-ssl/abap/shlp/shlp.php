<!DOCTYPE html>
<!-- Search Help object. -->
<?php
$__ROOT__ = dirname(dirname(dirname(__FILE__)));
require_once ($__ROOT__ . '/include/common/global.php');
require_once ($__ROOT__ . '/include/common/abap_db.php');
require_once ($__ROOT__ . '/include/common/abap_ui.php');
require_once ($__ROOT__ . '/include/common/schemaorg.php');
GLOBAL_UTIL::UpdateSAPDescLangu();

if (!isset($ObjID)) {
    $ObjID = filter_input(INPUT_GET, 'id');
}

if (empty($ObjID)) {
    ABAP_UI_TOOL::Redirect404();
}
$ObjID = strtoupper($ObjID);
$dd30l = ABAP_DB_TABLE_SHLP::DD30L(strtoupper($ObjID));
if (empty($dd30l['SHLPNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}

$dd30t = ABAP_DB_TABLE_SHLP::DD30T($dd30l['SHLPNAME']);
$dd30l_selmtype_t = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SHLP::DD30L_SELMTYPE_DOMAIN, $dd30l['SELMTYPE']);
$dd30l_selmethod_url = $dd30l['SELMETHOD'];
$dd30l_selmethod_t = '';
if ($dd30l['SELMTYPE'] == ABAP_DB_TABLE_SHLP::DD30L_SELMTYPE_T || $dd30l['SELMTYPE'] == ABAP_DB_TABLE_SHLP::DD30L_SELMTYPE_X) {
    $dd30l_selmethod_url = ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd30l['SELMETHOD'], '');
    $dd30l_selmethod_t = ABAP_DB_TABLE_TABL::DD02T($dd30l['SELMETHOD']);
} else if ($dd30l['SELMTYPE'] == ABAP_DB_TABLE_SHLP::DD30L_SELMTYPE_V || $dd30l['SELMTYPE'] == ABAP_DB_TABLE_SHLP::DD30L_SELMTYPE_H) {
    $dd30l_selmethod_url = ABAP_UI_DS_Navigation::GetHyperlink4View($dd30l['SELMETHOD'], '');
    $dd30l_selmethod_t = ABAP_DB_TABLE_VIEW::DD25T($dd30l['SELMETHOD']);
}
$dd30l_texttab_t = ABAP_DB_TABLE_TABL::DD02T($dd30l['TEXTTAB']);
$dd30l_selmexit_t = ABAP_DB_TABLE_FUNC::TFTIT($dd30l['SELMEXIT']);
$dd30l_DDSHDIATYP_t = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SHLP::DD30L_DIALOGTYPE_DOMAIN, $dd30l['DIALOGTYPE']);
$dd30l_AUTOSUGGEST_t = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SHLP::DD30L_AUTOSUGGEST_DOMAIN, $dd30l['AUTOSUGGEST']);
$dd30l_FUZZY_SEARCH_t = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SHLP::DD30L_FUZZY_SEARCH_DOMAIN, $dd30l['FUZZY_SEARCH']);

$dd31s_list = ABAP_DB_TABLE_SHLP::DD31S($dd30l['SHLPNAME']);
$dd32s_list = ABAP_DB_TABLE_SHLP::DD32S($dd30l['SHLPNAME']);
$dd33s_list = ABAP_DB_TABLE_SHLP::DD33S($dd30l['SHLPNAME']);

$wul_counter_list = ABAPANA_DB_TABLE::WULCOUNTER_List(GLOBAL_ABAP_OTYPE::SHLP_NAME, $dd30l['SHLPNAME']);
$wil_enabled = TRUE;
$wil_counter_list = ABAPANA_DB_TABLE::WILCOUNTER_List(GLOBAL_ABAP_OTYPE::SHLP_NAME, $dd30l['SHLPNAME']);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, GLOBAL_ABAP_OTYPE::SHLP_NAME, $ObjID);
$GLOBALS['TITLE_TEXT'] = ABAP_UI_TOOL::GetObjectTitle(GLOBAL_ABAP_OTYPE::SHLP_NAME, $ObjID);

$json_ld = new \OrgSchema\Thing();
$json_ld->name = $dd30l['SHLPNAME'];
$json_ld->alternateName = $dd30t;
$json_ld->description = $GLOBALS['TITLE_TEXT'];
$json_ld->image = GLOBAL_ABAP_ICON::getIconURL(GLOBAL_ABAP_ICON::OTYPE_SHLP, TRUE);
$json_ld->url = ABAP_UI_DS_Navigation::GetObjectURL(GLOBAL_ABAP_OTYPE::SHLP_NAME, $json_ld->name);
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] . GLOBAL_WEBSITE_SAPDS::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo GLOBAL_ABAP_OTYPE::SHLP_DESC ?>,<?php echo $ObjID ?>,<?php echo $dd30t ?>" />
        <meta name="description" content="<?php echo GLOBAL_WEBSITE_SAPDS::META_DESC; ?>" />
        <meta name="author" content="SAP Datasheet" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script type="application/ld+json"><?php echo $json_ld->toJson() ?></script>
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
                    <tr><td class="left_attribute">Software Component</td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() ?>
                        <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Application Component ID</td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
                        <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;</td></tr>
                    <tr><td class="left_attribute"> Package </td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() ?>
                        <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($hier->DEVCLASS, $hier->DEVCLASS_T) ?></td></tr>
                    <tr><td class="left_attribute"> Object type </td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeSHLP() ?>
                            <a href="/abap/shlp/"><?php echo GLOBAL_ABAP_OTYPE::SHLP_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeSHLP() ?>
                            <a href="#" title="<?php echo $dd30t ?>"><?php echo $ObjID ?></a> </td></tr>
                </tbody>
            </table>

            <?php require $__ROOT__ . '/include/abap_oname_wul.php' ?>
            <?php require $__ROOT__ . '/include/abap_relatedlinks.php' ?>
            <h5>&nbsp;</h5>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Content Navigator -->
            <div class="content_navi">
                <a href="/"><?php echo GLOBAL_ABAP_ICON::getIcon4Home() ?> Home page</a> &gt;
                <a href="/abap/">ABAP Object</a> &gt;
                <a href="/abap/shlp/"><?php echo GLOBAL_ABAP_OTYPE::SHLP_DESC ?></a> &gt;
                <a href="#"><?php echo $ObjID ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <?php require $__ROOT__ . '/include/abap_oname_hier.php' ?>

                <h4> Attribute </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Search Help </td>
                            <td class="field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Shlp($ObjID, $dd30t, FALSE); ?> </td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Short Description</td>
                            <td class="field"> <?php echo $dd30t ?> &nbsp;</td>
                            <td> &nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Package </td>
                            <td class="field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($hier->DEVCLASS, $hier->DEVCLASS_T); ?> </td>
                            <td> <?php echo $hier->DEVCLASS_T ?>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Flag if a search help is an elementary search help</td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox('ISSIMPLE', $dd30l['ISSIMPLE']) ?>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Existence of included search helps</td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox('ELEMEXI', $dd30l['ELEMEXI']) ?>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Flag if a search help has fields</td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox('NOFIELDS', $dd30l['NOFIELDS']) ?>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Flag if search help field assignment exists for search help</td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox('ATTACHEXI', $dd30l['ATTACHEXI']) ?>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Last Changed by</td>
                            <td class="field"><?php echo $dd30l['AS4USER'] ?>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Date of Last Change </td>
                            <td class="field"><?php echo $dd30l['AS4DATE'] ?>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Last changed at </td>
                            <td class="field"><?php echo $dd30l['AS4TIME'] ?>&nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                    </tbody>
                </table>

                <h4> Definition </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Selection Method Category</td>
                            <td class="field"> <?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_SHLP::DD30L_SELMTYPE_DOMAIN, $dd30l['SELMTYPE'], $dd30l_selmtype_t); ?> </td>
                            <td><?php echo $dd30l_selmtype_t ?> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Selection Method</td>
                            <td class="field"><?php echo $dd30l_selmethod_url ?>&nbsp;</td>
                            <td><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_SHLP::DD30L_SELMETHOD_DTEL, '?') ?> &nbsp;
                                <?php echo $dd30l_selmethod_t ?>&nbsp; 
                            </td>
                        </tr>
                        <tr><td class="content_label"> Text Table</td>
                            <td class="field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4Tabl($dd30l['TEXTTAB'], $dd30l_texttab_t) ?>&nbsp;</td>
                            <td><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_SHLP::DD30L_TEXTTAB_DTEL, '?') ?> &nbsp;
                                <?php echo $dd30l_texttab_t ?>&nbsp; 
                            </td>
                        </tr>
                        <tr><td class="content_label"> Dialog Type </td>
                            <td class="field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_SHLP::DD30L_DIALOGTYPE_DOMAIN, $dd30l['DIALOGTYPE'], $dd30l_DDSHDIATYP_t) ?>&nbsp;</td>
                            <td><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_SHLP::DD30L_DIALOGTYPE_DTEL, '?') ?> &nbsp;
                                <?php echo $dd30l_DDSHDIATYP_t ?> 
                            </td>
                        </tr>
                        <tr><td class="content_label"> Hot Key</td>
                            <td class="field"><?php echo $dd30l['AS4USER'] ?>&nbsp;</td>
                            <td><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_SHLP::DD30L_HOTKEY_DTEL, '?') ?>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Proposal Search for Input Fields </td>
                            <td class="field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_SHLP::DD30L_AUTOSUGGEST_DOMAIN, $dd30l['AUTOSUGGEST'], $dd30l_AUTOSUGGEST_t)  ?>&nbsp;</td>
                            <td><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_SHLP::DD30L_AUTOSUGGEST_DTEL, '?') ?>&nbsp; 
                                <?php echo $dd30l_AUTOSUGGEST_t ?>
                            </td>
                        </tr>
                        <tr><td class="content_label"> Full Text Fuzzy Search (Database-Specific) </td>
                            <td class="field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_SHLP::DD30L_FUZZY_SEARCH_DOMAIN, $dd30l['FUZZY_SEARCH'], $dd30l_FUZZY_SEARCH_t)  ?>&nbsp;</td>
                            <td><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_SHLP::DD30L_FUZZY_SEARCH_DTEL, '?') ?>&nbsp; 
                                <?php echo $dd30l_FUZZY_SEARCH_t ?>
                            </td>
                        </tr>
                        <tr><td class="content_label"> Accuracy Value for Error-Tolerant Full Text Search </td>
                            <td class="field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_SHLP::DD30L_FUZZY_SIMILARITY_DOMAIN, $dd30l['FUZZY_SIMILARITY'], $dd30l['FUZZY_SIMILARITY'])  ?>&nbsp;</td>
                            <td><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_SHLP::DD30L_FUZZY_SIMILARITY_DTEL, '?') ?>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Search Help Exit </td>
                            <td class="field"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4Func($dd30l['SELMEXIT'], $dd30l_selmexit_t) ?>&nbsp;</td>
                            <td><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument(ABAP_DB_TABLE_SHLP::DD30L_SELMEXIT_DTEL, '?') ?> &nbsp; 
                                <?php echo $dd30l_selmexit_t ?>&nbsp; 
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h4> Parameter </h4>
                <?php if (empty($dd32s_list) === FALSE) { ?>
                <table class="alv">
                    <tr>
                        <th class="alv"> # </th>
                        <th class="alv"> Search Help Parameter </th>
                        <th class="alv"> IMPORT Parameter </th>
                        <th class="alv"> EXPORT Parameter </th>
                        <th class="alv"> List Position </th>
                        <th class="alv"> Selection Position </th>
                        <th class="alv"> Selection Display </th>
                        <th class="alv"> Case Sensitive </th>
                        <th class="alv"> Data Element </th>
                        <th class="alv"> Default Type </th>
                        <th class="alv"> Default Value </th>
                    </tr>
                    <tr>
                        <th class="alv"> &nbsp; </th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('SHLPFIELD', '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('SHLPINPUT', '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('SHLPOUTPUT', '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('SHLPLISPOS', '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('SHLPSELPOS', '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('SHLPSELDIS', '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('MCNOUPPER', '?') ?></th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('SHLPSPARDE', '?') ?></th>
                        <th class="alv"> &nbsp; </th>
                        <th class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DtelDocument('DDSHDEFVAL', '?') ?></th>
                    </tr>
                    <?php
                    foreach ($dd32s_list as $dd32s) {
                        $dd32s_DEFAULTTYP_t = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SHLP::DD32S_DEFAULTTYP_DOMAIN, $dd32s['DEFAULTTYP']);
                        ?>
                        <tr><td class="alv" style="text-align: right;"><?php echo number_format($dd32s['FLPOSITION']) ?> </td>
                            <td class="alv"><?php echo GLOBAL_ABAP_ICON::getIcon4Parameter() ?>
                                <?php echo $dd32s['FIELDNAME'] ?></td>
                            <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox('SHLPINPUT', $dd32s['SHLPINPUT']) ?></td>
                            <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox('SHLPOUTPUT', $dd32s['SHLPOUTPUT']) ?></td>
                            <td class="alv"><?php echo $dd32s['SHLPLISPOS'] ?></td>
                            <td class="alv"><?php echo $dd32s['SHLPSELPOS'] ?></td>
                            <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox('SHLPSELDIS', $dd32s['SHLPSELDIS']) ?></td>
                            <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox('SHLPUPPER', $dd32s['SHLPUPPER']) ?></td>
                            <td class="alv"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDTEL() ?>
                                <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Dtel($dd32s['ROLLNAME'], '') ?></td>
                            <td class="alv"><?php echo ABAP_UI_DS_Navigation::GetHyperlink4DomainValue(ABAP_DB_TABLE_SHLP::DD32S_DEFAULTTYP_DOMAIN, $dd32s['DEFAULTTYP'], $dd32s_DEFAULTTYP_t) ?></td>
                            <td class="alv"><?php echo $dd32s['DEFAULTVAL'] ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <?php } else { ?>
                    <code>Search help <?php echo $ObjID ?> has no parameter.</code>
                <?php } ?>

                <h4> History </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $dd30l['AS4USER'] ?>&nbsp;</td><td> <?php echo $dd30l['AS4DATE'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <?php require $__ROOT__ . '/include/footer.php' ?>

    </body>
</html>
<?php
// Close PDO Database Connection
ABAP_DB_TABLE::close_conn();
