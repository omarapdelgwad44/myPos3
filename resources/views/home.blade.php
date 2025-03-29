@extends('adminlte::page')

@section('title', @trans('adminlte::adminlte.dashboard'))
@if (app()->getLocale() == 'ar')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">

    <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
@stop
@endif
@section('content_header')
    <h1>{{ @trans('adminlte::adminlte.dashboard') }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="">{{ @trans('adminlte::adminlte.welcome') }}</h3>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                {{ @trans('adminlte::adminlte.You_are_logged_in') }}
            </div>
        </div>
    </div>
</div>
@stop
