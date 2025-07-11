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
    Schema::table('doctor_prescription_transactions', function (Blueprint $table) {
        $table->string('hospital_name')->nullable();
        $table->unsignedBigInteger('user_id')->nullable();

        $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('doctor_prescription_transactions', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn(['hospital_name', 'transaction_date', 'user_id']);
    });
}

};
