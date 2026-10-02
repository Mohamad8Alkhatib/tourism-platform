<?php

namespace Database\Seeders;

use App\Models\AccountType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminType = AccountType::where('type', AccountType::SUPER_ADMIN)->firstOrFail();

        User::updateOrCreate(
            ['email' => 'superadmin@tourism-platform.test'],
            [
                'account_type_id' => $superAdminType->id,
                'name' => 'Super Admin',
                'password' => 'admin@123',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}
