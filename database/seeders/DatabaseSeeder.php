<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Website;
use App\Models\Category;
use App\Models\Vote;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        User::factory()->count(10)->create();
        $this->call(RoleSeeder::class);

        Category::factory()->count(5)->create();

        Website::factory()
            ->count(20)
            ->create()
            ->each(function ($website) {
                $website->categories()->attach(Category::all()->random(rand(1, 3))->pluck('id')->toArray());
            });

        Vote::factory()->count(50)->create();
      
    }
}