/**
 * main.js.
 * @author is5157 <ca74224497@gmail.com>.
 */
$(document).ready(function() {

    // Инициализация поиска.
    var search = new UserSearch(
        'search-text',
        'js-search-result',
        '/site/ajaxSearch'
    );

    // Обработка нажатия пункта "Search" в меню.
    var link = $('a[href$="#search"]');

    if (search.isMobile) {
        // Устанавливаем ссылку на мобильную версию поиска.
        link
            .prop('href', '#')
            .on('click', function() {
                location.href = location.origin + '/mobile-search';
            });

        // Стартовое диалоговое окно в мобильной версии.
        if (!$('i.uk-icon-power-off').length &&
            location.href == (location.origin + '/')) {
            // Отображаем меню.
            // $('a[href$="#mobile-start-dlg"]')
            //     .leanModal({'overlay' : 1, 'top' : 0})
            //     .click()
            //     .parent()
            //     .find('div')
            //     .css({
            //         'height'  : screen.height + 'px',
            //         'padding' : '50px 0 0 0'
            //     });
            // // Инициализируем кнопки логина и регистрации.
            // $('.register-link, .login-link').on('click', function() {
            //     $('#login_mobile').click();
            //     $('#lean_overlay').trigger('click');
            //     $('#login_content').on({'show.uk.modal' : (function() {
            //         var hdr_class = $(this).prop('class').indexOf('login-link') !== -1 ?
            //             '.login-hdr' : '.signup-hdr';
            //         setTimeout(function() {
            //             if ($(hdr_class).length) {
            //                 $(hdr_class).get(0).scrollIntoView(true);
            //             }
            //         }, 500);
            //     }).apply(this)});
            //     $('.wrapper').show();
            // });
            // // Скрываем контент позади меню.
            // $('.wrapper').hide();
        }
    } else {
        link
            .prop('href', '#search-dlg')
            .leanModal({
                'overlay'     : 0.9,
                'closeButton' : '.lnMod-cls-btn'
            })
            .on('click', function() {
                search.setSearchDefaults();
            });
    }

    /* Исправление отображения меню для Safari */
    var isSafari = navigator.userAgent.indexOf('Safari')  != -1 &&
                   navigator.userAgent.indexOf('Chrome')  == -1 &&
                   navigator.userAgent.indexOf('Android') == -1;
    if (isSafari && !search.isMobile) {
        $('body')
            .css('visibility', 'hidden')
            .animate({'scrollTop' : $(document).height()}, 'fast')
            .animate({'scrollTop' : 0}, 'fast', function() {
                $(this).css('visibility', 'visible');
            });
    }
    
    $('#newsletter-link').click(function() {
        if ($('#newsletter-frm').is(':visible')) {
            $('#newsletter-frm').slideUp();
        } else {
            $('#newsletter-frm').show();
            $('#newsletter-frm').addClass('uk-animation-slide-bottom');
            document.documentElement.scrollTop = document.documentElement.scrollHeight;
        }
    });
    
    $('#newsletter-btn').click(function() {
        $.ajax({
            url: "/site/subscribe",
            type: "POST",
            data: {email: $('#newsletter-email').val()},
            success: function(response) {
                var data = $.parseJSON(response);
                if (!(data && data.success)) {
                    if (data.error) {
                        $('#newsletter-frm').html(data.error);
                        setTimeout(function() { $('#newsletter-frm').slideUp(); }, 5000);
                    }
                } else {
                    $('#newsletter-frm').html('Thank you for subscribing!');
                    setTimeout(function() { $('#newsletter-frm').slideUp(); }, 3000);
                }
            },
        });
    });
    
});

$(window).on('load', function() {
    /**
     * Сообщение только для стран евросоюза.
     */
    /*var country;
    if (typeof geoplugin_countryCode != 'undefined') {
        $.cookie(
            'USR_CNT',
            (country = geoplugin_countryCode().toUpperCase()),
            {'expires' : 1}
        );
    } else {
        country = $.cookie('USR_CNT');
    }
    if (country) {
        // Список стран евросоюза.
        var EUCountries = [
            'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK',
            'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IE',
            'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL',
            'PT', 'RO', 'SK', 'SI', 'ES', 'SE', 'GB'
            // Возможно, когда-нибудь в этот список надо будет добавить UA.
            // Возможно, из этого списка стоит исключить GB,
            // потому что согласно официальным итогам плебисцита,
            // 52% жителей проголосовало за выход страны из ЕС.
        ];
        if ($.inArray(country, EUCountries) !== -1 && !$.cookie('eu-notif')) {
            // Показываем сообщение.
            $('.eu-notif').show();
            $('.eu-notif-btn').on('click', function() {
                // Удаляем сообщение при нажатии на кнопку ОК.
                $.cookie('eu-notif', 'true', {'expires' : 365});
                $(this).parent().remove();
            });
        }
    }*/
});

/* IE Origin Fix */
if (!window.location.origin) {
    window.location.origin = window.location.protocol + "//" +
                             window.location.hostname + (window.location.port ? ':' + window.location.port: '');
}