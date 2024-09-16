<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Traits\Utilities;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    use Utilities;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /**
         * Get the permission groups from the database.
         */
        $permissionGroups = [
            'permissionGroups' => PermissionGroup::where('name', 'Permission Groups')->firstOrFail(),
            'permissions' => PermissionGroup::where('name', 'Permissions')->firstOrFail(),
            'roles' => PermissionGroup::where('name', 'Roles')->firstOrFail(),
            'users' => PermissionGroup::where('name', 'Users')->firstOrFail(),
            'rentals' => PermissionGroup::where('name', 'Rentals')->firstOrFail(),
            'invoiceItems' => PermissionGroup::where('name', 'Invoice Items')->firstOrFail(),
            'houses' => PermissionGroup::where('name', 'Houses')->firstOrFail(),
            'tenants' => PermissionGroup::where('name', 'Tenants')->firstOrFail(),
            'invoices' => PermissionGroup::where('name', 'Invoices')->firstOrFail(),
            'payments' => PermissionGroup::where('name', 'Payments')->firstOrFail(),
            'audits' => PermissionGroup::where('name', 'Audits')->firstOrFail(),
        ];

        /**
         * Generate permission group's permissions.
         */
        $permissionGroupsPermissionNames = [
            'permissionGroups.index', 'permissionGroups.create', 'permissionGroups.show',
            'permissionGroups.edit', 'permissionGroups.delete',
        ];

        $permissionGroupsPermissions = collect($permissionGroupsPermissionNames)->map(function ($permissionGroupsPermissionName) use ($permissionGroups) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $permissionGroupsPermissionName,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroups['permissionGroups']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        /**
         * Generate permission's permissions.
         */
        $permissionsPermissionNames = [
            'permissions.index', 'permissions.create', 'permissions.show',
            'permissions.edit', 'permissions.delete',
        ];

        $permissionsPermissions = collect($permissionsPermissionNames)->map(function ($permissionsPermissionName) use ($permissionGroups) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $permissionsPermissionName,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroups['permissions']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        /**
         * Generate roles's permissions.
         */
        $rolesPermissionNames = [
            'roles.index', 'roles.create', 'roles.show',
            'roles.edit', 'roles.delete',
        ];

        $rolesPermissions = collect($rolesPermissionNames)->map(function ($rolesPermissionName) use ($permissionGroups) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $rolesPermissionName,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroups['roles']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        /**
         * Generate users's permissions.
         */
        $usersPermissionNames = [
            'users.index', 'users.create', 'users.show',
            'users.edit', 'users.delete',
        ];

        $usersPermissions = collect($usersPermissionNames)->map(function ($usersPermissionName) use ($permissionGroups) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $usersPermissionName,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroups['users']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        /**
         * Generate rentals's permissions.
         */
        $rentalsPermissionNames = [
            'rentals.index', 'rentals.create', 'rentals.show',
            'rentals.edit', 'rentals.delete',
        ];

        $rentalsPermissions = collect($rentalsPermissionNames)->map(function ($rentalsPermissionName) use ($permissionGroups) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $rentalsPermissionName,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroups['rentals']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        /**
         * Generate invoice items's permissions.
         */
        $invoiceItemsPermissionNames = [
            'invoiceItems.index', 'invoiceItems.create', 'invoiceItems.show',
            'invoiceItems.edit', 'invoiceItems.delete',
        ];

        $invoiceItemsPermissions = collect($invoiceItemsPermissionNames)->map(function ($invoiceItemsPermissionName) use ($permissionGroups) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $invoiceItemsPermissionName,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroups['invoiceItems']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        /**
         * Generate houses's permissions.
         */
        $housesPermissionNames = [
            'houses.index', 'houses.create', 'houses.show',
            'houses.edit', 'houses.delete', 'houses.vacate',
        ];

        $housesPermissions = collect($housesPermissionNames)->map(function ($housesPermissionName) use ($permissionGroups) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $housesPermissionName,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroups['houses']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        /**
         * Generate tenants's permissions.
         */
        $tenantsPermissionNames = [
            'tenants.index', 'tenants.create', 'tenants.show',
            'tenants.edit', 'tenants.delete',
        ];

        $tenantsPermissions = collect($tenantsPermissionNames)->map(function ($tenantsPermissionName) use ($permissionGroups) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $tenantsPermissionName,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroups['tenants']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        /**
         * Generate invoices's permissions.
         */
        $invoicesPermissionNames = [
            'invoices.index', 'invoices.create', 'invoices.show',
            'invoices.edit', 'invoices.delete',
        ];

        $invoicesPermissions = collect($invoicesPermissionNames)->map(function ($invoicesPermissionName) use ($permissionGroups) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $invoicesPermissionName,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroups['invoices']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        /**
         * Generate payments's permissions.
         */
        $paymentsPermissionNames = [
            'payments.index', 'payments.create', 'payments.show',
            'payments.edit', 'payments.delete',
        ];

        $paymentsPermissions = collect($paymentsPermissionNames)->map(function ($paymentsPermissionName) use ($permissionGroups) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $paymentsPermissionName,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroups['payments']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        /**
         * Generate audits's permissions.
         */
        $auditsPermissionNames = ['audits.index'];

        $auditsPermissions = collect($auditsPermissionNames)->map(function ($auditsPermissionName) use ($permissionGroups) {
            return [
                'uuid' => $this->generateUuid(),
                'name' => $auditsPermissionName,
                'guard_name' => 'web',
                'permission_group_id' => $permissionGroups['audits']->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        // Merge all generated permissions for insert.
        $mergedPermissions = array_merge(
            $permissionGroupsPermissions, $permissionsPermissions, $rolesPermissions,
            $usersPermissions, $rentalsPermissions, $invoiceItemsPermissions, $housesPermissions,
            $tenantsPermissions, $invoicesPermissions, $paymentsPermissions,
            $auditsPermissions
        );

        // Perform a bulk insert.
        Permission::insert($mergedPermissions);
    }
}
