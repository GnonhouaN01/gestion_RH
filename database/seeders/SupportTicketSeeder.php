<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupportTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::factory()->create(['key' => 'theme', 'value' => 'light']);
        Setting::factory()->create(['key' => 'language', 'value' => 'en']);
    }
}
