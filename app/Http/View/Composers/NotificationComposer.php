<?php

namespace App\Http\View\Composers;

use App\Models\Client;
use Illuminate\View\View;
use App\Models\ClientCheckIn;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    public function compose(View $view)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Base query for clients and related data
            $clientsQuery = Client::with(['subscriptions.package', 'group']);

            if ($user->role === 'coach') {
                // If user is a coach, fetch only the clients assigned to this coach
                $clientsQuery->where('user_id', $user->id);
            }

            // Fetch client check-ins with submitted answers
            $submittedAnswers = ClientCheckIn::with(['client', 'checkIn', 'formAnswers'])
                ->whereIn('client_id', $clientsQuery->pluck('id')) // Filter by clientsQuery
                ->whereHas('formAnswers', function ($query) {
                    $query->whereNotNull('answer');
                })
                ->latest('updated_at')
                ->take(5)
                ->get();

            // Count unviewed notifications
            $unviewedNotificationCount = ClientCheckIn::whereIn('client_id', $clientsQuery->pluck('id')) // Filter by clientsQuery
                ->whereHas('formAnswers', function ($query) {
                    $query->whereNotNull('answer');
                })
                ->where('notification_viewed', false)
                ->count();

            // Share the data with the view
            $view->with('submittedAnswers', $submittedAnswers);
            $view->with('unviewedNotificationCount', $unviewedNotificationCount);
        }
    }
}
