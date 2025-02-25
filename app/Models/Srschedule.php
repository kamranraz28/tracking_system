<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Srschedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'sr_id',
        'retail_id',
        'visit_datetime',
    ];

    public function sr()
    {
        return $this->belongsTo(Sr::class, 'sr_id');
    }
    public function retail()
    {
        return $this->belongsTo(Retail::class, 'retail_id');
    }

}
