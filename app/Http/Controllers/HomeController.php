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
            'caption-description' => __('Book your trip with Super Jet'),
        ]);
        $anyWhereSection = $this->getSectionContent($homePageSeos, 'any-where', [
            'title' => __('Super Jet is with you anywhere'),
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
            'image' => '',
            'button-text' => __('Send'),
        ]);
        $seo = $page ? getSeoData($page->toArray()) : $this->getDefaultSeo();
        return view('other.contact-us.index')->with([
            'contactForm' => $contactForm,
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
        $heroSection = $this->getSectionContent($destinationsPageSeos, 'hero-section', ['search-title' => __('Where are you traveling to?'), 'image' => '']);
        $trySection = $this->getSectionContent($destinationsPageSeos, 'try', ['title' => '', 'description' => '', 'image' => '']);
        $appSection = $this->getSectionContent($destinationsPageSeos, 'app', ['title' => '', 'description' => '', 'image' => '']);
        $seo = $page ? getSeoData($page->toArray()) : $this->getDefaultSeo();

        return view('other.destinations.index')->with([
            'cities' => $cities,
            'heroSection' => $heroSection,
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
        $section = $pageSeos->where('section_type', $sectionType)->first();
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
            'meta_title' => 'Super Jet',
            'meta_description' => 'Super Jet - ' . __('Book your trip'),
            'meta_keywords' => 'super jet, travel, booking',
            'meta_image' => 'default-image.jpg',
            'og_title' => 'Super Jet',
            'og_description' => 'Super Jet - ' . __('Book your trip'),
            'og_image' => 'default-og-image.jpg',
        ];
    }
}
