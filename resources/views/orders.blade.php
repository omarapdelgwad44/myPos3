@extends('adminlte::page')

@if (app()->getLocale() == 'ar')
    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
        <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
     @stop
@endif

@section('content')
<div class="container">
    <h1>{{ @trans('adminlte::adminlte.order_management') }}</h1>
    
    <div class="row mb-3">
         <!-- Clint Filter -->
         <form action="{{ route('dashboard.orders.index') }}" method="GET" class="row mb-3 d-flex">
    <div class="col-4">
        <select name="clint_id" class="form-control ms-2">
            <option value="">{{ @trans('adminlte::adminlte.clint') }}</option>
            @foreach($clints as $clint)
                <option value="{{ $clint->id }}" {{ request('clint_id') == $clint->id ? 'selected' : '' }}>
                    {{ $clint->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-4">
        <select name="product_id" class="form-control ms-2">
            <option value="">{{ @trans('adminlte::adminlte.product') }}</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-4 d-flex align-items-center">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-filter ms-1"></i> {{ @trans('adminlte::adminlte.search') }}
        </button>
    </div>
</form>
        


    <td>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ @trans('adminlte::adminlte.id') }}</th>
                <th>{{ @trans('adminlte::adminlte.clint') }}</th>
                <th>{{ @trans('adminlte::adminlte.phone') }}</th>
                <th>{{ @trans('adminlte::adminlte.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->clint->name }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->address }}</td>
                    <td>
                        @if(auth()->user()->hasPermission('orders-read'))
                            <a href="{{ route('dashboard.orders.show', $order->id) }}" class="btn btn-info btn-sm">
                                <i class="fa fa-eye"></i> {{ @trans('adminlte::adminlte.View_order') }}
                            </a>
                        @endif
                        @if(auth()->user()->hasPermission('orders-delete'))
                            <form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ @trans('adminlte::adminlte.are_you_sure') }}')">
                                    <i class="fa fa-trash"></i> {{ @trans('adminlte::adminlte.delete') }}
                                </button>
                            </form>
                        @endif
                     
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

