<!DOCTYPE html>
<!-- IMG Activity object. -->
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
$ObjID = strtoupper($ObjID);
$classdef = ABAP_DB_TABLE_SEO::SEOCLASSDF(strtoupper($ObjID));
if (empty($classdef['CLSNAME'])) {
    ABAP_UI_TOOL::Redirect404();
}

$exposure_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCLASSDF_EXPOSURE_DOMAIN, $classdef['EXPOSURE']);
$rstat_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCLASSDF_RSTAT_DOMAIN, $classdef['RSTAT']);
$category_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCLASSDF_CATEGORY_DOMAIN, $classdef['CATEGORY']);
$package_tx = ABAP_DB_TABLE_HIER::TDEVCT($classdef['CATEGORY']);

$class_tx = htmlentities(ABAP_DB_TABLE_SEO::SEOCLASSTX($ObjID));
$class_super = ABAP_DB_TABLE_SEO::SEOMETAREL_GetSuperClass($ObjID);
if (empty($class_super) === FALSE) {
    $class_super_tx = htmlentities(ABAP_DB_TABLE_SEO::SEOCLASSTX($class_super));
} else {
    $class_super_tx = '';
}

$typepls = ABAP_DB_TABLE_SEO::SEOTYPEPLS($ObjID);
$interfaces = ABAP_DB_TABLE_SEO::SEOMETAREL($ObjID, ABAP_DB_TABLE_SEO::SEOMETAREL_RELTYPE_1);
$friends = ABAP_DB_TABLE_SEO::SEOFRIENDS($ObjID);
$attributes = ABAP_DB_TABLE_SEO::SEOCOMPO($ObjID, ABAP_DB_TABLE_SEO::SEOCOMPO_CMPTYPE_0);
$methods = ABAP_DB_TABLE_SEO::SEOCOMPO($ObjID, ABAP_DB_TABLE_SEO::SEOCOMPO_CMPTYPE_1);
$events = ABAP_DB_TABLE_SEO::SEOCOMPO($ObjID, ABAP_DB_TABLE_SEO::SEOCOMPO_CMPTYPE_2);
$types = ABAP_DB_TABLE_SEO::SEOCOMPO($ObjID, ABAP_DB_TABLE_SEO::SEOCOMPO_CMPTYPE_3);

