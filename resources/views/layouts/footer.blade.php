<footer>
    <div class="container">
        <div class="row g-4">
            {{-- Column 1: Brand & Description --}}
            <div class="col-lg-3 col-md-6">
                <div class="footer-brand mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Eman Jet" class="img-fluid mb-3" style="max-height: 60px; filter: brightness(0) invert(1);">
                    <p class="text-white-50 mb-4">
                        {{ __('Eman Jet is your trusted partner for comfortable and safe travel across the region. We provide premium bus services with a focus on quality and passenger satisfaction.') }}
                    </p>
                </div>
                
                @if (!empty($socialMedia))
                    <div class="social-footer">
                        @foreach ($socialMedia as $link)
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer"
                                aria-label="{{ parse_url($link['url'], PHP_URL_HOST) ?? __('Social link') }}">
                                <i class="{{ $link['icon_class'] }}" aria-hidden="true"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Column 2: Quick Links --}}
            <div class="col-lg-2 col-md-6 offset-lg-1">
                <h5 class="footer-links-top">{{ __('Quick Links') }}</h5>
                <div class="footer-nav">
                    <a href="{{ route('home') }}" class="footer-links">{{ __('Home') }}</a>
                    <a href="{{ route('destinations') }}" class="footer-links">{{ __('Destinations') }}</a>
                    <a href="{{ route('blogs') }}" class="footer-links">{{ __('Bus Blogs') }}</a>
                    <a href="{{ route('faqs') }}" class="footer-links">{{ __('FAQS') }}</a>
                </div>
            </div>

            {{-- Column 3: Support --}}
            <div class="col-lg-2 col-md-6">
                <h5 class="footer-links-top">{{ __('Support') }}</h5>
                <div class="footer-nav">
                    <a href="{{ route('about-us') }}" class="footer-links">{{ __('About Us') }}</a>
                    <a href="{{ route('contact-us') }}" class="footer-links">{{ __('Contact Us') }}</a>
                    <a href="{{ route('privacy-policy') }}" class="footer-links">{{ __('Privacy') }}</a>
                    <a href="{{ route('usage-terms') }}" class="footer-links">{{ __('Usage Terms') }}</a>
                </div>
            </div>

            {{-- Column 4: Newsletter & Apps --}}
            <div class="col-lg-4 col-md-6 footer-newsletter-column">
                <h2 class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                    {{ __('Newsletter') }}
                </h2>
                <p class="small opacity-75 mb-4">{{ __('Subscribe to our newsletter for the latest updates and offers.') }}</p>

                <form action="#" class="mb-4">
                    <div class="footer-input-group">
                        <input type="email" placeholder="{{ __('Your Email') }}" required>
                        <button type="submit" class="footer-join-btn">
                            {{ __('Join') }}
                        </button>
                    </div>
                </form>

                @if (!empty($apps))
                    <div class="d-flex flex-wrap gap-3">
                        @if (!empty($apps['android']))
                            <a href="{{ $apps['android'] }}" target="_blank" class="google-play-box-footer rounded-4 text-decoration-none d-flex align-items-center gap-3">
                                <img src="{{ asset('images/google-play-icon.png') }}" alt="Google Play">
                                <div class="google-play-footer">
                                    <p>{{ __('Get It On') }}</p>
                                    <h6>{{ __('Google Play') }}</h6>
                                </div>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-bottom mt-5">
        <div class="container text-center">
            <p class="copyright-text">
                &copy; {{ date('Y') }} {{ config('app.name', 'Eman Jet') }}. {{ __('All rights reserved.') }}
            </p>
        </div>
    </div>
</footer>
