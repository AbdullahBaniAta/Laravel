@extends('layout.index')
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
    
    <script src="{{ asset('js/common/common.js') }}"></script>
    <script src="{{ asset('js/reports/pos-statement.js') }}"></script>

@endpush
