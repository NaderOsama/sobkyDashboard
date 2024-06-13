<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class packageController extends Controller
{

    public function index()
    {
        $packages = Package::all();
        return view('packages.index', compact('packages'));
    }
    public function allPackages()
    {
        $packages = Package::all();
        return view('packages.allPackages', compact('packages'));
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
            'description' => 'required|string',
            'duration' => 'required|string',
            'price' => 'required|numeric|min:0',
            'hold_limit_days' => 'nullable|integer|min:0',
        ]);

        // Create a new package instance
        $package = new Package;
        $package->name = $validatedData['name'];
        $package->description = $validatedData['description'];
        $package->duration = $validatedData['duration'];
        $package->price = $validatedData['price'];
        $package->hold_limit_days = $validatedData['hold_limit_days'];

        // Save the package to the database
        $package->save();

        // Redirect the user to a relevant page
        return redirect()->route('packages.index')->with('success', 'Package created successfully!');
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $package->update($request->all());
        return redirect()->route('packages.index')->with('success', 'Package updated successfully!');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();
        return redirect()->route('packages.index')->with('success', 'Package deleted successfully!');
    }
}
