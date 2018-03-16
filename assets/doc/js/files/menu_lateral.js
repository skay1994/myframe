/**
 * Created by skay_ on 02/05/2017.
 */
document.addEventListener('DOMContentLoaded',function () {
    var currentUrl = window.location.pathname.split('#')[0].split('?')[0],
        sidebar = $('.sidebar');

    sidebar.find('a[href="'+ currentUrl +'"]')
        .addClass('active');
});