@extends('layout.index')
@section('title')
Balance Request
@endsection

@section('reportname')
Balance Request
@endsection
@section('content')

@error('date_from')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
<form action="{{ route('reports.balance-request-download') }}" method="post" id="balance-form">
    @csrf
    <div class="row g-2">
        <div class="col-md-4">
            <label for="id" class="form-label"> ID </label>
            <input type="text" class="form-control" id="id" name="id" placeholder="...">
        </div>
        <div class="col-md-4">
            <label for="account_number" class="form-label"> Account Number </label>
            <input type="text" class="form-control" id="account_number" name="account_number" placeholder="....">
        </div>
        <div class="col-md-4">
            <label for="rep_id" class="form-label"> Rep ID </label>
            <input type="text" class="form-control" id="rep_id" name="rep_id" placeholder="...">
        </div>
        <div class="col-md-4">
            <label for="customers_id" class="form-label"> Customers ID </label>
            <input type="text" class="form-control" id="customers_id" name="customers_id" placeholder="...">
        </div>
        <div class="col-md-4">
            <label for="customers_name" class="form-label">Customer Name</label>
            <select id="customers_name" name="customers_name" class="searchable form-control">
                @foreach($dataToView['customer_name']??[] as $k => $v)
                <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="account_name" class="form-label">Account Name</label>
            <select id="account_name" name="account_name" class="searchable form-control">
                @foreach($dataToView['account_name']??[] as $k => $v)
                <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="sales_representative" class="form-label">Sales Representative</label>
            <select id="sales_representative" name="sales_representative" class="searchable form-control">
                @foreach($dataToView['sales_representative']??[] as $k => $v)
                <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="searchable form-control">
                @foreach($dataToView['status']??[] as $k => $v)
                <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <label for="date-picker" class="form-label">Date</label>
            <input type="text" class="form-control" id="date-picker">
            <input type="hidden" name="date_from" id="date_from">
            <input type="hidden" name="date_to" id="date_to">
        </div>
        <div class="col-4">
            <label for="file_type" class="form-label">File Format</label>
            <select id="file_type" name="file_type" class="form-control searchable">
                <option value="csv">CSV</option>
                <option value="xlsx">XLSX</option>
            </select>
        </div>
    </div>

    <div class="row mt-3">

        <div class="col-3">
            <button type="button" class="btn btn-primary" onclick="getPreviewData(`{{ route('reports.balance-request-download') }}`, '{{ csrf_token() }}')">Preview</button>
        </div>
        <div class="col-3">
            <button type="submit" name="action" value="export" class="btn btn-success">Export</button>
        </div>
    </div>

</form>
<div class="row g-2" id="preview-table"></div>
@endsection

@push('scripts')

<script src="{{ asset('js/common/common.js') }}"></script>
<script src="{{ asset('js/reports/balance-request.js') }}"></script>

@endpush
