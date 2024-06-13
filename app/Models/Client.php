<?php

namespace App\Models;

use App\Models\Coach;
use App\Models\Group;
use App\Models\CheckIn;
use App\Models\FormAnswer;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'mobile',
        'second_mobile',
        'gender',
        'birth_date',
        'diet_restrictions',
        'email',
        'job_title',
        'group_id',
        'coach_id',
        'client_type',
        'referred_by',
        'notes',
        'status',
        'code',
        'user_id' 
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function checkIns()
    {
        return $this->belongsToMany(CheckIn::class, 'client_check_ins')->withTimestamps();
    }

    public function formAnswers()
    {
        return $this->hasMany(FormAnswer::class, 'client_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }


}
