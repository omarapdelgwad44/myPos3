@extends('adminlte::page')

@if (app()->getLocale() == 'ar')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.min.css">
<link rel="stylesheet" href="{{ asset('css/adminlte-rtl.css') }}">
@stop
@endif

@section('content')
<div class="container">
    <h1>{{ @trans('adminlte::adminlte.create_product') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name_ar" class="form-label">{{ @trans('adminlte::adminlte.name_ar') }}:</label>
            <input type="text" name="name[ar]" id="name_ar" class="form-control" required value="{{ old('name.ar') }}">
        </div>

        <div class="mb-3">
            <label for="name_en" class="form-label">{{ @trans('adminlte::adminlte.name_en') }}:</label>
            <input type="text" name="name[en]" id="name_en" class="form-control" required value="{{ old('name.en') }}">
        </div>

        <div class="mb-3">
            <label for="description_ar" class="form-label">{{ @trans('adminlte::adminlte.description_ar') }}:</label>
            <textarea name="description[ar]" id="description_ar" class="form-control" >{{ old('description.ar') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="description_en" class="form-label">{{ @trans('adminlte::adminlte.description_en') }}:</label>
            <textarea name="description[en]" id="description_en" class="form-control" >{{ old('description.en') }}</textarea>
        </div>

        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                ClassicEditor
                    .create(document.querySelector('#description_ar'))
                    .catch(error => {
                        console.error(error);
                    });
        
                ClassicEditor
                    .create(document.querySelector('#description_en'))
                    .catch(error => {
                        console.error(error);
                    });
            });
        </script>

        <div class="mb-3">
            <label for="category" class="form-label">{{ @trans('adminlte::adminlte.category') }}:</label>
            <select name="category_id" id="category" class="form-control" required>
                <option value="">{{ @trans('adminlte::adminlte.choose_category') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="purchase_price" class="form-label">{{ @trans('adminlte::adminlte.purchase_price') }}:</label>
            <input type="number" name="purchase_price" id="purchase_price" class="form-control" required step="0.01" value="{{ old('purchase_price') }}">
        </div>

        <div class="mb-3">
            <label for="sale_price" class="form-label">{{ @trans('adminlte::adminlte.sale_price') }}:</label>
            <input type="number" name="sale_price" id="sale_price" class="form-control" required step="0.01" value="{{ old('sale_price') }}">
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">{{ @trans('adminlte::adminlte.stock') }}:</label>
            <input type="number" name="stock" id="stock" class="form-control" required value="{{ old('stock') }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">{{ @trans('adminlte::adminlte.image') }}:</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="image_preview" class="form-label">{{ @trans('adminlte::adminlte.image_preview') }}:</label>
            <div id="image_preview" style="max-width: 200px; max-height: 200px; overflow: hidden;">
                <img id="preview" src="#" alt="Image Preview" style="display: none; width: 100%; height: auto;">
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">{{ @trans('adminlte::adminlte.create_product') }}</button>
            <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary">{{ @trans('adminlte::adminlte.cancel') }}</a>
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
