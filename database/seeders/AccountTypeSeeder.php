<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'type' => AccountType::SUPER_ADMIN,
                'name_en' => 'Super Admin',
                'name_ar' => 'مدير عام'
            ],
            [
                'type' => AccountType::ADMIN,
                'name_en' => 'Admin',
                'name_ar' => 'مدير'
            ],
            [
                'type' => AccountType::GUIDE,
                'name_en' => 'Guide',
                'name_ar' => 'مرشد سياحي'
            ],
            [
                'type' => AccountType::OWNER,
                'name_en' => 'Owner',
                'name_ar' => 'مالك مكان'
            ],
            [
                'type' => AccountType::TOURIST,
                'name_en' => 'Tourist',
                'name_ar' => 'سائح'
            ]
        ];
        foreach ($types as $type) {
            AccountType::updateOrCreate(
                ['type' => $type['type']],
                $type
            );
        }
    }
}
