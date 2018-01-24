$(document).ready(function() {
    var data = {};
    cb(moment(), moment());

    var yearStartDate = moment().subtract(0, 'year').startOf('year');
    var yearEndDate = moment().subtract(0, 'year').endOf('year');

    var ranges = {
        'Last 24 hours' : [moment().startOf('day'), moment().endOf('day')],
        'Last 7 Days'   : [moment().subtract(6, 'days'), moment()],
        'Current Month' : [moment().subtract(0, 'month').startOf('month'), moment().subtract(0, 'month').endOf('month')],
        'Current Year'  : [yearStartDate, yearEndDate]
    };

    $('#dashboardRange').daterangepicker({
        'ranges' : ranges
    }, cb);

    $('#userReportRange, #saleReportRange, #orderReportRange, #deliveryReportRange').daterangepicker({
        'ranges' : ranges,
        'startDate' : yearStartDate,
        'endDate' : yearEndDate
    }, cb);

    $('#dashboardRange').on('apply.daterangepicker', function(ev, picker) {
        data.from_date = picker.startDate.format('YYYY-MM-DD H:m:s');
        data.to_date = picker.endDate.format('YYYY-MM-DD H:m:s');

        /* Временное решение */
        //**********************************************************************
        if (picker.chosenLabel == 'Last 24 hours') {
            var from = moment(server_date).subtract(1, 'days');
            var to = moment(server_date);
            data.from_date = from.format('YYYY-MM-DD H:m:s');
            cb(from, to);
        }
        //**********************************************************************

        loadContentFromDate(globals.url + '/control/index/dateRange', data);
        type_chart = ['users', 'products', 'orders'];
        for (type in type_chart) {
            getDasboardChartData(data.from_date, data.to_date, type_chart[type]);
        }
	});

    $('#userReportRange').on('apply.daterangepicker', function(ev, picker) {
        data.from_date = picker.startDate.format('YYYY-MM-DD H:m:s');
        data.to_date = picker.endDate.format('YYYY-MM-DD H:m:s');
        data.country = $('#country').val();

        if (picker.chosenLabel == 'Last 24 hours') {
            var from = moment(server_date).subtract(1, 'days');
            var to = moment(server_date);
            data.from_date = from.format('YYYY-MM-DD H:m:s');
            cb(from, to);
        }

        var succesFunc = function () {
            type_chart = 'users';
            dataChart = getReportChartData(picker.startDate.format('YYYY-MM-DD H:m:s'), picker.endDate.format('YYYY-MM-DD H:m:s'), "country", $('#country').val(), type_chart);
            drawChart('myChart', dataChart);
            $("#country_filter [value='"+$('#country').val()+"']").attr("selected", "selected");
        }

        loadContentFromDate(globals.url + '/control/reports/usersGrid', data, succesFunc);        
    });

    $('#saleReportRange').on('apply.daterangepicker', function(ev, picker) {
        data.from_date = picker.startDate.format('YYYY-MM-DD H:m:s');
        data.to_date = picker.endDate.format('YYYY-MM-DD H:m:s');
        data.category = $('#category').val();

        if (picker.chosenLabel == 'Last 24 hours') {
            var from = moment(server_date).subtract(1, 'days');
            var to = moment(server_date);
            data.from_date = from.format('YYYY-MM-DD H:m:s');
            cb(from, to);
        }

        var succesFunc = function () {
            type_chart = 'sale';
            dataChart = getReportChartData(picker.startDate.format('YYYY-MM-DD H:m:s'), picker.endDate.format('YYYY-MM-DD H:m:s'), "category", $('#category').val(), type_chart);
            drawChart('myChart', dataChart);
            $("#category_filter [value='"+$('#category').val()+"']").attr("selected", "selected");
        }

        loadContentFromDate(globals.url + '/control/reports/saleGrid', data, succesFunc);        
    });

    $('#orderReportRange').on('apply.daterangepicker', function(ev, picker) {
        data.from_date = picker.startDate.format('YYYY-MM-DD H:m:s');
        data.to_date = picker.endDate.format('YYYY-MM-DD H:m:s');

        if (picker.chosenLabel == 'Last 24 hours') {
            var from = moment(server_date).subtract(1, 'days');
            var to = moment(server_date);
            data.from_date = from.format('YYYY-MM-DD H:m:s');
            cb(from, to);
        }

        var succesFunc = function () {
            type_chart = 'orders';
            dataChart = getReportChartData(picker.startDate.format('YYYY-MM-DD H:m:s'), picker.endDate.format('YYYY-MM-DD H:m:s'), "", "", type_chart);
            drawChart('myChart', dataChart);
        }

        loadContentFromDate(globals.url + '/control/reports/ordersGrid', data, succesFunc);
        
    });

    $('#deliveryReportRange').on('apply.daterangepicker', function(ev, picker) {
        data.from_date = picker.startDate.format('YYYY-MM-DD H:m:s');
        data.to_date = picker.endDate.format('YYYY-MM-DD H:m:s');

        if (picker.chosenLabel == 'Last 24 hours') {
            var from = moment(server_date).subtract(1, 'days');
            var to = moment(server_date);
            data.from_date = from.format('YYYY-MM-DD H:m:s');
            cb(from, to);
        }

        var succesFunc = function () {
            type_chart = 'delivery';
            dataChart = getReportChartData(picker.startDate.format('YYYY-MM-DD H:m:s'), picker.endDate.format('YYYY-MM-DD H:m:s'), "", "", type_chart);
            drawChart('myChart', dataChart);
        }

        loadContentFromDate(globals.url + '/control/reports/deliveryGrid', data, succesFunc);
        
    });
});

function cb(start, end) {
    $('#dashboardRange span, #userReportRange span, #saleReportRange span, #orderReportRange span, #deliveryReportRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
}

function loadContentFromDate(url, dataObj, successFunc) {
    $.ajax({
        type: 'POST',
        data: dataObj,
        url: url,
        success: function(data, textStatus, jqXHR) {
            $("#grid-container").html(data);
            $('#from_date').val(dataObj.from_date);
            $('#to_date').val(dataObj.to_date);           

            if (typeof successFunc === "function") {
                successFunc();
            }
        }
    });
    return false;
}
