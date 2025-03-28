<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tsm_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function tsm()
    {
        return $this->belongsTo(Tsm::class, 'tsm_id');
    }

    public function sr()
    {
        return $this->hasMany(Sr::class, 'dealer_id');
    }
}
