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

         return view('menu.index', ['categories' => []]);
        // load categories + items (eager load)
        $categories = MenuCategory::with(['items' => function($q){
            $q->orderBy('created_at','desc');
        }])->orderBy('id')->get();

        return view('menu.index', compact('categories'));
    }



    // MenuController.php (add near index)
public function showItemJson($id)
{
    // Assuming your MenuItem model is App\Models\MenuItem and has relation addons()
    $item = MenuItem::with('addons')->find($id);

    if (! $item) {
        return response()->json(['error' => 'Item not found'], 404);
    }


     //fallback: ensure addons exists as array
    if (! isset($item->addons)) {
        $item->addons = [];
    }

    return response()->json($item);
}
}



