<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('doctor_prescription_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name')->nullable();
            $table->string('doctor_name')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('total_price', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_prescription_transactions');
    }
};
