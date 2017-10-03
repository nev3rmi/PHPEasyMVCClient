<?php 
// TODO: Need to auto get _head and _body this will be in uppercontainer and lowercontainer 
?>
<h1>Controllers &amp; Pages</h1>
<span>This page uses for managing the controllers and its functions. It will manage pages contents, and permission to access.</span>
<hr>
<div class="action-tools">
    <a href="javascript:;" class="btn btn-sm btn-success" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Controller.getFormToAddUpdateController();"><i class="fa fa-plus" aria-hidden="true"></i> New Controller</a>
    <a href="javascript:;" class="btn btn-sm btn-success" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.getFormToAddUpdatePage();"><i class="fa fa-plus" aria-hidden="true"></i> New Page</a>
    <a href="javascript:;" class="btn btn-sm btn-info" onclick="PHPEasy.Page.Sitemap.Admin.Pages.Page.viewSiteMap();"><i class="fa fa-eye" aria-hidden="true"></i> Sitemap</a>
</div>
<hr>
<div class="table-responsive">
    <table id="list-page" class="display table table-striped table-hover" cellspacing="0" width="100%">
       <thead>
            <tr>
                <th>Controller Name</th>
                <th>Page Name</th>
                <th>Page Url</th>
                <th>Parent Name</th>
                <th>Parent Url</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Controller Name</th>
                <th>Page Name</th>
                <th>Page Url</th>
                <th>Parent Name</th>
                <th>Parent Url</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>