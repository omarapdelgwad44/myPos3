@extends('adminlte::page')

@if (app()->getLocale() == 'ar')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
    <style>
        body {
            direction: rtl;
            text-align: right;
        }
        .form-check-label {
            margin-right: 25px;
        }
    </style>
@stop
@endif

@section('content')
<div class="container">
    <h1>{{ __('adminlte::adminlte.edit_user') }}</h1>

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
            <label for="name" class="form-label">{{ __('adminlte::adminlte.name') }}:</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $user->name) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('adminlte::adminlte.email') }}:</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email', $user->email) }}">
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">{{ __('adminlte::adminlte.profile_image') }}:</label>
            <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
            @if($user->image)
            <img id="image-preview" src="{{ asset('images/' . $user->image) }}" alt="User Image" class="img-thumbnail mt-2" style="max-width: 200px; max-height: 200px;">
            @else
            <img id="image-preview" class="img-thumbnail mt-2" style="max-width: 200px; max-height: 200px; display: none;">
            @endif
        </div>

        <script>
            function previewImage(event) {
            const imagePreview = document.getElementById('image-preview');
            imagePreview.src = URL.createObjectURL(event.target.files[0]);
            imagePreview.style.display = 'block';
            }
        </script>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('adminlte::adminlte.new_password') }} ({{ __('adminlte::adminlte.optional') }}):</label>
            <input type="password" name="password" id="password" class="form-control">
            <small class="text-muted">{{ __('adminlte::adminlte.password_hint') }}</small>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('adminlte::adminlte.confirm_new_password') }}:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">{{ __('adminlte::adminlte.permissions') }}</h3>
            </div>
            <div class="card-body">
                @if(isset($permissions) && isset($user->permissions))
                    @foreach($permissions as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input"
                            id="permission-{{ $permission->id }}"
                            {{ $user->hasPermission($permission->name) ? 'checked' : '' }}>
                            <label class="form-check-label" for="permission-{{ $permission->id }}">{{ __('adminlte::adminlte.' . $permission->name) }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <button type="submit" class="btn btn-success">{{ __('adminlte::adminlte.update_user') }}</button>
        <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">{{ __('adminlte::adminlte.cancel') }}</a>
    </form>
</div>
@endsection
