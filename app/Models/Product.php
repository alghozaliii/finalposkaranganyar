<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'stock',
        'average_price',
        'selling_price',
        'category',
        'unit',
        'user_id', // Added user_id to fillable array
         'profit',
         'status', // Add this if not exists
    ];

    protected $attributes = [
        'status' => 'active' // Default status
    ];

    /**
     * Get the owner that owns the product.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // Add status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
}