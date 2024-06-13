<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientCheckIn;

class AlertController extends Controller
{
    public function index()
    {
        $submittedAnswers = ClientCheckIn::with(['client', 'checkIn'])
            ->whereHas('formAnswers', function ($query) {
                $query->whereNotNull('answer');
            })
            ->orderByDesc('updated_at')
            ->paginate(10); // You can adjust the pagination as per your requirement

        return view('alerts.index', compact('submittedAnswers'));
    }
}
