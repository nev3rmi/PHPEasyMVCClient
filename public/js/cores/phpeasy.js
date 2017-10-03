var PHPEasy = PHPEasy || {};

PHPEasy = {
    UseHttps: function() {
        if (location.protocol != 'https:' && PHPEasy.Setting.Https == 1) {
            location.href = 'https:' + window.location.href.substring(window.location.protocol.length);
        }
    },


};