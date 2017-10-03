PHPEasy.Language = PHPEasy.Language || {};

PHPEasy.Language = {
    Init: function() {
        $('.language').on('click', function(e) {
            e.preventDefault();

            var self = $(this);
            var id = self.data('language-id');

            $.post('/language/InitLanguage', { lang: id }, function(result) {
                if (parseInt(result) === 1 || !$.trim(result)) {
                    location.reload();
                } else {
                    PHPEasy.Plugins.Custom.Bootstrap.Dialog.Alert.Fail(result);
                }
            })
        });
    }
}