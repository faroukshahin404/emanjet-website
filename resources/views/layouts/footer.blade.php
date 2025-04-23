<Footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 d-flex flex-column mx-auto align-items-lg-start align-items-center">
                <a href="{{ route('home') }}" class="footer-links-top footer-links">{{ __('Home') }}</a>
                <a href="{{ route('home') }}#heroSection" class="footer-links">{{ __('Book A Trip') }}</a>
                <a href="{{ route('destinations') }}" class="footer-links">{{ __('Destinations') }}</a>
                <a href="{{ route('blogs') }}" class="footer-links">{{ __('Bus Blogs') }}</a>
                <a href="{{ route('faqs') }}" class="footer-links">{{ __('Faqs') }}</a>
            </div>

            <div class="col-md-2 d-flex flex-column mx-auto align-items-lg-start align-items-center">
                <p class="footer-links-top">{{ __('Useful Links') }}</p>
                <a href="services.html" class="footer-links">{{ __('Services') }}</a>
                <a href="{{ route('home') }}#testimonials" class="footer-links">{{ __('Testimonials') }}</a>
                <a href="{{ route('about-us') }}" class="footer-links">{{ __('About Us') }}</a>
                <a href="{{ route('contact-us') }}" class="footer-links">{{ __('Contact Us') }}</a>
            </div>

            @if (!empty($contactUs))
                <div class="col-md-2 d-flex flex-column mx-auto align-items-lg-start align-items-center">
                    <p class="footer-links-top">{{ __('Contact Us') }}</p>
                    @if (!empty($contactUs['phone']))
                        <a href="tel:{{ $contactUs['phone'] }}" class="footer-links">
                            <i class="fa-solid fa-phone"></i>
                            {{ $contactUs['phone'] }}
                        </a>
                    @endif

                    @if (!empty($contactUs['email']))
                        <a href="mailto:{{ $contactUs['email'] }}" class="footer-links">
                            <i class="fa-solid fa-envelope"></i>
                            {{ $contactUs['email'] }}
                        </a>
                    @endif

                    @if (!empty($contactUs['whatsapp']))
                        <a href="https://api.whatsapp.com/send?phone={{ $contactUs['whatsapp'] }}" class="footer-links"
                            target="_blank">
                            <i class="fa-brands fa-whatsapp"></i>
                            {{ $contactUs['whatsapp'] }}
                        </a>
                    @endif
                </div>
            @endif

            <div class="col-md-4">
                <h2 class="text-right mt-lg-0 mt-2">{{ __('Contact Us') }}</h2>
                <form action="" class="footer-input">
                    <div>
                        <input type="email" placeholder="{{ __('Enter Your Email Here') }}">
                        <button type="submit">{{ __('Join') }}</button>
                    </div>
                </form>

                @if (!empty($apps))
                    <div
                        class="text-white d-flex flex-lg-row flex-column justify-content-start align-items-center gap-lg-3 gap-1 mt-4">
                        @if (!empty($apps['ios']))
                            <a href="{{ $apps['ios'] }}" target="_blank"
                                class="google-play-box-footer rounded-5 text-decoration-none">
                                <div class="d-flex justify-content-center align-items-center gap-3 py-2 px-2">
                                    <div class="google-play-footer">
                                        <p>{{ __('Download On The') }}</p>
                                        <h6>{{ __('App Store') }}</h6>
                                    </div>
                                    <i class="fa-brands fa-apple"></i>
                                </div>
                            </a>
                        @endif

                        @if (!empty($apps['android']))
                            <a href="{{ $apps['android'] }}" target="_blank"
                                class="google-play-box-footer rounded-5 text-decoration-none">
                                <div class="d-flex justify-content-center align-items-center gap-3 py-2 px-2">
                                    <div class="google-play-footer">
                                        <p>{{ __('Get It On') }}</p>
                                        <h6>{{ __('Google Play') }}</h6>
                                    </div>
                                    <img src="{{ asset('images/google-play-icon.png') }}" alt="google-play">
                                </div>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        @if (!empty($socialMedia) && collect($socialMedia)->filter()->isNotEmpty())
            <div class="d-flex flex-lg-row flex-column justify-content-center align-items-center mt-lg-5 mt-4">
                <div class="social d-flex justify-content-center align-items-center gap-4 mb-lg-0 mb-2">
                    @php
                        $icons = [
                            'twitter' => 'fab fa-twitter',
                            'instagram' => 'fab fa-instagram',
                            'linkedin' => 'fab fa-linkedin-in',
                            'facebook' => 'fab fa-facebook-f',
                        ];
                    @endphp

                    @foreach ($icons as $key => $icon)
                        @if (!empty($socialMedia[$key]))
                            <a href="{{ $socialMedia[$key] }}" target="_blank">
                                <i class="{{ $icon }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</Footer>
