PHPEasy.Plugins.Oauth.Facebook = PHPEasy.Plugins.Oauth.Facebook || {};

PHPEasy.Plugins.Oauth.Facebook = {
    // Variables
    appId: PHPEasy.Setting.Plugins.Facebook.appId,
    oauth: true,
    status: true, // check login status
    cookie: true, // enable cookies to allow the server to access the session
    xfbml: true, // parse XFBML
    version: 'v2.8',
    user: '',

    // FB Login
    scope: PHPEasy.Setting.Plugins.Facebook.scope, // user_birthday and user_location are special fields
    fields: PHPEasy.Setting.Plugins.Facebook.fields, // birthday, location are special fields

    // Initiation
    Init: function() {
        window.fbAsyncInit = function() {
            FB.init({
                appId: PHPEasy.Plugins.Oauth.Facebook.appId,
                oauth: PHPEasy.Plugins.Oauth.Facebook.oauth,
                status: PHPEasy.Plugins.Oauth.Facebook.status, // check login status
                cookie: PHPEasy.Plugins.Oauth.Facebook.cookie, // enable cookies to allow the server to access the session
                xfbml: PHPEasy.Plugins.Oauth.Facebook.xfbml, // parse XFBML
                version: PHPEasy.Plugins.Oauth.Facebook.version
            });
        };
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) { return; }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    },
    Login: {
        Do: function() {
            FB.login(function(response) {

                if (response.authResponse) {
                    // console.log(response); // dump complete info
                    access_token = response.authResponse.accessToken; //get access token
                    user_id = response.authResponse.userID; //get FB UID

                    // console.log(user_id);

                    FB.api('/me', 'get', { fields: PHPEasy.Plugins.Oauth.Facebook.fields }, function(response) {
                        user_email = response.email; //get user email
                        user_name = response.name;
                        // you can store this data into your database         
                        PHPEasy.Plugins.Oauth.Facebook.user = response;
                        PHPEasy.Login.AjaxSignIn('/login/route/Oauth/Facebook/Authenticate', PHPEasy.Plugins.Oauth.Facebook.user);
                    });

                } else {
                    //user hit cancel button
                    console.log('User cancelled login or did not fully authorize.');

                }
            }, {
                scope: PHPEasy.Plugins.Oauth.Facebook.scope
            });
        },
        Out: function() {
            FB.logout(function(response) {});
        }
    }
};