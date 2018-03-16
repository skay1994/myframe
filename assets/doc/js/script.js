/**
 * Created by skay_ on 02/05/2017.
 */

function copyToClipboard($text,$link) {
    window.prompt($text, $link);
}

(function () {
    'use strict';

    $('.config_name').on('click',function () {
        var $this = $(this);
        $this = $this.parent().find('.config_description');

        if($this.hasClass('hidden')){
            $this.fadeTo(600,1);
            $this.removeClass('hidden');
        } else {
            $this.fadeTo(600,0);
            setTimeout(function () {
                $this.addClass('hidden');
            },600)
        }
    })
})();
/**
 * Created by skay_ on 02/05/2017.
 */
document.addEventListener('DOMContentLoaded',function () {
    var currentUrl = window.location.pathname.split('#')[0].split('?')[0],
        sidebar = $('.sidebar');

    sidebar.find('a[href="'+ currentUrl +'"]')
        .addClass('active');

    $('[data-toggle="tooltip"]').tooltip();
});
/**
 * Created by skay_ on 12/05/2017.
 */
$('a[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = $(this.hash);

        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 1000);
            return false;
        }
    }
});