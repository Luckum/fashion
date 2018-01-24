/**
 * Поиск по товарам, брэндам, категориям, пользователям.
 * @author is5157 <ca74224497@gmail.com>.
 * @requires jQuery (https://jquery.com/).
 * @requires jQuery Scrollbar (https://github.com/gromo/jquery.scrollbar/).
 */

/**
 * Конструктор класса.
 * @constructor
 * @param {string} textfield.
 * @param {string} container.
 * @param {string} action.
 */
var UserSearch = function(textfield, container, action) {

    var search = this;

    /**
     * Текстовое поле поиска.
     * @type {*|jQuery|HTMLElement}.
     * @private.
     */
    search._textfield = $('#' + textfield);

    /**
     * Контейнер, содержащий результаты поиска.
     * @type {*|jQuery|HTMLElement}.
     * @private.
     */
    search._container = $('#' + container);

    /**
     * URL действия на сервере.
     */
    search._action = action;

    /**
     * Определение мобильного устройства.
     * @type {boolean}
     */
    try {
        document.createEvent('TouchEvent');
        search.isMobile = true;
    } catch (e) {
        search.isMobile = false;
    }

    /**
     * События текстового поля поиска.
     */
    search._textfield
        .on('keypress', function(e) {
            // Запуск поиска по нажатию кнопки Enter.
            if (e.keyCode == 13) {
                $(this).trigger('enter');
                e.preventDefault();
            } else if ($(this).hasClass('search-input-error')) {
                $(this).prop('class', 'search-input-normal');
            }
        })
        .on('enter', function() {
            // Запускаем поиск.
            search.start();
        });

    /**
     * Меняем внешний вид поиска для мобильной версии.
     */
    if (search.isMobile) {
        search._container
            .removeClass()
            .parent()
            .addClass('mobile-view');
    }

};

/**
 * Восстанавливаем значения по умолчанию для элементов поиска.
 */
UserSearch.prototype.setSearchDefaults = function() {
    this._textfield
        .prop('disabled', false)
        .val('')
        .focus();
    this._container.empty();
};

/**
 * Поиск.
 */
UserSearch.prototype.start = function() {

    /* Запускаем поиск. */

    var search = this;

    // Удаляем слэши из строки запроса (если оставлять, возникают проблемы роутинга).
    search._textfield.val(
        search._textfield.val().replace(/\\|\//g, '')
    );

    // Строка поиска не должна быть пустой.
    if (!search._textfield.val().length) {
        search._textfield.prop('class', 'search-input-error');
        return false;
    }

    // Проверяем, есть ли данные в кэше.
    var cache, diff;
    if (typeof localStorage != 'undefined' && (cache = localStorage.getItem(search._textfield.val()))) {
        cache = JSON.parse(cache);
        diff  = (new Date().getTime() - cache.timestamp) / 60000;
        if (diff > 15 /* Время жизни кэша 15 минут */) {
            localStorage.removeItem(search._textfield.val());
        } else {
            // Берем данные из кэша.
            return this.showResultTab(cache.data);
        }
    }

    // Блокируем текстовое поле поиска.
    search._textfield.prop('disabled', 'disabled');

    // Информируем пользователя о получении данных с сервера.
    search._container
        .empty()
        .html('<img src="' + location.origin + '/images/ajax.gif" />');

    // Посылаем на сервер поисковый запрос.
    $.post(location.origin + search._action, {'query' : search._textfield.val()})
        .done(function(response) {
            if (response) {
                // Ответ от сервера.
                response = JSON.parse(response).data;

                // Заносим результат поиска в кэш.
                if (typeof localStorage != 'undefined' && !localStorage.getItem(search._textfield.val())) {
                    try {
                        localStorage.setItem(
                            search._textfield.val(), JSON.stringify({
                                'timestamp' : new Date().getTime(),
                                'data'      : response
                            })
                        );
                    } catch (e) {
                        console.log('error: ' + e.message);
                    }
                }

                // Отображаем таблицу с результатом.
                search.showResultTab(response);
            }
        }).fail(function() {
            // Произошла ошибка.
            search._container.html('<p>Something wrong! Maybe incorrect search string?</p>');
            search._textfield.prop('class', 'search-input-error');
        }).always(function() {
            // Разблокировка текстового поля поиска.
            search._textfield
                .prop('disabled', false)
                .blur();
        });

};

/**
 * Отображает результат поиска.
 * @param response.
 */
UserSearch.prototype.showResultTab = function(response) {

    var data = '';
    var count = 0;
    var tmp, key, i, hdr, icon, hcat;

    // Заголовок таблицы.
    var html = '<table id="search-result-tab">'                             +
        '<caption>'                                                         +
        '<i class="uk-icon-search"></i> Searching results (<span></span>):' +
        '</caption>'                                                        +
        '<thead>'                                                           +
        '<tr>';

    // Описание столбцов.
    var headers = [
        'Users',      'uk-icon-user',
        'Categories', 'uk-icon-list-alt',
        'Brands',     'uk-icon-briefcase',
        'Products',   'uk-icon-shopping-cart'
    ];

    // Формируем основное содержимое таблицы.
    for (key in response) {

        icon = headers.pop();
        hcat = headers.pop();

        if (response[key].length) {

            tmp = '<td class="wb"><ul>';

            for (i = 0; i < response[key].length; i++) {
                if (hcat=='Brands'){
                    var regex = /\S[b]\w+.\w+/g;
                    m=regex.exec(response[key][i]['link']);
                    
                        var link = $('<div/>')
                            .text(m)
                            .html();
                }else{
                // Защита от XSS-атак.
                var link = $('<div/>')
                    .text(response[key][i]['link'])
                    .html();}
                var text = $('<div/>')
                    .text(response[key][i]['name'])
                    .html();

                // Выделяем искомую подстроку в пункте списка.
                text = text.toLowerCase().indexOf(this._textfield.val().toLowerCase()) != -1 &&
                this._textfield.val().length > 1 ?
                    text.replace(
                        new RegExp('(' + this._textfield.val() + ')', 'i'), '<span>$1</span>'
                    ) : text;

                // Формируем пункт списка.
                tmp += '<li>'                                   +
                       '<a href="' + link.toLowerCase() + '">'  +
                       '<i class="uk-icon-chevron-right"></i> ' + text +
                       '</a>'                                   +
                       '</li>';
                count++;
            }

            tmp += '</ul></td>';

            hdr = '<td><i class="' + icon + '"></i>'
                                   + hcat + '</td>';
            if (this.isMobile) {
                tmp = hdr + tmp;
            } else {
                html += hdr;
            }

            data += tmp;

        }

    }

    html += '</tr>'    +
            '</thead>' +
            '<tbody>'  +
            '<tr>'     + data +
            '</tr>'    +
            '</tbody>' +
            '</table>';

    // Добавляем таблицу на страницу и
    // указываем в заголовке результат поиска.
    this._container
        .html(html)
        .find('caption > span')
        .text(count);

    // Если ничего не найдено, сообщаем об этом.
    var tab = $('#search-result-tab');
    if (!count) {
        // Ничего не найдено.
        tab.append('<tr><td colspan="4">Nothing :(</td></tr>');
    } else if (!this.isMobile) {
        // Инициализация полосы прокрутки.
        $('.scrollbar-inner').scrollbar();
    }

};