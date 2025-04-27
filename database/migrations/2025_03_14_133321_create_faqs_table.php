<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('category', 50); // Kategori FAQ (misalnya: Produk, Transaksi, dll)
            $table->string('question'); // Pertanyaan FAQ
            $table->text('answer'); // Jawaban FAQ
            $table->timestamps(); // Kolom created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('faqs');
    }
};
