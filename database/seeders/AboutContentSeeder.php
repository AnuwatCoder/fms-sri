<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use App\Models\AboutResponsibility;
use App\Models\Personnel;
use Database\Seeders\Data\PortalContentData;
use Illuminate\Database\Seeder;

class AboutContentSeeder extends Seeder
{
    public function run(): void
    {
        AboutPage::query()->firstOrCreate(['id' => 1], [
            'page_title' => 'เกี่ยวกับหน่วยงาน',
            'meta_description' => 'ข้อมูล ภารกิจ และขอบเขตการดำเนินงานของงานยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ',
            'hero_eyebrow' => 'ABOUT OUR DIVISION',
            'hero_description' => 'ร่วมขับเคลื่อนคณะวิทยาการจัดการด้วยยุทธศาสตร์ ข้อมูล และนวัตกรรมที่สร้างคุณค่า',
            'intro_eyebrow' => 'WHO WE ARE',
            'intro_heading' => "เชื่อมโยงแผนงาน ข้อมูล และเทคโนโลยี\nสู่การบริหารที่มีประสิทธิภาพ",
            'intro_paragraph_1' => 'งานยุทธศาสตร์ บริหารรายได้ และนวัตกรรมสารสนเทศ เป็นหน่วยงานสนับสนุนภารกิจของคณะวิทยาการจัดการ มหาวิทยาลัยสงขลานครินทร์ รับผิดชอบการวางแผนยุทธศาสตร์ การบริหารข้อมูลและรายได้ ตลอดจนการพัฒนาระบบสารสนเทศสำหรับองค์กร',
            'intro_paragraph_2' => 'เรามุ่งสร้างกระบวนการทำงานที่โปร่งใส เชื่อมโยง และใช้ข้อมูลประกอบการตัดสินใจ เพื่อให้ทุกส่วนงานสามารถขับเคลื่อนไปสู่เป้าหมายเดียวกันได้อย่างยั่งยืน',
            'image_path' => 'images/portal/hero-campus.webp',
            'responsibilities_eyebrow' => 'OUR RESPONSIBILITIES',
            'responsibilities_title' => 'ภารกิจหลักของหน่วยงาน',
            'responsibilities_description' => 'สนับสนุนการดำเนินงานของคณะใน 4 มิติสำคัญ',
            'personnel_eyebrow' => 'OUR PEOPLE',
            'personnel_title' => 'บุคลากรของหน่วยงาน',
            'personnel_description' => 'ทีมงานผู้สนับสนุนและขับเคลื่อนภารกิจของหน่วยงานในทุกมิติ',
        ]);

        $responsibilities = [
            ['icon' => 'bi-bullseye', 'title' => 'วางแผนยุทธศาสตร์', 'description' => 'จัดทำแผน ติดตามตัวชี้วัด และประเมินผลการดำเนินงานขององค์กร'],
            ['icon' => 'bi-coin', 'title' => 'บริหารรายได้', 'description' => 'สนับสนุนการบริหารโครงการ รายได้ และการจัดสรรทรัพยากร'],
            ['icon' => 'bi-database-fill', 'title' => 'บริหารข้อมูล', 'description' => 'พัฒนาฐานข้อมูลกลางและสารสนเทศสำหรับการตัดสินใจ'],
            ['icon' => 'bi-display', 'title' => 'นวัตกรรมสารสนเทศ', 'description' => 'พัฒนาระบบดิจิทัลและให้บริการเทคโนโลยีแก่บุคลากร'],
        ];

        foreach ($responsibilities as $index => $item) {
            AboutResponsibility::query()->updateOrCreate(
                ['title' => $item['title']],
                $item + ['is_active' => true, 'sort_order' => $index + 1],
            );
        }

        foreach (PortalContentData::personnel() as $index => $item) {
            Personnel::query()->updateOrCreate(
                ['name_th' => $item['name_th']],
                $item + ['is_head' => $index === 0, 'is_active' => true, 'sort_order' => $index + 1],
            );
        }
    }
}
