<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tree = [
            ['name_en' => 'Food', 'name_ar' => 'طعام', 'children' => [
                ['name_en' => 'Restaurants', 'name_ar' => 'مطاعم'],
                ['name_en' => 'Cafes',       'name_ar' => 'مقاهي'],
            ]],
            ['name_en' => 'Historical Sites', 'name_ar' => 'مواقع تاريخية', 'children' => [
                ['name_en' => 'Mosques',  'name_ar' => 'مساجد'],
                ['name_en' => 'Castles',  'name_ar' => 'قلاع'],
            ]],
            ['name_en' => 'Nature', 'name_ar' => 'طبيعة'],
        ];

        foreach ($tree as $root) {
            $parent = Category::updateOrCreate(
                ['name_en' => $root['name_en'], 'parent_id' => null],
                ['name_ar' => $root['name_ar']]
            );

            foreach ($root['children'] ?? [] as $child) {
                Category::updateOrCreate(
                    ['name_en' => $child['name_en'], 'parent_id' => $parent->id],
                    ['name_ar' => $child['name_ar']]
                );
            }
        }
    }
}
