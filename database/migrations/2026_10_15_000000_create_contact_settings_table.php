<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->text('description')->nullable();
            $table->text('address');
            $table->string('phone', 50);
            $table->string('email');
            $table->string('office_hours');
            $table->string('office_hours_note', 500)->nullable();
            $table->timestamps();
        });

        DB::table('contact_settings')->insert([
            'heading' => 'ช่องทางติดต่อหน่วยงาน',
            'description' => 'ติดต่อเราได้ในวันและเวลาราชการ ทีมงานจะดำเนินการประสานงานและตอบกลับโดยเร็วที่สุด',
            'address' => "คณะวิทยาการจัดการ มหาวิทยาลัยสงขลานครินทร์\n15 ถนนกาญจนวนิช ต.คอหงส์ อ.หาดใหญ่ จ.สงขลา 90110",
            'phone' => '0 7428 7900',
            'email' => 'fms@psu.ac.th',
            'office_hours' => 'จันทร์ - ศุกร์ เวลา 08:30 - 16:30 น.',
            'office_hours_note' => 'หยุดวันเสาร์ อาทิตย์ และวันหยุดนักขัตฤกษ์',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_settings');
    }
};
