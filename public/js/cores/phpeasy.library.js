PHPEasy.Library = PHPEasy.Library || {};

PHPEasy.Library = {
    GetUrl: function() {
        var protocol = $(location).attr('protocol');
        var hostname = $(location).attr('hostname');
        var fullUrl = protocol + '//' + hostname + '/';
        return fullUrl;
    }
};

PHPEasy.Library.Cookie = PHPEasy.Library.Cookie || {};
PHPEasy.Library.Cookie = {
    SetCookie: function(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    },
    GetCookie: function(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }
};