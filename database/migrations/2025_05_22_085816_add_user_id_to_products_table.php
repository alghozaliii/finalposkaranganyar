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
    Schema::table('products', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id')->nullable(); // atau required tergantung kebutuhan
        // Jika ingin relasi ke users:
        // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('user_id');
    });
}

};
