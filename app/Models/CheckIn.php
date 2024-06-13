<?php

namespace App\Models;

use App\Models\Client;
use App\Models\FormAnswer;
use App\Models\CheckinForm;
use App\Models\CheckInType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckIn extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'request_every_days',
        
    ];

    public function checkinForms()
    {
        return $this->belongsToMany(CheckinForm::class, 'check_in_and_forms', 'check_in_id', 'checkin_form_id');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_check_in', 'check_in_id', 'client_id')
                    ->withTimestamps();
    }

    public function formAnswers()
    {
        return $this->hasMany(FormAnswer::class, 'check_in_id');
    }
}
