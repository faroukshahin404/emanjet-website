<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\City;
use App\Models\Contact;
use App\Models\Page;
use App\Models\PageSeo;
use App\Models\Station;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $stations = Station::where('available_online', 1)->get();
        $cities = City::available()->orderBy('rank')->get();
        $page = Page::where('slug', 'home')->first();
        $homePageSeos = $page->pageSeos()->get();
        $heroSection = $homePageSeos->where('section_type', 'hero-section')->first()->translated_content_json;
        $anyWhereSection = $homePageSeos->where('section_type', 'any-where')->first()->translated_content_json;
        $paymentMethodsSection = $homePageSeos->where('section_type', 'payment-methods')->first()->translated_content_json;
        //TODP :: get the bus types section from the bus categories table
        // $busTypesSection = $homePageSeos->where('section_type', 'bus-types')->first()->translated_content_json;
        $busTypesSection = [];
        $reservationSection = $homePageSeos->where('section_type', 'reservation')->first()->translated_content_json;
        $seo = getSeoData($page);
        $testimonials = Testimonial::inRandomOrder()->limit(3)->get();
        $blogs = Blog::inRandomOrder()->limit(6)->get();

        return view('home.index', [
            'stations' => $stations,
            'cities' => $cities,
            'heroSection' => $heroSection,
            'anyWhereSection' => $anyWhereSection,
            'paymentMethodsSection' => $paymentMethodsSection,
            'busTypesSection' => $busTypesSection,
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
        $contactPageSeos = $page->pageSeos()->get();
        $contactForm = $contactPageSeos->where('section_type', 'contact-form')->first()->translated_content_json;
        $seo = getSeoData($page);
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
        $aboutPageSeos = $page->pageSeos()->get();
        $heroSection = $aboutPageSeos->where('section_type', 'hero-section')->first()->translated_content_json;
        $serviceSection = $aboutPageSeos->where('section_type', 'services')->first()->translated_content_json;
        $seo = getSeoData($page);
        return view('other.about-us.index')->with([
            'heroSection' => $heroSection,
            'serviceSection' => $serviceSection,
            'seo' => $seo
        ]);
    }

    public function privacy_policy()
    {
        $page = Page::where('slug', 'privacy-policy')->first();
        $privacePageSeos = $page->pageSeos()->get();
        $heroSection = @$privacePageSeos->first()->translated_content_json;
        $serviceSection = @$privacePageSeos->first()->translated_content_json;
        $seo = getSeoData($page);


        return view('other.privacy-policy.index')->with([
            'heroSection' => $heroSection,
            'serviceSection' => $serviceSection,
            'seo' => $seo
        ]);
    }

    public function usage_terms()
    {
        $page = Page::where('slug', 'usage-terms')->first();
        $privacePageSeos = $page->pageSeos()->get();
        $heroSection = @$privacePageSeos->first()->translated_content_json;
        $serviceSection = @$privacePageSeos->first()->translated_content_json;
        $seo = getSeoData($page);


        return view('other.usage-terms.index')->with([
            'heroSection' => $heroSection,
            'serviceSection' => $serviceSection,
            'seo' => $seo
        ]);
    }

    public function blogs()
    {
        $page = Page::where('slug', 'blogs')->first();
        $blogsPageSeos = $page->pageSeos()->get();
        $heroSection = $blogsPageSeos->where('section_type', 'hero-section')->first()->translated_content_json;
        $tripStartSection = $blogsPageSeos->where('section_type', 'trip-start')->first()->translated_content_json;
        $seo = getSeoData($page);
        $blogsCategories = BlogCategory::with('blogs')->get();
        return view('other.blogs.index')->with([
            'heroSection' => $heroSection,
            'tripStartSection' => $tripStartSection,
            'seo' => $seo,
            'blogsCategories' => $blogsCategories
        ]);
    }

    public function destinations()
    {
        $cities = City::available()->orderBy('rank')->get();
        $page = Page::where('slug', 'destinations')->first();
        $destinationsPageSeos = $page->pageSeos()->get();
        $heroSection = $destinationsPageSeos->where('section_type', 'hero-section')->first()->translated_content_json;
        $trySection = $destinationsPageSeos->where('section_type', 'try')->first()->translated_content_json;
        $appSection = $destinationsPageSeos->where('section_type', 'app')->first()->translated_content_json;
        $seo = getSeoData($page);
        $cities = City::available()->orderBy('rank')->inRandomOrder()->limit(9)->get();
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
        $faqsPageSeos = $page->pageSeos()->get();
        $heroSection = $faqsPageSeos->where('section_type', 'hero-section')->first()->translated_content_json;
        $faqsList = $faqsPageSeos->where('section_type', 'faq-list')->first()->translated_content_json;
        $seo = getSeoData($page);
        return view('other.faqs.index', )->with([
            'heroSection' => $heroSection,
            'faqsList' => $faqsList,
            'seo' => $seo
        ]);
    }




}
