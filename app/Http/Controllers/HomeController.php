<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function home()
    {
        // Get active promotional banners
        $promotionalBanners = Banner::where('type', 'promotional')
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get active offer deals
        $offerDeals = Banner::where('type', 'offer')
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get featured testimonials for homepage
        $featuredTestimonials = Testimonial::where('is_featured', true)
            ->where('is_approved', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->limit(6) // Show max 6 on homepage
            ->get();

        return view('home', compact('promotionalBanners', 'offerDeals', 'featuredTestimonials'));
    }
}