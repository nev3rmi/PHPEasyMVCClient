(function($) {
    PHPEasy.UseHttps();
    PHPEasy.Page.Navbar.AutoActive();
    PHPEasy.Plugins.Oauth.Facebook.Init();
    PHPEasy.Plugins.Oauth.Google.V2.Init();
    PHPEasy.Login.Site.Init();
    PHPEasy.Language.Init();
    PHPEasy.AngularJS.Init();

    $(document.activeElement).keydown(function(e) {
        var getCarousel = $(this).find('.carousel');
        if (getCarousel.length > 0) {
            if (e.keyCode == 37) { // left
                getCarousel.carousel('prev');
            } else if (e.keyCode == 39) { // right
                getCarousel.carousel('next');
            }
        }
    });

    
})(jQuery);
$(function() { // Load after everything loaded, use for CDN
    

    // Plugin
    // Stellar.js
    $.stellar();

    // Tawk.to
    // var Tawk_API = Tawk_API || {},
    //     Tawk_LoadStart = new Date();
    // (function() {
    //     var s1 = document.createElement("script"),
    //         s0 = document.getElementsByTagName("script")[0];
    //     s1.async = true;
    //     s1.src = 'https://embed.tawk.to/597076f11dc79b329518f50b/default';
    //     s1.charset = 'UTF-8';
    //     s1.setAttribute('crossorigin', '*');
    //     s0.parentNode.insertBefore(s1, s0);
    // })();

    
});