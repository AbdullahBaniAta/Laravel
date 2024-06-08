
function setupHighCharts() {
    const H = Highcharts;

    const {
        pick,
        correctFloat,
        extend,
        fireEvent
    } = H;

    H.Chart.prototype.getTableAST = function(useLocalDecimalPoint) {
        let rowLength = 0;
        const treeChildren = [];
        const options = this.options,
            decimalPoint = useLocalDecimalPoint ? (1.1).toLocaleString()[1] : '.',
            useMultiLevelHeaders = pick(options.exporting.useMultiLevelHeaders, true),
            rows = this.getDataRows(useMultiLevelHeaders),
            topHeaders = useMultiLevelHeaders ? rows.shift() : null,
            subHeaders = rows.shift(),
            // Compare two rows for equality
            isRowEqual = function(row1, row2) {
                let i = row1.length;
                if (row2.length === i) {
                    while (i--) {
                        if (row1[i] !== row2[i]) {
                            return false;
                        }
                    }
                } else {
                    return false;
                }
                return true;
            },
            // Get table cell HTML from value
            getCellHTMLFromValue = function(tagName, classes, attributes, value) {
                let textContent = pick(value, ''),
                    className = 'highcharts-text' + (classes ? ' ' + classes : '');
                // Convert to string if number
                if (typeof textContent === 'number') {
                    textContent = textContent.toString();
                    if (decimalPoint === ',') {
                        textContent = textContent.replace('.', decimalPoint);
                    }
                    className = 'highcharts-number';
                } else if (!value) {
                    className = 'highcharts-empty';
                }
                attributes = extend({
                    'class': className
                }, attributes);
                return {
                    tagName,
                    attributes,
                    textContent
                };
            },
            // Get table header markup from row data
            getTableHeaderHTML = function(topheaders, subheaders, rowLength) {
                const theadChildren = [];
                let i = 0,
                    len = rowLength || subheaders && subheaders.length,
                    next, cur, curColspan = 0,
                    rowspan;
                // Clean up multiple table headers. Chart.getDataRows() returns two
                // levels of headers when using multilevel, not merged. We need to
                // merge identical headers, remove redundant headers, and keep it
                // all marked up nicely.
                if (useMultiLevelHeaders &&
                    topheaders &&
                    subheaders &&
                    !isRowEqual(topheaders, subheaders)) {
                    const trChildren = [];
                    for (; i < len; ++i) {
                        cur = topheaders[i];
                        next = topheaders[i + 1];
                        if (cur === next) {
                            ++curColspan;
                        } else if (curColspan) {
                            // Ended colspan
                            // Add cur to HTML with colspan.
                            trChildren.push(getCellHTMLFromValue('th', 'highcharts-table-topheading', {
                                scope: 'col',
                                colspan: curColspan + 1
                            }, cur));
                            curColspan = 0;
                        } else {
                            // Cur is standalone. If it is same as sublevel,
                            // remove sublevel and add just toplevel.
                            if (cur === subheaders[i]) {
                                if (options.exporting.useRowspanHeaders) {
                                    rowspan = 2;
                                    delete subheaders[i];
                                } else {
                                    rowspan = 1;
                                    subheaders[i] = '';
                                }
                            } else {
                                rowspan = 1;
                            }
                            const cell = getCellHTMLFromValue('th', 'highcharts-table-topheading', {
                                scope: 'col'
                            }, cur);
                            if (rowspan > 1 && cell.attributes) {
                                cell.attributes.valign = 'top';
                                cell.attributes.rowspan = rowspan;
                            }
                            trChildren.push(cell);
                        }
                    }
                    theadChildren.push({
                        tagName: 'tr',
                        children: trChildren
                    });
                }
                // Add the subheaders (the only headers if not using multilevels)
                if (subheaders) {
                    const trChildren = [];
                    for (i = 0, len = subheaders.length; i < len; ++i) {
                        if (typeof subheaders[i] !== 'undefined') {
                            trChildren.push(getCellHTMLFromValue('th', null, {
                                scope: 'col'
                            }, subheaders[i]));
                        }
                    }
                    theadChildren.push({
                        tagName: 'tr',
                        children: trChildren
                    });
                }
                return {
                    tagName: 'thead',
                    children: theadChildren
                };
            };
        // Add table caption
        if (options.exporting.tableCaption !== false) {
            treeChildren.push({
                tagName: 'caption',
                attributes: {
                    'class': 'highcharts-table-caption'
                },
                textContent: pick(options.exporting.tableCaption, (options.title.text ?
                    options.title.text :
                    'Chart'))
            });
        }
        // Find longest row
        for (let i = 0, len = rows.length; i < len; ++i) {
            if (rows[i].length > rowLength) {
                rowLength = rows[i].length;
            }
        }
        // Add header
        treeChildren.push(getTableHeaderHTML(topHeaders, subHeaders, Math.max(rowLength, subHeaders.length)));
        // Transform the rows to HTML
        const trs = [];

        // OVERRIDE START
        const seriesSums = Array.from({
            length: this.series.length
        });
        seriesSums[0] = 'Total';
        seriesSums[1] = 0;
        seriesSums[2] = 0;
        rows.forEach(function(row) {
            const trChildren = [];
            for (let j = 0; j < rowLength; j++) {
                // Make first column a header too. Especially important for
                // category axes, but also might make sense for datetime? Should
                // await user feedback on this.
                if (j > 0 && typeof row[j] === 'number') {
                    // @ts-ignore
                    seriesSums[j] += correctFloat(row[j]);
                }
                trChildren.push(getCellHTMLFromValue(j ? 'td' : 'th', null, j ? {} : {
                    scope: 'row'
                }, row[j]));
            }
            trs.push({
                tagName: 'tr',
                children: trChildren
            });
        });
        let temp = [];
        for (let i = 0; i <= this.series.length; i++) {
            temp.push(getCellHTMLFromValue(i ? 'td' : 'th', null, i ? {} : {
                scope: 'row'
            }, seriesSums[i]));
        }


        trs.push({
            tagName: 'tr',
            children: temp
        });

        // OVERRIDE END
        treeChildren.push({
            tagName: 'tbody',
            children: trs
        });
        const e = {
            tree: {
                tagName: 'table',
                id: `highcharts-data-table-${this.index}`,
                children: treeChildren
            }
        };
        fireEvent(this, 'aftergetTableAST', e);
        return e.tree;
    }


}



