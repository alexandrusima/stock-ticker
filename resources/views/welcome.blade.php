@extends('layout')

@push('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/luxon@1.26.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.1/dist/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.0.0"></script>
    <script src="{{ asset('js/chartjs-chart-financial.js') }}" type="text/javascript"></script>
    @include('partials.chart_data')
    <script src="{{ asset('js/chartjs-indx.js') }}" type="text/javascript"></script>
@endpush

@section('body')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                @include('partials.form')
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col">
                <canvas id="chart"></canvas>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col">
                @include('partials.table')
            </div>
        </div>
    </div>
@endsection
