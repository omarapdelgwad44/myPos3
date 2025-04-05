@extends('adminlte::page')

@if (app()->getLocale() == 'ar')
    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
        <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
     @stop
@endif

@section('content')
<div class="container">
    <h1>{{ @trans('adminlte::adminlte.clint_management') }}</h1>
    
    <div class="row mb-3">
        <!-- شريط البحث -->
        <form action="{{ route('dashboard.clints.index') }}" method="GET" class="col-4 d-flex">
            <input type="text" name="search" class="form-control ms-2" placeholder="{{ @trans('adminlte::adminlte.search_by_name') }}" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center" style="width: 100px;">
                <i class="fa fa-search ms-1"></i> {{ @trans('adminlte::adminlte.search') }}
            </button>
        </form>

        @if(auth()->user()->hasPermission('clints-create'))
            <div class="col-4 text-start">
                <button type="button" class="btn btn-success d-flex align-items-center justify-content-center" style="width: 100px;" data-bs-toggle="modal" data-bs-target="#addClintModal">
                    <i class="fa fa-plus ms-1"></i> {{ @trans('adminlte::adminlte.add') }}
                </button>
            </div>
        @endif
    </div>
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
                <th>{{ @trans('adminlte::adminlte.name') }}</th>
                <th>{{ @trans('adminlte::adminlte.phone') }}</th>
                <th>{{ @trans('adminlte::adminlte.address') }}</th>
                <th>{{ @trans('adminlte::adminlte.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clints as $clint)
                <tr>
                    <td>{{ $clint->id }}</td>
                    <td>{{ $clint->name }}</td>
                    <td>{{ $clint->phone }}</td>
                    <td>{{ $clint->address }}</td>
                    <td>
                    @if(auth()->user()->hasPermission('clints-update'))
                        <button type="button" class="btn btn-info btn-sm"
                            onclick="openEditModal('{{ $clint->id }}','{{ $clint->name }}', '{{$clint->address }}', '{{ $clint->phone }}')">
                            <i class="fa fa-edit"></i> {{ trans('adminlte::adminlte.edit') }}
                        </button>
                    @endif


                        @if(auth()->user()->hasPermission('clints-delete'))
                            <form action="{{ route('dashboard.clints.destroy', $clint->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ @trans('adminlte::adminlte.are_you_sure') }}')">
                                    <i class="fa fa-trash"></i> {{ @trans('adminlte::adminlte.delete') }}
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('clints.orders.create', $clint->id) }}" class="btn btn-success btn-sm">
        <i class="fa fa-plus"></i> Order
    </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-3">
        {{ $clints->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@extends('clints.create')
@extends('clints.edit')
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

