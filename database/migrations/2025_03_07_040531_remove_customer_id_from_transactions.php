<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Hapus foreign key constraint dulu
            $table->dropForeign(['customer_id']);

            // Hapus kolom customer_id setelah foreign key dihapus
            $table->dropColumn('customer_id');
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->constrained('customers')->cascadeOnDelete();
        });
    }
};
