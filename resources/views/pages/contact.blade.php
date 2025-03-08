@extends('layouts.app')

@section('content')
<section id="contact" class="contact">
    <div class="container">
        <div class="section-header">
            <h2>İletişim</h2>
            <p>Bizimle iletişime geçmek için aşağıdaki formu kullanabilirsiniz.</p>
        </div>

        <div class="row gx-lg-0 gy-4">
            <div class="col-lg-8 mx-auto">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="post" role="form" class="php-email-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="text" name="name" class="form-control" id="name" 
                                placeholder="Adınız" required value="{{ old('name') }}">
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <input type="email" class="form-control" name="email" id="email" 
                                placeholder="E-posta Adresiniz" required value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="text" class="form-control" name="subject" id="subject" 
                            placeholder="Konu" required value="{{ old('subject') }}">
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="message" rows="7" 
                            placeholder="Mesajınız" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="text-center"><button type="submit">Mesaj Gönder</button></div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
.alert {
    margin-bottom: 20px;
}

.alert ul {
    list-style: none;
    padding-left: 0;
}

.php-email-form .error-message {
    display: none;
    color: #fff;
    background: #df1529;
    text-align: left;
    padding: 15px;
    margin-bottom: 24px;
    font-weight: 600;
}

.php-email-form .sent-message {
    display: none;
    color: #fff;
    background: #059652;
    text-align: center;
    padding: 15px;
    margin-bottom: 24px;
    font-weight: 600;
}

.php-email-form button[type=submit] {
    background: var(--color-primary);
    border: 0;
    padding: 12px 40px;
    color: #fff;
    transition: 0.4s;
    border-radius: 50px;
}

.php-email-form button[type=submit]:hover {
    background: var(--color-secondary);
}
</style>
@endsection 