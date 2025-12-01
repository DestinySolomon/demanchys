<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class HomeController extends Controller
{
    public function home()
    {
        $promotionalBanners = Banner::where('type', 'promotional')
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        $offerDeals = Banner::where('type', 'offer')
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', compact('promotionalBanners', 'offerDeals'));
    }
}
