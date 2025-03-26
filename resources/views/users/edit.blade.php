@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email', $user->email) }}">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password (optional):</label>
            <input type="password" name="password" id="password" class="form-control">
            <small class="text-muted">Leave blank if you don't want to change the password.</small>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update User</button>
        <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
