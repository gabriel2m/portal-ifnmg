<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::exists(['name' => 'dev']))
            User::factory()->create([
                'name' => 'dev',
                'email' => 'gabriel2m.contact@gmail.com'
            ]);
    }
}
