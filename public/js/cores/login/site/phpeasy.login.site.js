PHPEasy.Login.Site = PHPEasy.Login.Site || {};
PHPEasy.Login.Site = {
    Init: function() {
        $('form[data-transfer-method="ajax"]').on("submit", function(e) {
            e.preventDefault();
            PHPEasy.Login.AjaxSignIn("/login/route/viawebsite/run", $(this).serialize());
        })
    }
}