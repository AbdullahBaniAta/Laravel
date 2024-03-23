@extends('layout.index')
@section('title')
    POS Statement
@endsection
@section('reportname')
    POS Statement
@endsection
@section('content')

    @error('date_from')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <form class="row g-2" action="{{ route('reports.pos-statement-download') }}" method="post">
        @csrf
        <div class="col-md-4">
            <label for="representativeID" class="form-label"> Representative ID </label>
            <input type="text" class="form-control" id="representativeID" name="representativeID" placeholder="MDR0040">
        </div>
        <div class="col-md-4">
            <label for="representative" class="form-label">Representative Name</label>
            <select id="representative" name="representative" class="searchable form-control">
                @foreach($dataToView['rep_names']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <label for="Category" class="form-label">Category</label>
            <select id="Category" name="Category" class="searchable form-control">
                @foreach($dataToView['categories']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <label for="Brand" class="form-label">Brand</label>
            <select id="Brand" name="Brand" class="searchable form-control">
                @foreach($dataToView['brands']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <label for="Channel_Type" class="form-label">Channel Type</label>
            <select id="Channel_Type" name="Channel_Type" class="searchable form-control">
                @foreach($dataToView['channel_types']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <label for="CustomersName" class="form-label">Customer Name</label>
            <input type="text" class="form-control" id="CustomersName" name="CustomersName"
                   placeholder="Al-Ahly Market Grocery">
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
        <div class="col-4"></div>
        <div class="col-4">
            <button type="button" class="btn btn-primary"
                    onclick="getPreviewData('{{ route('reports.pos-statement-download') }}', '{{csrf_token()}}')">
                Preview
            </button>
        </div>
        <div class="col-4">
            <button type="submit" name="action" value="export" class="btn btn-success">Export</button>
        </div>
    </form>
    <div class="row g-2" id="preview-table"></div>
@endsection

@push('scripts')

    <script src="{{ asset('js/common/common.js') }}"></script>
    <script src="{{ asset('js/reports/pos-statement.js') }}"></script>

@endpush
