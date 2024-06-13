<?php
namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientAlertsComposer
{
    public function compose(View $view)
    {
        $client = Auth::guard('client')->user();

        // Fetch check-ins sent to the client
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

        // Bind the data to the view
        $view->with('check_ins_sent', $check_ins_sent);
    }
}
