<?php

namespace App\Http\Controllers\Client;

use App\Models\CheckIn;
use App\Models\FormAnswer;
use Illuminate\Http\Request;
use App\Models\ClientCheckIn;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientFormController extends Controller
{
    public function checkIns()
    {
        // Get the authenticated client
        $client = Auth::guard('client')->user();

        // Execute the raw SQL query
        $check_ins_sent = $client ? DB::select("
        SELECT
                cci.id AS client_check_in_id,
                cci.client_id,
                c.name AS client_name,
                cci.check_in_id,
                ci.name AS check_in_name
            FROM
                client_check_ins cci
            JOIN
                clients c ON cci.client_id = c.id
            JOIN
                check_ins ci ON cci.check_in_id = ci.id
            LEFT JOIN
                form_answers fa ON cci.id = fa.client_check_in_id
            WHERE
                cci.client_id = :client_id
                AND fa.id IS NULL

        ", ['client_id' => $client->id]) : [];

        return view('client_panel.check-ins.index', compact('check_ins_sent'));
    }



    public function viewClientCheckinForm($check_in_id,$client_check_in_id)
    {
        $checkIn = ClientCheckIn::with('formAnswers', 'checkIn.checkinForms.questions')->findOrFail($client_check_in_id);
        return view('client_panel.check-ins.view', compact('checkIn', 'check_in_id','client_check_in_id'));
    }


    public function submitClientAnswers(Request $request, $client_check_in_id)
    {
        $clientCheckIn = ClientCheckIn::findOrFail($client_check_in_id);
        $clientId = auth()->guard('client')->id(); // Assuming the client is authenticated

        // Get the request_every_days value from the CheckIn model
        $requestEveryDays = $clientCheckIn->checkIn->request_every_days;

        foreach ($clientCheckIn->checkIn->checkinForms as $checkinForm) {
            if (isset($request->answers[$checkinForm->id])) {
                foreach ($request->answers[$checkinForm->id] as $questionId => $answer) {
                    FormAnswer::create([
                        'client_check_in_id' => $client_check_in_id,
                        'question_id' => $questionId,
                        'answer' => $answer,
                        'remaining_days' => $requestEveryDays,
                    ]);
                }
            }
        }

        return redirect()->route('client.checkIns')->with('success', 'Answers submitted successfully.');
    }






    public function oldCheckIns()
    {
        // Get the authenticated client
        $client = Auth::guard('client')->user();

        // Execute the raw SQL query
        $check_ins_sent = $client ? DB::select("
            SELECT
                cci.id AS client_check_in_id,
                cci.client_id,
                c.name AS client_name,
                cci.check_in_id,
                ci.name AS check_in_name
            FROM
                client_check_ins cci
            JOIN
                clients c ON cci.client_id = c.id
            JOIN
                check_ins ci ON cci.check_in_id = ci.id
            LEFT JOIN
                form_answers fa ON cci.id = fa.client_check_in_id
            WHERE
                cci.client_id = :client_id
                AND fa.id IS NOT NULL
            GROUP BY
                cci.id, cci.client_id, c.name, cci.check_in_id, ci.name
        ", ['client_id' => $client->id]) : [];

        return view('client_panel.old-check-ins.index', compact('check_ins_sent'));
    }


    public function viewOldClientCheckinForm($check_in_id, $client_check_in_id)
    {
        $checkInDetails = DB::select("
            SELECT
                cci.id AS client_check_in_id,
                cci.client_id,
                c.name AS client_name,
                cci.check_in_id,
                ci.name AS check_in_name,
                fa.id AS form_answer_id,
                fa.client_check_in_id AS form_answer_client_check_in_id,
                fa.question_id AS form_answer_question_id,
                fa.answer AS form_answer_answer,
                q.id AS question_id,
                q.title AS question_title,
                q.description AS question_description,
                q.image AS question_image,
                q.video AS question_video,
                q.answer_type AS question_answer_type,
                q.shown_in AS question_shown_in,
                cf.id AS checkin_form_id,
                cf.name AS checkin_form_name
            FROM
                client_check_ins cci
            JOIN
                clients c ON cci.client_id = c.id
            JOIN
                check_ins ci ON cci.check_in_id = ci.id
            LEFT JOIN
                form_answers fa ON cci.id = fa.client_check_in_id
            LEFT JOIN
                questions q ON fa.question_id = q.id
            LEFT JOIN
                checkin_forms cf ON q.shown_in = cf.name
            WHERE
                cci.id = :client_check_in_id
        ", ['client_check_in_id' => $client_check_in_id]);

        return view('client_panel.old-check-ins.view', compact('checkInDetails', 'check_in_id', 'client_check_in_id'));
    }

}
