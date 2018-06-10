<!-- Navigation bar -->
<!-- This file needs:
- class SITE_GLOBAL - for title
- variable $search  - for Search box
-->
<div class="container-fluid" id="banner">
    <div class="row">
        <h3>&nbsp;<?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_NAME ?><small>&nbsp;&nbsp;&nbsp;<?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_DESC ?></small></h3>
    </div>
</div>
<nav class="navbar navbar-inverse navbar-static-top" id="topnavbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand tooltip-custom-color" href="/" data-toggle="tooltip" data-placement="bottom"
               title="<?php echo GLOBAL_WEBSITE::SAP_TCODES_ORG_DESC ?>"><span class="glyphicon glyphicon-home"></span></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="/analytics/module/" data-toggle="tooltip" data-placement="bottom" title="TCode Analytis by Application Module"><span class="glyphicon glyphicon-equalizer"></span>&nbsp;TCode Module</a></li>
                <li><a href="/analytics/component/" data-toggle="tooltip" data-placement="bottom" title="TCode Analytis by Software Component"><span class="glyphicon glyphicon-folder-close"></span>&nbsp;TCode Component</a></li>
                <li><a href="/analytics/name/" data-toggle="tooltip" data-placement="bottom" title="TCode Analytis by Name"><span class="glyphicon glyphicon-tags"></span>&nbsp;TCode Name</a></li>
                <li><a href="/download/book/"  data-toggle="tooltip" data-placement="bottom" title="SAP TCode Books Download"><span class="glyphicon glyphicon-book"></span>&nbsp;TCode Books</a></li>
                <li><a href="/download/sheet/"  data-toggle="tooltip" data-placement="bottom" title="SAP TCode Sheets Download"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;TCode Sheets</a></li>
            </ul>
            <form class="navbar-form navbar-right" method="get" action="https://www.google.com/search" target="_blank">
                <div class="form-group">
                    <input type="text" name="q" placeholder="TCode" value="<?php echo $search ?>" class="form-control">
                    <input type="hidden" name="sitesearch" value="sap-tcodes.org" />
                </div>
                <button type="submit" class="btn btn-success" title="Search"><span class="glyphicon glyphicon-search"></span></button>
            </form>
        </div><!--/.nav-collapse -->
    </div>
</nav>
