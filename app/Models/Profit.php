<?php
// app/Models/Profit.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    protected $table = 'profit';
    protected $fillable = [
        'product_name',
        'total_quantity',
        'profit_per_product',
        'total_profit',
        'total_sales'
    ];
}