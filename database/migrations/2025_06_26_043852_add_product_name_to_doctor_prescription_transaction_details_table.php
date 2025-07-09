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
    Schema::table('doctor_prescription_transaction_details', function (Blueprint $table) {
        $table->string('product_name')->nullable()->after('doctor_prescription_transaction_id');
    });
}

public function down()
{
    Schema::table('doctor_prescription_transaction_details', function (Blueprint $table) {
        $table->dropColumn('product_name');
    });
}

};
