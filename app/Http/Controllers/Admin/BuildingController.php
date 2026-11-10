<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreBuildingRequest;
use App\Models\Building;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BuildingController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.buildings.index');
    }

    public function edit(Request $request): View
    {
        return view('admin.buildings.edit');
    }

    public function create(Request $request): View
    {
        return view('admin.buildings.create');
    }

    public function store(StoreBuildingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Building::create($validated);

        return back()->with('success', 'Building created successfully!');
    }

   
}
