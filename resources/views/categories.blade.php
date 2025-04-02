@extends('adminlte::page')

@if (app()->getLocale() == 'ar')
    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
        <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
     @stop
@endif

@section('content')
<div class="container">
    <h1>{{ @trans('adminlte::adminlte.category_management') }}</h1>
    
    <div class="row mb-3">
        <!-- شريط البحث -->
        <form action="{{ route('dashboard.categories.index') }}" method="GET" class="col-4 d-flex">
            <input type="text" name="search" class="form-control ms-2" placeholder="{{ @trans('adminlte::adminlte.search_by_name') }}" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center" style="width: 100px;">
                <i class="fa fa-search ms-1"></i> {{ @trans('adminlte::adminlte.search') }}
            </button>
        </form>

        @if(auth()->user()->hasPermission('categories-create'))
            <div class="col-4 text-start">
                <button type="button" class="btn btn-success d-flex align-items-center justify-content-center" style="width: 100px;" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="fa fa-plus ms-1"></i> {{ @trans('adminlte::adminlte.add') }}
                </button>
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
                <th>{{ @trans('adminlte::adminlte.name') }}</th>
                <th>{{ @trans('adminlte::adminlte.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>
                    <img src="{{ $category->image ? asset('images/categories/' . $category->image) : asset('images/default-avatar.png') }}" 
                         alt="category Image" class="img-thumbnail" width="50" height="50">
                </td>
                    <td>{{ $category->name }}</td>
                    <td>
                    @if(auth()->user()->hasPermission('categories-update'))
                        <button type="button" class="btn btn-info btn-sm"
                            onclick="openEditModal('{{ $category->id }}','{{ $category->getTranslation('name', 'en', false) }}', '{{ $category->getTranslation('name', 'ar', false) }}', '{{ asset('images/categories/' . $category->image) }}')">
                            <i class="fa fa-edit"></i> {{ trans('adminlte::adminlte.edit') }}
                        </button>
                    @endif


                        @if(auth()->user()->hasPermission('categories-delete'))
                            <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST" style="display:inline-block;">
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
        {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@extends('categories.create')
@extends('categories.edit')
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

