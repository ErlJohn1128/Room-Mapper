<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreCollegeRequest;
use App\Http\Requests\UpdateCollegeRequest;

use App\Models\College;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollegeController extends Controller
{
    // Allowed: GET
    // Returns the index.blade.php with corresponding necessary data
    public function index(Request $request): View 
    {
        $colleges = College::with('buildings.floors.rooms')->latest()->get();

        return view('admin.colleges.index', compact('colleges'));
    }

    // Allowed: GET
    // Returns the create.blade.php with corresponding necessary data
    public function create(Request $request): View
    {
        return view('admin.colleges.create');
    }

    // Allowed: GET
    // Returns the edit.blade.php with corresponding necessary data
    public function edit($college_id): View
    {
        $college = College::findOrFail($college_id);

        return view('admin.colleges.edit', compact('college'));
    }

    public function show($college_id): View
    {
        $college = College::with('buildings.floors.rooms')->findOrFail($college_id);

        return view('admin.colleges.show', compact('college'));
    }

    public function toggleAvailability($college_id): RedirectResponse
    {
        $college = College::findOrFail($college_id);
        $college->is_active = ! $college->is_active;
        $college->save();

        $message = $college->is_active
            ? 'College availability enabled successfully!'
            : 'College availability disabled successfully!';

        return redirect()->route('admin.colleges.show', $college->id)->with('success', $message);
    }

    // Allowed: POST
    // Responsible for post request of storing of colleges
    public function store(StoreCollegeRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        College::create($validated);
        
        return back()->with('success', 'College created successfully!');
    }

    // Allowed: POST
    // Responsible for patch request of existing college
    public function update(UpdateCollegeRequest $request, $college_id): RedirectResponse
    {
        $college = College::findOrFail($college_id);
        $college->update($request->validated());

        return back()->with('success', 'College updated successfully!');
    }

    // Allowed: Delete
    // Responsible for delete request of an existing college
    public function destroy($college_id): RedirectResponse
    {
        $college = College::findOrFail($college_id);
        $college->delete();

        return back()->with('success', 'College deleted successfully!');
    }
}
