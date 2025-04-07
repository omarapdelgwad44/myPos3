@extends('adminlte::page')

@section('title', __('adminlte::adminlte.order_management'))

@section('css')
    {{-- RTL Support for Arabic --}}
    @if (app()->getLocale() == 'ar')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
        <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
    @endif

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <h1>{{ __('adminlte::adminlte.order_management') }}</h1>

    {{-- Filters --}}
    <form action="{{ route('dashboard.orders.index') }}" method="GET" class="row mb-3 d-flex">
        {{-- Clint Filter --}}
        <div class="col-4">
            <select name="clint_id[]" class="form-control ms-2 select2" multiple>
                <option value="">{{ __('adminlte::adminlte.clint') }}</option>
                @foreach($clints as $clint)
                    <option value="{{ $clint->id }}" 
                        {{ is_array(request('clint_id')) && in_array($clint->id, request('clint_id')) ? 'selected' : '' }}>
                        {{ $clint->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Product Filter --}}
        <div class="col-4">
            <select name="product_id[]" class="form-control ms-2 select2" multiple>
                <option value="">{{ __('adminlte::adminlte.product') }}</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" 
                        {{ is_array(request('product_id')) && in_array($product->id, request('product_id')) ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filter Button --}}
        <div class="col-4 d-flex align-items-center">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-filter ms-1"></i> {{ __('adminlte::adminlte.search') }}
            </button>
        </div>
    </form>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Orders Table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ __('adminlte::adminlte.id') }}</th>
                <th>{{ __('adminlte::adminlte.clint') }}</th>
                <th>{{ __('adminlte::adminlte.total') }}</th>
                <th>{{ __('adminlte::adminlte.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->clint->name }}</td>
                    <td>{{ $order->total }}</td>
                    <td>
                        @if(auth()->user()->hasPermission('orders-read'))
                            <a href="{{ route('dashboard.orders.show', $order->id) }}" class="btn btn-info btn-sm">
                                <i class="fa fa-eye"></i> {{ __('adminlte::adminlte.View_order') }}
                            </a>
                        @endif

                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-success btn-sm">
                            <i class="fa fa-edit"></i> {{ __('adminlte::adminlte.edit') }}
                        </a>

                        @if(auth()->user()->hasPermission('orders-delete'))
                            <form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('adminlte::adminlte.are_you_sure') }}')">
                                    <i class="fa fa-trash"></i> {{ __('adminlte::adminlte.delete') }}
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection

@section('js')
    {{-- jQuery + Select2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                dir: '{{ app()->getLocale() == "ar" ? "rtl" : "ltr" }}',
                width: '100%',
                placeholder: '{{ __("adminlte::adminlte.select_option") }}',
                allowClear: true
            });
        });
    </script>
@endsection
