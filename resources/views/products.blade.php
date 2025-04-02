@extends('adminlte::page')

@if (app()->getLocale() == 'ar')
    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
        <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
    @stop
@endif

@section('content')
<div class="container">
    <h1>{{ @trans('adminlte::adminlte.product_management') }}</h1>
    
    <div class="row mb-3">
        <!-- Search Bar -->
        <form action="{{ route('dashboard.products.index') }}" method="GET" class="col-4 d-flex">
            <input type="text" name="search" class="form-control ms-2" placeholder="{{ @trans('adminlte::adminlte.search_by_name') }}" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center" style="width: 100px;">
                <i class="fa fa-search ms-1"></i> {{ @trans('adminlte::adminlte.search') }}
            </button>
        </form>

        @if(auth()->user()->hasPermission('products-create'))
            <div class="col-4 text-start">
                <a href="{{ route('dashboard.products.create') }}" class="btn btn-success d-flex align-items-center justify-content-center" style="width: 100px;">
                    <i class="fa fa-plus ms-1"></i> {{ @trans('adminlte::adminlte.add') }}
                </a>
            </div>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>{{ @trans('adminlte::adminlte.id') }}</th>
                <th>{{ @trans('adminlte::adminlte.image') }}</th>
                <th>{{ @trans('adminlte::adminlte.name_ar') }}</th>
                <th>{{ @trans('adminlte::adminlte.name_en') }}</th>
                <th>{{ @trans('adminlte::adminlte.description_ar') }}</th>
                <th>{{ @trans('adminlte::adminlte.description_en') }}</th>
                <th>{{ @trans('adminlte::adminlte.purchase_price') }}</th>
                <th>{{ @trans('adminlte::adminlte.sale_price') }}</th>
                <th>{{ @trans('adminlte::adminlte.stock') }}</th>
                <th>{{ @trans('adminlte::adminlte.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                    <img src="{{ $product->image ? asset('images/products/' . $product->image) : asset('images\products\product-default.png') }}" 
                         alt="products Image" class="img-thumbnail" width="50" height="50">
                </td>
                    <td>{{ $product->getTranslation('name', 'ar') }}</td>
                    <td>{{ $product->getTranslation('name', 'en') }}</td>
                    <td>{{ $product->getTranslation('description', 'ar') }}</td>
                    <td>{{ $product->getTranslation('description', 'en') }}</td>
                    <td>{{ $product->purchase_price }}</td>
                    <td>{{ $product->sale_price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if(auth()->user()->hasPermission('products-update'))
                            <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-info btn-sm">
                                <i class="fa fa-edit"></i> {{ @trans('adminlte::adminlte.edit') }}
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('products-delete'))
                            <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
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
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
