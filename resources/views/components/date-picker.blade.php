<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>

<div class="form-group row">
    <div class="col-auto d-flex align-items-center justify-content-center" style="margin-right: -14px">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-calendar-range" viewBox="0 0 16 16">
            <path d="M9 7a1 1 0 0 1 1-1h5v2h-5a1 1 0 0 1-1-1M1 9h4a1 1 0 0 1 0 2H1z"/>
            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
        </svg>
    </div>
    <div class="col">
        <input type="text" class="form-control datepicker" id="{{ $id }}-date" placeholder="Select date range" value="{{\Carbon\Carbon::now()->format('F Y')}}">
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#{{ $id }}-date", {
            mode: 'range',
            dateFormat: 'Y-m',
            plugins: [
                new monthSelectPlugin({
                    shorthand: true,
                    theme: "dark"
                })
            ],
            onClose: function (selectedDates, dateStr, instance) {
                let dateObj = {};
                if (selectedDates.length !== 2) {
                    selectedDates[1] = selectedDates[0];
                }
                dateObj['from'] = selectedDates[0]?.toISOString();
                dateObj['to'] = selectedDates[1]?.toISOString();
                fetchData('{{$id}}', dateObj['from'] ,dateObj['to'], '{{ $id }}-chart', '{{$chartTitle}}',  {{$jsFunction}})
            }
        });
    });
</script>

