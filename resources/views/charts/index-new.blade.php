@extends('layout.index')
@section('content')
    <h1>Charts</h1>
    <div class="row g-2">
        <div class="col-md-4">
            <label for="chart-type" class="form-label">Chart Type</label>
            <select id="chart-type" name="chart_name" class="searchable form-control">
                    <option value="">Select Type</option>
                    <option value="posStatementCharts">Pos Statement</option>
            </select>
        </div>
{{--        <div class="col-1"></div>--}}
        <div class="col-4">
            <label for="date-picker" class="form-label">Date</label>
            <input type="text" class="form-control" id="date-picker">
            <input type="hidden" name="date_from" id="date_from">
            <input type="hidden" name="date_to" id="date_to">
        </div>
{{--        <div class="col-1"></div>--}}
        <div class="col-2 d-flex justify-content-center align-items-end">
            <button id="refresh" class="btn btn-success mb-0" onclick="refreshCharts();">Refresh</button>
        </div>
    </div>

    <div class="row" id="chart-container">
{{--        <div class="col-md-12" id="chart-container">--}}
{{--        </div>--}}
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/common/common.js') }}"></script>
    <script src="{{ asset('js/charts/charts-new.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/sunburst.js"></script>
    <script src="https://code.highcharts.com/modules/funnel.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/treemap.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>

@endpush

