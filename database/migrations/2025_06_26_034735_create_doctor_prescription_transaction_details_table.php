<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorPrescriptionTransactionDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('doctor_prescription_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_prescription_transaction_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->timestamps();

            $table->foreign('doctor_prescription_transaction_id', 'fk_transaction')
                ->references('id')->on('doctor_prescription_transactions')->onDelete('cascade');

            $table->foreign('product_id', 'fk_product')
                ->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctor_prescription_transaction_details');
    }
}
