<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(MasterDataSeeder::class);
        $this->call(UserAwalSeeder::class);
        $this->call(KelasPresensiSeeder::class);
        $this->call(QuizSeeder::class);
        $this->call(ModulSeeder::class);
        $this->call(AchievementSeeder::class);
    }
}
