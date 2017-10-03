PHPEasy.Login = PHPEasy.Login || {};
PHPEasy.Login = {
    AjaxSignIn: function(authenticateLink, data, redirectUrl = "/dashboard") {
        var dialog = PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Loading();

        $.post(authenticateLink, data, function(result) {
            if (parseInt(result) === 1 || !$.trim(result)) { // !$.trim -> remove all blank and <br>
                window.location.replace(redirectUrl);
            } else {
                dialog.setTitle('<i class="glyphicon glyphicon-remove" aria-hidden="true"></i> <b>Error</b>');
                dialog.setMessage(result);
                dialog.setType(BootstrapDialog.TYPE_DANGER);
                grecaptcha.reset();
            }
        });
    },
    AjaxSignOut: function() {
        var dialog = PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Loading();
        $.post("/login/logout", "", function(result) {
            if (typeof FB !== 'undefined') {
                PHPEasy.Plugins.Oauth.Facebook.Login.Out();
            }
            window.location.replace("/");
        })
    }
}