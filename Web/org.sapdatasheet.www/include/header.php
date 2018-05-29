<div class="container-fluid sticky-top bg-light">
    <div class="row">
        <div class="col-md-auto pt-2">
            <img class="" src="/sapdatasheet-big.png" width="200" height="21" class="d-inline-block align-top" alt="">
            <br><span class="text-nowrap text-muted text-monospace font-weight-bold sapds-slogan"><?php echo GLOBAL_WEBSITE_SAPDS::DESC ?></span>
        </div>
        <div class="col">

            <nav class="navbar navbar-expand-md navbar-dark sapds-menu"> 
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active"><a class="nav-link" href="/abap/" title="ABAP Object Types">ABAP</a></li>

                        <li class="nav-item active dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Hierarchy</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/abap/cvers/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCVERS() ?>&nbsp; Software Component</a>
                                <a class="dropdown-item" href="/abap/bmfr/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeBMFR() ?>&nbsp; Application Component</a>
                                <a class="dropdown-item" href="/abap/devc/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDEVC() ?>&nbsp; Package</a>
                            </div>
                        </li>

                        <li class="nav-item active dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">DDIC</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/abap/doma/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDOMA() ?>&nbsp; Domain</a>
                                <a class="dropdown-item" href="/abap/dtel/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeDTEL() ?>&nbsp; Data Element</a>
                                <a class="dropdown-item" href="/abap/tabl/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTABL() ?>&nbsp; Table</a>
                                <a class="dropdown-item" href="/abap/sqlt/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeSQLT() ?>&nbsp; Table Cluster/Pool</a>
                                <a class="dropdown-item" href="/abap/view/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeVIEW() ?>&nbsp; View</a>
                                <a class="dropdown-item" href="/abap/shlp/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeSHLP() ?>&nbsp; Search Help</a>
                            </div>
                        </li>

                        <li class="nav-item active dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Code</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/abap/intf/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeINTF() ?>&nbsp; ABAP Interface</a>
                                <a class="dropdown-item" href="/abap/clas/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCLAS() ?>&nbsp; ABAP Class</a>
                                <a class="dropdown-item" href="/abap/fugr/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeFUGR() ?>&nbsp; Function Group</a>
                                <a class="dropdown-item" href="/abap/func/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeFUNC() ?>&nbsp; Function Module</a>
                                <a class="dropdown-item" href="/abap/prog/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypePROG() ?>&nbsp; Program</a>
                            </div>
                        </li>

                        <li class="nav-item active dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Entrance</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/abap/tran/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeTRAN() ?>&nbsp; Transaction Code</a>
                                <a class="dropdown-item" href="/abap/cus0/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeCUS0() ?>&nbsp; IMG Activity</a>
                                <a class="dropdown-item" href="/abap/msag/"><?php echo GLOBAL_ABAP_ICON::getIcon4OtypeMSAG() ?>&nbsp; Message Class</a>
                            </div>
                        </li>

                        <li class="nav-item active dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">XRef</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/wul/abap/"><?php echo GLOBAL_ABAP_ICON::getIcon4WUL() ?>&nbsp; Where Used List</a>
                                <a class="dropdown-item" href="/wil/abap/"><?php echo GLOBAL_ABAP_ICON::getIcon4WIL() ?>&nbsp; Where Using List</a>
                            </div>
                        </li>
                    </ul>

                    <form class="form-inline mt-2 mt-md-0" method="get" action="https://www.google.com/search" target="_blank">
                        <input class="form-control mr-sm-2" type="text" name="q" placeholder="Search" aria-label="Search"
                               value="<?php echo $GLOBALS['TITLE_TEXT']; ?>">
                        <input type="hidden" name="sitesearch" value="sapdatasheet.org" />
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">&#128269;</button>
                    </form>
                </div>
            </nav>

        </div><!-- End col -->
    </div><!-- End row -->
</div>



<!-- End of Menu -->