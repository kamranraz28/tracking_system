<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobilesetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'main_color',
        'cart_color',
        'button_color',
        'text_color',
    ];
}
