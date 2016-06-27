<?php if (isset($hier) && strlen(trim($hier->DLVUNIT)) > 0) { ?>
    <h4> <?php echo GLOBAL_ABAP_ICON::getIcon4DisplayTree() ?> Hierarchy </h4>
    <div class="hier">
        <?php $hier_spaces = 0; ?>
        <!-- Software Component -->
        <?php if (strlen(trim($hier->DLVUNIT)) > 0) { ?>
        <span>&#9755;</span>
            <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() ?>
            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Cvers($hier->DLVUNIT, $hier->DLVUNIT_T) ?>
            (<?php echo GLOBAL_ABAP_OTYPE::CVERS_DESC ?>) <?php echo $hier->DLVUNIT_T ?><br />
            <?php $hier_spaces += 2; ?>
        <?php } ?>
        <!-- Application Component -->
        <?php if (strlen(trim($hier->POSID)) > 0) { ?>
            <?php GLOBAL_UTIL::EchoSpace($hier_spaces) ?>
            <span>&#10551;</span> 
            <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>
            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Bmfr($hier->FCTR_ID, $hier->POSID, $hier->POSID_T) ?>
            (<?php echo GLOBAL_ABAP_OTYPE::BMFR_DESC ?>) <?php echo $hier->POSID_T ?><br />
            <?php $hier_spaces += 2; ?>
        <?php } ?>
        <!-- Super Super Package -->
        <?php if (strlen(trim($hier->PARENTCL2 )) > 0) { ?>
            <?php GLOBAL_UTIL::EchoSpace($hier_spaces) ?>
            <span>&#10551;</span>
            <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() ?>
            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($hier->PARENTCL2, $hier->PARENTCL2_T) ?>
            (<?php echo GLOBAL_ABAP_OTYPE::DEVC_DESC ?>) <?php echo $hier->PARENTCL2_T ?><br />
            <?php $hier_spaces += 2; ?>
        <?php } ?>
        <!-- Super Package -->
        <?php if (strlen(trim($hier->PARENTCL1 )) > 0) { ?>
            <?php GLOBAL_UTIL::EchoSpace($hier_spaces) ?>
            <span>&#10551;</span>
            <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() ?>
            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($hier->PARENTCL1, $hier->PARENTCL1_T) ?>
            (<?php echo GLOBAL_ABAP_OTYPE::DEVC_DESC ?>) <?php echo $hier->PARENTCL1_T ?><br />
            <?php $hier_spaces += 2; ?>
        <?php } ?>
        <!-- Package -->
        <?php if (strlen(trim($hier->DEVCLASS)) > 0) { ?>
            <?php GLOBAL_UTIL::EchoSpace($hier_spaces) ?>
            <span>&#10551;</span>
            <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() ?>
            <?php echo ABAP_UI_DS_Navigation::GetHyperlink4Devc($hier->DEVCLASS, $hier->DEVCLASS_T) ?>
            (<?php echo GLOBAL_ABAP_OTYPE::DEVC_DESC ?>) <?php echo $hier->DEVCLASS_T ?><br />
            <?php $hier_spaces += 2; ?>
        <?php } ?>

    </div>
<?php } ?>
