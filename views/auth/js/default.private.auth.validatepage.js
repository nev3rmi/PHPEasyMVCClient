// Private Auth
(function($) {
    PHPEasy.AngularJS.module.controller('FormPassword', function ($scope, $http, $window){
        $scope.data = {};
        $scope.submit = function(postedUrl, data){
            data = this.data;
            data.PostedUrl = postedUrl;

            var loadingDialog = PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Loading("Request to check password, please wait!");
            $http.post('/auth/posttovalidate', data).then(function (response) {
                loadingDialog.setMessage("Fetching response...");
                loadingDialog.close();
                if (response.data.result === 101) {
                    // $location.url(data.PostedUrl);
                    $window.location.href = data.PostedUrl;
                } else {
                    PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Fail("Error " + response.data.result + ": \n" + response.data.message);
                    return false;
                }
            });
        }
    });
})(jQuery);