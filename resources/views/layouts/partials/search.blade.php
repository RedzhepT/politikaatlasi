<div class="search-section">
    <div class="container">
        <form action="{{ route('articles.search') }}" method="GET" class="search-form">
            <div class="input-group">
                <input type="text" name="query" class="form-control" 
                    placeholder="Makalelerde ara..." 
                    value="{{ request('query') }}" 
                    required 
                    minlength="3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Ara
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.search-section {
    padding: 0.5rem 0;
}

.search-section .search-form {
    max-width: 600px;
    margin: 0 auto;
}

.search-section .input-group {
    border-radius: 50px;
    overflow: hidden;
    box-shadow: 0 20px 15px rgba(0,0,0,0.15);
}

.search-section input {
    border: none;
    padding: 15px 25px;
    font-size: 16px;
}

.search-section .btn {
    padding: 0 25px;
    border: none;
    background: var(--color-primary);
    color: white;
    transition: all 0.3s ease;
}

.search-section .btn:hover {
    background: var(--color-primary-dark);
}
</style> 