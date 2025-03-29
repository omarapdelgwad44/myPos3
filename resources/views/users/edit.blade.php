@extends('adminlte::page')

@if (app()->getLocale() == 'ar')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
@stop
@endif

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

    <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
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
            <label for="image" class="form-label">Profile Image:</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($user->image)
            <img src="{{ asset('images/' . $user->image) }}" alt="User Image" class="img-thumbnail mt-2" style="max-width: 200px; max-height: 200px;">
            @endif

        <div class="mb-3">
            <label for="password" class="form-label">New Password (optional):</label>
            <input type="password" name="password" id="password" class="form-control">
            <small class="text-muted">Leave blank if you don't want to change the password.</small>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Permissions</h3>
            </div>
            <div class="card-body">
                @if(isset($permissions) && isset($user->permissions))
                @foreach($permissions as $permission)
                    <div class="form-check">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input"
                        id="permission-{{ $permission->id }}"
                        {{ $user->hasPermission($permission->name) ? 'checked' : '' }}>
                        <label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                    </div>
                @endforeach
                @endif
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update User</button>
        <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
