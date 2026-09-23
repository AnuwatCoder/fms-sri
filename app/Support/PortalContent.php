<?php

namespace App\Support;

class PortalContent
{
    /** @return array<int, array<string, mixed>> */
    public static function applications(): array
    {
        return [
            ['name_th' => 'ระบบแผนยุทธศาสตร์', 'name_en' => 'Strategic Planning System', 'description' => 'จัดทำ ติดตาม และรายงานแผนยุทธศาสตร์และแผนปฏิบัติการ', 'icon' => 'bi-bar-chart-fill', 'color' => 'blue', 'url' => '#', 'favorite' => true, 'category' => 'แผนยุทธศาสตร์', 'group' => 'plan'],
            ['name_th' => 'ระบบบริหารรายได้', 'name_en' => 'Revenue Management', 'description' => 'บริหารจัดการรายได้ โครงการ และการจัดสรรงบประมาณ', 'icon' => 'bi-coin', 'color' => 'green', 'url' => '#', 'favorite' => true, 'category' => 'บริหารรายได้', 'group' => 'revenue'],
            ['name_th' => 'ระบบบริหารโครงการ', 'name_en' => 'Project Management', 'description' => 'ติดตามความก้าวหน้าโครงการและผลการดำเนินงาน', 'icon' => 'bi-kanban-fill', 'color' => 'purple', 'url' => '#', 'favorite' => false, 'category' => 'บริหารโครงการ', 'group' => 'plan'],
            ['name_th' => 'ระบบรายงานผู้บริหาร', 'name_en' => 'Executive Dashboard', 'description' => 'สรุปข้อมูลเชิงบริหารสำหรับผู้บริหารและหน่วยงานที่เกี่ยวข้อง', 'icon' => 'bi-graph-up-arrow', 'color' => 'pink', 'url' => '#', 'favorite' => false, 'category' => 'รายงาน', 'group' => 'data'],
            ['name_th' => 'ระบบฐานข้อมูลกลาง', 'name_en' => 'Data Management', 'description' => 'บริหารจัดการข้อมูลกลางของหน่วยงานอย่างเป็นระบบ', 'icon' => 'bi-database-fill', 'color' => 'cyan', 'url' => '#', 'favorite' => false, 'category' => 'ข้อมูล', 'group' => 'data'],
            ['name_th' => 'ระบบขอใช้บริการ IT', 'name_en' => 'IT Service Request', 'description' => 'แจ้งปัญหา ขอรับบริการ และติดตามสถานะคำขอ', 'icon' => 'bi-file-earmark-text-fill', 'color' => 'orange', 'url' => '#', 'favorite' => true, 'category' => 'บริการ IT', 'group' => 'service'],
            ['name_th' => 'ระบบจัดการองค์ความรู้', 'name_en' => 'Knowledge Management', 'description' => 'รวบรวมเอกสาร ความรู้ และแนวปฏิบัติที่ดี', 'icon' => 'bi-lightbulb-fill', 'color' => 'violet', 'url' => '#', 'favorite' => false, 'category' => 'องค์ความรู้', 'group' => 'data'],
            ['name_th' => 'ระบบบริหารบุคลากร', 'name_en' => 'HR Management', 'description' => 'ข้อมูลบุคลากร ภาระงาน และการพัฒนาศักยภาพ', 'icon' => 'bi-people-fill', 'color' => 'teal', 'url' => '#', 'favorite' => false, 'category' => 'บุคลากร', 'group' => 'service'],
        ];
    }

    /** @return array<int, array<string, string>> */
    public static function news(): array
    {
        return [
            ['date' => '20 ก.ย. 2569', 'title' => 'ประกาศแผนยุทธศาสตร์คณะวิทยาการจัดการ ประจำปีงบประมาณ 2570', 'description' => 'เผยแพร่กรอบทิศทางและเป้าหมายสำคัญในการขับเคลื่อนองค์กร เพื่อให้ทุกส่วนงานนำไปใช้วางแผนและติดตามผลการดำเนินงานร่วมกัน', 'image' => 'images/portal/news-strategy.webp', 'url' => '#', 'category' => 'ประกาศ'],
            ['date' => '15 ก.ย. 2569', 'title' => 'เปิดใช้งานระบบรายงานผู้บริหาร Version 2.0', 'description' => 'ยกระดับการติดตามผลด้วยมุมมองข้อมูลที่ชัดเจน รวดเร็ว และรองรับการตัดสินใจเชิงบริหารได้ดียิ่งขึ้น', 'image' => 'images/portal/news-dashboard.webp', 'url' => '#', 'category' => 'ระบบสารสนเทศ'],
            ['date' => '10 ก.ย. 2569', 'title' => 'เชิญอบรมการใช้งานระบบบริหารรายได้สำหรับเจ้าหน้าที่', 'description' => 'เรียนรู้ขั้นตอนการใช้งาน การจัดการข้อมูลโครงการ และแนวทางบริหารรายได้อย่างมีประสิทธิภาพ', 'image' => 'images/portal/news-training.webp', 'url' => '#', 'category' => 'อบรม'],
        ];
    }

