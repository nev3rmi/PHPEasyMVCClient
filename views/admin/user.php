<?php 
// TODO: Need to auto get _head and _body this will be in uppercontainer and lowercontainer 
?>
<h1>Users</h1>
<span>This page uses for managing the user information.</span>
<hr>
<div class="action-tools">
    <a href="#" class="btn btn-sm btn-success" onclick="PrivateControllerControl.getFormToAddUpdateController();"><i class="fa fa-plus" aria-hidden="true"></i> New Controller</a>
    <a href="#" class="btn btn-sm btn-success" onclick="PrivatePageControl.getFormToAddUpdatePage();"><i class="fa fa-plus" aria-hidden="true"></i> New Page</a>
</div>
<hr>
<div class="table-responsive">
    <table id="list-page" class=" nowrap display table table-striped table-hover" cellspacing="0" width="100%">
       <thead>
            <tr>
                <th>User Id</th>
                <th>Avartar</th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>FacebookOauthId</th>
                <th>GoogleOauthId</th>
                <th></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>User Id</th>
                <th class="dataTables_nosearch"></th>
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>FacebookOauthId</th>
                <th>GoogleOauthId</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>