@extends('layouts.back-end.app')
@section('title', translate('stock_list'))
@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">--}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endpush
    @section('content')
        <h2>Add Data to Table from Modal</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dataModal">Add Data</button>

        <!-- Modal -->
        <div class="modal fade" id="dataModal" tabindex="-1" aria-labelledby="dataModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dataModalLabel">Add Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="dataForm">
                            <div class="mb-3">
                                <label for="inputData" class="form-label">Data</label>
                                <input type="text" class="form-control" id="inputData" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveData">Save Data</button>
                    </div>
                </div>
            </div>
        </div>
        <table id="dataTable" class="table table-bordered mt-3">
            <thead>
            <tr>
                <th>Data</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    @endsection
    @push('script_2')
        <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/stock-script.js') }}"></script>
    @endpush
