<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $syria = Country::where('name_en', 'Syria')->firstOrFail();

        $cities = [
            ['name_en' => 'Damascus', 'name_ar' => 'دمشق'],
            ['name_en' => 'Aleppo', 'name_ar' => 'حلب'],
            ['name_en' => 'Homs', 'name_ar' => 'حمص'],
            ['name_en' => 'Hama', 'name_ar' => 'حماة'],
            ['name_en' => 'Latakia', 'name_ar' => 'اللاذقية'],
            ['name_en' => 'Tartus', 'name_ar' => 'طرطوس'],
            ['name_en' => 'Idlib', 'name_ar' => 'إدلب'],
            ['name_en' => 'Raqqa', 'name_ar' => 'الرقة'],
            ['name_en' => 'Deir ez-Zor', 'name_ar' => 'دير الزور'],
            ['name_en' => 'Hasakah', 'name_ar' => 'الحسكة'],
            ['name_en' => 'Daraa', 'name_ar' => 'درعا'],
            ['name_en' => 'As-Suwayda', 'name_ar' => 'السويداء'],
            ['name_en' => 'Quneitra', 'name_ar' => 'القنيطرة'],
            ['name_en' => 'Damascus Countryside', 'name_ar' => 'ريف دمشق'],
        ];

        foreach ($cities as $city) {
            City::updateOrCreate(
                ['country_id' => $syria->id, 'name_en' => $city['name_en']],
                ['name_ar' => $city['name_ar']]
            );
        }
    }
}
