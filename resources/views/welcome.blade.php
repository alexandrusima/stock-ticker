@extends('layout')

@push('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endpush

@section('body')
    <div class="container">
        <div class="row">
            <div class="col">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col">
                &nbsp;
            </div>
            <div class="col">
                @include('partials.table')
            </div>
        </div>
    </div>
@endsection
