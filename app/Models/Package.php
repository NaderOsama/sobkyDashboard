<?php

namespace App\Models;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
        'hold_limit_days',
    ];

    public function getDurationInMonthsAttribute()
    {
        switch ($this->duration) {
            case '3 Month':
                return 3;
            case '6 Month':
                return 6;
            case '12 Month':
                return 12;
            default:
                return 0;
        }
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
