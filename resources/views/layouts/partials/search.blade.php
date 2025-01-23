<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="searchModalLabel">Ara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('articles.search') }}" method="GET" class="search-form">
                    <div class="input-group">
                        <input type="text" 
                               name="q" 
                               class="form-control" 
                               placeholder="Makale ara..." 
                               value="{{ request('q') }}"
                               autocomplete="off"
                               required>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .search-form .form-control {
        border-radius: 4px 0 0 4px;
        border-right: none;
        box-shadow: none;
        font-size: 16px;
        padding: 12px 15px;
    }

    .search-form .form-control:focus {
        border-color: #ced4da;
        box-shadow: none;
    }

    .search-form .btn {
        border-radius: 0 4px 4px 0;
        padding: 12px 20px;
    }

    .search-form .btn:hover {
        background-color: var(--color-primary-dark);
    }

    .modal-header {
        padding: 1rem 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-primary);
    }

    .btn-close:focus {
        box-shadow: none;
    }

    @media (max-width: 576px) {
        .modal-dialog {
            margin: 1rem;
        }
    }
</style> 