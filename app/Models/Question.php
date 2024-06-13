<?php

namespace App\Models;

use App\Models\FormAnswer;
use App\Models\CheckinForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['fixed_name', 'title', 'description', 'image', 'video', 'answer_type', 'shown_in'];

    public function checkinForms()
    {
        return $this->belongsToMany(CheckinForm::class, 'checkin_form_question');
    }
    public function answers()
    {
        return $this->hasMany(FormAnswer::class);
    }

}
