@extends('layouts.app')

@section('content')
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2>İletişim</h2>
            <p>Bizimle iletişime geçmek için aşağıdaki formu kullanabilirsiniz.</p>
        </div>

        <div class="row gx-lg-0 gy-4">
            <div class="col-lg-8 mx-auto">
                <form action="{{ route('contact.send') }}" method="post" role="form" class="php-email-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Adınız" required>
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <input type="email" class="form-control" name="email" id="email" placeholder="E-posta Adresiniz" required>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Konu" required>
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="message" rows="7" placeholder="Mesajınız" required></textarea>
                    </div>
                    <div class="text-center"><button type="submit">Mesaj Gönder</button></div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection 