<?php
namespace PHPEasy\Views;
use PHPEasy\Cores as Cores;
use PHPEasy\Models as Models;
use PHPEasy\Controllers as Controllers;
?>
<header class="<?php echo $this->navbar->config == 2 ?"sticky_header":"normal_header"?>">
<nav class="navbar navbar-default <?php echo $this->navbar->transparent ?"navbar-transparent":""?> <?php echo ($this->navbar->config == 1)?"navbar-fixed":""?>" role="navigation" id="nav">

  <div class="container-fluid">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>

      <a class="navbar-brand" href="#"><?php echo Cores\_Security::GetKey('siteName');?></a> </div>

    <div class="collapse navbar-collapse" id="myNavbar">

      <ul class="nav navbar-nav">

        <li><a href="<?php echo $GLOBALS['_Site']-> GetUrl();?>index">Home</a></li>

        <li><a href="<?php echo $GLOBALS['_Site']-> GetUrl();?>about">About</a></li>

        <li><a href="<?php echo $GLOBALS['_Site']-> GetUrl();?>help">Help</a></li>

        <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu 1 <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">Action</a></li>
                                                <li><a href="#">Another action</a></li>
                                                <li><a href="#">Something else here</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Separated link</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">One more separated link</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

      </ul>

      <ul class="nav navbar-nav navbar-right" id="userNavbar">
      <?php 
      $loggedUser = Cores\_Session::Get('loggedUser');
      if (!empty($loggedUser) && $loggedUser -> id !== 1){ 
      ?>
         <li><p class="navbar-text">Welcome Back, <?php echo Cores\_Session::Get('loggedUser') -> firstname ?>!</p></li>
         <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <?php if (empty(Cores\_Session::Get('loggedUser') -> avatar)){ ?>
                  <i class="fa fa-user fa-fw"></i> 
                <?php }else{ ?>
                  <img class="img-circle" src="<?php echo Cores\_Session::Get('loggedUser') -> avatar?>" alt="<?php echo Cores\_Session::Get('loggedUser') -> firstname?>'s Avatar" style="margin-bottom: 5px;width:16px;height:16px;">
                <?php } ?>
                <i class="fa fa-caret-down"></i>
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
                <li><a href="javascript:;" onclick="PHPEasy.Login.AjaxSignOut()"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
                    <div class="social-buttons text-center">
                      <div class="btn-group">
                        <button type="button" class="btn btn-md btn-primary" onclick="PHPEasy.Plugins.Oauth.Facebook.Login.Do();"><i class="fa fa-facebook"></i> Facebook</button>
                        <button type="button" class="btn btn-md btn-danger" onclick="PHPEasy.Plugins.Oauth.Google.V2.Login();"><i class="fa fa-google"></i> Google</button>
                      </div>
                    </div>
                                    or
                    <form class="form" role="form" method="post" action="/login/route/viawebsite/run" accept-charset="UTF-8" id="login-nav" data-transfer-method="ajax">
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
                    New here ? <a href="/login/register"><b>Join Us</b></a>
                  </div>
              </div>
            </li>
          </ul>
          </li>
      <?php }  ?>  
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="flag-icon flag-icon-<?php echo Cores\_Session::Get('Language') ->  imageCode?>"></span> <?php echo Cores\_Session::Get('Language') ->  name?>  <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <?php 
                $allLanguage = Cores\_Session::Get('Language') -> allSiteLanguage;
                foreach ($allLanguage as $language) {
                ?>
                  <li><a href="#" data-language-id="<?php echo $language['LanguageId']?>" class="language" rel="<?php echo $language['Symbol']?>"><span class="flag-icon flag-icon-<?php echo $language['ImageCode']?>"></span> <?php echo $language['LanguageName']?></a></li>
                <?php
                }?>
              </ul>
          </li>
      </ul>
    </div>

  </div>

</nav>
</header>


<!-- Need auto get page --> 