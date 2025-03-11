@extends('layouts.admin')

@section('title', 'Yeni Kategori')

@section('content')
<div class="category-form-wrapper">
    <h2 class="mb-4">Yeni Kategori</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Kategori Adı</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Açıklama</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn-primary">Kaydet</button>
    </form>
</div>
@endsection 