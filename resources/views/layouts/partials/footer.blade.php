<footer id="footer" class="footer">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5 col-md-12 footer-info">
                <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                    <span>Politika Atlası</span>
                </a>
                <p>Farklı yönetim biçimlerini ve siyasi kavramları herkesin anlayabileceği bir dille açıklayan eğitici bir platform.</p>
                <div class="social-links d-flex mt-4">
                    @if(config('site.social.twitter'))
                        <a href="{{ config('site.social.twitter') }}" class="twitter" target="_blank">
                            <i class="bi bi-twitter"></i>
                        </a>
                    @endif
                    
                    @if(config('site.social.facebook'))
                        <a href="{{ config('site.social.facebook') }}" class="facebook" target="_blank">
                            <i class="bi bi-facebook"></i>
                        </a>
                    @endif
                    
                    @if(config('site.social.instagram'))
                        <a href="{{ config('site.social.instagram') }}" class="instagram" target="_blank">
                            <i class="bi bi-instagram"></i>
                        </a>
                    @endif
                    
                    @if(config('site.social.linkedin'))
                        <a href="{{ config('site.social.linkedin') }}" class="linkedin" target="_blank">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    @endif
                </div>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Hızlı Linkler</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Anasayfa</a></li>
                    <li><a href="{{ route('about') }}">Hakkımızda</a></li>
                    <li><a href="{{ route('articles.index') }}">Blog</a></li>
                    <li><a href="{{ route('contact') }}">İletişim</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-6 footer-links">
                <h4>Kategoriler</h4>
                <ul>
                    @foreach($categories->take(5) as $category)
                        <li>
                            <a href="{{ route('articles.category', $category->slug) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                <h4>İletişim</h4>
                <p>
                    {{ config('site.contact.address') }}<br>
                    <strong>Email:</strong> {{ config('site.contact.email') }}<br>
                </p>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="copyright">
            &copy; {{ date('Y') }} <strong><span>Politika Atlası</span></strong>. Tüm hakları saklıdır.
        </div>
    </div>
</footer>

<style>
.footer {
    font-size: 14px;
    background-color: var(--color-primary);
    padding: 50px 0;
    color: white;
}

.footer .footer-info .logo {
    line-height: 0;
    margin-bottom: 25px;
}

.footer .footer-info .logo span {
    font-size: 30px;
    font-weight: 700;
    letter-spacing: 1px;
    color: white;
    font-family: var(--font-primary);
}

.footer .social-links a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid rgba(255, 255, 255, 0.2);
    font-size: 16px;
    color: rgba(255, 255, 255, 0.7);
    margin-right: 10px;
    transition: 0.3s;
}

.footer .social-links a:hover {
    color: white;
    border-color: white;
}

.footer h4 {
    font-size: 16px;
    font-weight: bold;
    position: relative;
    padding-bottom: 12px;
    color: white;
}

.footer .footer-links {
    margin-bottom: 30px;
}

.footer .footer-links ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer .footer-links ul li {
    padding: 10px 0;
    display: flex;
    align-items: center;
}

.footer .footer-links ul li:first-child {
    padding-top: 0;
}

.footer .footer-links ul a {
    color: rgba(255, 255, 255, 0.7);
    transition: 0.3s;
    display: inline-block;
    line-height: 1;
    text-decoration: none;
}

.footer .footer-links ul a:hover {
    color: white;
}

.footer .copyright {
    text-align: center;
    padding-top: 30px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}
</style> 