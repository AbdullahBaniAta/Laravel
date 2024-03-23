window.request_data = {};

let reports = {
    'getEntitiesReport' : 'City',
    'getVoucherStockReport': null,
    'getSalesReportByVoucher': 'date',
    'getSalesReportByTerminal': 'date',
    'getBalanceStatementReport': 'date',
}

document.addEventListener('DOMContentLoaded', function () {

    window.request_data.report = document.getElementById('report').value;
    showHideFilter()
    buildDateRangePicker();

    document.getElementById('exportButton').addEventListener('click', async function () {
        await exportReport();
    });

    document.getElementById('report').addEventListener('change', async function () {
        window.request_data = {};
        window.document.getElementById('date').value = '';
        window.request_data.report = this.value;
        window.document.getElementById('pagination-links').innerHTML = '';
        window.document.getElementById('table').innerHTML = '';
        showHideFilter();
    });

    document.getElementById('show').addEventListener('click', async function () {
        if(window.request_data.report === 'getEntitiesReport') {
            window.request_data.filter = {
                'City': document.getElementById('City').value,
            }
        }

        if (window.request_data.report && (window.request_data.filter || reports[window.request_data.report] === null)) {
            const response = await fetch(createUrlForFetch());
            const data = await response.json();
            createTable(data.data, data.report_title);
            renderPagination(data.data);
        } else {
            alert('Please select report and filter');
        }
    });
});

function showHideFilter() {
    Object.entries(reports).forEach(([key, value]) => {
        if (value === null) return;
        document.getElementById(value+'-filter').style.display = 'none';
    });
    if (reports[window.request_data.report] !== null)
        document.getElementById(reports[window.request_data.report]+'-filter').style.display = 'block';
}

function buildDateRangePicker(isMonthPicker = false) {
    let dateFormat = 'Y-m-d';
    let plugins = [];

    if (isMonthPicker) {
        dateFormat = 'Y-m';
        plugins = [
            new monthSelectPlugin({
                shorthand: true,
                // theme: "dark"
            })
        ];
    }
    flatpickr("#date", {
        mode: 'range',
        dateFormat: dateFormat,
        plugins: plugins,
        onClose: async function (selectedDates) {
            const startDate = selectedDates[0]?.toISOString();
            const endDate = selectedDates.length === 2 ? selectedDates[1]?.toISOString() : startDate;
            window.request_data.filter = {
                date: {
                    date_from: startDate,
                    date_to: endDate,
                },
            };
        }
    });
}

async function fetchData(url) {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Error fetching data:', error);
        // Handle error (e.g., display a message to the user)
    }
}

function createTable(data, reportTitle) {

    const tableId = 'table';
    const tableContainer = document.getElementById(tableId);
    const table = document.createElement('table');
    table.classList.add('table', 'table-striped');

    const thead = document.createElement('thead');
    const tbody = document.createElement('tbody');

    const headerRow = document.createElement('tr');
    Object.keys(data.data[0]).forEach(key => {
        const th = document.createElement('th');
        th.textContent = key;
        headerRow.appendChild(th);
    });
    thead.appendChild(headerRow);

    data.data.forEach((item, index) => {
        const tr = document.createElement('tr');
        Object.values(item).forEach(value => {
            const td = document.createElement('td');
            td.textContent = value;
            tr.appendChild(td);
        });

        tr.classList.add(index % 2 === 0 ? 'table-primary' : 'table-secondary');
        tbody.appendChild(tr);
    });

    table.appendChild(thead);
    table.appendChild(tbody);

    const caption = document.createElement('caption');
    caption.textContent = reportTitle;
    table.appendChild(caption);

    table.style.width = '100%';

    tableContainer.innerHTML = '';
    tableContainer.appendChild(table);
}

function createUrlForFetch(isExport=false) {
    let params = new URLSearchParams();
    params.append('report', window.request_data.report);
    if (window.request_data?.filter?.date) {
        params.append('filter_type', 'date');
        params.append('date_from', window.request_data.filter.date.date_from);
        params.append('date_to', window.request_data.filter.date.date_to);
    } else {
        if (reports[window.request_data.report] !== null) {
            Object.entries(window.request_data?.filter).forEach(([key, value]) => {
                params.append('filter_type', 'City');
                params.append('filter_name', key);
                params.append('filter_value', window.request_data.filter[key]);
            });
        }
    }
    if (isExport) {
        params.append('export', '1');
    }
    return `/zain-report/fetch?${params.toString()}`;
}

async function exportReport() {
    await fetch(createUrlForFetch(true))
        .then(response => response.blob())
        .then(blob => {
            const downloadLink = document.createElement('a');
            downloadLink.href = window.URL.createObjectURL(blob);
            downloadLink.download = window.request_data.report + '.xlsx';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            window.URL.revokeObjectURL(downloadLink.href);
            document.body.removeChild(downloadLink);
        });
}

async function renderPagination(data) {
    const paginationLinks = document.getElementById('pagination-links');
    paginationLinks.innerHTML = '';

    const ul = document.createElement('ul');
    ul.classList.add('pagination');
    for (let i = 1; i <= data.last_page; i++) {
        const li = document.createElement('li');
        li.classList.add('page-item');
        li.style.marginRight = '5px';
        const link = document.createElement('button');
        link.href = '';
        link.addEventListener('click', async function () {
            if (i !== data.current_page) {
                await handlePaginationClick(data.links[i].url);
            }
        });
        link.textContent = 'Page ' +i;
        link.classList.add('btn', 'btn-primary', 'btn-sm');

        if (i === data.current_page) {
            link.classList.add('active');
        }
        li.appendChild(link);

        ul.appendChild(li);
    }
    paginationLinks.appendChild(ul);
}

async function handlePaginationClick(link) {
    const response = await fetchData(link);
    createTable(response.data);
    await renderPagination(response.data);
}
