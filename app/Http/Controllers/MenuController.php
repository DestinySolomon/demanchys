<?php

namespace App\Http\Controllers;
use App\Models\MenuItem;

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



    // MenuController.php (add near index)
public function showItemJson($id)
{
    $item = MenuItem::with('addons')->find($id);

    if (!$item) {
        return response()->json(['error' => 'Item not found'], 404);
    }

    // Add price property to each addon for frontend
    $item->addons->each(function($addon) {
        $addon->price = $addon->pivot->additional_price ?? $addon->additional_price;
    });

    return response()->json($item);
}
}



