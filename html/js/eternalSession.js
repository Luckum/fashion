var eternal_session = {
    url: null,
    period: null,

    request: function () {
        $.ajax({
            url: eternal_session.url,
            type: 'POST'
        });
    },

    start: function () {
        if(this.url === null || this.period === null) return;

        setInterval(this.request, this.period);
    }
};

eternal_session.url = '/eternal';
eternal_session.period = 600000; // --------------- 10 minute
eternal_session.start();


