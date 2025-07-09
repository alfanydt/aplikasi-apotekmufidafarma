<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResepDokterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resep_dokter', function (Blueprint $table) {
            $table->id();
            $table->string('no_resep')->unique();
            $table->date('tanggal_resep');
            $table->string('nama_dokter');
            $table->string('rumah_sakit');
            $table->string('nama_pasien');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resep_dokter');
    }
}
