<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class subscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'package_id' => 'required|exists:packages,id',
            'start_at' => 'required|date',
            'check_in_id' => 'nullable|exists:check_ins,id',
            'payment_method' => 'required|string',
            'transaction_number' => 'required|string',
            'transaction_date' => 'required|date',
            'from_phone' => 'nullable|string',
            'to_phone' => 'nullable|string',
            'transaction_type' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Create a new subscription instance
        $subscription = new Subscription;

        // Assign values to the subscription object
        $subscription->client_id = $validatedData['client_id'];
        $subscription->package_id = $validatedData['package_id'];
        $subscription->start_at = $validatedData['start_at'];
        $subscription->initial_send_check_in = $validatedData['check_in_id'];
        $subscription->payment_method = $validatedData['payment_method'];
        $subscription->transaction_number = $validatedData['transaction_number'];
        $subscription->transaction_date = $validatedData['transaction_date'];
        $subscription->from_phone = $validatedData['from_phone'];
        $subscription->to_phone = $validatedData['to_phone'];
        $subscription->transaction_type = $validatedData['transaction_type'];
        $subscription->notes = $validatedData['notes'];



        // Retrieve the authenticated user instance
        $user = Auth::user();

        // Assign the name of the authenticated user to the created_by field
        $subscription->created_by = $user->name;


        // Save the subscription to the database
        $subscription->save();
        // Attach the selected check-in to the client's check-ins
        $client = Client::findOrFail($validatedData['client_id']);
        $client->checkIns()->attach($validatedData['check_in_id']);

        // Redirect to a success page or return a response
        // For example, redirect back to the subscription form page
        return redirect()->back()->with('success', 'Subscription created successfully!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
