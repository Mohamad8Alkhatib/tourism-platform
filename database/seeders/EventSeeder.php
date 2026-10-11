<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\City;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creatorId = User::oldest('id')->value('id');
        $cities = City::pluck('id', 'name_en');
        $categories = Category::pluck('id', 'name_en');

        $events = [
            [
                'city' => 'Damascus',
                'category' => 'Historical Sites',
                'name_en' => 'Damascus Old City Cultural Week',
                'name_ar' => 'أسبوع دمشق القديمة الثقافي',
                'description_en' => 'A week of cultural activities, guided tours, traditional music, and local crafts in the Old City of Damascus.',
                'description_ar' => 'أسبوع من الفعاليات الثقافية والجولات الإرشادية والموسيقى التراثية والحرف المحلية في مدينة دمشق القديمة.',
                'location' => 'Old City of Damascus',
                'start_date' => '2026-04-10',
                'end_date' => '2026-04-17',
                'organizer' => 'Damascus Cultural Directorate',
                'ticket_information' => 'Free entry. Some guided tours require prior registration.',
                'status' => 'published',
            ],
            [
                'city' => 'Aleppo',
                'category' => 'Historical Sites',
                'name_en' => 'Aleppo Citadel Heritage Festival',
                'name_ar' => 'مهرجان تراث قلعة حلب',
                'description_en' => 'A heritage festival featuring traditional performances, exhibitions, and tours around the historic Aleppo Citadel.',
                'description_ar' => 'مهرجان تراثي يضم عروضاً فنية ومعارض وجولات حول قلعة حلب التاريخية.',
                'location' => 'Aleppo Citadel',
                'start_date' => '2026-05-01',
                'end_date' => '2026-05-03',
                'organizer' => 'Aleppo City Council',
                'ticket_information' => 'Tickets are available at the venue entrance.',
                'status' => 'published',
            ],
            [
                'city' => 'Latakia',
                'category' => 'Nature',
                'name_en' => 'Latakia Summer Sea Festival',
                'name_ar' => 'مهرجان اللاذقية الصيفي البحري',
                'description_en' => 'A family-friendly coastal event with sea activities, local food stalls, and evening entertainment.',
                'description_ar' => 'فعالية ساحلية عائلية تتضمن أنشطة بحرية وأكشاكاً للمأكولات المحلية وبرامج ترفيهية مسائية.',
                'location' => 'Latakia Corniche',
                'start_date' => '2026-07-15',
                'end_date' => '2026-07-20',
                'organizer' => 'Latakia Tourism Office',
                'ticket_information' => 'Entry is free. Activities may have separate fees.',
                'status' => 'submitted',
            ],
            [
                'city' => 'Tartus',
                'category' => 'Food',
                'name_en' => 'Tartus Local Food Market',
                'name_ar' => 'سوق طرطوس للمأكولات المحلية',
                'description_en' => 'A seasonal market showcasing traditional dishes, olive products, sweets, and handmade food products from the coast.',
                'description_ar' => 'سوق موسمي يعرض الأطباق التقليدية ومنتجات الزيتون والحلويات والمأكولات المنزلية من المنطقة الساحلية.',
                'location' => 'Tartus Cultural Center',
                'start_date' => '2026-09-05',
                'end_date' => '2026-09-07',
                'organizer' => 'Tartus Municipality',
                'ticket_information' => 'Free entry.',
                'status' => 'draft',
            ],
            [
                'city' => 'Homs',
                'category' => null,
                'name_en' => 'Homs Community Arts Exhibition',
                'name_ar' => 'المعرض الفني المجتمعي في حمص',
                'description_en' => 'An exhibition of paintings, photography, and handmade works by local artists and community groups.',
                'description_ar' => 'معرض للوحات والصور والأعمال اليدوية لفنانين محليين ومجموعات مجتمعية.',
                'location' => 'Homs Cultural Palace',
                'start_date' => '2026-10-12',
                'end_date' => '2026-10-19',
                'organizer' => 'Homs Cultural Palace',
                'ticket_information' => null,
                'status' => 'under_review',
            ],
        ];

        foreach ($events as $eventData) {
            $cityId = $cities[$eventData['city']] ?? null;

            if (! $cityId) {
                $this->command->warn("City '{$eventData['city']}' not found, skipped '{$eventData['name_en']}'.");

                continue;
            }

            $categoryId = $eventData['category']
                ? ($categories[$eventData['category']] ?? null)
                : null;

            unset($eventData['city'], $eventData['category']);

            Event::updateOrCreate(
                ['city_id' => $cityId, 'name_en' => $eventData['name_en']],
                $eventData + [
                    'category_id' => $categoryId,
                    'created_by' => $creatorId,
                ]
            );
        }
    }
}
