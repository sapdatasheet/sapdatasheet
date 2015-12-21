<h5>Used by</h5>
<div class="whereusedlist">
    <table class="content_obj">
        <tbody>
            <?php if (empty($wul_counter_list) === FALSE) { ?>
                <?php foreach ($wul_counter_list as $wul_counter_item) { ?>
                    <tr><td><?php echo ABAP_Navigation::GetWulURL($wul_counter_item) ?>&nbsp;</td></tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td>Not Used by Anyone</td></tr>
            <?php } ?>
        </tbody>
    </table>
</div>
