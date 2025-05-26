<?php
// database/migrations/xxxx_xx_xx_create_profit_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('profit', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->integer('total_quantity');
            $table->decimal('profit_per_product', 15, 2);
            $table->decimal('total_profit', 15, 2);
            $table->decimal('total_sales', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profit');
    }
};