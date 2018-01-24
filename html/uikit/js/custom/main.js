$(document).ready(function() {
	select_init();
	callback();
	scrollbar();
	navbar_toggle();
	if (is.desktop()){
		zoom_img();
	};
	accordion_click();
	thumb_click();
	upload_file();
	bag_init();
	update_dropdown_bag();
	update_dropdown();
	open_homepage_menu();
});

function open_homepage_menu(){
	var $btn_toggle = $('.uk-navbar-toggle-home[data-uk-toggle]');
	$btn_toggle.on('click', function() {
		if ($(window).scrollTop() < 380) {
			$("html,body").stop().animate({scrollTop: 380});
		};
	});
}

function select_init() {
	$(".js-select").select2({
		minimumResultsForSearch: '-1'
	});
}

function callback() {
	$(function(fix) {
		var el = fix('.button-to-top');
		fix(window).on('scroll', function() {
			el['fade' + (fix(this).scrollTop() > 100 ? 'In' : 'Out')](500);
		});
	});
}

function scrollbar(){
	var scrollPaneSettings = {
		verticalDragMinHeight: 32,
		verticalDragMaxHeight: 32,
	};
	var $scrollPane = $('.scroll-pane');

	$scrollPane.each(function() {
		var $this = $(this);
		$this.jScrollPane(scrollPaneSettings);
	});
	var scrollPaneApi = $scrollPane.data('jsp');
	$('[data-uk-dropdown]').on('show.uk.dropdown', function(){
		$scrollPane.each(function() {
			var $this = $(this);
			var scrollPaneApi = $this.data('jsp');
			scrollPaneApi.reinitialise();
		});
	});
	var throttleTimeout;
	$(window).on('resize', function () {
		if (!throttleTimeout) {
			throttleTimeout = setTimeout( function() {
				scrollPaneApi.reinitialise();
				throttleTimeout = null;
			}, 50);
		}
	});
}

function update_dropdown() {
	var resizeTimer;
	$(window).on('resize', function(e) {
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(function() {
			UIkit.dropdown('.filter-wrapper', {
				mode: 'click',
				justify: '#dropdown-nav'
			}).checkDimensions();
		}, 150);
	});
}


function bag_init() {
	$('.open-bag').on('click', function() {
		bag();
	});
}

function bag() {
	UIkit.dropdown('.dropdown-bag-wrapper', {
		mode: 'click',
		pos: 'bottom-right'
	}).show();
}

function update_dropdown_bag(){
	$(window).on('resize', function() {
		UIkit.dropdown('.dropdown-bag-wrapper', {
			mode: 'click',
			pos:'bottom-right'
		}).checkDimensions()
	});
}

function navbar_toggle() {
	var $window = $(window);
	var $body = $('body');
	var target;
	var $btn_toggle = $('.uk-navbar-toggle[data-uk-toggle]');
	$btn_toggle.on('click', function() {
		$btn_toggle.toggleClass('active-menu');
		$body.toggleClass("mobile-menu-open");
		navbar_height();
	});
	$window.on('resize', function() {
		if ($window.width() > 768) {
			$(target).css('height', '');
			$btn_toggle.removeClass('active-menu');
			$body.removeClass("mobile-menu-open");
		}
		navbar_height();
	});
	function navbar_height() {
		var windowHeight = window.innerHeight;
		var data_str = $btn_toggle.data('uk-toggle');
		var data = UIkit.Utils.str2json(data_str);
		target = data.target;
		var header_height = $('.uk-navbar').height();
		var menu_height = windowHeight - header_height;
		if ($btn_toggle.hasClass('active-menu')) {
			$(target).css('height', menu_height + 'px');
		} else {
			$(target).css('height', '');
		}
	}
}

function zoom_img(){
	$('.zoom').on('click', function() {
		if ($(this).hasClass('zoomed')) {
			$('.zoomContainer').remove();
			$(this).removeClass('zoomed');
		} else {
			$(this).elevateZoom({
				borderSize: 1,
				borderColour: '#b1b1b1'
			});
			$(this).addClass('zoomed');
		}
	});
}

function accordion_click(){
	var $accordion = $('.account-wrapper');
	var $accordion_title = $accordion.find('.accordion-title');
	var $uk_accordion_title = $accordion.find('.uk-accordion-title');
	var activeIndex = 0;
	$accordion_title.on('click', function(){
		var $this = $(this);
		if ($this.hasClass('active')) return;
		$uk_accordion_title.eq($this.index()).trigger('click');
	});
	$accordion.on('toggle.uk.accordion', function(){
		if (!$uk_accordion_title.filter('.uk-active').length) {
			$uk_accordion_title.eq(activeIndex).trigger('click');
		}
		$uk_accordion_title.each(function(index){
			if ($(this).hasClass('uk-active')){
				activeIndex = index;
				return false;
			};
		});
		$accordion_title.removeClass('active');
		$accordion_title.eq(activeIndex).addClass('active');
		if ($uk_accordion_title.eq(activeIndex).data('account-edit') == true) {
			$accordion.find('.edit-account-link').removeClass('uk-hidden');
		}
		else {
			$accordion.find('.edit-account-link').addClass('uk-hidden');
		}
	});
}

function thumb_click(){
	$link = $('.reduce-price');
	$link.on('click', function(){
		var $this =  $(this);
		var $thumbnail = $this.closest('.thumbnail-wrapper');
		var $thumbnail_reduce = $thumbnail.find('.thumbnail-click-block');
		$thumbnail_reduce.show();
		return false;
	})
}

function upload_file(){
	$.uploadPreview({
		input_field: ".image-upload",
		preview_box: ".image-preview",
		label_field: ".image-label",
		label_default: "add image",
		label_selected: "change image",
		no_label: false
	});

	$.uploadPreview({
		input_field: ".image-upload_account",
		preview_box: ".image-preview_account",
		label_field: ".image-label_account",
		label_default: "add new item for sale",
		label_selected: "change item for sale",
		no_label: false
	});
}