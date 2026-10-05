<?php

namespace Database\Seeders;

use App\Models\SeoSetting;
use Illuminate\Database\Seeder;

class SeoSettingSeeder extends Seeder
{
    public function run(): void
    {
        SeoSetting::query()->firstOrCreate(['id' => 1], [
            'site_name' => 'FMS Portal',
            'default_title' => 'งานยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ',
            'default_description' => 'ศูนย์รวมระบบสารสนเทศ ข่าวสาร เอกสาร และบริการของงานยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ คณะวิทยาการจัดการ มหาวิทยาลัยสงขลานครินทร์',
            'keywords' => 'คณะวิทยาการจัดการ, มหาวิทยาลัยสงขลานครินทร์, แผนยุทธศาสตร์, บริหารรายได้, ระบบสารสนเทศ',
            'author' => 'คณะวิทยาการจัดการ มหาวิทยาลัยสงขลานครินทร์',
            'og_image_path' => 'images/psu-fms-logo-th.png',
            'robots_index' => true,
            'robots_follow' => true,
        ]);
    }
}
