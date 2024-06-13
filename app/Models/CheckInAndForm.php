<?php

namespace App\Models;

use App\Models\CheckIn;
use App\Models\CheckinForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckInAndForm extends Model
{
    use HasFactory;
    protected $table = 'check_in_and_forms';

    public function checkIn()
    {
        return $this->belongsTo(CheckIn::class, 'check_in_id');
    }

    public function checkinForm()
    {
        return $this->belongsTo(CheckinForm::class, 'checkin_form_id');
    }
}
