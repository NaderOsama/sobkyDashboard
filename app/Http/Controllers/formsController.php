<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\Question;
use App\Models\FormAnswer;
use App\Models\CheckinForm;
use App\Models\CheckInType;
use Illuminate\Http\Request;

class formsController extends Controller
{

    public function checkIn()
    {
        $checkinForms = CheckinForm::all();
        $checkins = CheckIn::with('checkinForms')->get();

        return view('forms.checkIn', compact('checkinForms', 'checkins'));
    }

    public function storeCheckIn(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'request_every_days' => 'required|integer',
            'checkin_form_ids' => 'required|array'
        ]);

        $checkIn = CheckIn::create([
            'name' => $request->name,
            'request_every_days' => $request->request_every_days,
        ]);

        $checkIn->checkinForms()->sync($request->checkin_form_ids);

        return redirect()->route('forms.checkIn')->with('success', 'Check-In created successfully.');
    }
    public function checkInType()
    {
        $checkintypes = CheckInType::all();

        return view('forms.checkInType',compact('checkintypes'));
    }

    public function storeCheckInType(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',

        ]);

        // Create a new package instance
        $checkintype = new CheckInType;
        $checkintype->name = $validatedData['name'];


        // Save the package to the database
        $checkintype->save();

        // Redirect the user to a relevant page
        return redirect()->route('forms.checkInType')->with('success', 'Check-In Type created successfully!');
    }

    public function formQuestion()
    {
        $questions = Question::all();
        $checkintypes = CheckInType::all();
        $checkinforms = CheckinForm::all();

        return view('forms.formQuestion', compact('questions','checkintypes','checkinforms'));
    }

    public function storeFormQuestion(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'checkin_type_id' => 'required|integer',
            'questions' => 'required|array'
        ]);

        $checkinForm = CheckinForm::create([
            'name' => $request->name,
            'checkin_type_id' => $request->checkin_type_id
        ]);

        $checkinForm->questions()->sync($request->questions);

        return redirect()->route('forms.formQuestion')->with('success', 'Check-in form created successfully.');
    }

    public function question()
    {
        $questions = Question::all();
        return view('forms.question',compact('questions'));
    }

    public function storeQuestion(Request $request)
    {
        $request->validate([
            'fixed_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|file|mimes:mp4,avi,mov|max:20480',
            'answer_type' => 'required|in:text,textarea,select,checkbox,radio,number',
            'shown_in' => 'nullable|in:Resistance,Mobility,Fitness,Diet'
        ]);

        $question = new Question($request->only(['fixed_name', 'title', 'description', 'answer_type', 'shown_in']));

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/questions'), $imageName);
            $question->image = $imageName;
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = time() . '.' . $video->extension();
            $video->move(public_path('videos/questions'), $videoName);
            $question->video = $videoName;
        }

        $question->save();

        return redirect()->route('forms.question')->with('success', 'Question created successfully.');
    }

    // public function storeQuestion2(Request $request)
    // {
    //     $request->validate([
    //         'fixed_name' => 'required|string|max:255',
    //         'title' => 'required|string|max:255',
    //         'description' => 'nullable|string',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'video' => 'nullable|url',
    //         'answer_type' => 'required|in:text,textarea,select,checkbox,radio,number',
    //         'shown_in' => 'required|in:Resistance,Mobility,Fitness,Diet'
    //     ]);

    //     $question = new Question($request->only(['fixed_name', 'title', 'description', 'video', 'answer_type', 'shown_in']));

    //     // Handle image upload
    //     if ($request->hasFile('image')) {
    //         $image = $request->file('image');
    //         $imageName = time() . '.' . $image->extension();
    //         $image->move(public_path('images/questions'), $imageName);
    //         $question->image = $imageName;
    //     }

    //     $question->save();

    //     // Store form data in session
    //     $formData = $request->except(['fixed_name', 'title', 'description', 'image', 'video', 'answer_type', 'shown_in']);

    //     session()->flash('new_question', $question->id);
    //     session()->flash('new_question_title', $question->title);

    //     return redirect()->route('forms.formQuestion')
    //         ->with('success', 'Question created successfully.');
    // }



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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
