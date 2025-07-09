<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('doctor_prescription_transactions', function (Blueprint $table) {
        $table->date('transaction_date')->after('patient_name');
    });
}

public function down()
{
    Schema::table('doctor_prescription_transactions', function (Blueprint $table) {
        $table->dropColumn('transaction_date');
    });
}
};
