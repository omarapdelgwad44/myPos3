@extends('adminlte::page')

@if (app()->getLocale() == 'ar')
    @section('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
        <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
     @stop
@endif

@section('content')
<div class="container">
    <h1>{{ @trans('adminlte::adminlte.user_management') }}</h1>
    
    <div class="row mb-3">
        <!-- شريط البحث -->
        <form action="{{ route('dashboard.users.index') }}" method="GET" class="col-4 d-flex">
            <input type="text" name="search" class="form-control ms-2" placeholder="{{ @trans('adminlte::adminlte.search_by_name_or_email') }}" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center" style="width: 100px;">
                <i class="fa fa-search ms-1"></i> {{ @trans('adminlte::adminlte.search') }}
            </button>
        </form>

        @if(auth()->user()->hasPermission('users-create'))
            <div class="col-4 text-start">
                <a href="{{ route('dashboard.users.create') }}" class="btn btn-success d-flex align-items-center justify-content-center" style="width: 100px;">
                    <i class="fa fa-plus ms-1"></i> {{ @trans('adminlte::adminlte.add') }}
                </a>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">
        <i class="fa fa-plus"></i> Add User form wizard
    </a>
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
                <th>{{ @trans('adminlte::adminlte.email') }}</th>
                <th>{{ @trans('adminlte::adminlte.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                    <img src="{{ $user->image ? asset('images/users/' . $user->image) : asset('images/default-avatar.png') }}" 
                         alt="User Image" class="img-thumbnail" width="50" height="50">
                </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if(auth()->user()->hasPermission('users-update'))
                            <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-info btn-sm">
                                <i class="fa fa-edit"></i> {{ @trans('adminlte::adminlte.edit') }}
                            </a>
                        @endif

                        @if(auth()->user()->hasPermission('users-delete') && $user->id != auth()->user()->id)
                            <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
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
        {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
