<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // show menu page with categories and items
    public function index(Request $request)
    {
        // load categories + items (eager load)
        $categories = MenuCategory::with(['items' => function($q){
            $q->orderBy('created_at','desc');
        }])->orderBy('id')->get();

        return view('menu.index', compact('categories'));
    }
}
