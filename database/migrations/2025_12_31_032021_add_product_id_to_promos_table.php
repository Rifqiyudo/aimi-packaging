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
    Schema::table('promos', function (Blueprint $table) {
        // Kolom product_id boleh NULL. 
        // Jika NULL = Berlaku untuk Semua Produk.
        // Jika Terisi = Berlaku hanya untuk produk itu.
        $table->foreignId('product_id')->nullable()->after('code')->constrained('products')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('promos', function (Blueprint $table) {
        $table->dropForeign(['product_id']);
        $table->dropColumn('product_id');
    });
}
};
