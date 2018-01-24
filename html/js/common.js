// $(document).on("click", '.changeLang',function(){
//     var listLang = ['en', 'ru', 'de'];
//     var splitPath = location.pathname.split('/');
//     var lang = $(this).data('lang');
//     var flag = true;

//     for (var l in listLang) {
//         if (splitPath[1] == listLang[l]) {
//             splitPath[1] = lang;
//             flag = false;
//         };
//     };
//     if (flag) {
//         splitPath.splice(1, 0, lang);
//     };

//     var curUrl = "http://"+location.hostname+splitPath.join("/");
//     document.location.href = curUrl;
//     return false;
// });

jQuery(document).ready(function($) {
    $('#cart-mobile-link').off('mouseenter').on('mouseenter', function () {
        var modal = UIkit.modal('#cart-mobile-window');

        if(!modal.isActive()){
            $('.uk-modal-cart').css('position', 'relative');
            modal.show();
        }
    });


    $(document).on("click", '#cart .icon-remove-circle', function () {
        $.ajax({
            type: 'POST',
            data: {id: $(this).data('id')},
            url: globals.url + '/members/shop/removeFromBag',
            success: function (data, textStatus, jqXHR) {
                $("#cart").html(data);
                $("#count_bag").html($("#count_in_bag").val());
            }
        });
        return false;
    });

    $(document).on("click", '.table_cart .icon-remove-circle', function () {
        $.ajax({
            type: 'POST',
            data: {id: $(this).data('id'), checkout: true},
            url: globals.url + '/members/shop/removeFromBag',
            success: function (data, textStatus, jqXHR) {
                $(".tab_checkout_cart").html(data);
                $("#count_bag").html($("#check_count_in_bag").val());
            }
        });
        return false;
    });

    $(document).on("click", '.add_item', function () {
        location.href = globals.url + '/sell-online';
        return false;
    });

    $(document).on("click", '#menu_cart', function () {
        $("#cart").toggle();
        $('.scrollbar-inner').scrollbar();
        return false;
    });

    $(document).on("click", '#cart .close', function () {
        $("#cart").hide();
        return false;
    });

    $('li.nav-correction > a').on('mouseover', function() {
        $(this).trigger('click', ['fire_event']);
    }).on('click', function(e, extra) {
        if (typeof extra == 'undefined' /* Исправление поведения меню */) {
            $(this)
                .parent()
                .find('.uk-dropdown')
                .remove();
            location.href = $(this).prop('href');
        }
    });

    $(document).on("mouseover", '#navbar-collapse .navbar-main li.category_menu', function () {
        $(this).trigger('click');

        var elements = $('#navbar-collapse .navbar-main > li > a');

        $(elements).each(function (index) {
            $(this).attr('style', 'text-decoration: none !important');
        });

        $(this).find('a').eq(0).attr('style', 'text-decoration: underline');
    });

    $(document).on("mouseout", '#navbar-collapse .navbar-main li.category_menu', function () {
        var elements = $('#navbar-collapse .navbar-main > li > a');

        $(elements).each(function (index) {
            $(this).removeAttr('style');
        });

        $(this).removeClass('uk-open');
        $(this).attr('aria-expanded', false);
    });

    $(document).on("click", '#navbar-collapse .navbar-main li.category_menu', function () {
        $(this).addClass('uk-open');
        $(this).attr('aria-expanded', true);
    });
});