<?php

namespace App\Models;

use App\Models\FormAnswer;
use App\Models\RemainingDay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientCheckIn extends Model
{
    use HasFactory;

    protected $table = 'client_check_ins';
        protected $guarded = [];


    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function checkIn()
    {
        return $this->belongsTo(CheckIn::class, 'check_in_id');
    }

    public function checkInAndForms()
    {
        return $this->belongsTo(CheckInAndForm::class, 'check_in_id');
    }

    public function formAnswers()
    {
        return $this->hasMany(FormAnswer::class, 'client_check_in_id');
    }


}
