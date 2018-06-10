<div class="container-fluid">
    <!-- Google Adsense: bottom -->
    <div class="text-center"><?php include $__WS_ROOT__ . '/common-php/google/adsense-bottom.html' ?></div>

    <footer class="container-fluid pt-4">
        <p class="text-center">
            Affinities: <a href="<?php echo GLOBAL_WEBSITE::SAP_TABLES_ORG_URL ?>" target="_blank" title="<?php echo GLOBAL_WEBSITE::SAP_TABLES_ORG_DESC ?>"><?php echo GLOBAL_WEBSITE::SAP_TABLES_ORG_URL_DISPLAY ?></a>
            &middot; <a href="<?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_URL ?>" target="_blank" title="<?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_DESC ?>"><?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_URL_DISPLAY ?></a>
            | <a target="_blank" href="/site/about.html"><b>About</b></a>
            &middot; <a target="_blank" href="/site/term.html"><b>Terms</b></a>
            &middot; <a target="_blank" href="/site/privacy.html"><b>Privacy</b></a>
            &middot; <a target="_blank" href="https://github.com/sapdatasheet/sapdatasheet/issues"><b>Feedback</b></a>
            <br>
            &copy; Copyright 2014 - <?php echo date("Y"); ?>, <a href="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL ?>" target="_blank" title="<?php echo GLOBAL_WEBSITE::SAPDS_ORG_DESC ?>"><?php echo GLOBAL_WEBSITE::SAPDS_ORG_URL_DISPLAY ?></a>, <?php echo GLOBAL_WEBSITE::SAPDS_ORG_DESC ?>
            <br>
        </p>
        <p><small>
                SAP Datasheet web site and its affinity sites content is based on our knowledge of SAP system, and it is constantly reviewed to avoid errors; 
                well we cannot warrant full correctness of all content. 

                While using this site, you agree to have read and accepted our terms of use, cookie and privacy policy. 
                Use the information and content on this web site at your own risk.

                SAP and the SAP logo are registered trademarks of <a href="http://www.sap.com" target="_blank" title="SAP SE">SAP SE</a>. 
                This web site is not sponsored by, affiliated with, or approved by <a href="http://www.sap.com" target="_blank" title="SAP SE Web Site">SAP SE</a>. 

                This web site is validated by <a href="http://validator.w3.org/" target="_blank" title="W3 Validator">W3 Validator</a> 
                as <a href="http://www.w3.org/TR/html5/" target="_blank" title="">HTML5</a>. 
            </small></p>
    </footer>
</div>
<!-- Java Script - https://getbootstrap.com/docs/4.1/getting-started/introduction/ -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="/3rdparty/bootstrap/js/bootstrap.min.js"></script>
<!-- Google Analytics Tracking -->
<div>
    <?php include dirname(__FILE__, 2) . '/include/google/analyticstracking-sapds-org.html' ?>
</div>
