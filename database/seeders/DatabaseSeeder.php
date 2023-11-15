<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $user = \App\Models\User::factory()->create([
            'name' => fake()->name,
            'email' => fake()->email,
            'password' => Hash::make('password'),
        ]);


        $company = Company::factory()->create(['user_id' => $user->id]);

        $company->users()->attach($user);

        $this->call([
            CreateRoleSeed::class,
        ]);

        $user->syncRoles(['admin']);
    }
}
