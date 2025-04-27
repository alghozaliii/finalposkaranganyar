<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('store_name')->nullable();
            $table->text('address')->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('ktp_photo')->nullable();
            $table->string('selfie_photo')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['store_name', 'address', 'nik', 'phone', 'ktp_photo', 'selfie_photo']);
        });
    }
};

