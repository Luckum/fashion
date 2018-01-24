var BlogSlider = {

    'init' : function() {

        // Корневой элемент слайдера.
        var slider = $('.slider').show();
        // Обертка.
        var slider_wrapper = slider.find('.slide-wrap');

        // Следующий слайд.
        $('.next-slide').on('click', function() {
            // Смещение.
            if(!slider_wrapper.is(':animated')) {
                slider_wrapper.animate({'left' : slider_wrapper.position().left - $('.slide-item > img').outerWidth()}, {
                    'duration' : 200,
                    'easing'   : 'linear',
                    'step'     : function() {},
                    'complete' : function() {
                        $(this)
                            .find('.slide-item:first')
                            .appendTo(slider_wrapper)
                            .parent()
                            .css({'left' : 0});
                    }
                });
            }
        });

        // Предыдущий слайд.
        $('.prev-slide').on('click', function() {
            if(!slider_wrapper.is(':animated')) {
                slider_wrapper
                    .css({'left' : slider_wrapper.position().left - $('.slide-item > img').outerWidth()})
                    .find('.slide-item:last')
                    .prependTo(slider_wrapper)
                    .parent()
                    .animate({'left' : 0}, {
                        'duration' : 200,
                        'easing'   : 'linear',
                        'step'     : function() {}
                    });
            }
        });

        // Ресайз слайдера.
        slider.css({
            'left'       : -slider.offset().left + 'px',
            'width'      : $(window).width()     + 'px'
        });

    }

};