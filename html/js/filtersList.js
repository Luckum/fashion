/**
 * Код, выполняемый после загрузки DOM.
 */
$(document).ready(function() {

    /**
     * Контейнер для фильтров.
     * @type {*|jQuery|HTMLElement}
     */
    var container = $('#set_filters');
    var container2 = $('#set_filters_2');

    /**
     * Выбор фильтра.
     */
    container.find('input:checkbox').on('change', function() {
        var fType = this.id.split('_')[2];
        if ($(this).is(':checked')) {
            $('#filter' + fType).show();
        } else {
            $('#filter' + fType).hide();
        }

        setOptionValue(null, null); // ---------- если сняли выделение родительского
                                    // ---------- чекбокса, убрать из url все дочерние ключи и наоборот,
                                    // ---------- вставить их, если они были до этого выбраны
    });

    container2.find('input:checkbox').on('change', function() {
        var fType = this.id.split('_')[2];
        if ($(this).is(':checked')) {
            $('#filter2' + fType).show();
        } else {
            $('#filter2' + fType).hide();
        }

        setOptionValueSecond(null, null); // ---------- если сняли выделение родительского
                                    // ---------- чекбокса, убрать из url все дочерние ключи и наоборот,
                                    // ---------- вставить их, если они были до этого выбраны
    });

    /**
     * Преобразуем простые списки в multiselect и
     * навешиваем необходимые обработчики событий.
     */
    container.find('select:not(".size-cat")').each(function() {
        $(this)
            .find('option[value="0"], option[value=""]')
            .remove();
        $(this).multiselect({
            'onChange' : setOptionValue
        });
    });

    container2.find('select:not(".size-cat")').each(function() {
        $(this)
            .find('option[value="0"], option[value=""]')
            .remove();
        $(this).multiselect({
            'onChange' : setOptionValueSecond
        });
    });

    /**
     * Подгрузка размеров для категории.
     */
    $('.size-cat').on('change', function() {
        var szSel = $(this);
        if (!szSel.hasClass('size-cat')) {return false;}
        szSel
            .prop({'id' : 'sz', 'name' : 'sz[]', 'multiple' : 'multiple'})
            .removeClass('size-cat');
        var url  = globals.url + '/members/size/getSizeListForSubCat';
        var data = {
            'category' : szSel.find('option:selected').val(),
            'type'     : 'size'
        };
        szSel
            .empty()
            .append(new Option('Loading...'));
        $.post(url, data, function(response) {
            szSel
                .html(response)
                .find('option[value=""]')
                .remove();
            szSel.multiselect({
                'onChange' : setOptionValue
            });
        });
    });

});

/**
 * Обработка выбранного значения фильтра.
 * @param option
 * @param checked
 */
function setOptionValue(option, checked) {
    var params = '';
    $('div[id^="filter"][style="display: block;"]').each(function() {
        var key   = $(this).find(':first-child').prop('id');
        var items = $(this).find('input:checked');

        items.each(function() {
            params += '/' + key + '/' + $(this).val();
        });
    });
    $('#HomepageBlock_url').val('/filter' + params);
    $('#MainMenuImages_url1').val('/filter' + params);
}

function setOptionValueSecond(option, checked) {
    var params = '';
    $('div[id^="filter2"][style="display: block;"]').each(function() {
        var key   = $(this).find(':first-child').prop('id');
        var items = $(this).find('input:checked');

        items.each(function() {
            params += '/' + key + '/' + $(this).val();
        });
    });
    $('#MainMenuImages_url2').val('/filter' + params);
}