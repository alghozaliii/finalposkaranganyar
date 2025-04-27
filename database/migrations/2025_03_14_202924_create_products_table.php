<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code'); //code barang
            $table->string('name');           // Nama produk
            $table->integer('stock');         // Jumlah stok
            $table->decimal('average_price', 10, 2); // Harga rata-rata
            $table->decimal('markup', 5, 2);  // Markup dalam persen
            $table->decimal('selling_price', 10, 2); // Harga jual
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