    /** @return array<int, array<string, string>> */
    public static function events(): array
    {
        return [
            ['day' => '25', 'month' => 'ก.ย.', 'date' => '2026-09-25', 'title' => 'ประชุมติดตามแผนยุทธศาสตร์', 'time' => '09:30 - 12:00 น.', 'place' => 'ห้องประชุม 1', 'color' => 'blue'],
            ['day' => '28', 'month' => 'ก.ย.', 'date' => '2026-09-28', 'title' => 'นำเสนอผลการดำเนินงานรายไตรมาส', 'time' => '13:30 - 16:00 น.', 'place' => 'ออนไลน์ (Zoom)', 'color' => 'pink'],
            ['day' => '2', 'month' => 'ต.ค.', 'date' => '2026-10-02', 'title' => 'อบรมการใช้งานระบบบริหารรายได้', 'time' => '09:00 - 12:00 น.', 'place' => 'ห้องคอมพิวเตอร์', 'color' => 'green'],
        ];
    }

    /** @return array<int, array<string, string>> */
    public static function documents(): array
    {
        return [
            ['name' => 'คู่มือการใช้งานระบบสารสนเทศ', 'type' => 'PDF', 'icon' => 'bi-file-earmark-pdf', 'color' => 'red', 'category' => 'คู่มือ', 'description' => 'คู่มือเริ่มต้นใช้งานและแนวทางแก้ไขปัญหาเบื้องต้น', 'updated_at' => '18 ก.ย. 2569', 'size' => '4.2 MB', 'url' => '#'],
            ['name' => 'แบบฟอร์มขอรับบริการ IT', 'type' => 'DOCX', 'icon' => 'bi-file-earmark-word', 'color' => 'blue', 'category' => 'แบบฟอร์ม', 'description' => 'แบบฟอร์มสำหรับแจ้งปัญหาและขอรับบริการด้านเทคโนโลยีสารสนเทศ', 'updated_at' => '12 ก.ย. 2569', 'size' => '86 KB', 'url' => '#'],
            ['name' => 'แนวปฏิบัติการบริหารรายได้', 'type' => 'PDF', 'icon' => 'bi-file-earmark-pdf', 'color' => 'pink', 'category' => 'แนวปฏิบัติ', 'description' => 'หลักเกณฑ์และขั้นตอนการดำเนินงานด้านการบริหารรายได้', 'updated_at' => '5 ก.ย. 2569', 'size' => '2.8 MB', 'url' => '#'],
            ['name' => 'นโยบายและแนวทางการดำเนินงาน', 'type' => 'PDF', 'icon' => 'bi-file-earmark-text', 'color' => 'purple', 'category' => 'นโยบาย', 'description' => 'นโยบายสำคัญและกรอบการดำเนินงานของหน่วยงาน', 'updated_at' => '1 ก.ย. 2569', 'size' => '3.5 MB', 'url' => '#'],
        ];
    }

    /** @return array<int, array<string, string>> */
    public static function personnel(): array
    {
        return [
            ['name_th' => 'ดร.กมลชนก ศรีสุข', 'name_en' => 'Kamonchanok Srisuk', 'position_th' => 'หัวหน้างาน', 'position_en' => 'Head of Division', 'unit' => 'บริหารและกำกับดูแลภาพรวม', 'initials' => 'KS', 'color' => 'navy'],
            ['name_th' => 'นางสาวพิมพ์พิศา วัฒนกุล', 'name_en' => 'Pimpisa Wattanakul', 'position_th' => 'นักวิชาการอุดมศึกษา', 'position_en' => 'Higher Education Officer', 'unit' => 'แผนยุทธศาสตร์และประกันคุณภาพ', 'initials' => 'PW', 'color' => 'blue'],
            ['name_th' => 'นายณัฐพงศ์ แซ่ลิ้ม', 'name_en' => 'Nattapong Saelim', 'position_th' => 'นักวิชาการเงินและบัญชี', 'position_en' => 'Finance and Accounting Officer', 'unit' => 'บริหารรายได้และโครงการ', 'initials' => 'NS', 'color' => 'green'],
            ['name_th' => 'Anuwat Pattanachian', 'name_en' => 'Anuwat Pattanachian', 'position_th' => 'นักวิชาการคอมพิวเตอร์', 'position_en' => 'Computer Technical Officer', 'unit' => 'นวัตกรรมและระบบสารสนเทศ', 'initials' => 'AP', 'color' => 'purple'],
        ];
    }
}
