@extends('layout.layouts')
@section('content')
    <div class="row gy-4">
        <div class="col-md-4">
            <label class="form-label" for="report">Role:</label>
            <select class="form-select" id="report" name="Report" required>
                @foreach($reports as $reportId => $reportName)
                    <option value="{{$reportId}}">{{$reportName}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <div id="date-filter" style="display: none">
                <label class="form-label" for="date">Date:</label>
                <input type="text" class="form-control datepicker" id="date" placeholder="Select date range">
            </div>
            <div id="City-filter" style="display: none">
                <label class="form-label" for="City">City:</label>
                <select class="form-select" id="City">
                    @foreach($cities as $cityId => $cityName)
                        <option value="{{$cityId}}">{{$cityName}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4" style="text-align: center ;padding-top: 30px">
            <button id="show" class="btn btn-success">Show</button>
            <button id="exportButton" class="btn btn-success">Export to CSV</button>
        </div>
    </div>
    <br/>
    <br/>
    <div id="table"></div>
    <div id="pagination-links"></div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="..." crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.js"></script>
    <script src="{{asset('js/report/report.js')}}"></script>
    <style>
        #pagination-links {
            list-style: none;
            display: flex;
            padding: 0;
        }

        #pagination-links a {
            text-decoration: none;
            padding: 8px;
            margin: 0 5px;
            border: 1px solid #ddd;
            color: #333;
            cursor: pointer;
        }

        #pagination-links a:hover {
            background-color: #ddd;
        }

        #pagination-links a.active {
            background-color: #007bff;
            color: #fff;
        }
    </style>

@endpush
