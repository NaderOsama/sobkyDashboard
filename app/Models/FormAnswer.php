<?php

namespace App\Models;

use App\Models\Client;
use App\Models\CheckIn;
use App\Models\Question;
use App\Models\CheckinForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['client_check_in_id', 'question_id', 'answer','remaining_days'];

    public function checkinForm()
    {
        return $this->belongsTo(CheckinForm::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function checkIn()
    { 
        return $this->belongsTo(CheckIn::class);
    }
    public function clientCheckIn()
    {
        return $this->belongsTo(ClientCheckIn::class, 'client_check_in_id');
    }
}
