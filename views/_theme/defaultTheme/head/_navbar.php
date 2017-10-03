<?php
namespace PHPEasy\Views;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;
use PHPEasy\Controllers as Controllers;
?>
<nav class="navbar navbar-default" role="navigation" id="nav">

  <div class="container-fluid">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>

      <a class="navbar-brand" href="#"><?php echo Cores\_Security::GetKey('siteName');?></a> </div>

    <div class="collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav">

        <li><a href="<?php echo $GLOBALS['_Site']-> GetUrl();?>index">Home</a></li>

        <li><a href="<?php echo $GLOBALS['_Site']-> GetUrl();?>about">About</a></li>

        <li><a href="<?php echo $GLOBALS['_Site']-> GetUrl();?>help">Help</a></li>

      </ul>

      <ul class="nav navbar-nav navbar-right" id="userNavbar">
      <?php 
      $loggedUser = Cores\_Session::Get('loggedUser');
      if (!empty($loggedUser) && $loggedUser -> id !== 1){ 
      ?>
         <li><p class="navbar-text">Welcome Back, <?php echo Cores\_Session::Get('loggedUser') -> fullname ?>!</p></li>
         <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?php echo Cores\_Site::GetUrl();?>dashboard"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <?php if (in_array(Cores\_EnumGroup::Admin_Group,$loggedUser -> group) || in_array(Cores\_EnumGroup::Owner_Group,$loggedUser -> group)){?>
                <li class="divider"></li>
                <li><a href="<?php echo Cores\_Site::GetUrl();?>admin"><i class="fa fa-superpowers fa-fw"></i> Admin Dashboard</a>
                </li>
                <?php }?>
                <li class="divider"></li>
                <li><a href="<?php echo Cores\_Site::GetUrl();?>dashboard/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
         </li>
      <?php }else{ ?>
         <li><p class="navbar-text">Already have an account?</p></li>
         <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
          <ul id="login-dp" class="dropdown-menu">
            <li>
              <div class="row">
                  <div class="col-md-12">
                    Login via
                    <div class="social-buttons">
                      <a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
                      <a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i> Twitter</a>
                    </div>
                                    or
                    <form class="form" role="form" method="post" action="<?php echo Cores\_Site::GetUrl();?>login/run" accept-charset="UTF-8" id="login-nav">
                        <div class="form-group">
                          <label class="sr-only" for="exampleInputEmail2">Email address</label>
                          <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" required name="email">
                        </div>
                        <div class="form-group">
                          <label class="sr-only" for="exampleInputPassword2">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" required name="password">
                                                <div class="help-block text-right"><a href="">Forget the password ?</a></div>
                        </div>
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                        </div>
                        <div class="checkbox">
                          <label>
                          <input type="checkbox"> keep me logged-in
                          </label>
                        </div>
                    </form>
                  </div>
                  <div class="bottom text-center">
                    New here ? <a href="#"><b>Join Us</b></a>
                  </div>
              </div>
            </li>
          </ul>
          </li>
      <?php }  ?>  
      </ul>

    </div>

  </div>

</nav>



<!-- Need auto get page --> 