@extends('layouts.admin')

@section('title', 'Kategori Düzenle')

@section('content')
<div class="content-wrapper">
    <div class="editor-wrapper">
        <h2 class="mb-4">Kategori Düzenle</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Kategori Adı</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Açıklama</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="button-container">
                <button type="submit" class="btn">Değiştir</button>
            </div>
        </form>
    </div>
</div>
@endsection 