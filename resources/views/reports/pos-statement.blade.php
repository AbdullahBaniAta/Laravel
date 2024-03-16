@extends('layout.layouts')
@section('content')
    @error('date_from')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <form class="row g-2" action="{{ route('reports.pos-statement-download') }}" method="post">
        @csrf
        <div class="col-md-4">
            <label for="rep_id" class="form-label"> Representative ID </label>
            <input type="text" class="form-control" id="rep_id" name="rep_id" placeholder="MDR0040"
                   value="{{ old('rep_id') }}">
        </div>
        <div class="col-md-4">
            <label for="rep_name" class="form-label">Representative Name</label>
            <select id="rep_name" name="rep_name" class="searchable form-control">
                @foreach($dataToView['rep_names']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category" class="searchable form-control">
                @foreach($dataToView['categories']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <label for="brand" class="form-label">Brand</label>
            <select id="brand" name="brand" class="searchable form-control">
                @foreach($dataToView['brands']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <label for="channel_type" class="form-label">Channel Type</label>
            <select id="channel_type" name="channel_type" class="searchable form-control">
                @foreach($dataToView['channel_types']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <label for="cus-name" class="form-label">Customer Name</label>
            <input type="text" class="form-control" id="cus-name" name="cus_name" placeholder="Al-Ahly Market Grocery">
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
            <button type="button" class="btn btn-primary" onclick="getPreviewData('{{ route('reports.pos-statement-download') }}', '{{csrf_token()}}')">Preview</button>
        </div>
        <div class="col-4">
            <button type="submit" name="action" value="export" class="btn btn-success">Export</button>
        </div>
    </form>
    <div class="row g-2" id="preview-table"></div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
    <!-- Or for RTL support -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css"/>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.js"></script>
    <script src="{{ asset('js/common/common.js') }}"></script>
    <script src="{{ asset('js/reports/pos-statement.js') }}"></script>

@endpush
