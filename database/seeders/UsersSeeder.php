<?php

namespace Database\Seeders;

use App\Models\User;
use App\Traits\Utilities;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    use Utilities;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Super User
        User::create([
            'uuid' => $this->generateUuid(),
            'name' => config('users.superUser.name'),
            'email' => config('users.superUser.email'),
            'email_verified_at' => now(),
            'password' => Hash::make(config('users.superUser.password')),
        ])->assignRole('Super User');

        // Landlord
        User::create([
            'uuid' => $this->generateUuid(),
            'name' => config('users.landlord.name'),
            'email' => config('users.landlord.email'),
            'email_verified_at' => now(),
            'password' => Hash::make(config('users.landlord.password')),
        ])->assignRole('Landlord');
    }
}
