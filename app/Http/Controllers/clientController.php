<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Models\Group;
use App\Models\Client;
use App\Models\CheckIn;
use App\Models\Package;
use App\Models\Question;
use App\Models\FormAnswer;
use App\Models\CheckinForm;
use App\Models\RemainingDay;
use Illuminate\Http\Request;
use App\Models\ClientCheckIn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class clientController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Base query for clients and related data
        $clientsQuery = Client::with('group');


        if ($user && $user->role === 'coach') {
            // If user is a coach, fetch only the clients assigned to this coach
            $clientsQuery->where('user_id', $user->id);
        }

        // Clone the query before modifying it for specific conditions
        $clientsNotSubscribedQuery = clone $clientsQuery;

        // Fetch all clients regardless of status
        $clients = $clientsQuery->get();

        // Fetch only clients with status 'not subscribed'
        $clientsNotSubscribed = $clientsNotSubscribedQuery->where('status', 'not subscribed')->get();

        $users = User::where('role', 'coach')->get();
        // Fetch all packages
        $packages = Package::all();

        // Fetch check-ins with their relationships
        $check_ins = CheckIn::with('checkinForms.questions.answers')->get();

        // Fetch all groups
        $groups = Group::all();

        return view('clients.index', compact('clients', 'clientsNotSubscribed', 'packages', 'check_ins', 'groups','users'));
    }


    public function allClients()
    {
        $user = Auth::user();

        // Base query for clients and related data
        $clientsQuery = Client::with('group');

        if ($user && $user->role === 'coach') {
            // If user is a coach, fetch only the clients assigned to this coach
            $clientsQuery->where('user_id', $user->id);
        }

        // Fetch all clients regardless of status
        $clients = $clientsQuery->get();

        // Fetch only clients with status 'not subscribed'
        $clientsNotSubscribed = $clientsQuery->where('status', 'not subscribed')->get();

        // Fetch all packages
        $packages = Package::all();

        // Fetch check-ins with their relationships
        $check_ins = CheckIn::with('checkinForms.questions.answers')->get();

        // Fetch all groups
        $groups = Group::all();

        return view('clients.allClients', compact('clients', 'clientsNotSubscribed', 'packages', 'check_ins', 'groups'));
    }



    public function profile($clientId)
    {
        $clientsandsubscriptionsandpackages = Client::with(['subscriptions.package', 'group'])->findOrFail($clientId);


        if (!$clientsandsubscriptionsandpackages) {
            return redirect()->back()->with('error', 'Client not found.');
        }

        $client = Client::findOrFail($clientId);
        $clients = Client::all();
        $check_ins = CheckIn::with('checkinForms.questions.answers')->get();
        $check_ins_sent = $client->checkIns()->get();

        $check_ins_sent_answers = DB::select("
            SELECT
                fa.id AS form_answer_id,
                fa.client_check_in_id,
                c.id AS client_id,
                c.name AS client_name,
                cci.check_in_id,
                ci.name AS check_in_name,
                q.id AS question_id,
                q.title AS question_title,
                fa.answer,
                fa.created_at AS form_answer_created_at,
                fa.updated_at AS form_answer_updated_at
            FROM
                form_answers fa
            JOIN
                client_check_ins cci ON fa.client_check_in_id = cci.id
            JOIN
                clients c ON cci.client_id = c.id
            JOIN
                check_ins ci ON cci.check_in_id = ci.id
            JOIN
                questions q ON fa.question_id = q.id
            WHERE
                cci.client_id = :client_id
            ORDER BY
                fa.client_check_in_id, q.id
        ", ['client_id' => $clientId]);

        // Group the answers by client_check_in_id using Laravel collection
        $groupedAnswers = collect($check_ins_sent_answers)->groupBy('client_check_in_id');
        return view('clients.profile', compact(
            'clientsandsubscriptionsandpackages',
            'client',
            'check_ins',
            'clients',
            'check_ins_sent',
            'groupedAnswers'
        ));
    }

    public function sendCheckIn(Request $request, Client $client)
    {
        // Validate the incoming request
        $request->validate([
            'check_in_id' => 'required|exists:check_ins,id',
        ]);

        // Find the check-in by ID
        $checkIn = CheckIn::findOrFail($request->check_in_id);

        // Create a new ClientCheckIn record
        $clientCheckIn = ClientCheckIn::create([
            'client_id' => $client->id,
            'check_in_id' => $checkIn->id,
        ]);

        return redirect()->back()->with('success', 'Check-in sent successfully.');
    }

    public function sendCheckInAnswer(Request $request, Client $client)
    {
        // Validate the incoming request
        $request->validate([
            'check_in_id' => 'required|exists:check_ins,id',
            'client_check_in_id' => 'required|exists:client_check_ins,id',
        ]);

        // Find the check-in by ID
        $checkIn = CheckIn::findOrFail($request->check_in_id);

        // Create a new ClientCheckIn record
        $clientCheckIn = ClientCheckIn::create([
            'client_id' => $client->id,
            'check_in_id' => $checkIn->id,
        ]);

        // Update form answers to set remaining_days to null
        FormAnswer::where('client_check_in_id', $request->client_check_in_id)
            ->update(['remaining_days' => null]);

        return redirect()->back()->with('success', 'Check-in sent successfully.');
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'second_mobile' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:Male,Female',
            'birth_date' => 'nullable|date',
            'diet_restrictions' => 'required|string|in:Muslim,Christian',
            'email' => 'required|email|max:255',
            'job_title' => 'nullable|string|max:255',
            'group_id' => 'required|integer|exists:groups,id',
            'client_type' => 'required|string|in:Online,Offline,Online + Offline',
            'referred_by' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'code' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id'
        ]);

        // Create a new client instance
        $client = new Client;

        // Fill the client instance with the validated data
        $client->fill($validatedData);

        // Assign the user_id based on the authenticated user's role
        $user = Auth::user();

        if ($user->role === 'admin') {
            $client->user_id = $validatedData['user_id'];
        } else if ($user->role === 'coach') {
            $client->user_id = $user->id;
        }

        // Save the client instance to the database
        $client->save();

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
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
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('clients.allClients')->with('success', 'Client deleted successfully!');
    }
    public function updateProfileImage(Request $request, $clientId)
    {
        // Validate the incoming request data
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif', // Adjust max file size as needed
        ]);

        // Find the client by ID
        $client = Client::find($clientId);

        if (!$client) {
            // Handle the case where no client is found, maybe redirect or show an error
            return redirect()->back()->with('error', 'Client not found.');
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $imageName = time().'.'.$profileImage->extension();
            $profileImage->move(public_path('profile_images'), $imageName);
            $client->profile_image = $imageName; // Update the profile_image property
            $client->save(); // Save the changes to the database
        }

        return redirect()->back()->with('success', 'Profile image updated successfully.');
    }

}


