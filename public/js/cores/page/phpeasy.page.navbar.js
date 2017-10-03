PHPEasy.Page.Navbar = PHPEasy.Page.Navbar || {};
PHPEasy.Page.Navbar = {
    Store: {
        lastScrollTop: 0
    },
    Init: function() {
        // $(window).scroll(function(event) {
        //     var st = $(this).scrollTop();
        //     if (st > lastScrollTop) {
        //         // downscroll code
        //     } else {
        //         // upscroll code
        //     }
        //     lastScrollTop = st;
        // });
    },
    AutoActive: function() {
        $(PHPEasy.Setting.Page.activeNavbarElement).each(function() {

            if ( /*regexCheck($(this).attr("href"), pgurl) ||*/ $(this).attr("href") == PHPEasy.Enum.pageUrl || $(this).attr("href") == '')

                $(this).parent().addClass("active");

        });
        // TODO: Dynamic in future
        $('ul.nav.navbar-top-links.text-center li').click(function(e) {
            if (!$(this).hasClass('open')) {
                $(this).children("ul.dropdown-menu.dropdown-menu-right.dropdown-tasks.collapse").addClass('in');
            } else {
                $(this).children("ul.dropdown-menu.dropdown-menu-right.dropdown-tasks.collapse").removeClass('in');
            }
        });
    }
}