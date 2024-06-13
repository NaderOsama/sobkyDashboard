<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return view('groups.index', compact('groups'));
    }
    public function allGroups()
    {
        $groups = Group::all();
        return view('groups.allGroups', compact('groups'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new group instance
        $group = new Group;
        $group->name = $validatedData['name'];

        // Save the group to the database
        $group->save();

        // Redirect the user to a relevant page
        return redirect()->route('groups.index')->with('success', 'Group created successfully!');
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $group = Group::findOrFail($id);
        return view('groups.edit', compact('group'));
    }

    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $group->update($request->all());
        return redirect()->route('groups.index')->with('success', 'group updated successfully!');
    }

    public function destroy($id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        return redirect()->route('groups.index')->with('success', 'group deleted successfully!');
    }



}
