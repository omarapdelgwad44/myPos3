@extends('adminlte::page')

@if (app()->getLocale() == 'ar')
    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
        <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
    @stop
@endif

@section('content')
<div class="container">
    <h3>{{ __('adminlte::adminlte.order_details') }}</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ __('adminlte::adminlte.products') }}</th>
                <th>{{ __('adminlte::adminlte.sale_price') }}</th>
                <th>{{ __('adminlte::adminlte.quantity') }}</th>
                <th>{{ __('adminlte::adminlte.total') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->sale_price, 2) }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ number_format($product->sale_price * $product->pivot->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row mb-3">
        <div class="col-md-6">
            <strong>{{ __('adminlte::adminlte.total') }}:</strong> {{ number_format($order->total, 2) }}
        </div>
        
</div>
@endsection
