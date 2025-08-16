<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menulis extends Model
{
    use HasFactory;

    protected $table = 'menulis';

    protected $fillable = [
        'nama',
        'soal_1',
    ];

    public $timestamps = true;
}