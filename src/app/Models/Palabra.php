<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Palabra extends Model
{
    /**
     * Los atributos que se pueden asignar masivamente.
     * 
     * @var array<string>
     */
    protected $fillable = [
        'palabra',
    ];
}
