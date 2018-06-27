// Login client functions -------------

// show login window
//
$('#login_main, #wishlist_main').click(function () {
    var url = $(this).attr('href');
    var wrapper = $('#login_content');

    $.ajax({
        'url': url,
        success: function (data) {
            $(wrapper).html(data);
        }
    });

    return false; // without redirect
});

$('#login_mobile').click(function () {
    var url = $(this).attr('href');
    var wrapper = $('#login_content');

    $.ajax({
        'url': url,
        success: function (data) {
            $(wrapper).html(data);
        }
    });

    return false; // without redirect
});

function loginCart (url, returnUrl) {
    console.log(url);
    var wrapper = $('#login_content');

    $.post(url, { return : returnUrl }, function (data) {
        $(wrapper).html(data);
    });

    return false; // without redirect
}

function authResponseHandler(data, type) {
    var obj = null;
    var isJson = true;
    try{
        obj = JSON.parse(data);
    }catch(error){
       isJson = false;
    }

    if(isJson){
        if (obj.hasOwnProperty('sendSellForm') && obj.sendSellForm == '1') {
            if (typeof submitSellForm != 'undefined') {
                submitSellForm();
            }
        }
        if (obj.hasOwnProperty('commentsForm') && obj.commentsForm == '1') {
            if (typeof submitCommentForm != 'undefined') {
                submitCommentForm();
            }
        }
        if (obj.hasOwnProperty('redirect')) {
            window.location.href = obj.redirect;
        }        
    }else{ // ------------------ html response
        var divSelector = '#div-' + type + '-reload';
        var div = $(data).find(divSelector);
        var content = $(div).html();

        $(divSelector).empty();
        $(divSelector).html(content);
        
        var countryHidden = $(divSelector).find('.country_hidden.error');
        if (countryHidden.length > 0) {
            var placeholder = countryHidden.attr('placeholder');
            if (typeof placeholder !== typeof undefined && placeholder !== false) {
                countryHidden.parent().find('.country_input').addClass('error').attr('placeholder', placeholder);
            }
        }

        if (typeof setCountryAutocomplete !== 'undefined') {
            setCountryAutocomplete();
        }        
    }
}

// $('#checkout').click(function () {
//     var url = $(this).attr('href');
//     var wrapper = $('#login_content');
//     var part = location.href.split('/');

//     if (part[part.length - 1] == 'cart') {
//         $('.cart-pos').css('display', 'none');
//         return false;
//     }

//     $.ajax({
//         'url': url,
//         success: function (data) {
//             $(wrapper).html(data);
//         }
//     });

//     return false; // without redirect
// });






