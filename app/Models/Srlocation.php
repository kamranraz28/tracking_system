<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Srlocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'sr_id',
        'lat',
        'lon',
    ];
    public function sr()
    {
        return $this->belongsTo(Sr::class, 'sr_id');
    }
}
