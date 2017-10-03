PHPEasy.Plugins.Oauth.Google = PHPEasy.Plugins.Oauth.Google || {};

PHPEasy.Plugins.Oauth.Google = {
    V1: {
        oauthUrl: 'https://accounts.google.com/o/oauth2/auth?',
        validUrl: 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=',
        scope: 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/plus.login',
        clientId: '253394849025-82u0nl6cqpe91ln0j7hmlrrufh0pj5or.apps.googleusercontent.com',
        redirect: 'http://phpeasy.ml/login/route/oauth/google',
        type: 'token',
        _url: function() { return this.oauthUrl + 'scope=' + this.scope + '&client_id=' + this.clientId + '&redirect_uri=' + this.redirect + '&response_type=' + this.type },
        acToken: {},
        tokenType: {},
        expiresIn: {},
        user: {},

        Login: function() {
            // TODO: Fix error cross origin

            var win = window.open(PHPEasy.Plugins.Oauth.Google.V1._url(), "GoogleSignIn", 'width=' + PHPEasy.Setting.Plugins.Google.V1.Width + ', height=' + PHPEasy.Setting.Plugins.Google.V1.Height);

            var pollTimer = setInterval(function() {
                if (win.closed) {
                    clearInterval(pollTimer);
                }
                var windowLoadingResult = (win.document.URL.indexOf(PHPEasy.Plugins.Oauth.Google.V1.redirect));
                if (windowLoadingResult != -1) {
                    var url = win.document.URL;
                    PHPEasy.Plugins.Oauth.Google.V1.acToken = PHPEasy.Plugins.Oauth.Google.V1.Gup(url, 'access_token');
                    PHPEasy.Plugins.Oauth.Google.V1.tokenType = PHPEasy.Plugins.Oauth.Google.V1.Gup(url, 'token_type');
                    PHPEasy.Plugins.Oauth.Google.V1.expiresIn = PHPEasy.Plugins.Oauth.Google.V1.Gup(url, 'expires_in');
                    win.close();
                    PHPEasy.Plugins.Oauth.Google.V1.ValidateToken(PHPEasy.Plugins.Oauth.Google.V1.acToken);
                    clearInterval(pollTimer);
                }
            }, 100);
        },

        AjaxSignIn: function() {
            $.post('/login/route/Oauth/Google/Authenticate', PHPEasy.Plugins.Oauth.Google.V1.user, function(result) {
                // console.log(result);
                if (!result) {
                    PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Fail(result);
                } else {
                    window.location.replace("/dashboard");
                }
            });
        },

        ValidateToken: function(token) {
            $.ajax({
                url: PHPEasy.Plugins.Oauth.Google.V1.validUrl + token,
                data: null,
                success: function(responseText) {
                    PHPEasy.Plugins.Oauth.Google.V1.GetUserInfo();
                },
                dataType: "jsonp"
            });
        },

        GetUserInfo: function() {
            $.ajax({
                url: 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' + PHPEasy.Plugins.Oauth.Google.V1.acToken,
                data: null,
                success: function(resp) {
                    PHPEasy.Plugins.Oauth.Google.V1.user = resp;
                    PHPEasy.Plugins.Oauth.Google.V1.AjaxSignIn();
                },
                dataType: "jsonp"
            });
        },

        //credits: http://www.netlobo.com/url_query_string_javascript.html
        Gup: function(url, name) {
            name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
            var regexS = "[\\#&]" + name + "=([^&#]*)";
            var regex = new RegExp(regexS);
            var results = regex.exec(url);
            if (results == null) {
                return "";
            } else {
                return results[1];
            }
        }
    },
    V2: {
        user: '',

        Logout: function() {
            gapi.auth.signOut();
            location.reload();
        },
        Login: function() {
            var myParams = {
                'clientid': PHPEasy.Setting.Plugins.Google.V2.ClientId + '.apps.googleusercontent.com',
                'cookiepolicy': 'single_host_origin',
                'callback': 'GoogleLoginCallback',
                'approvalprompt': 'force',
                'scope': PHPEasy.Setting.Plugins.Google.V2.Scope
            };
            gapi.auth.signIn(myParams);
        },

        LoginCallback: function(result) {
            gapi.client.load('plus', 'v1', function() {
                if (result['status']['signed_in']) {
                    try {
                        var request = gapi.client.plus.people.get({
                            'userId': 'me'
                        });
                        request.execute(function(resp) {
                            if (resp['code'] === 403) {
                                PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Fail(resp['message']);
                            }
                            PHPEasy.Plugins.Oauth.Google.V2.user = resp;
                            PHPEasy.Login.AjaxSignIn('/login/route/Oauth/Google/Authenticate', PHPEasy.Plugins.Oauth.Google.V2.user);
                        });
                    } catch (ex) {
                        PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Fail(ex)
                    }
                }
            });
        },

        OnLoadCallback: function() {
            gapi.client.setApiKey(PHPEasy.Setting.Plugins.Google.V2.ApiKey);
            gapi.client.load('plus', 'v1', function() {});
        },

        Init: function() {
            var po = document.createElement('script');
            po.type = 'text/javascript';
            po.async = true;
            po.src = 'https://apis.google.com/js/client.js?onload=PHPEasy.Plugins.Oauth.Google.V2.OnLoadCallback';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(po, s);
        }
    }
};

function GoogleLoginCallback(result) {
    PHPEasy.Plugins.Oauth.Google.V2.LoginCallback(result);
}