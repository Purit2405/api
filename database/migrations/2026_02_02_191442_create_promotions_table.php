<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('type', ['reward', 'redeem']);
            $table->integer('points_value');

            // 🔥 ระบบจำกัดสิทธิ์
            $table->integer('max_total')->nullable();     // ทั้งระบบ
            $table->integer('max_per_user')->nullable();  // ต่อคน

            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
