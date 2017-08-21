(function ($) {

    "use strict";

    /* ================================================
     Header Scroll Effect
     ================================================ */

    if ($('.custom-header').length) {

        var lastScrollTop = $(window).scrollTop();
        var windowWidth = $(window).width();

        $(window).scroll(function (event) {
            if (windowWidth > 767) {

                var scrollAmt = $(this).scrollTop();
                var deltaS = scrollAmt - lastScrollTop;

                if (scrollAmt < 1500) {
                    // $('.custom-header').css({
                    //     'backgroundPosition': '50% 50%',
                    //     'backgroundSize': (200+scrollAmt) + '% ' + (200+scrollAmt) + '%'
                    // });
                    $('.custom-header .container').css({
                        'opacity': "-=" + deltaS / 300
                    });
                }
                lastScrollTop = scrollAmt;
            }
        }); // scroll

    }

    /* ================================================
     Toggle Accordian
     ================================================ */


    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function () {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        }
    }


})(jQuery); // End $fn
