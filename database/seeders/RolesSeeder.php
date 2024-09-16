<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Traits\Utilities;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    use Utilities;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'uuid' => $this->generateUuid(),
            'name' => 'Super User',
        ])->givePermissionTo(Permission::all());

        $landlord = Role::create([
            'uuid' => $this->generateUuid(),
            'name' => 'Landlord',
        ]);

        $landlordPermissions = Permission::query()
            ->where('name', 'like', 'rentals.%')
            ->orWhere('name', 'like', 'invoiceItems.%')
            ->orWhere('name', 'like', 'houses.%')
            ->orWhere('name', 'like', 'tenants.%')
            ->orWhere('name', 'like', 'invoices.%')
            ->orWhere('name', 'like', 'payments.%')
            ->pluck('id')->toArray();

        $landlord->givePermissionTo($landlordPermissions);

        $tenant = Role::create([
            'uuid' => $this->generateUuid(),
            'name' => 'Tenant',
        ]);

        $tenantPermissions = Permission::query()
            ->where('name', 'tenants.show')
            ->orWhere('name', 'tenants.edit')
            ->orWhere('name', 'invoices.index')
            ->orWhere('name', 'invoices.show')
            ->orWhere('name', 'payments.create')
            ->pluck('id')->toArray();

        $tenant->givePermissionTo($tenantPermissions);
    }
}
