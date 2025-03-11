@extends('layouts.admin')

@section('title', 'Kategoriler')

@section('styles')
<style>
    .categories-wrapper {
        padding: 20px;
        background: #fff;
        border-radius: 4px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .categories-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .btn-add {
        padding: 8px 16px;
        background: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    .btn-add:hover {
        background: #218838;
        color: white;
        text-decoration: none;
    }

    .categories-table {
        width: 100%;
        border-collapse: collapse;
    }

    .categories-table th,
    .categories-table td {
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
    }

    .categories-table th {
        background: #f8f9fa;
        font-weight: 600;
        text-align: left;
    }

    .categories-table tr:hover {
        background: #f8f9fa;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-edit,
    .btn-delete {
        padding: 4px 8px;
        border: none;
        border-radius: 4px;
        color: white;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-edit {
        background: #007bff;
    }

    .btn-edit:hover {
        background: #0056b3;
        color: white;
        text-decoration: none;
    }

    .btn-delete {
        background: #dc3545;
    }

    .btn-delete:hover {
        background: #c82333;
        color: white;
        text-decoration: none;
    }

    .alert {
        padding: 12px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
</style>
@endsection

@section('content')
<div class="categories-wrapper">
    <div class="categories-header">
        <h2>Kategoriler</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn-add">
            <i class="fas fa-plus"></i> Yeni Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <table class="categories-table">
        <thead>
            <tr>
                <th>Kategori Adı</th>
                <th>Açıklama</th>
                <th>Makale Sayısı</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>{{ $category->articles->count() }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Bu kategoriyi silmek istediğinize emin misiniz?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="pagination">
        {{ $categories->links() }}
    </div>
</div>
@endsection 