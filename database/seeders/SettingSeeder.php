<?php

namespace Database\Seeders;

use App\Models\SupportTicket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SupportTicket::factory(5)->create();
    }
}
