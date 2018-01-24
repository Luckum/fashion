function drawChart(sel, dataChart) {
    if ($.isEmptyObject(dataChart.data) === true) {
        dataChart.labels = [0];
        dataChart.data = {};
        dataChart.data[0] = [0];
    }

    $('#' + sel).replaceWith('<canvas id="' + sel + '"></canvas>');

    var ctx = $("#" + sel).get(0).getContext("2d");
    var options = {
        responsive: true,
        animation: false,
        showXLabels: 40

    };

    var datasets = [];
    var i = 0;
    $.each(dataChart.data, function (key, value) {
        var dataset = {};
        var color;
        color = randomColor();
        dataset.fillColor = color;
        dataset.strokeColor = color;
        dataset.highlightFill = color;
        dataset.highlightStroke = color;
        dataset.data = value;
        datasets[i] = dataset;
        i++;
    });

    var data = {
        labels: dataChart.labels,
        datasets: datasets
    };

    var myBarChart = new Chart(ctx).Bar(data, options);

}

function getReportChartData(from_date, to_date, param, value, type_chart) {
    var data = {from_date: from_date, to_date: to_date, type_chart: type_chart};

    if (param == 'category') {
        data[param] = value;
    } else if (param == 'country') {
        data[param] = value;
    }

    var response = $.ajax({
        type: 'POST',
        url: globals.url + '/control/reports/dataChart',
        data: data,
        dataType: 'json',
        async: false
    }).responseText;
    var responseJson = JSON.parse(response);

    return responseJson;
}

function getDasboardChartData(from_date, to_date, type_chart) {
    $.ajax({
        type: 'POST',
        url: globals.url + '/control/index/dataChart',
        data: {from_date: from_date, to_date: to_date, type_chart: type_chart},
        success: function (data) {
            var dataChart = JSON.parse(data);

            drawChart(type_chart + '_chart', dataChart);
        }
    });
}

















