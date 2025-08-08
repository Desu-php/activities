<?php

namespace Database\Seeders;

use App\Models\Activity\Activity;
use App\Models\Activity\ActivityType;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        User::factory()->count(10)->create();

        ActivityType::factory()->count(10)->create();

        Activity::factory()->count(500)->create();
    }
}
