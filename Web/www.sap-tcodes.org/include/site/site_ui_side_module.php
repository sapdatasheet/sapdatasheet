<!-- All T-Codes by Level 1 Application Component -->
<div class="panel panel-success">
    <div class="panel-heading">TCodes by Each Module</div>
    <table class="table table-hover table-condensed">
        <tbody>
            <?php foreach (SITE_UI_ANALYTICS::AnaModuleL1_DB2UI() as $appl_l1) { ?>
                <tr><td><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?>
                        <?php if ($appl_l1[SITE_UI_CONST::KEY_HIGHLIGHT]) { ?>
                            <span class="label label-warning">
                            <?php } ?>
                            <a href="<?php echo $appl_l1[SITE_UI_CONST::KEY_URL] ?>"
                               title="<?php echo $appl_l1[SITE_UI_CONST::KEY_CAPTION] ?>" target="_blank">
                                <?php echo $appl_l1[SITE_UI_CONST::KEY_LABEL] ?></a>
                            <?php if ($appl_l1[SITE_UI_CONST::KEY_HIGHLIGHT]) { ?>
                            </span>
                        <?php } ?></td>
                    <td class="text-right"><span class="label label-success">
                            <?php echo number_format($appl_l1[SITE_UI_CONST::KEY_VALUE]) ?></span></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>