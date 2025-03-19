@extends('layouts.admin')

@section('title', 'Yeni Makale')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/editor.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/forms.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/modal.css') }}">
<style>
    #errorAlert {
        display: none;
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 4px;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <div id="errorAlert"></div>
    
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
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        Makale Görseli
                    </label>
                    
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <input type="file" 
                                   name="image" 
                                   id="featured_image"
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewImage(this)">
                            
                            <label for="featured_image" 
                                   class="cursor-pointer bg-blue-500 text-white px-4 py-2 rounded">
                                Görsel Seç
                            </label>
                        </div>
                        
                        <!-- Görsel önizleme alanı -->
                        <div id="image-preview" class="hidden">
                            <img src="" alt="Önizleme" class="max-w-xs">
                            <button type="button" onclick="removeImage()" 
                                    class="mt-2 text-red-500">
                                Görseli Kaldır
                            </button>
                        </div>
                    </div>
                    
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>Kategori</div>
                <div class="category-container">
                    <select name="category_id" class="editor-field single-line category-select">
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
                <button type="submit" class="btn" id="submitBtn">Kaydet</button>
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
    const form = document.getElementById('articleForm');
    const submitBtn = document.getElementById('submitBtn');
    const errorAlert = document.getElementById('errorAlert');

    // Form submit öncesi içeriği güncelle
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
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

        // Form verilerini hazırla
        const formData = new FormData(this);
        
        // Debug: Form verilerini detaylı kontrol et
        console.log('Form verileri detayı:');
        formData.forEach((value, key) => {
            console.log(`${key}:`, {
                'değer': value,
                'tip': typeof value,
                'uzunluk': value.length
            });
        });
        
        // Zorunlu alanları kontrol et
        const requiredFields = {
            'title': 'Başlık',
            'author': 'Yazar',
            'category_id': 'Kategori',
            'content': 'İçerik'
        };
        
        let hasError = false;
        Object.entries(requiredFields).forEach(([field, label]) => {
            const value = formData.get(field);
            if (!value || value.trim() === '') {
                console.error(`${label} alanı boş:`, {field, value});
                hasError = true;
            }
        });
        
        if (hasError) {
            errorAlert.innerHTML = 'Lütfen tüm zorunlu alanları doldurun.';
            errorAlert.style.display = 'block';
            errorAlert.scrollIntoView({ behavior: 'smooth' });
            return;
        }
        
        // Butonu devre dışı bırak
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Kaydediliyor...';
        
        // Hata mesajını gizle
        errorAlert.style.display = 'none';
        
        // AJAX isteği gönder
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            console.log('HTTP Status:', response.status);
            return response.json().then(data => ({
                status: response.status,
                data: data
            }));
        })
        .then(({status, data}) => {
            console.log('Response Data:', data);
            
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                errorAlert.innerHTML = '';
                if (typeof data.errors === 'object') {
                    console.log('Validation Errors:', data.errors);
                    Object.values(data.errors).forEach(error => {
                        errorAlert.innerHTML += `<div>${error}</div>`;
                    });
                } else {
                    console.log('Error Message:', data.message);
                    errorAlert.innerHTML = data.message || 'Bir hata oluştu';
                }
                errorAlert.style.display = 'block';
                errorAlert.scrollIntoView({ behavior: 'smooth' });
                
                // Butonu tekrar aktif et
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Kaydet';
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            errorAlert.innerHTML = 'Bir hata oluştu. Lütfen tekrar deneyin.';
            errorAlert.style.display = 'block';
            errorAlert.scrollIntoView({ behavior: 'smooth' });
            
            // Butonu tekrar aktif et
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Kaydet';
        });
    });
});

function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const img = preview.querySelector('img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    const input = document.getElementById('featured_image');
    const preview = document.getElementById('image-preview');
    
    input.value = '';
    preview.classList.add('hidden');
}
</script>
@endsection 