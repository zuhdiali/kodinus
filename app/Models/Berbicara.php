<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berbicara extends Model
{
    use HasFactory;

    protected $table = 'berbicara';

    protected $fillable = [
        'nama',
        'file_audio',
    ];

    public $timestamps = true;
}