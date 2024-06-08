@extends('layout.index')
@section('title')
POS Summary
@endsection

@section('reportname')
POS Summary
@endsection
@section('content')

@error('date_from')
<div class="alert alert-danger">{{ $message }}</div>
@enderror
<form action="{{ route('reports.pos-summary-download') }}" method="post" id="pos_summary">
    @csrf
    <div class="row g-2">
        <div class="col-md-4">
            <label for="id" class="form-label"> ID </label>
            <input type="text" class="form-control" id="id" name="id" placeholder="...">
        </div>
        <div class="col-md-4">
            <label for="pos_id" class="form-label"> POS ID </label>
            <input type="text" class="form-control" id="pos_id" name="pos_id" placeholder="...">
        </div>
        <div class="col-md-4">
            <label for="rep_id" class="form-label"> REP ID </label>
            <input type="text" class="form-control" id="rep_id" name="rep_id" placeholder="...">
        </div>
        <div class="col-md-4">
            <label for="pos_name" class="form-label">POS Name</label>
            <select id="pos_name" name="pos_name" class="searchable form-control">
                @foreach($dataToView['pos_name']??[] as $k => $v)
                <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="arabic_name" class="form-label">Arabic Name</label>
            <select id="arabic_name" name="arabic_name" class="searchable form-control">
                @foreach($dataToView['arabic_name']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="rep_name" class="form-label">REP Name</label>
            <select id="rep_name" name="rep_name" class="searchable form-control">
                @foreach($dataToView['rep_name']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="channel" class="form-label">Channel</label>
            <select id="channel" name="channel" class="searchable form-control">
                @foreach($dataToView['channel']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="region" class="form-label">Region</label>
            <select id="region" name="region" class="searchable form-control">
                @foreach($dataToView['region']??[] as $k => $v)
                    <option value="{{ $k }}">{{ $v }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="city" class="form-label">City</label>
            <select id="city" name="city" class="searchable form-control">
                @foreach($dataToView['city']??[] as $k => $v)
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
            <button type="button" class="btn btn-primary" onclick="getPreviewData(`{{ route('reports.pos-summary-download') }}`, '{{ csrf_token() }}')">Preview</button>
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
<script src="{{ asset('js/reports/pos_summary.js') }}"></script>

@endpush
