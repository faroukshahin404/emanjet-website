<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BusCategory;
use App\Models\City;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Station;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {

        $qnbPaymentService = new \App\Services\QNBPaymentService('app');

        $payment = $qnbPaymentService->initiateQNBPaymentLink([
            'amount' => 100,
            'order_id' => 1234567890,
        ]);


        $stations = Station::where('available_online', 1)->get();
        $cities = City::available()->orderBy('rank')->get();
        $page = Page::where('slug', 'home')->first();
        $homePageSeos = $page ? $page->pageSeos()->get() : collect();
        $heroSection = $this->getSectionContent($homePageSeos, 'hero-section', [
            'card-title' => __('Book your trip now!'),
            'image' => asset('images/hero-section.png'),
            'caption-title' => __('We are here to help you'),
            'caption-description' => __('Book your trip with Eman Jet'),
        ]);
        $anyWhereSection = $this->getSectionContent($homePageSeos, 'any-where', [
            'title' => __('Eman Jet is with you anywhere'),
            'description' => '',
            'image' => 'https://placehold.co/745x677',
        ]);
        $paymentMethodsSection = $this->getSectionContent($homePageSeos, 'payment-methods', [
            'title' => __('Choose the payment method that suits you'),
            'images' => [],
        ]);
        $busTypesSection = BusCategory::get();
        $popularDestinationsSection = $this->getSectionContent($homePageSeos, 'popular-destinations', [
            'title' => __('Popular Destinations'),
            'description' => '',
        ]);
        $reservationSection = $this->getSectionContent($homePageSeos, 'reservation', [
            'title' => '',
            'description' => '',
        ]);
        $advantageSection = $this->getSectionContent($homePageSeos, 'advantage', [
            'pre-title' => __('THE EMAN JET ADVANTAGE'),
            'title' => __('Why Choose Eman Jet?'),
            'description' => '',
            'items' => []
        ]);
        $statsSection = $this->getSectionContent($homePageSeos, 'stats', [
            'items' => []
        ]);
        $commitmentSection = $this->getSectionContent($homePageSeos, 'quality-commitment', [
            'pre-title' => __('OUR COMMITMENT'),
            'title' => __('Your Comfort is Our Priority'),
            'items' => []
        ]);
        $seo = $page ? getSeoData($page->toArray()) : $this->getDefaultSeo();
        $testimonials = Testimonial::inRandomOrder()->limit(3)->get();
        $blogs = Blog::inRandomOrder()->limit(6)->get();

        return view('home.index', [
            'stations' => $stations,
            'cities' => $cities,
            'heroSection' => $heroSection,
            'anyWhereSection' => $anyWhereSection,
            'paymentMethodsSection' => $paymentMethodsSection,
            'busTypesSection' => $busTypesSection,
            'popularDestinationsSection' => $popularDestinationsSection,
            'reservationSection' => $reservationSection,
            'advantageSection' => $advantageSection,
            'statsSection' => $statsSection,
            'commitmentSection' => $commitmentSection,
            'seo' => $seo,
            'testimonials' => $testimonials,
            'blogs' => $blogs,
        ]);
    }


    public function getCities()
    {
        $cities = City::available()->orderBy('rank')->get();
        $cities->transform(function ($city) {
            return [
                'id' => $city->id,
                'name' => $city->name,
                'image' => $city->image,
            ];
        });

        return response()->json($cities);
    }
    public function getStations(City $city)
    {
        $stations = $city->stations()->where('available_online', 1)->select('id', 'name')->get();
        $stations->transform(function ($station) {
            return [
                'id' => $station->id,
                'name' => $station->name,
            ];
        });

        return response()->json($stations);
    }

    public function tickets()
    {
        return view('mobile.tickets');
    }

    public function settings()
    {
        return view('mobile.settings');
    }

    public function contact_us()
    {
        $page = Page::where('slug', 'contact-us')->first();
        $contactPageSeos = $page ? $page->pageSeos()->get() : collect();
        $contactForm = $this->getSectionContent($contactPageSeos, 'contact-form', [
            'title' => __('Contact Form'),
            'description' => '',
            'form-title' => __('Send Us a Message'),
            'image' => '',
            'button-text' => __('Submit Message'),
            'complaints-title' => __('Complaints & Feedback'),
            'complaints-description' => __('Experience any issues? We are here to listen and improve our service.'),
        ]);
        $generalPage = Page::where('slug', 'general')->first();
        $generalSeos = $generalPage ? $generalPage->pageSeos()->get() : collect();
        $socialMedia = $this->getSectionContent($generalSeos, 'social-media', []);
        $contactUs = $socialMedia['contact'] ?? [];
        $seo = $page ? getSeoData($page->toArray()) : $this->getDefaultSeo();

        return view('other.contact-us.index')->with([
            'contactForm' => $contactForm,
            'contactUs' => $contactUs,
            'seo' => $seo
        ]);
    }

    public function submit_contact_form(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'name' => 'required',
            'message' => 'required'
        ], [
            'phone.required' => __('Phone is required'),
            'name.required' => __('Name is required'),
            'message.required' => __('Message is required')
        ]);
        Contact::create([
            'name' => $request->name,
            'mobile' => $request->phone,
            'message' => $request->message,
        ]);
        return redirect()->back()->with('success', __('Submitted Successfully!'));
    }

    public function about_us()
    {
        $page = Page::where('slug', 'about-us')->first();
        $aboutPageSeos = $page ? $page->pageSeos()->get() : collect();
        $heroSection = $this->getSectionContent($aboutPageSeos, 'hero-section', ['title' => __('About Us'), 'description' => '', 'image' => '']);
        $serviceSection = $this->getSectionContent($aboutPageSeos, 'services', []);
        $seo = $page ? getSeoData($page->toArray()) : $this->getDefaultSeo();
        return view('other.about-us.index')->with([
            'heroSection' => $heroSection,
            'serviceSection' => $serviceSection,
            'seo' => $seo
        ]);
    }

    public function privacy_policy()
    {
        $page = Page::where('slug', 'privacy-policy')->first();
        $privacePageSeos = $page ? $page->pageSeos()->get() : collect();
        $heroSection = $this->getSectionContent($privacePageSeos, 'privacy-policy', ['title' => __('Privacy Policy'), 'description' => '', 'image' => '', 'button-text' => '']);
        $serviceSection = $heroSection;
        $seo = $page ? getSeoData($page->toArray()) : $this->getDefaultSeo();

        return view('other.privacy-policy.index')->with([
            'heroSection' => $heroSection,
            'serviceSection' => $serviceSection,
            'seo' => $seo
        ]);
    }
    public function usage_terms()
    {
        $page = Page::where('slug', 'usage-terms')->first();
        $privacePageSeos = $page ? $page->pageSeos()->get() : collect();
        $heroSection = $this->getSectionContent($privacePageSeos, 'usage-terms', ['title' => __('Usage Terms'), 'description' => '', 'image' => '', 'button-text' => '']);
        $serviceSection = $heroSection;
        $seo = $page ? getSeoData($page->toArray()) : $this->getDefaultSeo();

        return view('other.usage-terms.index')->with([
            'heroSection' => $heroSection,
            'serviceSection' => $serviceSection,
            'seo' => $seo
        ]);
    }



    public function blogs()
    {
        $page = Page::where('slug', 'blogs')->first();
        $blogsPageSeos = $page ? $page->pageSeos()->get() : collect();
        $heroSection = $this->getSectionContent($blogsPageSeos, 'hero-section', ['title' => __('Bus Blogs'), 'description' => '', 'image' => '']);
        $tripStartSection = $this->getSectionContent($blogsPageSeos, 'trip-start', ['title' => '', 'description' => '', 'button-text' => __('Book Now'), 'images' => []]);
        $seo = $page ? getSeoData($page->toArray()) : $this->getDefaultSeo();
        $blogsCategories = BlogCategory::with('blogs')->get();
        return view('other.blogs.index')->with([
            'heroSection' => $heroSection,
            'tripStartSection' => $tripStartSection,
            'seo' => $seo,
            'blogsCategories' => $blogsCategories
        ]);
    }
    public function destinations(Request $request)
    {
        $search = $request->input('search', '');
        $query = City::available()->orderBy('rank');
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name->ar', 'LIKE', '%' . $search . '%')
                    ->orWhere('name->en', 'LIKE', '%' . $search . '%');
            });
        }
        $cities = $query->inRandomOrder()->limit(9)->get();
        $page = Page::where('slug', 'destinations')->first();
        $destinationsPageSeos = $page ? $page->pageSeos()->get() : collect();
        $heroSection = $this->getSectionContent($destinationsPageSeos, 'hero-section', [
            'pre-title' => __('OUR ROUTES'),
            'title' => __('Discover Your Next Adventure'),
            'description' => __('Explore the best destinations across the country with Eman Jet. Premium services, safe journeys, and unforgettable experiences.'),
            'search-title' => __('Where are you traveling to?'),
            'image' => ''
        ]);
        $popularCitiesSection = $this->getSectionContent($destinationsPageSeos, 'popular-cities', [
            'pre-title' => __('TRAVEL THE COUNTRY'),
            'title' => __('Explore Popular Cities'),
            'description' => __('Curated routes for your ultimate comfort. Choose your destination and book your ticket in seconds.'),
        ]);
        $trySection = $this->getSectionContent($destinationsPageSeos, 'try', [
            'title' => '',
            'description' => '',
            'button-text' => __('Find your trip now'),
            'image' => ''
        ]);
        $appSection = $this->getSectionContent($destinationsPageSeos, 'app', ['title' => '', 'description' => '', 'image' => '']);
        $seo = $page ? getSeoData($page->toArray()) : $this->getDefaultSeo();

        return view('other.destinations.index')->with([
            'cities' => $cities,
            'heroSection' => $heroSection,
            'popularCitiesSection' => $popularCitiesSection,
            'trySection' => $trySection,
            'appSection' => $appSection,
            'seo' => $seo,

        ]);
    }

    public function faqs()
    {
        $page = Page::where('slug', 'faqs')->first();
        $faqsPageSeos = $page ? $page->pageSeos()->get() : collect();
        $heroSection = $this->getSectionContent($faqsPageSeos, 'hero-section', ['title' => __('FAQs'), 'description' => '', 'image' => '']);
        $faqs = Faq::active()->ordered()->get();
        $seo = $page ? getSeoData($page->toArray()) : $this->getDefaultSeo();
        return view('other.faqs.index')->with([
            'heroSection' => $heroSection,
            'faqs' => $faqs,
            'seo' => $seo
        ]);
    }

    /**
     * Get section content from page SEO collection with fallback defaults.
     */
    private function getSectionContent($pageSeos, string $sectionType, array $default = []): array
    {
        $section = $pageSeos
            ->where('section_type', $sectionType)
            ->where('status', true)
            ->first();
        if (!$section) {
            return $default;
        }
        $content = $section->translated_content_json;
        return is_array($content) ? $content : $default;
    }

    /**
     * Default SEO data when no page is found.
     */
    private function getDefaultSeo(): array
    {
        return [
            'meta_title' => 'Eman Jet',
            'meta_description' => 'Eman Jet - ' . __('Book your trip'),
            'meta_keywords' => 'eman jet, travel, booking',
            'meta_image' => 'default-image.jpg',
            'og_title' => 'Eman Jet',
            'og_description' => 'Eman Jet - ' . __('Book your trip'),
            'og_image' => 'default-og-image.jpg',
        ];
    }
}
