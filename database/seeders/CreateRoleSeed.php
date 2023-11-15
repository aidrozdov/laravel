<?php

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CreateRoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /** @var Role $roleAdmin */
        $roleAdmin = Role::create(['name' => Roles::ROLE_ADMIN->value]);
        $roleSuperAdmin = Role::create(['name' => Roles::ROLE_SUPER_ADMIN->value]);
        /** @var Role $roleManager */
        $roleManager = Role::create(['name' => Roles::ROLE_MANAGER->value]);
        /** @var Role $roleUser */
        $roleUser = Role::create(['name' => Roles::ROLE_USER->value]);

        // create permissions
        Permission::create(['name' => Permissions::COMPANY_CREATE->value]);
        Permission::create(['name' => Permissions::COMPANY_EDIT->value]);
        Permission::create(['name' => Permissions::COMPANY_VIEW->value]);
        Permission::create(['name' => Permissions::COMPANY_CHANGE_TARIFF->value]);

        Permission::create(['name' => Permissions::USER_CREATE->value]);
        Permission::create(['name' => Permissions::USER_VIEW->value]);
        Permission::create(['name' => Permissions::USER_EDIT->value]);
        Permission::create(['name' => Permissions::USER_DELETE->value]);
        Permission::create(['name' => Permissions::USER_PERMISSIONS->value]);
        Permission::create(['name' => Permissions::USER_CHANGE_PASSWORD->value]);

        $roleAdmin->syncPermissions([
            Permissions::COMPANY_CREATE->value,
            Permissions::COMPANY_EDIT->value,
            Permissions::COMPANY_VIEW->value,
            Permissions::COMPANY_CHANGE_TARIFF->value,
            Permissions::USER_CREATE->value,
            Permissions::USER_EDIT->value,
            Permissions::USER_DELETE->value,
            Permissions::USER_PERMISSIONS->value,
            Permissions::USER_VIEW->value,
            Permissions::USER_CHANGE_PASSWORD->value
        ]);
        $roleManager->syncPermissions([
            Permissions::COMPANY_CREATE->value,
            Permissions::COMPANY_EDIT->value,
            Permissions::COMPANY_VIEW->value,
            Permissions::USER_VIEW->value,
        ]);
        $roleUser->syncPermissions([
            Permissions::USER_VIEW->value,
            Permissions::USER_CHANGE_PASSWORD->value,
        ]);

        $roleSuperAdmin->givePermissionTo(Permission::all());
    }
}
