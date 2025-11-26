<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\AddOn;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Cocktails', 'slug' => 'cocktails', 'description' => 'Signature mixed drinks'],
            ['name' => 'Wines', 'slug' => 'wines', 'description' => 'Fine selection of wines'],
            ['name' => 'Appetizers', 'slug' => 'appetizers', 'description' => 'Perfect starters'],
            ['name' => 'Main Courses', 'slug' => 'main-courses', 'description' => 'Hearty main dishes'],
        ];

        foreach ($categories as $category) {
            $cat = MenuCategory::create($category);

            // Add items to each category
            if ($cat->slug === 'cocktails') {
                $this->createCocktails($cat);
            } elseif ($cat->slug === 'wines') {
                $this->createWines($cat);
            } elseif ($cat->slug === 'appetizers') {
                $this->createAppetizers($cat);
            } elseif ($cat->slug === 'main-courses') {
                $this->createMainCourses($cat);
            }
        }

        // Create some add-ons
        $addOns = [
            ['name' => 'Extra Cheese', 'price' => 2.00],
            ['name' => 'Bacon', 'price' => 3.00],
            ['name' => 'Avocado', 'price' => 2.50],
            ['name' => 'Spicy Level', 'price' => 0.00],
        ];

        foreach ($addOns as $addOn) {
            AddOn::create($addOn);
        }
    }

    private function createCocktails($category)
    {
        $items = [
            ['name' => 'Mojito', 'slug' => 'mojito', 'description' => 'Fresh mint, lime, rum and soda', 'price' => 12.00, 'availability' => true],
            ['name' => 'Old Fashioned', 'slug' => 'old-fashioned', 'description' => 'Whiskey, bitters, sugar', 'price' => 14.00, 'availability' => true],
            ['name' => 'Margarita', 'slug' => 'margarita', 'description' => 'Tequila, triple sec, lime juice', 'price' => 13.00, 'availability' => true],
        ];

        foreach ($items as $item) {
            MenuItem::create(array_merge($item, ['menu_category_id' => $category->id]));
        }
    }

    private function createWines($category)
    {
        $items = [
            ['name' => 'House Red', 'slug' => 'house-red', 'description' => 'Our signature red wine blend', 'price' => 8.00, 'availability' => true],
            ['name' => 'Chardonnay', 'slug' => 'chardonnay', 'description' => 'Crisp white wine', 'price' => 10.00, 'availability' => true],
        ];

        foreach ($items as $item) {
            MenuItem::create(array_merge($item, ['menu_category_id' => $category->id]));
        }
    }

    private function createAppetizers($category)
    {
        $items = [
            ['name' => 'Garlic Bread', 'slug' => 'garlic-bread', 'description' => 'Fresh baked bread with garlic butter', 'price' => 6.00, 'availability' => true],
            ['name' => 'Mozzarella Sticks', 'slug' => 'mozzarella-sticks', 'description' => 'Breaded and fried cheese sticks', 'price' => 8.00, 'availability' => true],
        ];

        foreach ($items as $item) {
            MenuItem::create(array_merge($item, ['menu_category_id' => $category->id]));
        }
    }

    private function createMainCourses($category)
    {
        $items = [
            ['name' => 'Grilled Salmon', 'slug' => 'grilled-salmon', 'description' => 'Fresh salmon with lemon butter sauce', 'price' => 24.00, 'availability' => true],
            ['name' => 'Ribeye Steak', 'slug' => 'ribeye-steak', 'description' => '12oz steak with mashed potatoes', 'price' => 32.00, 'availability' => true],
        ];

        foreach ($items as $item) {
            MenuItem::create(array_merge($item, ['menu_category_id' => $category->id]));
        }
    }
}