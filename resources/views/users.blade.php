@extends('adminlte::page')
@section('content')
<div class="container">
    <h1>User Management</h1>
    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary mb-3">Add New User</a>

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
                        <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                      @if($user->id != auth()->user()->id)
                        <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection