// window.chart_name_obj = {};
//
// function fetchData(chart_name, date_from, date_to, chart_canvas_id, chart_title, callback) {
//     let urlParams = new URLSearchParams();
//     urlParams.append('chart_name', chart_name);
//     urlParams.append('date_from', date_from ?? '');
//     urlParams.append('date_to', date_to ?? '');
//     fetch('/charts/fetch-chart-data?' + urlParams.toString())
//         .then(function (response) {
//             return response.json();
//         })
//         .then(function (data) {
//             window[chart_name](chart_name, chart_canvas_id, chart_title, data)
//             // callback && callback(chart_name, chart_canvas_id, chart_title, data);
//         })
// }
//
// function posStatementCharts(chart_name, chart_canvas_id, chart_title, data)
// {
//     data.forEach(function (item) {
//         window[item.js_function](chart_name, chart_canvas_id, chart_title, item);
//     });
// }
//
// function getRandomColor() {
//     let letters = '0123456789ABCDEF';
//     let color = '#';
//     for (let i = 0; i < 6; i++) {
//         color += letters[Math.floor(Math.random() * 16)];
//     }
//     return color;
// }
//
// function handleStackedBarChartData(chartData) {
//     let data = chartData.data;
//
//     let categories = Object.keys(data);
//     let products = Array.from(new Set(categories.flatMap(category => Object.keys(data[category]))));
//
//     let datasets = [];
//     products.forEach(function (product) {
//         let productData = categories.map(function (category) {
//             return data[category][product] || 0;
//         });
//
//         datasets.push({
//             label: product,
//             data: productData,
//         });
//     });
//     return {
//         labels: categories,
//         datasets: datasets,
//     }
// }
//
// function handlePieChartData(chartData) {
//     return chartData.data.map((value, index) => ({
//         name: chartData.labels[index],
//         y: value,
//     }))
// }
//
// function buildPieChart(chart_name, chart_canvas_id, chart_title,chartData) {
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'pie',
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         plotOptions: {
//             pie: {
//                 dataLabels: {
//                     enabled: false,
//                 },
//             },
//         },
//         series: [{
//             data: handlePieChartData(chartData),
//         }],
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
// function buildStackedBarChart(chart_name, chart_canvas_id, chart_title,chartData) {
//     let chart_data = handleStackedBarChartData(chartData);
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'column',
//
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         xAxis: {
//             categories: chart_data.labels,
//         },
//         yAxis: {
//             title: {
//                 text: 'Values',
//             },
//             stackLabels: {
//                 enabled: false,
//             },
//         },
//         plotOptions: {
//             series: {
//                 stacking: 'normal',
//             },
//         },
//         series: chart_data.datasets.map(dataset => ({
//             name: dataset.label,
//             data: dataset.data,
//         })),
//         legend: {
//             enabled: false,
//         },
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildBarChart(chart_name, chart_canvas_id, chart_title,chartData) {
//
//     console.log(chart_name, chart_canvas_id, chart_title,chartData);
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'column',
//
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         xAxis: {
//             categories: chartData.labels,
//         },
//         yAxis: {
//             title: {
//                 text: 'Values',
//             },
//         },
//         plotOptions: {
//             series: {
//                 colorByPoint: true,
//                 colors: Highcharts.getOptions().colors.slice(0, chartData.labels.length)
//             },
//         },
//         series: [{
//             name: chartData.label || '',
//             data: chartData.data,
//         }],
//         legend: {
//             enabled: false,
//         },
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildHeatmapChart(chart_name, chart_canvas_id, chart_title,chartData) {
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'heatmap',
//
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         xAxis: {
//             categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
//             title: 'Day of Week'
//         },
//         yAxis: {
//             categories: chartData.labels.forEach(row => 'Week ' + row[0]),
//             title: 'Week Number'
//         },
//         colorAxis: {
//             min: 0,
//             minColor: '#FFFFFF',
//             maxColor: Highcharts.getOptions().colors[0],
//         },
//         series: [{
//             name: 'Total Sales',
//             borderWidth: 1,
//             data: chartData.data,
//             dataLabels: {
//                 enabled: true,
//                 color: '#000000'
//             }
//         }],
//         legend: {
//             align: 'right',
//             layout: 'vertical',
//             margin: 0,
//             verticalAlign: 'top',
//             y: 25,
//             symbolHeight: 280
//         },
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildFunnelChart(chart_name, chart_canvas_id, chart_title,chartData) {
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'funnel',
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         plotOptions: {
//             series: {
//                 dataLabels: {
//                     enabled: true,
//                     format: '<b>{point.name}</b> ({point.y:,.0f})',
//                     softConnector: true,
//                 },
//                 center: ['40%', '50%'],
//                 neckWidth: '30%',
//                 neckHeight: '25%',
//                 width: '80%'
//             },
//         },
//         series: chartData.data.map((salesmanData) => ({
//             name: salesmanData.name,
//             data: salesmanData.data.map((value, index) => ({
//                 name: chartData.labels[index],
//                 y: value,
//             })),
//         })),
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildSunburstChart(chart_name, chart_canvas_id, chart_title,data) {
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         colors: ['transparent'].concat(Highcharts.getOptions().colors),
//         series: [{
//             type: 'sunburst',
//             data: data,
//             allowDrillToNode: true,
//             name: 'Root',
//             borderRadius: 3,
//             cursor: 'pointer',
//             dataLabels: {
//                 format: '{point.name}',
//                 filter: {
//                     property: 'innerArcLength',
//                     operator: '>',
//                     value: 16
//                 }
//             },
//             levels: [{
//                 level: 1,
//                 levelIsConstant: false,
//                 dataLabels: {
//                     filter: {
//                         property: 'outerArcLength',
//                         operator: '>',
//                         value: 64
//                     }
//                 }
//             }, {
//                 level: 2,
//                 colorByPoint: true
//             },
//                 {
//                     level: 3,
//                     colorVariation: {
//                         key: 'brightness',
//                         to: -0.5
//                     }
//                 }, {
//                     level: 4,
//                     colorVariation: {
//                         key: 'brightness',
//                         to: 0.5
//                     }
//                 }]
//         }],
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         tooltip: {
//             headerFormat: '',
//             pointFormat: 'The population of <b>{point.name}</b> is <b>{point.value}</b>'
//         }
//     });
// }
//
//
// function buildWaterfallChart(chart_name, chart_canvas_id, chart_title,chartData) {
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'waterfall',
//
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         xAxis: {
//             categories: chartData.labels,
//         },
//         yAxis: {
//             title: {
//                 text: 'Values',
//             },
//         },
//         series: [{
//             data: chartData.data,
//             upColor: 'rgba(75, 192, 192, 0.7)',
//             color: 'rgba(0, 0, 0, 0.2)',
//             dataLabels: {
//                 enabled: true,
//                 format: '{point.y:,.2f}',
//             },
//         }],
//         legend: {
//             enabled: false,
//         },
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildRadarChart(chart_name, chart_canvas_id, chart_title,data) {
//
//     let categories = data.map(item => item.product);
//     let salesValues = data.map(item => item.total_sales);
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             polar: true,
//             type: 'column',
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         xAxis: {
//             categories: categories,
//             tickmarkPlacement: 'on',
//             lineWidth: 0,
//         },
//         yAxis: {
//             gridLineInterpolation: 'polygon',
//             lineWidth: 0,
//             min: 0,
//         },
//         tooltip: {
//             shared: true,
//             pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.0f}</b><br/>'
//         },
//         series: [{
//             name: 'Total Sales',
//             data: salesValues,
//             pointPlacement: 'on'
//         }]
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildBubbleChart(chart_name, chart_canvas_id, chart_title,chartData) {
//
//     let seriesData = chartData.map(function (item) {
//         return {
//             name: item.product_name,
//             data: [[parseFloat(item.total_cost), parseFloat(item.total_sales), parseFloat(item.units_sold)]],
//         };
//     });
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'bubble',
//             plotBorderWidth: 1,
//             zoomType: 'xy'
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         xAxis: {
//             title: {
//                 text: 'Cost',
//             },
//         },
//         yAxis: {
//             title: {
//                 text: 'Sales',
//             },
//         },
//         series: seriesData,
//         legend: {
//             enabled: false,
//         },
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildDonutChart(chart_name, chart_canvas_id, chart_title,chartData) {
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'pie',
//
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         plotOptions: {
//             pie: {
//                 shadow: false,
//                 center: ['50%', '50%']
//             }
//         },
//         tooltip: {
//             valueSuffix: '%'
//         },
//         series: [{
//             data: chartData
//         }],
//         legend: {
//             enabled: false,
//         },
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildAreaChart(chart_name, chart_canvas_id, chart_title,chartData) {
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'area',
//
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         xAxis: {
//             categories: chartData.labels,
//         },
//         yAxis: {
//             title: {
//                 text: 'Total Sales',
//             },
//         },
//         plotOptions: {
//             area: {
//                 stacking: 'normal',
//                 lineColor: '#666666',
//                 lineWidth: 1,
//                 marker: {
//                     lineWidth: 1,
//                     lineColor: '#666666'
//                 }
//             }
//         },
//         series: chartData.datasets
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildTreemapChart(chart_name, chart_canvas_id, chart_title,chartData) {
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         series: [{
//             type: 'treemap',
//             layoutAlgorithm: 'squarified',
//             data: chartData
//         }],
//         title: {
//             text: 'Sales Distribution by Region',
//             style: {
//                 fontSize: '14px'
//             }
//         }
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildLineChart(chart_name, chart_canvas_id, chart_title,chartData) {
//     let series = [];
//     for (const name in chartData.data) {
//         series.push({
//             name: name,
//             data: chartData.data[name],
//         });
//     }
//
//     console.log(chartData.labels)
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'line',
//
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         xAxis: {
//             categories: chartData.labels,
//         },
//         yAxis: {
//             title: {
//                 text: 'Values',
//             },
//         },
//         legend: {
//             enabled: false,
//         },
//         plotOptions: {
//             line: {
//                 dataLabels: {
//                     enabled: true,
//                 },
//             },
//         },
//         series: series,
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildScatterChart(chart_name, chart_canvas_id, chart_title,chartData) {
//     const seriesData = chartData.data.map((value, index) => ({
//         x: value.x,
//         y: value.y,
//     }));
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'scatter',
//
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         xAxis: {
//             title: {
//                 text: 'Company Price',
//             },
//         },
//         yAxis: {
//             title: {
//                 text: 'End User Price',
//             },
//         },
//         legend: {
//             enabled: false,
//         },
//         plotOptions: {
//             scatter: {
//                 marker: {
//                     radius: 5,
//                     symbol: 'circle',
//                     color: 'red',
//                 },
//             },
//         },
//         series: [{
//             name: 'Company vs. User Price',
//             data: seriesData,
//         }],
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function buildBoxPlotChart(chart_name, chart_canvas_id, chart_title,chartData) {
//     const seriesData = handleBoxPlotChartData(chartData);
//
//     window.chart_name_obj[chart_name] = Highcharts.chart(chart_canvas_id, {
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'boxplot',
//
//         },
//         title: {
//             text: chart_title,
//             style: {
//                 fontSize: '14px'
//             }
//         },
//         xAxis: {
//             title: {
//                 text: 'Cities',
//             },
//             categories: chartData.map(item => item.City),
//         },
//         yAxis: {
//             title: {
//                 text: 'Cost',
//             },
//         },
//         legend: {
//             enabled: false,
//         },
//         series: [{
//             name: 'Costs',
//             data: seriesData,
//         }],
//     });
//
//     return window.chart_name_obj[chart_name];
// }
//
//
// function handleBoxPlotChartData(chartData) {
//     return chartData.map(item => {
//         const costs = item.Costs.split(',').map(cost => parseFloat(cost));
//         return [Math.min(...costs), calculateQ1(costs), calculateMedian(costs), calculateQ3(costs), Math.max(...costs)];
//     });
// }
//
// function calculateMedian(values) {
//     values.sort((a, b) => a - b);
//
//     const mid = Math.floor(values.length / 2);
//
//     if (values.length % 2 === 0) {
//         return (values[mid - 1] + values[mid]) / 2;
//     } else {
//         return values[mid];
//     }
// }
//
// const calculateQ1 = (arr) => {
//     const index = Math.floor(arr.length / 4);
//     return arr[index];
// };
//
// const calculateQ3 = (arr) => {
//     const index = Math.ceil((3 * arr.length) / 4);
//     return arr[index];
// };
