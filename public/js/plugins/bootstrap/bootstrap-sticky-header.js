// Helper function:
var supportsES6 = function() {
    try {
        new Function("(a = 0) => a");
        return true;
    } catch (err) {
        return false;
    }
}();



var StickyHeader = (function(window, document) {

    // version 3.0 - MJF @ websemantics.uk 2017

    "use strict";
    if (!supportsES6) { return false; }

    const stickyClass = "sticky_header";
    const header = document.querySelector("." + stickyClass);
    const hiddenClass = stickyClass + "-hidden";
    const transparentClass = "navbar-transparent";
    const hiddenTransparentClass = transparentClass + "-remove";

    // The amount of downward movement before header is hidden
    const downTolerance = 8;
    let hasScrolled = false;
    let lastScrollTop = 0;

    var _redraw = function() {

        // This is costly to performance but unavoidable
        const pageY = window.scrollY;

        // Put it away -> Scroll down
        if (pageY > (lastScrollTop + downTolerance)) {
            if (header) {
                header.classList.add(hiddenClass);
            }
            // Remove <li> open
            $("." + stickyClass).find('.open').removeClass('open');
            // Transparent Class
            if ($("." + stickyClass).find('.navbar').hasClass(transparentClass)) {
                $("." + stickyClass).find('.navbar').removeClass(transparentClass).addClass(hiddenTransparentClass);
            }
        }

        // Pull em down -> Scroll Up
        if (pageY < lastScrollTop || pageY <= 0) {
            if (header) {
                header.classList.remove(hiddenClass);
            }
            // Transparent Class
            if ($("." + stickyClass).find('.navbar').hasClass(hiddenTransparentClass) && pageY == 0) {
                $("." + stickyClass).find('.navbar').removeClass(hiddenTransparentClass).addClass(transparentClass);
            }
        }

        lastScrollTop = pageY;
        hasScrolled = false;
    };

    // Important: keep this function as performant as possible!
    var _onScroll = function() {
        if (!hasScrolled) {
            window.requestAnimationFrame(_redraw);
        }
        hasScrolled = true;
        window.requestAnimationFrame(_onScroll);
    };

    _onScroll();

}(window, document));