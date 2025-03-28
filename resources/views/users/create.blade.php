@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Create New User</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Profile Image:</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="mb-3">
            <label for="image_preview" class="form-label">Image Preview:</label>
            <div id="image_preview" style="max-width: 200px; max-height: 200px; overflow: hidden;">
                <img id="preview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
            </div>
        </div>


        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" required minlength="8">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="8">
        </div>

        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Permissions</h3>
            </div>
            <div class="card-body">
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="users-create" class="form-check-input" id="create">
                    <label class="form-check-label" for="create">Create</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="users-read" class="form-check-input" id="read">
                    <label class="form-check-label" for="read">Read</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="users-update" class="form-check-input" id="update">
                    <label class="form-check-label" for="update">Update</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="users-delete" class="form-check-input" id="delete">
                    <label class="form-check-label" for="delete">Delete</label>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Create User</button>
            <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<script>
            document.getElementById('image').addEventListener('change', function(event) {
                const preview = document.getElementById('preview');
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            });
        </script>
@endsection
