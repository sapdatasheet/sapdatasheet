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
$class_super_tx = '';
if (empty($class_super) === FALSE) {
    $class_super_tx = htmlentities(ABAP_DB_TABLE_SEO::SEOCLASSTX($class_super));
}

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

                <h4> Type group / Object type </h4>
                <h4> Interfaces </h4>
                <h4> Friends </h4>
                <h4> Attributes </h4>
                <h4> Methods </h4>
                <h4> Events </h4>
                <h4> Types </h4>
                <h4> Texts </h4>
                <h4> Alias </h4>

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
