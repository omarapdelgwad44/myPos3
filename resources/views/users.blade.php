@extends('adminlte::page')
@section('content')
<div class="container">
    <h1>User Management</h1>
    
    <div class="row mb-3">
        <!-- Search Bar -->
        <form action="{{ route('dashboard.users.index') }}" method="GET" class="col-4 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by name or email..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary d-flex align-items-center justify-content-center" style="width: 100px;">
                <i class="fa fa-search me-1"></i> Search
            </button>
        </form>
        @if(auth()->user()->hasPermission('users-create'))
            <div class="col-4 text-end">
                <a href="{{ route('dashboard.users.create') }}" class="btn btn-success d-flex align-items-center justify-content-center" style="width: 100px;">
                    <i class="fa fa-plus me-1"></i> Add
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
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if( auth()->user()->hasPermission('users-update'))
                        <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-info btn-sm ">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        @endif
                        @if( auth()->user()->hasPermission('users-delete'))
                      @if($user->id != auth()->user()->id)
                        <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                        @endif
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