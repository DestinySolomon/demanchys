<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\AddOn;

class MenuDemoSeeder extends Seeder
{
    public function run()
    {
        $c1 = MenuCategory::create(['name'=>'Local & International Cuisine','slug'=>'cuisine','description'=>'Local favourites and international dishes.']);
        $c2 = MenuCategory::create(['name'=>'Premium Drinks & Beverages','slug'=>'drinks','description'=>'Cocktails and fine drinks.']);
        $c3 = MenuCategory::create(['name'=>'Grilled Specialties & Snacks','slug'=>'grilled','description'=>'Grilled meats and snacks.']);

        MenuItem::create([
            'menu_category_id'=>$c1->id,
            'name'=>'Grilled Fish & Jollof',
            'slug'=>'grilled-fish-jollof',
            'description'=>'Succulent grilled fish served with jollof rice.',
            'price'=>3500,
            'availability'=>'daily'
        ]);

        MenuItem::create([
            'menu_category_id'=>$c2->id,
            'name'=>'Signature Cocktail',
            'slug'=>'signature-cocktail',
            'description'=>'Our bartender’s signature mix.',
            'price'=>1200,
            'availability'=>'daily'
        ]);

        MenuItem::create([
            'menu_category_id'=>$c3->id,
            'name'=>'Spicy Suya Platter',
            'slug'=>'suya-platter',
            'description'=>'Skewered beef and chicken suya with sides.',
            'price'=>2500,
            'availability'=>'on_demand'
        ]);

        // add-ons
        $a1 = AddOn::create(['name'=>'Fish','price'=>400]);
        $a2 = AddOn::create(['name'=>'Beef','price'=>500]);
        $a3 = AddOn::create(['name'=>'Chicken','price'=>400]);
        $a4 = AddOn::create(['name'=>'Eba','price'=>150]);

        // attach for demonstration
        $item = MenuItem::first();
        $item->addOns()->attach($a1->id, ['additional_price' => $a1->price]);
    }
}

