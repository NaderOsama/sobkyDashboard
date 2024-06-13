<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Client;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\ClientCheckIn;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Base query for clients and related data
        $clientsQuery = Client::with(['subscriptions.package', 'group']);
        $packages = Package::all();
        $users = User::all();

        if ($user->role === 'coach') {
            // If user is a coach, fetch only the clients assigned to this coach
            $clientsQuery->where('user_id', $user->id);
        }

        // Get the clients and related data
        $clients = $clientsQuery->get();
        $clientsandsubscriptionsandpackages = $clientsQuery->get();

        $clientCount = $clients->count();
        $coachesCount = $users->where('role', 'coach')->count();
        $packagesCount = $packages->count();

        // Calculate client statuses
        $subscribeCount = $clients->where('status', 'subscribed')->count();
        $onHoldCount = $clients->where('status', 'paused')->count();
        $expiredCount = $clients->where('status', 'expired')->count();
        $noSubscriptionCount = $clients->where('status', 'not subscribed')->count();
        $totalCount = $clients->count();

        // Calculate percentages
        $subscribePercentage = $totalCount ? ($subscribeCount / $totalCount) * 100 : 0;
        $onHoldPercentage = $totalCount ? ($onHoldCount / $totalCount) * 100 : 0;
        $expiredPercentage = $totalCount ? ($expiredCount / $totalCount) * 100 : 0;
        $noSubscriptionPercentage = $totalCount ? ($noSubscriptionCount / $totalCount) * 100 : 0;

        // Fetch client check-ins with their relationships
        $clientCheckIns = ClientCheckIn::with(['checkIn', 'client.subscriptions.package', 'client.group', 'formAnswers'])
            ->whereIn('client_id', $clients->pluck('id'))
            ->whereHas('formAnswers', function ($query) {
                $query->whereNotNull('remaining_days');
            })
            ->distinct('client_check_in_id')
            ->get();

        // Count of distinct client_check_in_id (using primary key 'id')
        $clientCheckInCount = ClientCheckIn::whereIn('client_id', $clients->pluck('id'))
            ->whereHas('formAnswers', function ($query) {
                $query->whereNotNull('remaining_days');
            })
            ->distinct('id')
            ->count('id');

        // Fetch upcoming birthdays based on month and day
        $currentDate = Carbon::now();
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        $upcomingBirthdays = $clientsQuery->where(function ($query) use ($currentDate, $startOfMonth, $endOfMonth) {
                $query->whereMonth('birth_date', '=', $currentDate->month)
                    ->whereDay('birth_date', '>=', $currentDate->day)
                    ->whereDay('birth_date', '<=', $currentDate->addDays(30)->day)
                    ->orWhere(function ($query) use ($startOfMonth, $endOfMonth) {
                        $query->whereMonth('birth_date', '=', $startOfMonth->month)
                                ->whereDay('birth_date', '>=', $startOfMonth->day)
                                ->orWhereMonth('birth_date', '=', $endOfMonth->month)
                                ->whereDay('birth_date', '<=', $endOfMonth->day);
                    });
            })
            ->orderByRaw('MONTH(birth_date), DAY(birth_date)')
            ->get();

        return view('welcome', compact(
            'clients', 'packages', 'clientsandsubscriptionsandpackages',
            'clientCount', 'users', 'coachesCount', 'packagesCount',
            'subscribeCount', 'onHoldCount', 'expiredCount', 'noSubscriptionCount',
            'subscribePercentage', 'onHoldPercentage', 'expiredPercentage', 'noSubscriptionPercentage',
            'clientCheckIns', 'clientCheckInCount', 'upcomingBirthdays'
        ));
    }

    public function markAsViewed(Request $request)
    {
        $user = Auth::user();

        // Base query for clients and related data
        $clientsQuery = Client::with(['subscriptions.package', 'group']);

        if ($user->role === 'coach') {
            // If user is a coach, fetch only the clients assigned to this coach
            $clientsQuery->where('user_id', $user->id);
        }

        ClientCheckIn::whereIn('client_id', $clientsQuery->pluck('id')) // Filter by clientsQuery
            ->whereHas('formAnswers', function ($query) {
                $query->whereNotNull('answer');
            })
            ->update(['notification_viewed' => true]);

        return response()->json(['message' => 'Notifications marked as viewed']);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
