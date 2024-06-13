<?php

namespace App\Models;

use App\Models\CheckIn;
use App\Models\Question;
use App\Models\FormAnswer;
use App\Models\CheckInType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckinForm extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'checkin_type_id'];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'checkin_form_question');
    }

    public function checkinType()
    {
        return $this->belongsTo(CheckInType::class, 'checkin_type_id');
    }

    public function checkins()
    {
        return $this->belongsToMany(CheckIn::class, 'check_in_and_forms', 'checkin_form_id', 'check_in_id');
    }

    public function formAnswers()
    {
        return $this->hasMany(FormAnswer::class, 'checkin_form_id');
    }
 }