$hier = ABAP_DB_TABLE_HIER::Hier(ABAP_DB_TABLE_HIER::TADIR_PGMID_R3TR, ABAP_OTYPE::CLAS_NAME, $ObjID);
$GLOBALS['TITLE_TEXT'] = 'SAP ABAP ' . ABAP_OTYPE::CLAS_DESC . ' ' . $ObjID . ' - ' . $class_tx;
?>
<html>
    <head>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/abap.css" type="text/css" />
        <title><?php echo $GLOBALS['TITLE_TEXT'] ?><?php echo WEBSITE::TITLE ?> </title>
        <meta name="keywords" content="SAP,<?php echo ABAP_OTYPE::CLAS_DESC ?>,<?php echo $ObjID ?>,<?php echo $class_tx ?>" />
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
                    <tr><td class="left_value"><a href="/abap/clas/"><?php echo ABAP_OTYPE::CLAS_DESC ?></a></td></tr>
                    <tr><td class="left_attribute"> Object name </td></tr>
                    <tr><td class="left_value"> <a href="#" title="<?php echo $class_tx ?>"><?php echo $ObjID ?></a> </td></tr>
                </tbody>
            </table>

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
                <a href="/abap/clas/"><?php echo ABAP_OTYPE::CLAS_DESC ?></a> &gt;
                <a href="#"><?php echo $ObjID ?></a>
            </div>

            <!-- Content Object -->
            <div class="content_obj_title"><span><?php echo $GLOBALS['TITLE_TEXT'] ?></span></div>
            <div class="content_obj">
                <div>
                    <?php include $__ROOT__ . '/include/google/adsense-content-top.html' ?>
                </div>

                <!-- Optional: if the class has super class  -->
                <h4> Class Tree </h4>

                <h4> Properties </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Class </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLClass($ObjID, $class_tx, FALSE); ?> </td>
                            <td> &nbsp;</td>
                        </tr>
                        <tr><td class="content_label"> Short Description</td>
                            <td class="field"> <?php echo $class_tx ?> &nbsp;</td>
                            <td> &nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Super Class </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLClass($class_super, $class_super_tx); ?> </td>
                            <td> <?php echo $class_super_tx ?>&nbsp; </td>
                        </tr>
                        <!--
                        <tr><td class="content_label"> Super Class - Modeled only </td>
                            <td class="field"> &nbsp;</td>
                            <td> &nbsp; </td>
                        </tr>
                        -->
                        <tr><td class="content_label"> Instantiability of a Class</td>
                            <td class="field"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCLASSDF_EXPOSURE_DOMAIN, $classdef['EXPOSURE'], $exposure_tx); ?>&nbsp;</td>
                            <td><?php echo $exposure_tx ?>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Final </td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox("CLSFINAL", $classdef['CLSFINAL']) ?> &nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                    </tbody>
                </table>

                <h4> General Data </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Message Class </td>
                            <td class="field"> <?php echo $classdef['MSG_ID'] ?> &nbsp;</td>
                            <td> <?php echo '' ?>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Program status</td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCLASSDF_RSTAT_DOMAIN, $classdef['RSTAT'], $rstat_tx); ?>&nbsp;</td>
                            <td> <?php echo $rstat_tx ?>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Category </td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCLASSDF_CATEGORY_DOMAIN, $classdef['CATEGORY'], $category_tx); ?>&nbsp;</td>
                            <td> <?php echo $category_tx ?>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Package</td>
                            <td class="field"> <?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?> &nbsp;</td>
                            <td> <?php echo $hier->DEVCLASS_T ?>&nbsp; </td>
                        </tr>
                        <!--
                        <tr><td class="content_label"> Original Language </td>
                            <td class="field"> <?php echo '' ?> &nbsp;</td>
                            <td> <?php echo '' ?>&nbsp; </td>
                        </tr>
                        -->
                        <tr><td class="content_label"> Created </td>
                            <td class="field"> <?php echo $classdef['CREATEDON'] ?> &nbsp;</td>
                            <td> <?php echo $classdef['AUTHOR'] ?>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Last change </td>
                            <td class="field"> <?php echo $classdef['CHANGEDON'] ?> &nbsp;</td>
                            <td> <?php echo $classdef['CHANGEDBY'] ?>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Shared Memory-enabled </td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox("CLSSHAREDMEMORY", $classdef['CLSSHAREDMEMORY']) ?> &nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        <!-- Example: CX_WD_GENERAL
                        <tr><td class="content_label"> Constructor generated </td>
                            <td> &nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        -->
                        <tr><td class="content_label"> Fixed point arithmetic </td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox("FIXPT", $classdef['FIXPT']) ?> &nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                        <tr><td class="content_label"> Unicode checks active </td>
                            <td><?php echo ABAP_UI_TOOL::GetCheckBox("UNICODE", $classdef['UNICODE']) ?> &nbsp;</td>
                            <td>&nbsp; </td>
                        </tr>
                    </tbody>
                </table>

                <h4> Forward declarations </h4>
                <?php if (empty($typepls) === FALSE) { ?>
                    <table class="alv">
                        <tr>
                            <th class="alv"> # </th>
                            <th class="alv"> Type group / Object type </th>
                            <th class="alv"> Type </th>
                            <th class="alv"> Type Description</th>
                        </tr>
                        <?php
                        $count = 0;
                        foreach ($typepls as $typepl) {
                            $count++;
                            $typepl_type_desc = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOTYPEPLS_TPUTYPE_DOMAIN, $typepl['TPUTYPE']);
                            if ($typepl['TPUTYPE'] == ABAP_DB_TABLE_SEO::SEOTYPEPLS_TPUTYPE_1 || $typepl['TPUTYPE'] == ABAP_DB_TABLE_SEO::SEOTYPEPLS_TPUTYPE_2) {
                                $typepl_type = ABAP_Navigation::GetURLClass($typepl['TYPEGROUP'], NULL);
                            } else {
                                $typepl_type = $typepl['TYPEGROUP'];
                            }
                            ?>
                            <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                                <td class="alv"><?php echo $typepl_type ?></td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOTYPEPLS_TPUTYPE_DOMAIN, $typepl['TPUTYPE'], $typepl_type_desc) ?>&nbsp;</td>
                                <td class="alv"><?php echo $typepl_type_desc ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <code>Class <?php echo $ObjID ?> has no forward declaration.</code>
                <?php } ?>

                <h4> Interfaces </h4>
                <?php if (empty($interfaces) === FALSE) { ?>
                    <table class="alv">
                        <tr>
                            <th class="alv"> # </th>
                            <th class="alv"> Interface </th>
                            <th class="alv"> Abstract </th>
                            <th class="alv"> Final </th>
                            <th class="alv"> Description</th>
                        </tr>
                        <?php
                        $count = 0;
                        foreach ($interfaces as $interface) {
                            $count++;
                            $interface_tx = ABAP_DB_TABLE_SEO::SEOCLASSTX($interface['REFCLSNAME']);
                            ?>
                            <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLInterface($interface['REFCLSNAME'], $interface_tx) ?></td>
                                <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox("IMPABSTRCT", $interface['IMPABSTRCT']) ?></td>
                                <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox("IMPFINAL", $interface['IMPFINAL']) ?></td>
                                <td class="alv"><?php echo $interface_tx ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <code>Class <?php echo $ObjID ?> has interface implemented.</code>
                <?php } ?>

                <h4> Friends </h4>
                <?php if (empty($friends) === FALSE) { ?>
                    <table class="alv">
                        <tr>
                            <th class="alv"> # </th>
                            <th class="alv"> Friend </th>
                            <th class="alv"> Modeled only </th>
                            <th class="alv"> Created on </th>
                            <th class="alv"> Description</th>
                        </tr>
                        <?php
                        $count = 0;
                        foreach ($friends as $friend) {
                            $count++;
                            $friend_tx = ABAP_DB_TABLE_SEO::SEOCLASSTX($friend['REFCLSNAME']);
                            $friend_state = ($friend['STATE'] == 1) ? '' : 'X';
                            ?>
                            <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                                <td class="alv"><?php echo ABAP_Navigation::GetURLClass($friend['REFCLSNAME'], $friend_tx) ?></td>
                                <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox("IMPABSTRCT", $friend_state) ?></td>
                                <td class="alv"><?php echo $friend['CREATEDON'] ?></td>
                                <td class="alv"><?php echo $friend_tx ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <code>Class <?php echo $ObjID ?> has no friend class.</code>
                <?php } ?>

                <h4> Attributes </h4>
                <?php if (empty($attributes) === FALSE) { ?>
                    <table class="alv">
                        <tr>
                            <th class="alv"> # </th>
                            <th class="alv"> Attribute </th>
                            <th class="alv"> Level </th>
                            <th class="alv"> Visibility </th>
                            <th class="alv"> Read only</th>
                            <th class="alv"> Typing </th>
                            <th class="alv"> Associated Type </th>
                            <th class="alv"> Initial Value </th>
                            <th class="alv"> Description </th>
                            <th class="alv"> Created on </th>
                        </tr>
                        <?php
                        $count = 0;
                        foreach ($attributes as $attribute) {
                            $count++;
                            $seocomp_tx = ABAP_DB_TABLE_SEO::SEOCOMPOTX($ObjID, $attribute['CMPNAME']);
                            $seocomp_df = ABAP_DB_TABLE_SEO::SEOCOMPODF($ObjID, $attribute['CMPNAME']);
                            $attribute_level_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCOMPODF_ATTDECLTYP_DOMAIN, $seocomp_df['ATTDECLTYP']);
                            $seocomp_visibility_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCOMPODF_EXPOSURE_DOMAIN, $seocomp_df['EXPOSURE']);
                            $seocomp_typing_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCOMPODF_TYPTYPE_DOMAIN, $seocomp_df['TYPTYPE']);
                            ?>
                            <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                                <td class="alv"><?php echo $seocomp_df['CMPNAME'] ?></td>
                                <td class="alv"><?php echo $attribute_level_tx ?>
                                    <br/>(<?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCOMPODF_ATTDECLTYP_DOMAIN, $seocomp_df['ATTDECLTYP'], $attribute_level_tx) ?>)
                                </td>
                                <td class="alv"><?php echo $seocomp_visibility_tx ?>
                                    <br/>(<?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCOMPODF_EXPOSURE_DOMAIN, $seocomp_df['EXPOSURE'], $seocomp_visibility_tx) ?>)
                                </td>
                                <td class="alv"><?php echo ABAP_UI_TOOL::GetCheckBox('ATTRDONLY', $seocomp_df['ATTRDONLY']) ?></td>
                                <td class="alv"><?php echo $seocomp_typing_tx ?>
                                    <br/>(<?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCOMPODF_TYPTYPE_DOMAIN, $seocomp_df['TYPTYPE'], $seocomp_typing_tx) ?>)
                                </td>
                                <td class="alv"><?php
                                    if ($seocomp_df['TYPTYPE'] == ABAP_DB_TABLE_SEO::SEOCOMPODF_TYPTYPE_3) {
                                        $clstype = ABAP_DB_TABLE_SEO::SEOCLASS($seocomp_df['TYPE']);
                                        if ($clstype['CLSTYPE'] == ABAP_DB_TABLE_SEO::SEOCLASS_CLSTYPE_CLAS) {
                                            echo ABAP_Navigation::GetURLClass($seocomp_df['TYPE'], NULL);
                                        } else {
                                            echo ABAP_Navigation::GetURLInterface($seocomp_df['TYPE'], NULL);
                                        }
                                    } else {
                                        echo $seocomp_df['TYPE'];
                                    }
                                    ?></td>
                                <td class="alv"><?php echo $seocomp_df['ATTVALUE'] ?></td>
                                <td class="alv"><?php echo $seocomp_tx ?></td>
                                <td class="alv"><?php echo $seocomp_df['CREATEDON'] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <code>Class <?php echo $ObjID ?> has no attribute.</code>
                <?php } ?>

                <h4> Methods </h4>
                <?php if (empty($methods) === FALSE) { ?>
                    <table class="alv">
                        <tr>
                            <th class="alv"> # </th>
                            <th class="alv"> Method </th>
                            <th class="alv"> Level </th>
                            <th class="alv"> Visibility </th>
                            <th class="alv"> Method type </th>
                            <th class="alv"> Description </th>
                            <th class="alv"> Created on </th>
                        </tr>
                        <?php
                        $count = 0;
                        foreach ($methods as $method) {
                            $count++;
                            $seocomp_tx = ABAP_DB_TABLE_SEO::SEOCOMPOTX($ObjID, $method['CMPNAME']);
                            $seocomp_df = ABAP_DB_TABLE_SEO::SEOCOMPODF($ObjID, $method['CMPNAME']);
                            $method_level_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCOMPODF_MTDDECLTYP_DOMAIN, $seocomp_df['MTDDECLTYP']);
                            $seocomp_visibility_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCOMPODF_EXPOSURE_DOMAIN, $seocomp_df['EXPOSURE']);
                            $method_type_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCOMPO_MTDTYPE_DOMAIN, $method['MTDTYPE']);
                            ?>
                            <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                                <td class="alv"><a href="#<?php echo ABAP_UI_TOOL::GetClassMethodAnchorName($seocomp_df['CMPNAME']) ?>"><?php echo $seocomp_df['CMPNAME'] ?></a></td>
                                <td class="alv"><?php echo $method_level_tx ?>
                                    <br/>(<?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCOMPODF_MTDDECLTYP_DOMAIN, $seocomp_df['MTDDECLTYP'], $method_level_tx) ?>)
                                </td>
                                <td class="alv"><?php echo $seocomp_visibility_tx ?>
                                    <br/>(<?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCOMPODF_EXPOSURE_DOMAIN, $seocomp_df['EXPOSURE'], $seocomp_visibility_tx) ?>)
                                </td>
                                <td class="alv"><?php echo $method_type_tx ?>
                                    <br/>(<?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCOMPO_MTDTYPE_DOMAIN, $method['MTDTYPE'], $method_type_tx) ?>)
                                </td>
                                <td class="alv"><?php echo $seocomp_tx ?></td>
                                <td class="alv"><?php echo $seocomp_df['CREATEDON'] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <code>Class <?php echo $ObjID ?> has no method.</code>
                <?php } ?>

                <h4> Events </h4>
                <?php if (empty($events) === FALSE) { ?>
                    <table class="alv">
                        <tr>
                            <th class="alv"> # </th>
                            <th class="alv"> Event </th>
                            <th class="alv"> Type </th>
                            <th class="alv"> Visibility </th>
                            <th class="alv"> Description </th>
                            <th class="alv"> Created on </th>
                        </tr>
                        <?php
                        $count = 0;
                        foreach ($events as $event) {
                            $count++;
                            $seocomp_tx = ABAP_DB_TABLE_SEO::SEOCOMPOTX($ObjID, $event['CMPNAME']);
                            $seocomp_df = ABAP_DB_TABLE_SEO::SEOCOMPODF($ObjID, $event['CMPNAME']);
                            $event_type_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCOMPODF_EVTDECLTYP_DOMAIN, $seocomp_df['EVTDECLTYP']);
                            $seocomp_visibility_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCOMPODF_EXPOSURE_DOMAIN, $seocomp_df['EXPOSURE']);
                            $method_type_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCOMPO_MTDTYPE_DOMAIN, $method['MTDTYPE']);
                            ?>
                            <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                                <td class="alv"><?php echo $seocomp_df['CMPNAME'] ?></td>
                                <td class="alv"><?php echo $event_type_tx ?>
                                    <br/>(<?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCOMPODF_EVTDECLTYP_DOMAIN, $seocomp_df['EVTDECLTYP'], $method_level_tx) ?>)
                                </td>
                                <td class="alv"><?php echo $seocomp_visibility_tx ?>
                                    <br/>(<?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCOMPODF_EXPOSURE_DOMAIN, $seocomp_df['EXPOSURE'], $seocomp_visibility_tx) ?>)
                                </td>
                                <td class="alv"><?php echo $seocomp_tx ?></td>
                                <td class="alv"><?php echo $seocomp_df['CREATEDON'] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <code>Class <?php echo $ObjID ?> has no event.</code>
                <?php } ?>


                <h4> Types </h4>
                <?php if (empty($types) === FALSE) { ?>
                    <table class="alv">
                        <tr>
                            <th class="alv"> # </th>
                            <th class="alv"> Type </th>
                            <th class="alv"> Visibility </th>
                            <th class="alv"> Typing </th>
                            <th class="alv"> Associated Type </th>
                            <th class="alv"> Description </th>
                            <th class="alv"> Created on </th>
                            <th class="alv"> Type Source </th>
                        </tr>
                        <?php
                        $count = 0;
                        foreach ($types as $type) {
                            $count++;
                            $seocomp_tx = ABAP_DB_TABLE_SEO::SEOCOMPOTX($ObjID, $type['CMPNAME']);
                            $seocomp_df = ABAP_DB_TABLE_SEO::SEOCOMPODF($ObjID, $type['CMPNAME']);
                            $seocomp_visibility_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCOMPODF_EXPOSURE_DOMAIN, $seocomp_df['EXPOSURE']);
                            $seocomp_typing_tx = ABAP_DB_TABLE_DOMA::DD07T(ABAP_DB_TABLE_SEO::SEOCOMPODF_TYPTYPE_DOMAIN, $seocomp_df['TYPTYPE']);
                            ?>
                            <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                                <td class="alv"><?php echo $seocomp_df['CMPNAME'] ?></td>
                                <td class="alv"><?php echo $seocomp_visibility_tx ?>
                                    <br/>(<?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCOMPODF_EXPOSURE_DOMAIN, $seocomp_df['EXPOSURE'], $seocomp_visibility_tx) ?>)
                                </td>
                                <td class="alv"><?php echo $seocomp_typing_tx ?>
                                    <br/>(<?php echo ABAP_Navigation::GetURLDomainValue(ABAP_DB_TABLE_SEO::SEOCOMPODF_TYPTYPE_DOMAIN, $seocomp_df['TYPTYPE'], $seocomp_typing_tx) ?>)
                                </td>
                                <td class="alv"><?php echo $seocomp_df['TYPE']; ?></td>
                                <td class="alv"><?php echo $seocomp_tx ?></td>
                                <td class="alv"><?php echo $seocomp_df['CREATEDON'] ?></td>
                                <td class="alv"><code><?php echo $seocomp_df['TYPESRC'] ?></code></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <code>Class <?php echo $ObjID ?> has no local type.</code>
                <?php } ?>

                <h4> Alias </h4>
                <h4> Method Signatures </h4>
                <?php
                if (empty($methods) === FALSE) {
                    foreach ($methods as $method) {
                        $method_paras = ABAP_DB_TABLE_SEO::SEOSUBCO($ObjID, $method['CMPNAME']);
                        ?>
                        <strong id="<?php echo ABAP_UI_TOOL::GetClassMethodAnchorName($method['CMPNAME']) ?>"><code>Method <?php echo $method['CMPNAME'] ?> Parameter(s)</code></strong>
                        <?php if (empty($method_paras) === FALSE) { ?>
                            <table class="alv">
                                <tr>
                                    <th class="alv"> # </th>
                                    <th class="alv"> Parameter </th>
                                    <th class="alv"> Type </th>
                                    <th class="alv"> Pass Value </th>
                                    <th class="alv"> Optional </th>
                                    <th class="alv"> Typing Method </th>
                                    <th class="alv"> Associated Type </th>
                                    <th class="alv"> Default value </th>
                                    <th class="alv"> Description </th>
                                    <th class="alv"> Created on </th>
                                </tr>
                                <?php
                                $count = 0;
                                foreach ($method_paras as $method_para) {
                                    $count++;
                                    ?>
                                    <tr><td class="alv" style="text-align: right;"><?php echo number_format($count) ?> </td>
                                        <td class="alv"><?php echo $method_para['SCONAME'] ?></td>
                                        <td class="alv"><?php echo $method_para['SCONAME'] ?></td>
                                        <td class="alv"><?php echo $method_para['SCONAME'] ?></td>
                                        <td class="alv"><?php echo $method_para['SCONAME'] ?></td>
                                        <td class="alv"><?php echo $method_para['SCONAME'] ?></td>
                                        <td class="alv"><?php echo $method_para['SCONAME'] ?></td>
                                        <td class="alv"><?php echo $method_para['SCONAME'] ?></td>
                                        <td class="alv"><?php echo $method_para['SCONAME'] ?></td>
                                        <td class="alv"><?php echo $method_para['SCONAME'] ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        <?php } else { ?>
                            <code>Method <?php echo $method['CMPNAME'] ?> on class <?php echo $ObjID ?> has no parameter.</code>
                            <?php
                        }
                    }
                } else {
                    ?>
                    <code>Class <?php echo $ObjID ?> has no method parameters.</code>
                <?php } ?>


                <h4> Hierarchy </h4>
                <table class="content_obj">
                    <tbody>
                        <tr><td class="content_label"> Last changed by/on      </td><td class="field"><?php echo $classdef['AUTHOR'] ?>&nbsp;</td><td> <?php echo $classdef['CHANGEDON'] ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Software Component      </td><td class="field"><?php echo ABAP_Navigation::GetURLSoftComp($hier->DLVUNIT, $hier->DLVUNIT_T) ?>&nbsp;</td><td> <?php echo $hier->DLVUNIT_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> SAP Release Created in  </td><td class="field"><?php echo $hier->CRELEASE ?>&nbsp;</td><td>&nbsp;</td></tr>
                        <tr><td class="content_label"> Application Component   </td><td class="field"><?php echo ABAP_Navigation::GetURLAppComp($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>&nbsp;(<?php echo $hier->FCTR_ID ?>)</td><td> <?php echo $hier->POSID_T ?>&nbsp;</td></tr>
                        <tr><td class="content_label"> Package                 </td><td class="field"><?php echo ABAP_Navigation::GetURLPackage($hier->DEVCLASS, $hier->DEVCLASS_T) ?>&nbsp;</td><td> <?php echo $hier->DEVCLASS_T ?>&nbsp;</td></tr>
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
?>
<?php ?>
