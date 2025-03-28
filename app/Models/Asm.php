<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rsm_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rsm()
    {
        return $this->belongsTo(User::class, 'rsm_id');
    }

}
