@extends('layouts.admin')

@section('title', 'Yeni Makale')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/editor.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/forms.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/modal.css') }}">
@endsection

@section('content')
<div class="content-wrapper">
    <form id="articleForm" action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="editor-wrapper">
            <div id="toolbar" class="toolbar">
                <div class="toolbar-group">
                    <button type="button" data-command="bold"><i class="fas fa-bold"></i></button>
                    <button type="button" data-command="italic"><i class="fas fa-italic"></i></button>
                    <button type="button" data-command="underline"><i class="fas fa-underline"></i></button>
                    <button type="button" data-command="strikeThrough"><i class="fas fa-strikethrough"></i></button>
                </div>
                <div class="toolbar-group">
                    <button type="button" data-command="justifyLeft"><i class="fas fa-align-left"></i></button>
                    <button type="button" data-command="justifyCenter"><i class="fas fa-align-center"></i></button>
                    <button type="button" data-command="justifyRight"><i class="fas fa-align-right"></i></button>
                    <button type="button" data-command="justifyFull"><i class="fas fa-align-justify"></i></button>
                </div>
                <div class="toolbar-group">
                    <button type="button" data-command="insertUnorderedList"><i class="fas fa-list-ul"></i></button>
                    <button type="button" data-command="insertOrderedList"><i class="fas fa-list-ol"></i></button>
                    <button type="button" data-command="indent"><i class="fas fa-indent"></i></button>
                    <button type="button" data-command="outdent"><i class="fas fa-outdent"></i></button>
                </div>
                <div class="toolbar-group">
                    <button type="button" data-command="createLink"><i class="fas fa-link"></i></button>
                    <button type="button" data-command="unlink"><i class="fas fa-unlink"></i></button>
                    <button type="button" data-command="image"><i class="fas fa-image"></i></button>
                </div>
            </div>

            <div class="text-fields">
                <div>Başlık</div>
                <div class="editor-field single-line" contenteditable="true" id="title"></div>
                <input type="hidden" name="title" id="hiddenTitle" value="">

                <div>Yazar</div>
                <div class="editor-field single-line" contenteditable="true" id="author"></div>
                <input type="hidden" name="author" id="hiddenAuthor" value="">

                <div>Görsel</div>
                <div class="image-upload-field">
                    <input type="file" name="image" accept="image/*">
                    <span class="text-muted">Desteklenen formatlar: JPEG, PNG, JPG, GIF (max. 2MB)</span>
                </div>

                <div>Kategori</div>
                <div class="category-container">
                    <select name="category" class="editor-field single-line category-select">
                        <option value="">Kategori Seçin</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('admin.categories.create') }}" class="btn-add-category">
                        <i class="fas fa-plus"></i> Yeni Kategori
                    </a>
                </div>

                <div>İçerik</div>
                <div class="editor-field multi-line" contenteditable="true" id="articleContent"></div>
                <input type="hidden" name="content" id="hiddenContent" value="">
            </div>

            <div class="button-container">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1">
                    <label class="form-check-label" for="is_published">Yayınla</label>
                </div>
                <button type="submit" class="btn">Kaydet</button>
            </div>
        </div>
    </form>
</div>

<!-- Image Upload Modal -->
<div id="imageModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Resim Yükle</h2>
        <form id="imageUploadForm" action="{{ route('admin.upload.image') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="image" accept="image/*" required>
            <button type="submit">Yükle</button>
        </form>
        <div id="uploadProgress"></div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/editor.js') }}"></script>
<script src="{{ asset('js/admin/modal.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Form submit öncesi içeriği güncelle
    document.getElementById('articleForm').addEventListener('submit', function(e) {
        // Title ve author alanlarını güncelle
        const titleField = document.getElementById('title');
        const authorField = document.getElementById('author');
        const contentField = document.getElementById('articleContent');
        
        if (titleField && document.getElementById('hiddenTitle')) {
            document.getElementById('hiddenTitle').value = titleField.textContent;
        }
        
        if (authorField && document.getElementById('hiddenAuthor')) {
            document.getElementById('hiddenAuthor').value = authorField.textContent;
        }
        
        if (contentField && document.getElementById('hiddenContent')) {
            document.getElementById('hiddenContent').value = contentField.innerHTML;
        }
    });
});
</script>
@endsection 