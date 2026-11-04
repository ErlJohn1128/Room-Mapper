<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreCollegeRequest;

use App\Models\College;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollegeController extends Controller
{
    /**
     * Display a listing of colleges along with CRUD forms.
     */
    public function index(Request $request): View 
    {
        $colleges = College::latest()->get();
        return view('admin.college', compact('colleges'));
    }

    public function store(StoreCollegeRequest $request): RedirectResponse // STORE
    {
        $validated = $request->validated();

        echo "RECEIVED";
        
        College::create($validated);

        return redirect()->route('admin.colleges.index')
            ->with('success', 'College created successfully!');
    }
}
