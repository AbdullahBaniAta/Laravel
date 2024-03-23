@extends('layout.index')
@section('title')
    Financial Transactions
@endsection
@section('reportname')
    Financial Transactions
@endsection
@section('content')
    @error('date_from')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <form class="row g-2" action="{{ route('reports.financial-transaction-download') }}" method="post">
        @csrf
        <div class="col-md-4">
            <label for="SenderID" class="form-label"> Sender ID </label>
            <input type="text" class="form-control" id="SenderID" name="SenderID" placeholder="MDR0040">
        </div>
        <div class="col-md-4">
            <label for="SenderName" class="form-label">Sender Name</label>
            <select id="SenderName" name="SenderName" class="searchable form-control">
                @foreach($dataToView['SenderName']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <label for="IDReceive" class="form-label"> Receive ID </label>
            <input type="text" class="form-control" id="IDReceive" name="IDReceive" placeholder="MDR0040">
        </div>
        <div class="col-md-4">
            <label for="ReceiveName" class="form-label">Receive Name</label>
            <select id="ReceiveName" name="ReceiveName" class="searchable form-control">
                @foreach($dataToView['ReceiveName']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <label for="date-picker" class="form-label">Date</label>
            <input type="text" class="form-control" id="date-picker">
            <input type="hidden" name="date_from" id="date_from">
            <input type="hidden" name="date_to" id="date_to">
        </div>
        <div class="col-md-4">
            <label for="file_type" class="form-label">File Format</label>
            <select id="file_type" name="file_type" class="form-control searchable">
                <option value="csv">CSV</option>
                <option value="xlsx">XLSX</option>
            </select>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <button type="button" class="btn btn-primary"
                    onclick="getPreviewData('{{ route('reports.financial-transaction-download') }}', '{{csrf_token()}}')">
                Preview
            </button>
        </div>
        <div class="col-md-4">
            <button type="submit" name="action" value="export" class="btn btn-success">Export</button>
        </div>
    </form>
    <div class="row g-2" id="preview-table"></div>
@endsection

@push('scripts')

    <script src="{{ asset('js/common/common.js') }}"></script>
    <script src="{{ asset('js/reports/financial-transaction.js') }}"></script>

@endpush
