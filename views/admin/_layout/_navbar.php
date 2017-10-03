<?php
namespace PHPEasy\Views\Admin\_layout;
use PHPEasy\Cores as Cores;
?>
<div class="navbar-default sidebar" role="navigation" id="admin-sidebar">
    <div class="sidebar-nav">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                </div>
                <!-- /input-group -->
            </li>
            <!-- Dashboard -->
            <li>
                <a href="<?php echo Cores\_Site::GetUrl();?>admin"><i class="fa fa-tachometer fa-fw" aria-hidden="true"></i> Dashboard</a>
            </li>
            <!-- page -->
            <li>
                <a href="javascript:;"><i class="fa fa-sitemap fa-fw"></i> Sitemap<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <!--<li>
                        <a href="<?php echo Cores\_Site::GetUrl();?>admin/controller"><i class="fa fa-files-o fa-fw"></i> Controllers</a>
                    </li>-->
                    <li>
                        <a href="<?php echo Cores\_Site::GetUrl();?>admin/page"><i class="fa fa-files-o fa-fw"></i> Controllers &amp; Pages</a>
                    </li>
                </ul>
            </li>
            <!-- user -->
            <li>
                <a href="javascript:;"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="<?php echo Cores\_Site::GetUrl();?>admin/user"><i class="fa fa-user-circle-o fa-fw"></i> Manage Users</a>
                    </li>
                    <li>
                        <a href="<?php echo Cores\_Site::GetUrl();?>admin/group"><i class="fa fa-object-group fa-fw"></i> Manage Groups</a>
                    </li>
                </ul>
            </li>
            <!-- task manager -->
            <li>
                <a href="javascript:;"><i class="fa fa-tasks fa-fw"></i> Tasks<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="<?php echo Cores\_Site::GetUrl();?>admin/taskmanager"><i class="fa fa-calendar-check-o fa-fw"></i> Task Managers</a>
                    </li>
                    <li>
                        <a href="<?php echo Cores\_Site::GetUrl();?>admin/drawio"><i class="fa fa-handshake-o fa-fw"></i> Draw.IO</a>
                    </li>
                    <li>
                        <a href="<?php echo Cores\_Site::GetUrl();?>admin/twbscolor"><i class="fa fa-handshake-o fa-fw"></i> TWBSColor</a>
                    </li>
                </ul>
            </li>
            <!-- log -->
            <li>
                <a href="javascript:;"><i class="fa fa-stop-circle fa-fw"></i> Logs<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="<?php echo Cores\_Site::GetUrl();?>admin/log"><i class="fa fa-eye fa-fw"></i> View</a>
                    </li>
                </ul>
            </li>
            <!-- system -->
            <li>
                <a href="javascript:;"><i class="fa fa-cog fa-fw"></i> System<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li>
                        <a href="<?php echo Cores\_Site::GetUrl();?>admin/update"><i class="fa fa-level-up fa-fw"></i> Update</a>
                    </li>
                    <li>
                        <a href="<?php echo Cores\_Site::GetUrl();?>admin/filemanager"><i class="fa fa-folder fa-fw"></i> File Managers</a>
                    </li>
                </ul>
            </li>
            <!-- Notification bar -->
            <ul class="nav navbar-top-links text-center">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
            </ul>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
