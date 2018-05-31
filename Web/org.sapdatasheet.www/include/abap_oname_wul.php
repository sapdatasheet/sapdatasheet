<?php if (isset($wil_enabled) && $wil_enabled) { ?>
<h6 class="pt-4">Using</h6>
    <table>
        <tbody>
            <?php if (empty($wil_counter_list) === FALSE) { ?>
                <?php foreach ($wil_counter_list as $wil_counter_item) { ?>
                    <tr><td><?php echo ABAP_UI_DS_Navigation::GetWilHyperlink($wil_counter_item) ?>&nbsp;</td></tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td>Not Using Anyone else</td></tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>

<h6 class="pt-4">Used by</h6>
<table>
    <tbody>
        <?php if (empty($wul_counter_list) === FALSE) { ?>
            <?php foreach ($wul_counter_list as $wul_counter_item) { ?>
                <tr><td><?php echo ABAP_UI_DS_Navigation::GetWulHyperlink($wul_counter_item) ?>&nbsp;</td></tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td>Not Used by Anyone</td></tr>
        <?php } ?>
    </tbody>
</table>
