<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_data_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_rekening_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('target', 15, 2);
            $table->date('validity_period_start');
            $table->date('validity_period_end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_data_targets');
    }
};

