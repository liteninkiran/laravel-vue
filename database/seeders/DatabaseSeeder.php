<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use App\Models\Country;
// use App\Models\State;
// use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            StateSeeder::class,
            UserSeeder::class,
        ]);
    }
}
