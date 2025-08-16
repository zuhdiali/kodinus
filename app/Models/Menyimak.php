<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menyimak extends Model
{
    use HasFactory;

    protected $table = 'menyimak';

    protected $fillable = [
        'nama',
        'soal_1',
        'soal_2',
    ];

    public $timestamps = true;
}