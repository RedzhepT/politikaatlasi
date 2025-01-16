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
                <img src="{{ asset('assets/img/about-2.jpg') }}" class="img-fluid rounded-4" alt="">
            </div>
            <div class="col-lg-6">
                <div class="content ps-0 ps-lg-5">
                    <h3>Politika Atlası Nedir?</h3>
                    <p>
                        Politika Atlası, dünya genelindeki farklı yönetim sistemlerini, siyasi yapıları ve devlet organizasyonlarını 
                        herkesin anlayabileceği bir dille açıklayan eğitici bir platformdur.
                    </p>
                    <ul>
                        <li><i class="bi bi-check-circle-fill"></i> Tarafsız ve akademik bir yaklaşım</li>
                        <li><i class="bi bi-check-circle-fill"></i> Karşılaştırmalı siyaset analizi</li>
                        <li><i class="bi bi-check-circle-fill"></i> Güncel siyasi gelişmelerin değerlendirilmesi</li>
                    </ul>
                    <p>
                        Amacımız, farklı ülkelerin yönetim biçimlerini, siyasi sistemlerini ve devlet yapılarını 
                        objektif bir bakış açısıyla inceleyerek, okuyucularımıza kapsamlı bir siyasi atlas sunmaktır. 
                        Her ülkenin kendine özgü yönetim pratiklerini, tarihsel süreçlerini ve siyasi kültürünü 
                        analiz ederek, karşılaştırmalı bir perspektif oluşturmayı hedefliyoruz.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="values" class="values">
    <div class="container" data-aos="fade-up">
        <div class="section-header">
            <h2>Değerlerimiz</h2>
            <p>Politika Atlası olarak benimsediğimiz temel ilkeler</p>
        </div>

        <div class="row gy-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="value-box">
                    <i class="bi bi-book-half"></i>
                    <h3>Eğitici İçerik</h3>
                    <p>Karmaşık siyasi kavramları ve sistemleri, herkesin anlayabileceği bir dille açıklayarak, okuyucularımızın siyasi bilgi düzeyini artırmayı hedefliyoruz.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="value-box">
                    <i class="bi bi-shield-check"></i>
                    <h3>Tarafsız Yaklaşım</h3>
                    <p>Farklı yönetim sistemlerini ve siyasi yapıları, objektif bir bakış açısıyla inceleyerek, tarafsız ve akademik bir perspektif sunuyoruz.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="value-box">
                    <i class="bi bi-graph-up-arrow"></i>
                    <h3>Güncel Analiz</h3>
                    <p>Dünya siyasetindeki güncel gelişmeleri yakından takip ederek, derinlemesine analizler ve karşılaştırmalı değerlendirmeler sunuyoruz.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.values .value-box {
    padding: 30px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.08);
    border-radius: 8px;
    text-align: center;
    height: 100%;
    transition: 0.3s;
}

.values .value-box i {
    font-size: 48px;
    color: var(--color-primary);
    margin-bottom: 20px;
}

.values .value-box h3 {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 15px;
    color: var(--color-secondary);
}

.values .value-box p {
    color: #6c757d;
    line-height: 1.6;
}

.values .value-box:hover {
    transform: translateY(-5px);
}

.section-header {
    text-align: center;
    padding-bottom: 40px;
}

.section-header h2 {
    font-size: 32px;
    font-weight: 700;
    position: relative;
    color: var(--color-default);
}

.section-header p {
    margin-bottom: 0;
    color: #6c757d;
}
</style>
@endsection 