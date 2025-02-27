<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'sr_id',
        'retail_id',
        'schedule_id',
        'time',
        'lat',
        'lon',
        'image',
    ];

    public function sr()
    {
        return $this->belongsTo(Sr::class, 'sr_id');
    }
    public function retail()
    {
        return $this->belongsTo(Retail::class, 'retail_id');
    }
    public function schedule()
    {
        return $this->belongsTo(Srschedule::class, 'schedule_id');
    }
}
