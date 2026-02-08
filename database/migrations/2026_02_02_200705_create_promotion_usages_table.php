<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('promotion_usages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('promotion_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // ❌ ห้าม unique
            // max_per_user คุมด้วย logic

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_usages');
    }
};
