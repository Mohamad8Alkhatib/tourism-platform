<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['type' => 'view_places', 'name_en' => 'View Places', 'name_ar' => 'عرض الأماكن'],
            ['type' => 'create_places', 'name_en' => 'Create Places', 'name_ar' => 'إنشاء الأماكن'],
            ['type' => 'update_places', 'name_en' => 'Update Places', 'name_ar' => 'تحديث الأماكن'],
            ['type' => 'delete_places', 'name_en' => 'Delete Places', 'name_ar' => 'حذف الأماكن']
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['type' => $permission['type']],
                $permission
            );
        }
        $allRole = Role::where('name', Role::ALL_PERMISSIONS_ROLE)->firstOrFail();
        $allRole->permissions()->sync(Permission::pluck('id'));
    }
}
