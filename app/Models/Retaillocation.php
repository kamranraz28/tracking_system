<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retaillocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'retail_id',
        'lat',
        'lon'
    ];

    public function retail()
    {
        return $this->belongsTo(Retail::class, 'retail_id');
    }
}
