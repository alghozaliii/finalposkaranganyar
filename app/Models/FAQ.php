<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use HasFactory;

    protected $table = 'faqs'; // Nama tabel di database

    protected $fillable = [
        'category', // Kategori pertanyaan
        'question', // Pertanyaan
        'answer',   // Jawaban
    ];
}
