<?php

namespace Database\Seeders\Data;

class ContactSettingData
{
    /** @return array<string, string> */
    public static function defaults(): array
    {
        return [
            'heading' => 'ช่องทางติดต่อหน่วยงาน',
            'description' => 'ติดต่อเราได้ในวันและเวลาราชการ ทีมงานจะดำเนินการประสานงานและตอบกลับโดยเร็วที่สุด',
            'address' => "คณะวิทยาการจัดการ มหาวิทยาลัยสงขลานครินทร์\n15 ถนนกาญจนวนิช ต.คอหงส์ อ.หาดใหญ่ จ.สงขลา 90110",
            'phone' => '0 7428 7900',
            'email' => 'fms@psu.ac.th',
            'office_hours' => 'จันทร์ - ศุกร์ เวลา 08:30 - 16:30 น.',
            'office_hours_note' => 'หยุดวันเสาร์ อาทิตย์ และวันหยุดนักขัตฤกษ์',
        ];
    }
}
