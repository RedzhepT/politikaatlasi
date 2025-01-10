@extends('layouts.app')

@section('content')
<div class="breadcrumbs">
    <div class="page-header d-flex align-items-center">
        <div class="container position-relative">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2>Hakkımızda</h2>
                </div>
            </div>
        </div>
    </div>
    <nav>
        <div class="container">
            <ol>
                <li><a href="{{ route('home') }}">Anasayfa</a></li>
                <li>Hakkımızda</li>
            </ol>
        </div>
    </nav>
</div>

<section id="about" class="about">
    <div class="container" data-aos="fade-up">
        <div class="row gy-4">
            <div class="col-lg-6">
                <img src="{{ asset('assets/img/about.jpg') }}" class="img-fluid rounded-4" alt="">
            </div>
            <div class="col-lg-6">
                <div class="content ps-0 ps-lg-5">
                    <h3>Politika Atlası Hakkında</h3>
                    <p>
                        Politika Atlası, Türkiye ve dünya siyasetini analiz eden, güncel gelişmeleri takip eden ve okuyucularına objektif bir bakış açısı sunmayı hedefleyen bir platformdur.
                    </p>
                    <ul>
                        <li><i class="bi bi-check-circle-fill"></i> Tarafsız ve objektif habercilik</li>
                        <li><i class="bi bi-check-circle-fill"></i> Derinlemesine siyasi analizler</li>
                        <li><i class="bi bi-check-circle-fill"></i> Uzman görüşleri ve değerlendirmeler</li>
                    </ul>
                    <p>
                        2023 yılında kurulan platformumuz, siyaset bilimi uzmanları, gazeteciler ve akademisyenlerden oluşan geniş bir yazar kadrosuyla hizmet vermektedir.
                    </p>

                    <div class="position-relative mt-4">
                        <img src="{{ asset('assets/img/about-2.jpg') }}" class="img-fluid rounded-4" alt="">
                        <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="team" class="team">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2>Ekibimiz</h2>
            <p>Deneyimli ve uzman kadromuzla sizlere en iyi hizmeti sunmayı hedefliyoruz.</p>
        </div>

        <div class="row gy-4">
            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="member">
                    <img src="{{ asset('assets/img/portfolio/app-1.jpg') }}" class="img-fluid" alt="">
                    <h4>Ahmet Yılmaz</h4>
                    <span>Genel Yayın Yönetmeni</span>
                </div>
            </div>

            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="member">
                    <img src="{{ asset('assets/img/portfolio/product-1.jpg') }}" class="img-fluid" alt="">
                    <h4>Ayşe Kaya</h4>
                    <span>Siyaset Bilimi Uzmanı</span>
                </div>
            </div>

            <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="member">
                    <img src="{{ asset('assets/img/portfolio/branding-1.jpg') }}" class="img-fluid" alt="">
                    <h4>Mehmet Demir</h4>
                    <span>Dış Politika Editörü</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 