$(document).ready(function () {
    $('.searchable').select2({
        theme: 'bootstrap-5'
    });
    buildDateRangePicker('#date-picker', '#date_from', '#date_to', false, refreshCharts);
    $('#chart-type').change(() => fetchCharts());
    $('#refresh').click(() => fetchCharts());
    setupHighCharts();
});

function refreshCharts() {
    fetchCharts();
}

function fetchCharts() {
    if ($('#chart-type').val() === 'posSummaryCharts') {
        $('.rg').show();
    } else {
        $('.rg').hide();
    }
    let dateFrom = $('#date_from').val();
    let dateTo = $('#date_to').val();
    let chartType = $('#chart-type').val();
    let rg = $('#rg').val();
    let url = '/charts/fetch-chart-data';
    if (chartType) {
        url += '?chart_name=' + chartType;
        if (dateFrom)
            url += '&date_from=' + dateFrom;
        if (dateFrom && dateTo) {
            url += '&date_to=' + dateTo;
        }
        url += '&rg=' + rg;
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
        let chartData = {labels: item.labels, data: item.data, is_horizontal: item.is_horizontal, size: item.size, total: item?.total};
        window[item.js_function] && window[item.js_function](chartTitle, chartData);
    });
}

function buildBarChart(chart_name, chartData) {
    buildChartColAndCard(chart_name, chartData.size);
    let suggestedHeight = 50 + chartData.labels.length * 12;
    let defaultHeight = 434;

    console.log(chartData);
    Highcharts.chart(chart_name + '-chart', {
        credits: {
            enabled: false
        },
        chart: {
            type: chartData.is_horizontal ? 'bar' : 'column',
            height: suggestedHeight < defaultHeight ? defaultHeight : suggestedHeight,
        },
        title: {
            text: chart_name,
            style: {
                fontSize: '14px'
            }
        },
        xAxis: {
            categories: chartData.labels,
            labels: {
                step: 1,
                style: {
                    fontSize: '10px',
                    fontFamily: 'lato'
                },
                disabled: true,
            },
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
        tooltip: {
            formatter: function () {
                let percentage = (this.y / chartData.total * 100).toFixed(2);
                return this.y + ' (' + percentage + '%)';
            }
        }
    });
}
function buildPieChart(chart_name,chartData) {
    buildChartColAndCard(chart_name, chartData.size);
    let suggestedHeight = 50 + chartData.labels.length * 12;
    let defaultHeight = 434;

    Highcharts.chart(chart_name + '-chart', {
        credits: {
            enabled: false
        },
        chart: {
            type: 'pie',
            height: suggestedHeight < defaultHeight ? defaultHeight : suggestedHeight,
        },
        title: {
            text: chart_name,
            style: {
                fontSize: '14px'
            }
        },
        xAxis: {
            categories: chartData.labels,
            labels: {
                step: 1,
                style: {
                    fontSize: '10px',
                    fontFamily: 'lato'
                },
                disabled: true,
            },
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
            data: handlePieChartData(chartData),
        }],
        legend: {
            enabled: false,
        },
        tooltip: {
            formatter: function () {
                let percentage = (this.y / chartData.total * 100).toFixed(2);
                return this.y + ' (' + percentage + '%)';
            }
        }
    });
}
function handlePieChartData(chartData) {
    return chartData.data.map((value, index) => ({
        name: chartData.labels[index],
        y: value,
    }))
}

function buildChartColAndCard(chartId, size) {
    let chartContainer = $('#chart-container');

    let newDiv = document.createElement("div");
    newDiv.classList.add(size);
    newDiv.classList.add("mb-3");
    newDiv.classList.add("mt-3");
    let cardDiv = document.createElement("div");12
    cardDiv.classList.add("card");
    let cardBodyDiv = document.createElement("div");
    cardBodyDiv.classList.add("card-body");
    cardBodyDiv.id = chartId + '-chart-id';
    let chartDiv = document.createElement("div");
    chartDiv.id = chartId + '-chart';
    cardBodyDiv.appendChild(chartDiv);
    cardDiv.appendChild(cardBodyDiv);
    newDiv.appendChild(cardDiv);
    chartContainer.append(newDiv);
}
