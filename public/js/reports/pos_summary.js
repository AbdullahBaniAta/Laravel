$(document).ready(function () {
    $('.searchable').select2({
        theme: 'bootstrap-5'
    });
    buildDateRangePicker('#date-picker', '#date_from', '#date_to',false,null,'Y-m-d');
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
    const formFields = $('#pos_summary').serializeArray();
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
            <th>POS ID</th>
            <th>POS Name</th>
            <th>ARABIC NAME</th>
            <th>REP Name</th>
            <th>REP ID</th>
            <th>DAY</th>
            <th>CHANNEL</th>
            <th>REGION</th>
            <th>CITY</th>
            <th>QUANTITY</th>
            <th>Sum channel Price</th>
            <th>Sum Net Price</th>
            <th>CUSTOMER EARNING</th>
            <th>Updated At</th>
            </tr>
        </thead>
        `;
        table += '<tbody>';
        data.forEach(row => {
            table += `
            <tr>
                <td>${row.id}</td>
                <td>${row.pos_id}</td>
                <td>${row.pos_name}</td>
                <td>${row.arabic_name}</td>
                <td>${row.rep_name}</td>
                <td>${row.rep_id}</td>
                <td>${row.day}</td>
                <td>${row.channel}</td>
                <td>${row.region}</td>
                <td>${row.city}</td>
                <td>${row.quantity}</td>
                <td>${row.sum_channel_price}</td>
                <td>${row.sum_net_price}</td>
                <td>${row.customer_earning}</td>
                <td>${row.updated_at}</td>
            </tr>`;
        });
        table += '</tbody></table>';
        previewTable.html(table);
    } else {
        previewTable.html('');
        previewTable.append('<div class="alert alert-danger mt-4">No Data Found</div>');
    }
}
