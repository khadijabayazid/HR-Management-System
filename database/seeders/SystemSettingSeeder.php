<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::insert([
        [
            'setting_key' => 'work_start_time',
            'setting_value' => '09:00',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'setting_key' => 'work_end_time',
            'setting_value' => '17:00',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'setting_key' => 'late_threshold_minutes',
            'setting_value' => '15',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
    }
}
