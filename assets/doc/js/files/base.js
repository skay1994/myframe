/**
 * Created by skay_ on 02/05/2017.
 */

function copyToClipboard($text,$link) {
    window.prompt($text, $link);
}

(function () {
    'use strict';

    $('[data-toggle="tooltip"]').tooltip();

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