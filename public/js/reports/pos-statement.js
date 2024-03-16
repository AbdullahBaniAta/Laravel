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
    formData.append('rep_id', $('#rep_id').val());
    formData.append('rep_name', $('#rep_name').val());
    formData.append('category', $('#category').val());
    formData.append('brand', $('#brand').val());
    formData.append('channel_type', $('#channel_type').val());
    formData.append('cus_name', $('#cus-name').val());
    formData.append('date_from', $('#date_from').val());
    formData.append('date_to', $('#date_to').val());
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
        table += '<thead><tr><th>Rep ID</th><th>Rep Name</th><th>Category</th><th>Brand</th><th>Channel Type</th><th>Customer Name</th><th>Date</th></tr></thead>';
        table += '<tbody>';
        data.forEach(row => {
            table += `<tr><td>${row.rep_id}</td><td>${row.rep_name}</td><td>${row.category}</td><td>${row.brand}</td><td>${row.channel_type}</td><td>${row.CustomersName}</td><td>${row.DateTime}</td></tr>`;
        });
        table += '</tbody></table>';
        previewTable.html(table);
    } else {
        previewTable.html('');
        previewTable.append('<div class="alert alert-danger mt-4">No Data Found</div>');
    }
}
