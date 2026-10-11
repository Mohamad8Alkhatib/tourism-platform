<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\Place;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creatorId = User::oldest('id')->value('id');
        $cities = City::pluck('id', 'name_en');
        $categories = Category::pluck('id', 'name_en');

        $places = [
            ['city' => 'Damascus', 'name_en' => 'Umayyad Mosque', 'name_ar' => 'الجامع الأموي',
                'description_en' => 'One of the oldest and largest mosques in the world, in the heart of the Old City.',
                'description_ar' => 'من أقدم وأكبر مساجد العالم، في قلب دمشق القديمة.',
                'address' => 'Old City, Damascus', 'latitude' => 33.5115000, 'longitude' => 36.3066000,
                'status' => 'published', 'categories' => ['Historical Sites', 'Mosques']],
            ['city' => 'Damascus', 'name_en' => 'Azm Palace', 'name_ar' => 'قصر العظم',
                'description_en' => 'An 18th-century Ottoman palace, now a museum of arts and traditions.',
                'description_ar' => 'قصر عثماني من القرن الثامن عشر، تحوّل إلى متحف للفنون والتقاليد.',
                'address' => 'Al-Buzuriyah, Damascus', 'latitude' => 33.5105000, 'longitude' => 36.3055000,
                'status' => 'published', 'categories' => ['Historical Sites']],
            ['city' => 'Aleppo', 'name_en' => 'Citadel of Aleppo', 'name_ar' => 'قلعة حلب',
                'description_en' => 'A medieval fortified palace on a large hill in the old city.',
                'description_ar' => 'قلعة محصّنة من العصور الوسطى على تلّة كبيرة في المدينة القديمة.',
                'address' => 'Old City, Aleppo', 'latitude' => 36.1990000, 'longitude' => 37.1620000,
                'status' => 'published', 'categories' => ['Historical Sites', 'Castles']],
            ['city' => 'Aleppo', 'name_en' => 'Khan Al-Wazir', 'name_ar' => 'خان الوزير',
                'description_en' => 'A historic caravanserai in the covered souks of Aleppo.',
                'description_ar' => null,
                'address' => 'Al-Madina Souq, Aleppo', 'latitude' => 36.2000000, 'longitude' => 37.1590000,
                'status' => 'draft', 'categories' => ['Historical Sites']],
            ['city' => 'Latakia', 'name_en' => 'Ugarit', 'name_ar' => 'أوغاريت',
                'description_en' => 'Ancient Bronze Age city, known for one of the earliest alphabets.',
                'description_ar' => 'مدينة قديمة من العصر البرونزي، اشتهرت بأحد أقدم الأبجديات.',
                'address' => 'Ras Shamra, Latakia', 'latitude' => 35.6020000, 'longitude' => 35.7810000,
                'status' => 'submitted', 'categories' => ['Historical Sites']],
        ];

        foreach ($places as $p) {
            $cityId = $cities[$p['city']] ?? null;

            if (! $cityId) {
                $this->command->warn("City '{$p['city']}' not found, skipped '{$p['name_en']}'.");

                continue;
            }

            $categoryNames = $p['categories'];
            unset($p['city'], $p['categories']);

            $place = Place::updateOrCreate(
                ['name_en' => $p['name_en'], 'city_id' => $cityId],
                $p + ['created_by' => $creatorId]
            );

            $place->categories()->sync(
                collect($categoryNames)->map(fn ($n) => $categories[$n] ?? null)->filter()->all()
            );
        }
    }
}
