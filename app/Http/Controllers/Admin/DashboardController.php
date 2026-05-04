<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_cities'       => \App\Models\City::count(),
            'total_destinations' => \App\Models\Destination::count(),
            'total_blogs'        => \App\Models\Blog::count(),
            'total_faqs'         => \App\Models\Faq::count(),
            'total_testimonials' => \App\Models\Testimonial::count(),
            'total_pages'        => \App\Models\Page::count(),
            'total_contacts'     => \App\Models\Contact::count(),
        ];

        $recent_blogs = \App\Models\Blog::latest()->take(5)->get();
        $recent_messages = \App\Models\Contact::latest()->take(5)->get();

        return view('admin.pages.dashboard.index', compact('stats', 'recent_blogs', 'recent_messages'));
    }
}
