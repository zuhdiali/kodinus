<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membaca extends Model
{
    use HasFactory;

    protected $table = 'membaca';

    protected $fillable = [
        'nama',
        'soal_1',
        'soal_2',
        'soal_3',
        'soal_4',
        'soal_5',
        'soal_6'
    ];

    public $timestamps = true;
}