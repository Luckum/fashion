$(document).ready(function() {
    var category = $('#category');
    var country = $('#country');
    var from_date = $('#from_date');
    var to_date = $('#to_date');
    var dataChart = {};

    $(document).on("change", '#country_filter',function(){
        country.val($(this).val());
        $.ajax({
            type: 'POST',
            data: {from_date: from_date.val(), to_date: to_date.val(), country: country.val()},
            url: globals.url + '/control/reports/usersGrid',
            success: function(data, textStatus, jqXHR) {
                $("#grid-container").html(data);
                $("#country_filter [value='"+country.val()+"']").attr("selected", "selected");
            }
        });
        type_chart = 'users';
        dataChart = getReportChartData(from_date.val(), to_date.val(), "country", country.val(), type_chart);
        drawChart('myChart', dataChart);
    });

    $(document).on("change", '#category_filter',function(){
        category.val($(this).val());
        $.ajax({
            type: 'POST',
            data: {from_date: from_date.val(), to_date: to_date.val(), category: category.val()},
            url: globals.url + '/control/reports/saleGrid',
            success: function(data, textStatus, jqXHR) {
                $("#grid-container").html(data);
                $("#category_filter [value='"+category.val()+"']").attr("selected", "selected");
            }
        });
        type_chart = 'sale';
        dataChart = getReportChartData(from_date.val(), to_date.val(), "category", category.val(), type_chart);
        drawChart('myChart', dataChart);
    });

    if ($('#userReportRange').length || $('#saleReportRange').length || $('#orderReportRange').length || $('#deliveryReportRange').length) {
        cb(moment().subtract(0, 'year').startOf('year'), moment());
        from_date.val(moment().subtract(0, 'year').startOf('year').format('YYYY-MM-DD H:m:s'));
        to_date.val(moment().format('YYYY-MM-DD H:m:s'));
    }

    if ($('#dashboardRange').length) {
        var from = moment(server_date).subtract(1, 'days');
        var to = moment(server_date);
        cb(from, to);
        from_date.val(from.format('YYYY-MM-DD H:m:s'));
        to_date.val(to.format('YYYY-MM-DD H:m:s'));
    }

    if (location.href.indexOf('reports/sale') != -1) {
        type_chart = 'sale';
        dataChart = getReportChartData(from_date.val(), to_date.val(), "category", category.val(), type_chart);
        drawChart('myChart', dataChart);
    } else if (location.href.indexOf('reports/users') != -1) {
        type_chart = 'users';
        dataChart = getReportChartData(from_date.val(), to_date.val(), "country", country.val(), type_chart);
        drawChart('myChart', dataChart);
    } else if (location.href.indexOf('reports/orders') != -1) {
        type_chart = 'orders';
        dataChart = getReportChartData(from_date.val(), to_date.val(), "", "", type_chart);
        drawChart('myChart', dataChart);
    } else if (location.href.indexOf('reports/delivery') != -1) {
        type_chart = 'delivery';
        dataChart = getReportChartData(from_date.val(), to_date.val(), "", "", type_chart);
        drawChart('myChart', dataChart);
    }
    
    if ($('#users_chart').length) {
        getDasboardChartData(from_date.val(), to_date.val(), 'users');
    }

    if ($('#products_chart').length) {
        getDasboardChartData(from_date.val(), to_date.val(), 'products');
    }

    if ($('#orders_chart').length) {
        getDasboardChartData(from_date.val(), to_date.val(), 'orders');
    }
});

function export_exel(){
    document.getElementById('frmsearch').submit();
    return false;
}

function randomColor() {
    var r=Math.floor(Math.random() * (256));
    var g=Math.floor(Math.random() * (256));
    var b=Math.floor(Math.random() * (256));
    
    return "rgb("+r+","+g+","+b+")";
}

