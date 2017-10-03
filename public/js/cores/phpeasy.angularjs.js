PHPEasy.AngularJS = PHPEasy.AngularJS || {};
PHPEasy.AngularJS = {
    module: null,
    Init: function(){
        if (PHPEasy.AngularJS.module === null){
            PHPEasy.AngularJS.module = angular.module('PHPEasy', []);
        }
    }
}