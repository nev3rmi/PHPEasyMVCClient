<div class="container">
  <div class="row">

    <div class="main login-form">

      <h3>Please Sign Up, or <a href="/login">Log In</a></h3>
      <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
          <a href="javascript:;" class="btn btn-lg btn-fb  btn-block" scope="public_profile,email" onclick="PHPEasy.Plugins.Oauth.Facebook.Login.Do();"><i class="fa fa-facebook-square fa-lg" aria-hidden="true" style="margin-right: 24px; width:18px;"></i> Facebook</a>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
          <!--<a href="javascript:;" class="btn btn-lg btn-default btn-block btn-google" onclick="PHPEasy.Plugins.Google.Login();"><span><img src="/public/img/g-logo.png" class="img-responsive" alt="Google Login" style="width:18px;display:inline-block;margin-right: 24px;"></span> Google</a>-->
          <a href="javascript:;" class="btn btn-lg btn-default btn-block btn-google" onclick="PHPEasy.Plugins.Oauth.Google.V2.Login();"><span><img src="/public/img/g-logo.png" class="img-responsive" alt="Google Login" style="width:18px;display:inline-block;margin-right: 24px;"></span> Google</a>
        </div>
      </div>
      <div class="login-or">
        <hr class="hr-or">
        <span class="span-or">or</span>
      </div>

      <form role="form" action="/login/route/viawebsite/run" method="post" data-transfer-method="ajax">
        <div class="form-group">
          <label for="inputUsernameEmail">Email</label>
          <input type="email" class="form-control" id="inputUsernameEmail" name="email" required>
        </div>
        <div class="form-group">
          <label for="inputPassword">Password</label>
          <input type="password" class="form-control" id="inputPassword" name="password" required>
        </div>
        <div class="form-group">
          <label for="inputRePassword">Retype Password</label>
          <input type="password" class="form-control" id="inputRePassword" name="repassword" required>
        </div>
        <div class="form-group">
          <div class="g-recaptcha" data-sitekey="<?php echo \PHPEasy\Cores\_Security::DecryptObject(\PHPEasy\Cores\_Security::GetKey('GoogleCaptcha'))['siteKey'];?>"></div> 
        </div>
        <div class="checkbox pull-right">
          <label>
            <input type="checkbox" required>
            Term &amp; Condition </label>
        </div>
        <button type="submit" class="btn btn btn-primary">
          Register Me
        </button>
      </form>
    
    </div>
    
  </div>

</div>
