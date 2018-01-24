
// ------------- CODE FOR INPUT ERROR DISPLAY

// --------- for load case
//
$('.errorMessage').each(function(index, element){
    changeErrorMessageHandler(element, 'load');
});

// --------- for change case
//
$('.errorMessage').each(function (index, element) {
    $(element).on('DOMSubtreeModified', function () {
        changeErrorMessageHandler(element, 'change');
    });
});

// -------- for ajax case
//
$('#div-login-reload, #div-register-reload').on('DOMNodeInserted', function(){
    $('.errorMessage').each(function (index, element) {
        changeErrorMessageHandler(element, 'ajax');
    });
});


function changeErrorMessageHandler(element, mode) {
    var text = $(element).html();

    if(text.length > 0){
        var margin = '    ';
        var input = $(element).prev();

        if($(input).hasClass('image-label')){
            console.log('in if');
            $(input).html(text.toUpperCase());
            $(input).addClass('error');
            return;
        }

        $(input).addClass('error');
        $(input).parent().addClass('error');
        $(input).attr('placeholder', margin + text.toUpperCase());

        if(mode == 'ajax'){
            $(input).val('');
        }
    }
}

