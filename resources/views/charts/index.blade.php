@extends('layout.layouts')
@section('content')
    <div class="row gy-4 align-items-center justify-content-center mb-3">
        <div class="col-md-3 d-flex align-items-center justify-content-center">
            <a class="btn btn-primary" data-bs-toggle="modal" href="#channel-target" role="button">View Channels Target</a>
        </div>
    </div>
    <div class="row gy-4">
        @foreach($charts as $key => $chart)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <x-date-picker :id="$key" :chartId="$key" :jsFunction="$chart['jsBuildFunction']" :chartTitle="$chart['title']" />
                    </div>
                    <div class="card-body" id="{{ $key }}-chart-id">
                        <div id="{{ $key }}-chart" style="width: 300px; height: 272px;"></div>
                        <script>
                            fetchData('{{$key}}', '' ,'', '{{ $key }}-chart', '{{$chart['title']}}',  {{$chart['jsBuildFunction']}})
                        </script>
                    </div>
                </div>
            </div>
            <br/>
        @endforeach
    </div>
    <x-channel-target />
@endsection
@push('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/sunburst.js"></script>
    <script src="https://code.highcharts.com/modules/funnel.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/treemap.js"></script>
    <script src="https://code.highcharts.com/modules/heatmap.js"></script>
    <script src="/js/charts/charts.js?v=1.0001"></script>
@endpush
