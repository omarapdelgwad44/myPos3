@extends('adminlte::page')

@if (app()->getLocale() == 'ar')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
@stop
@endif

@section('content')
<div class="container">
<h1>{{@trans('adminlte::adminlte.create_user')}}</h1>
    
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
            <label for="name" class="form-label">{{@trans('adminlte::adminlte.name')}}:</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{@trans('adminlte::adminlte.email')}}:</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">{{@trans('adminlte::adminlte.image')}}:</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="mb-3">
            <label for="image_preview" class="form-label">{{@trans('adminlte::adminlte.image_preview')}}:</label>
            <div id="image_preview" style="max-width: 200px; max-height: 200px; overflow: hidden;">
                <img id="preview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
            </div>
        </div>


        <div class="mb-3">
            <label for="password" class="form-label">{{@trans('adminlte::adminlte.password')}}</label>
            <input type="password" name="password" id="password" class="form-control" required minlength="8">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{@trans('adminlte::adminlte.confirm_password')}}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="8">
        </div>
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">{{ __('adminlte::adminlte.permissions') }}</h3>
            </div>
        @if(isset($permissions) && $permissions->isNotEmpty())
            @php
                $chunks = $permissions->chunk(4); 
            @endphp
            <ul class="nav nav-tabs mt-3" id="permissionsTab" role="tablist">
                @foreach($chunks as $index => $chunk)
                    <li class="nav-item">
                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}" id="permissions-tab-link-{{ $index }}" data-toggle="tab" href="#permissions-tab-{{ $index }}" role="tab">
                            {{ $index === 0 ? __('adminlte::adminlte.users') : ($index === 1 ? __('adminlte::adminlte.categories') : __('adminlte::adminlte.products')) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-muted">{{ @trans('adminlte::adminlte.no_permissions_available') }}</p>
        @endif
    <div class="tab-content mt-3">
            @php
                $chunks = $permissions->chunk(4);
                $names=['create','read','update','delete'];
                $i=0;
            @endphp
            @foreach($chunks as $index => $chunk)
                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="permissions-tab-{{ $index }}" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            @foreach($chunk as $permission)
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                           class="form-check-input" id="permission-{{ $permission->id }}"
                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission-{{ $permission->id }}">
                                        {{ __('adminlte::adminlte.' . $names[$i]) }}
                                        @php $i++;
                                        if($i==4)$i=0;
                                        @endphp
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
    </div>
    </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">{{@trans('adminlte::adminlte.create_user')}}</button>
            <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">{{@trans('adminlte::adminlte.cancel')}}</a>
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
