<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            // ลำดับการแสดง (ยิ่งน้อยยิ่งมาก่อน)
            $table->integer('position')
                  ->default(0)
                  ->comment('ลำดับการแสดงข่าว');

            $table->string('title');
            $table->text('content')->nullable();

            $table->string('image')->nullable();

            // วันที่เผยแพร่ (ไม่บังคับ)
            $table->date('publish_date')->nullable();

            // สถานะเปิด / ปิด
            $table->boolean('is_active')
                  ->default(true);

            $table->timestamps();

            /* ===== Index เพื่อประสิทธิภาพ ===== */
            
            $table->index('is_active');
            $table->index('publish_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
