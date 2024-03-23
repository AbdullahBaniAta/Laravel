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
    if (urlParams.get('SenderID'))
        $('#rep_id').val(urlParams.get('SenderID'));
    if (urlParams.get('SenderName'))
        $('#category').val(urlParams.get('SenderName')).trigger('change');
    if (urlParams.get('IDReceive'))
        $('#cus-name').val(urlParams.get('IDReceive'));
    if (urlParams.get('ReceiveName'))
        $('#rep_name').val(urlParams.get('ReceiveName')).trigger('change');
    if (urlParams.get('file_type'))
        $('#file-type').val(urlParams.get('file_type')).trigger('change');
    if (urlParams.get('date_from') && urlParams.get('date_to')) {
        let dateFrom = new Date(urlParams.get('date_from'));
        let dateTo = new Date(urlParams.get('date_to'));
        $('#date-picker')[0]?._flatpickr?.setDate([dateFrom, dateTo]);
    }

}

function getPreviewData(url, csrfToken) {
    const formData = new FormData();
    formData.append('SenderID', $('#SenderID').val() ? $('#SenderID').val() : '');
    formData.append('SenderName', $('#SenderName').val() ? $('#SenderName').val() : '');
    formData.append('IDReceive', $('#IDReceive').val() ? $('#IDReceive').val() : '');
    formData.append('ReceiveName', $('#ReceiveName').val() ? $('#ReceiveName').val() : '');
    formData.append('date_from', $('#date_from').val() ? $('#date_from').val() : '');
    formData.append('date_to', $('#date_to').val() ? $('#date_to').val() : '');
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
    if (data.length > 0) {
        let table = '<table class="table table-striped mt-4">';
        table += '' +
            '<thead>' +
            '<tr>' +
            '<th>ID</th>' +
            '<th>DateTime</th>' +
            '<th>TransactionID</th>' +
            '<th>SenderID</th>' +
            '<th>SenderName</th>' +
            '<th>Amount</th>' +
            '<th>IDReceive</th>' +
            '<th>ReceiveName</th>' +
            '<th>Operation</th>' +
            '<th>Note</th>' +
            '</tr>' +
            '</thead>';
        table += '<tbody>';
        data.forEach(row => {
            table += `<tr>
                <td class="text-center">${row.ID}</td>
                <td class="text-center">${row.DateTime}</td>
                <td class="text-center">${row.TransactionID}</td>
                <td class="text-center">${row.SenderID}</td>
                <td class="text-center">${row.SenderName}</td>
                <td class="text-center">${row.Amount}</td>
                <td class="text-center">${row.IDReceive}</td>
                <td class="text-center">${row.ReceiveName}</td>
                <td class="text-center">${row.Operation}</td>
                <td class="text-center">${row.Note}</td>
            </tr>`;
        });
        table += '</tbody></table>';
        previewTable.html(table);
    } else {
        previewTable.html('');
        previewTable.append('<div class="alert alert-danger mt-4">No Data Found</div>');
    }
}
