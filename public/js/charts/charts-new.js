$(document).ready(function () {
    $('.searchable').select2({
        theme: 'bootstrap-5'
    });
    buildDateRangePicker('#date-picker', '#date_from', '#date_to', false, refreshCharts);
    $('#chart-type').change(() => fetchCharts());
    $('#refresh').click(() => fetchCharts());
});

function refreshCharts() {
    fetchCharts();
}

function fetchCharts() {
    let dateFrom = $('#date_from').val();
    let dateTo = $('#date_to').val();
    let chartType = $('#chart-type').val();
    let url = '/charts/fetch-chart-data';
    if (chartType) {
        url += '?chart_name=' + chartType;
        if (dateFrom)
            url += '&date_from=' + dateFrom;
        if (dateFrom && dateTo) {
            url += '&date_to=' + dateTo;
        }
        fetch(url).then(response => response.json())
            .then(data => {
                $('#chart-container').html('');
                processChartData(data);
            });
    } else {
        alert('Please select Chart Type');
    }
}

function processChartData(data) {
    data.forEach(function (item) {
        let chartTitle = item.label;
        let chartData = {labels: item.labels, data: item.data, is_horizontal: item.is_horizontal, size: item.size};
        window[item.js_function] && window[item.js_function](chartTitle, chartData);
    });
}

function buildBarChart(chart_name, chartData) {
    buildChartColAndCard(chart_name, chartData.size);
    Highcharts.chart(chart_name + '-chart', {
        credits: {
            enabled: false
        },
        chart: {
            type: chartData.is_horizontal ? 'bar' : 'column',
            height: (100 + chartData.labels.length * 25) < 400 ? 400 : (100 + chartData.labels.length * 25),
        },
        title: {
            text: chart_name,
            style: {
                fontSize: '14px'
            }
        },
        xAxis: {
            categories: chartData.labels,
        },
        yAxis: {
            title: {
                text: 'Values',
            },
        },
        plotOptions: {
            series: {
                colorByPoint: true,
                colors: Highcharts.getOptions().colors.slice(0, chartData.labels.length)
            },
        },
        series: [{
            name: chartData.label || '',
            data: chartData.data,
        }],
        legend: {
            enabled: false,
        },
    });
}


function buildChartColAndCard(chartId, size) {
    let chartContainer = $('#chart-container');

    let newDiv = document.createElement("div");
    newDiv.classList.add(size);
    newDiv.classList.add("mb-3");
    if (chartContainer.html().trim() === '')
        newDiv.classList.add("mt-3");
    let cardDiv = document.createElement("div");
    cardDiv.classList.add("card");
    let cardBodyDiv = document.createElement("div");
    cardBodyDiv.classList.add("card-body");
    cardBodyDiv.id = chartId + '-chart-id';
    let chartDiv = document.createElement("div");
    chartDiv.id = chartId + '-chart';
    cardBodyDiv.appendChild(chartDiv);
    cardDiv.appendChild(cardBodyDiv);
    newDiv.appendChild(cardDiv);
    // chartContainer.append('<div class="col-md-2"></div>');
    chartContainer.append(newDiv);
    // chartContainer.append('<div class="col-md-2"></div>');
}


