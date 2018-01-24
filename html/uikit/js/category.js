
$(document).on("change", '#sort', function () {
    var sort = $(this).val();
    var data = {sort: sort};
    var pageSize = $("#h_pageSize").val();

    if (pageSize) {
        data.pageSize = pageSize;
    }

    $.ajax({
        type: 'GET',
        data: data,
        url: location.href,
        success: function (data, textStatus, jqXHR) {
            $("#products").html(data);
            $("#sort [value='" + sort + "']").attr("selected", "selected");
            $("#h_sort").val(sort);
            $("#h_pageSize").val(pageSize);
            if (pageSize == 'all') {
                $(".all").hide();
                $(".ten").show();
            } else {
                $(".all").show();
                $(".ten").hide();
            }
            ;
        }
    });
});

$(document).ready(function () {

    //to avoid unnecessary ajax requests
    window.isChangedFilterCond = false;

    $(document).on("click", '.filter-list li a', function () {
        //change filter condition, can perform ajax request
        window.isChangedFilterCond = true;
        if ($(this).parent().hasClass("filter-list-active")) {
            $(this).parent().removeClass("filter-list-active");
        } else {
            $(this).parent().addClass("filter-list-active");
        }

        if ($(this).hasClass("checked")) {
            $(this).removeClass("checked");
        } else {
            $(this).addClass("checked");
        }

        return false;
    });

    $(document).on("click", '#apply_filter', function () {
        if (window.isChangedFilterCond) {
            applyFilters();
            window.isChangedFilterCond = false;
        }
        return false;
    });

    $(document).on("click", '#save_filter', function () {
        saveFilters();
        return false;
    });

    $(document).on("click", '#clear_filter', function () {
        var filter = {category: {0: 0}, brand: {0: 0}, size_type: {0: 0}, country: {0: 0}, condition: {0: 0}, seller_type: {0: 0}};

        $.ajax({
            type: 'POST',
            data: {filter: filter, model: '', model_id: '', clear_all: true},
            url: location.href,
            success: function (data, textStatus, jqXHR) {
                $("#products").html(data);
            }
        });
        return false;
    });

    $(document).on("hide.uk.dropdown", '.filter-wrapper', function () {
        if (window.isChangedFilterCond) {
            applyFilters();
            window.isChangedFilterCond = false;
        }
    });

});

function saveFilters() {
    var filter = getFiltersFromPage();

    $.ajax({
        type: 'POST',
        data: {filter: filter, is_save_filters: true},
        url: location.href
    });
}

function applyFilters() {
    var filter = getFiltersFromPage();

    $.ajax({
        type: 'POST',
        data: {filter: filter, model: '', model_id: ''},
        url: location.href,
        success: function (data, textStatus, jqXHR) {
            $("#products").html(data);
        }
    });
}

function getFiltersFromPage() {
    var filter = {category: {0: 0}, brand: {0: 0}, size_type: {0: 0}, country: {0: 0}, condition: {0: 0}, seller_type: {0: 0}};

    jQuery.each($('#filter a.checked'), function (i, link) {
        filter[$(link).data('filter')][$(link).data('id')] = ($(link).text());
    });

    return filter;
}

function addItemToWishList(a, pid) {
    var info;
    var url = globals.url + '/members/profile/ajaxAddItemToWishlist';
    $.post(url, {pid: pid})
        .done(function (response) {
            info = JSON.parse(response).result;
        }).fail(function () {
        info = 'error';
    }).always(function () {
        if (info == 'ok') {
            info = 'Item added';
        } else if (info == 'exists') {
            info = 'Already added';
        } else if (info == 'error') {
            info = 'Failed';
        }
        $(a).replaceWith(info);
    });
    return false;
}
