<?php if (isset($wil_enabled) && $wil_enabled) { ?>
    <h5>Using</h5>
    <table class="content_obj">
        <tbody>
            <?php if (empty($wil_counter_list) === FALSE) { ?>
                <?php foreach ($wil_counter_list as $wil_counter_item) { ?>
                    <tr><td class="left_value"><?php echo ABAP_UI_Navigation::GetWilHyperlink($wil_counter_item) ?>&nbsp;</td></tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td class="left_value">Not Using Anyone else</td></tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>

<h5>Used by</h5>
<table class="content_obj">
    <tbody>
        <?php if (empty($wul_counter_list) === FALSE) { ?>
            <?php foreach ($wul_counter_list as $wul_counter_item) { ?>
                <tr><td class="left_value"><?php echo ABAP_UI_Navigation::GetWulHyperlink($wul_counter_item) ?>&nbsp;</td></tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td class="left_value">Not Used by Anyone</td></tr>
        <?php } ?>
    </tbody>
</table>
