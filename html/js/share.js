/**
 * Класс для интеграции с социальными сетями.
 */
var Share = {

    // Размеры диалогового окна.
    'width'  : 626,
    'height' : 400,

    'facebook' : function (link, caption, image, description, name) {
        var url = 'https://www.facebook.com/dialog/feed?'
            + 'app_id='        + globals.facebook_id
            + '&link='         + encodeURIComponent(link)
            + '&name='         + encodeURIComponent(name)
            + '&caption='      + encodeURIComponent(caption)
            + '&picture='      + encodeURIComponent(image)
            + '&description='  + encodeURIComponent(description)
            + '&redirect_uri=' + encodeURIComponent(document.location.origin) + '/site/share/'
            + '&display=popup';
        Share.popup(url);
    },

    'twitter' : function (link, title, tags) {
        var url = 'https://twitter.com/intent/tweet?'
            + 'text='      + encodeURIComponent(title)
            + '&url='      + encodeURIComponent(link)
            + '&hashtags=' + encodeURIComponent(tags);
        Share.popup(url);
    },

    'pinterest' : function (link, image, description) {
        var url = 'https://pinterest.com/pin/create/button/?'
            + 'url='          + encodeURIComponent(link)
            + '&media='       + encodeURIComponent(image)
            + '&description=' + encodeURIComponent(description);
        Share.popup(url);
    },

    'instagram' : function (link, image, description) {
        // instagram
    },

    popup: function (url) {
        var top  = (screen.height - this.height) / 2;
        var left = (document.body.clientWidth - this.width) / 2;
        window.open(url, '',
            'toolbar=0,status=0,width=' + this.width
            + ',height=' + this.height
            + ',top='    + top
            + ',left='   + left);
    }
};