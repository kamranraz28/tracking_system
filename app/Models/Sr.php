<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sr extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'dealer_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function dealer()
    {
        return $this->belongsTo(Dealer::class, 'dealer_id');
    }
    public function schedules()
    {
        return $this->hasMany(Srschedule::class, 'sr_id');
    }
    public function location()
    {
        return $this->hasMany(Srlocation::class, 'sr_id');
    }
}
