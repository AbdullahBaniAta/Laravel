$(document).ready(function () {
    $('.searchable').select2({
        theme: 'bootstrap-5'
    });
    buildDateRangePicker('#date-picker', '#date_from', '#date_to');
    fillData();
});

function fillData() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    if (urlParams.get('rep_id'))
        $('#rep_id').val(urlParams.get('rep_id'));
    if (urlParams.get('rep_name'))
        $('#rep_name').val(urlParams.get('rep_name')).trigger('change');
    if (urlParams.get('category'))
        $('#category').val(urlParams.get('category')).trigger('change');
    if (urlParams.get('brand'))
        $('#brand').val(urlParams.get('brand')).trigger('change');
    if (urlParams.get('channel_type'))
        $('#channel_type').val(urlParams.get('channel_type')).trigger('change');
    if (urlParams.get('file_type'))
        $('#file-type').val(urlParams.get('file_type')).trigger('change');
    if (urlParams.get('cus_name'))
        $('#cus-name').val(urlParams.get('cus_name'));
    if (urlParams.get('date_from') && urlParams.get('date_to')) {
        let dateFrom = new Date(urlParams.get('date_from'));
        let dateTo = new Date(urlParams.get('date_to'));
        $('#date-picker')[0]?._flatpickr?.setDate([dateFrom, dateTo]);
    }

}

function getPreviewData(url, csrfToken) {
    const formData = new FormData();
    const formFields = $('#balance-form').serializeArray();
    formFields.forEach(field => {
        if(field.name!="_token")
        formData.append(field.name, field.value);
    });
    formData.append('action', 'preview');
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    }).then(response => response.json())
        .then(data => {
            buildTable(data);
        });
}
function buildTable(data) {
    let previewTable = $('#preview-table');
    if(data.length>0) {
        let table = '<table class="table table-striped mt-4">';
        table += `<thead>
            <tr>
            <th>ID</th>
            <th>Account Number</th>
            <th>Account Name</th>
            <th>Rep ID</th>
            <th>Account Name</th>
            <th>Customer ID</th>
            <th>Customer Name</th>            
            <th>Sales Representative</th>
            <th>Status</th>
            <th>Balance Accept</th>
            <th>Date Time</th>
            <th>Pending Balance</th>
            <th>Transaction Amount</th>
            <th>Updated At</th>            
            </tr>
        </thead>
        `;
        table += '<tbody>';
        data.forEach(row => {
            table += `
            <tr>
                <td>${row.id}</td>
                <td>${row.account_number}</td>
                <td>${row.account_name}</td>
                <td>${row.rep_id}</td>
                <td>${row.account_name}</td>
                <td>${row.customers_id}</td>
                <td>${row.customers_name}</td>
                <td>${row.sales_representative}</td>
                <td>${row.status}</td>
                <td>${row.balance_accept}</td>
                <td>${row.date_time}</td>
                <td>${row.pending_balance}</td>
                <td>${row.transaction_amount}</td>
                <td>${row.update_at}</td>
            </tr>`;
        });
        table += '</tbody></table>';
        previewTable.html(table);
    } else {
        previewTable.html('');
        previewTable.append('<div class="alert alert-danger mt-4">No Data Found</div>');
    }
}
