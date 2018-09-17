<!-- Navigation bar -->
<!-- This file needs:
- class SITE_GLOBAL - for title
- variable $search  - for Search box
-->
<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top ">
    <a class="navbar-brand" href="/" title="<?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_DESC ?>"><?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_NAME ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/analytics/module/" data-toggle="tooltip" data-placement="bottom" title="TCode Analytis by Application Module">
                    <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR(TRUE) ?>TCode Module <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/analytics/component/" data-toggle="tooltip" data-placement="bottom" title="TCode Analytis by Software Component">
                    <?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS(TRUE) ?>TCode Component</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/analytics/name/" data-toggle="tooltip" data-placement="bottom" title="TCode Analytis by Name">
                    <?php echo GLOBAL_ABAP_ICON::getIcon4NamePrefix(TRUE) ?>TCode Name</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/download/book/" data-toggle="tooltip" data-placement="bottom" title="SAP TCode Books Download">
                    <?php echo GLOBAL_ABAP_ICON::getIcon4FilePDF(TRUE) ?>TCode Books</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/download/sheet/" data-toggle="tooltip" data-placement="bottom" title="SAP TCode Sheets Download">
                    <img src='/include/icon/s_x__xlv.gif'>TCode Excels</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="get" action="https://www.google.com/search" target="_blank">
            <input type="text" name="q" placeholder="TCode" value="<?php echo $search ?>" class="form-control mr-sm-2" aria-label="Search">
            <input type="hidden" name="sitesearch" value="sap-tcodes.org" />
            <button class="btn btn-outline-success bg-warning my-2 my-sm-0" type="submit" title="Search">Search</button>
        </form>
    </div>
</nav>
