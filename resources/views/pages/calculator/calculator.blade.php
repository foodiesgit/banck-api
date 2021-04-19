@extends('layouts.app', ['activePage' => 'calculator', 'titlePage' => __('Calculator')])



@section('content')

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-5">
                    @include('pages.calculator.invoice_financing')
                    @include('pages.calculator.mca')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/calculator.js') }}"></script>
@endpush

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/calculator.css') }}">
@endpush


