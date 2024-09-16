<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use App\Traits\Utilities;
use Illuminate\Database\Seeder;

class PermissionGroupsSeeder extends Seeder
{
    use Utilities;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroupNames = [
            'Permission Groups', 'Permissions', 'Roles', 'Users',
            'Rentals', 'Invoice Items', 'Houses', 'Tenants', 'Invoices', 'Payments',
            'Audits',
        ];

        $permissionGroups = collect($permissionGroupNames)->map(function ($permissionGroup) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $permissionGroup,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        PermissionGroup::insert($permissionGroups->toArray());
    }
}
