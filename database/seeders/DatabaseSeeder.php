<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's public content. Every seeder is idempotent
     * (updateOrCreate) so it is safe to re-run in any environment.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,
            CaseStudySeeder::class,
            FaqSeeder::class,
            PostSeeder::class,
        ]);
    }
}
