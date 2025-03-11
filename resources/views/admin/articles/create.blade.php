@extends('layouts.admin')

@section('title', 'Yeni Makale')

@section('styles')
<style>
    .editor-wrapper {
        padding: 20px;
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .toolbar {
        margin-bottom: 20px;
        border-bottom: 1px solid #ccc;
        padding: 10px;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        background: #f8f9fa;
        position: sticky;
        top: 0;
        z-index: 100;
        border-radius: 4px 4px 0 0;
    }

    .toolbar-group {
        display: flex;
        gap: 2px;
        border-right: 1px solid #eee;
        padding-right: 10px;
    }

    .toolbar-group:last-child {
        border-right: none;
    }

    .toolbar button {
        width: 35px;
        height: 35px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s;
    }

    .toolbar button:hover {
        background: #f0f0f0;
        border-color: #ccc;
    }

    .toolbar button i {
        font-size: 16px;
    }

    .text-fields {
        padding: 20px;
        background: #fff;
        border-radius: 0 0 4px 4px;
    }

    .text-fields > div:not(.editor-field) {
        font-weight: bold;
        margin: 10px 0 5px 0;
        user-select: none;
        color: #333;
    }

    .editor-field {
        width: 100%;
        border: 1px solid #ddd;
        padding: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        background: white;
        min-height: 40px;
        border-radius: 4px;
        transition: border-color 0.2s;
    }

    .editor-field:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .single-line {
        height: 40px;
        overflow: hidden;
        white-space: nowrap;
    }

    .multi-line {
        min-height: 300px;
        overflow-y: auto;
    }

    .button-container {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 4px;
    }

    .btn {
        padding: 10px 25px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }

    .btn:hover {
        background: #0056b3;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 25px;
        border: none;
        width: 90%;
        max-width: 500px;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: color 0.2s;
    }

    .close:hover {
        color: #333;
    }

    #imageUploadForm {
        margin-top: 20px;
        display: flex;
        gap: 15px;
        align-items: center;
    }

    #imageUploadForm input[type="file"] {
        flex: 1;
        padding: 10px;
        border: 2px dashed #ddd;
        border-radius: 4px;
        background: #f8f9fa;
        cursor: pointer;
    }

    #imageUploadForm input[type="file"]:hover {
        border-color: #007bff;
    }

    #imageUploadForm button {
        padding: 10px 25px;
        background: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
    }

    #imageUploadForm button:hover {
        background: #0056b3;
    }

    #imageUploadForm button:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    #uploadProgress {
        margin-top: 15px;
        color: #666;
        text-align: center;
        font-size: 14px;
    }

    /* Editor içerik stilleri */
    .editor-field img {
        max-width: 100%;
        height: auto;
        margin: 10px auto;
        border-radius: 4px;
        display: block;
    }

    .editor-field figure {
        margin: 0;
        padding: 0;
        max-width: 100%;
    }

    .editor-field figure img {
        width: 100%;
        height: auto;
        margin: 10px auto;
        border-radius: 4px;
        display: block;
    }

    .editor-field figure figcaption {
        text-align: center;
        font-size: 14px;
        color: #666;
        margin-top: 5px;
    }

    .editor-field a {
        color: #007bff;
        text-decoration: none;
    }

    .editor-field a:hover {
        text-decoration: underline;
    }

    .editor-field ul, 
    .editor-field ol {
        margin: 10px 0;
        padding-left: 25px;
    }

    .editor-field li {
        margin: 5px 0;
    }

    .image-upload-field {
        margin-bottom: 20px;
    }

    .image-upload-field input[type="file"] {
        width: 100%;
        padding: 12px;
        border: 2px dashed #ddd;
        border-radius: 4px;
        background: #f8f9fa;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .image-upload-field input[type="file"]:hover {
        border-color: #007bff;
    }

    .image-upload-field .text-muted {
        display: block;
        margin-top: 5px;
        font-size: 12px;
        color: #666;
    }

    .select-field {
        height: 40px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 8px 12px;
        width: 50%;
        margin-bottom: 20px;
        font-size: 14px;
        transition: border-color 0.2s;
        margin-right: 10px;
        display: inline-block;
    }

    .select-field:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .new-category-btn {
        display: inline-flex;
        align-items: center;
        padding: 8px 15px;
        background: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    .new-category-btn:hover {
        background: #218838;
        color: white;
        text-decoration: none;
    }

    .new-category-btn i {
        margin-right: 5px;
    }
</style>
@endsection

@section('content')
<div class="editor-wrapper">
    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-group">
            <button type="button" onclick="execCommand('cut')" title="Kes"><i class="bi bi-scissors"></i></button>
            <button type="button" onclick="execCommand('copy')" title="Kopyala"><i class="bi bi-files"></i></button>
            <button type="button" onclick="execCommand('paste')" title="Yapıştır"><i class="bi bi-clipboard"></i></button>
        </div>
        <div class="toolbar-group">
            <button type="button" onclick="execCommand('undo')" title="Geri Al"><i class="bi bi-arrow-counterclockwise"></i></button>
            <button type="button" onclick="execCommand('redo')" title="İleri Al"><i class="bi bi-arrow-clockwise"></i></button>
        </div>
        <div class="toolbar-group">
            <button type="button" onclick="execCommand('bold')" title="Kalın"><i class="bi bi-type-bold"></i></button>
            <button type="button" onclick="execCommand('italic')" title="İtalik"><i class="bi bi-type-italic"></i></button>
            <button type="button" onclick="execCommand('underline')" title="Altı Çizili"><i class="bi bi-type-underline"></i></button>
            <button type="button" onclick="execCommand('strikeThrough')" title="Üstü Çizili"><i class="bi bi-type-strikethrough"></i></button>
        </div>
        <div class="toolbar-group">
            <button type="button" onclick="execCommand('justifyLeft')" title="Sola Hizala"><i class="bi bi-text-left"></i></button>
            <button type="button" onclick="execCommand('justifyCenter')" title="Ortala"><i class="bi bi-text-center"></i></button>
            <button type="button" onclick="execCommand('justifyRight')" title="Sağa Hizala"><i class="bi bi-text-right"></i></button>
        </div>
        <div class="toolbar-group">
            <button type="button" onclick="execCommand('insertUnorderedList')" title="Sırasız Liste"><i class="bi bi-list-ul"></i></button>
            <button type="button" onclick="execCommand('insertOrderedList')" title="Sıralı Liste"><i class="bi bi-list-ol"></i></button>
        </div>
        <div class="toolbar-group">
            <button type="button" onclick="execCommand('createLink', true)" title="Link Ekle"><i class="bi bi-link-45deg"></i></button>
            <button type="button" onclick="execCommand('unlink')" title="Link Kaldır"><i class="bi bi-link-45deg-strike"></i></button>
        </div>
        <div class="toolbar-group">
            <button type="button" onclick="showImageUpload()" title="Resim Ekle"><i class="bi bi-image"></i></button>
        </div>
        <div class="toolbar-group">
            <button type="button" onclick="execCommand('formatBlock', false, 'h1')">H1</button>
            <button type="button" onclick="execCommand('formatBlock', false, 'h2')">H2</button>
            <button type="button" onclick="execCommand('formatBlock', false, 'h3')">H3</button>
            <button type="button" onclick="execCommand('formatBlock', false, 'h4')">H4</button>
            <button type="button" onclick="execCommand('formatBlock', false, 'h5')">H5</button>
            <button type="button" onclick="execCommand('formatBlock', false, 'h6')">H6</button>
        </div>
    </div>

    <!-- Image Upload Modal -->
    <div id="imageUploadModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Resim Yükle</h2>
            <form id="imageUploadForm" enctype="multipart/form-data">
                <input type="file" name="upload" accept="image/*" required>
                <button type="submit">Yükle</button>
            </form>
            <div id="uploadProgress" style="display: none;">
                Yükleniyor...
            </div>
        </div>
    </div>

    <form id="articleForm" action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="text-fields">
            <div>Görsel</div>
            <div class="image-upload-field">
                <input type="file" name="image" accept="image/*" class="form-control">
                <small class="text-muted">Önerilen boyut: 1200x800 piksel</small>
            </div>

            <div>Başlık</div>
            <div name="title" class="editor-field single-line" contenteditable="true"></div>
            
            <div>Yazar</div>
            <input type="text" name="author" class="editor-field single-line" required>

            <div>Kategori</div>
            <select name="category" class="select-field" required>
                <option value="">Kategori Seçin</option>
                @foreach($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <a href="{{ route('admin.categories.create') }}" class="new-category-btn" target="_blank">
                <i class="bi bi-plus-lg"></i> Yeni Kategori
            </a>
            
            <div>İçerik</div>
            <div name="content" class="editor-field multi-line" contenteditable="true"></div>
        </div>

        <div class="button-container">
            <button type="submit" name="action" value="publish" class="btn">Kaydet</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Otomatik toolbar'ı devre dışı bırak
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[contenteditable="true"]').forEach(function(element) {
            element.addEventListener('mouseup', function(e) {
                const selection = window.getSelection();
                if (selection.rangeCount > 0) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        });
    });

    function execCommand(command, ui = false, value = null) {
        if (command === 'createLink' && ui) {
            const url = prompt('Link URL giriniz:', 'http://');
            if (url) {
                document.execCommand(command, false, url);
            }
        } else {
            document.execCommand(command, ui, value);
        }
    }

    document.getElementById('articleForm').onsubmit = function() {
        const fields = document.querySelectorAll('.editor-field');
        fields.forEach(field => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = field.getAttribute('name');
            hiddenInput.value = field.innerHTML;
            this.appendChild(hiddenInput);
        });
        return true;
    };

    // Resim yükleme modalını göster
    function showImageUpload() {
        document.getElementById('imageUploadModal').style.display = 'block';
    }

    // Modal kapatma
    document.querySelector('.close').onclick = function() {
        document.getElementById('imageUploadModal').style.display = 'none';
    }

    // Modal dışına tıklandığında kapat
    window.onclick = function(event) {
        const modal = document.getElementById('imageUploadModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    // Resim yükleme işlemi
    document.getElementById('imageUploadForm').onsubmit = function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const progressDiv = document.getElementById('uploadProgress');
        const form = this;
        
        progressDiv.style.display = 'block';
        form.querySelector('button').disabled = true;

        fetch('{{ route("admin.upload.image") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.url) {
                // Resmi editöre ekle
                const img = '<img src="' + data.url + '" alt="" style="max-width: 100%; height: auto;">';
                document.querySelector('[name="content"]').focus();
                document.execCommand('insertHTML', false, img);
                
                // Modalı kapat ve formu temizle
                document.getElementById('imageUploadModal').style.display = 'none';
                form.reset();
            } else {
                alert('Resim yüklenirken bir hata oluştu.');
            }
        })
        .catch(error => {
            alert('Resim yüklenirken bir hata oluştu.');
        })
        .finally(() => {
            progressDiv.style.display = 'none';
            form.querySelector('button').disabled = false;
        });
    }
</script>
@endsection 