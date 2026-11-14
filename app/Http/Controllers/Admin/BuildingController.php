<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use App\Models\Building;
use App\Models\College;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class BuildingController extends Controller
{
    // Allowed: GET
    // Returns the index.blade.php with corresponding necessary data
    public function index(Request $request): View
    {
        $buildings = Building::with(['college', 'floors.rooms'])->latest()->get();
    
        return view('admin.buildings.index', compact('buildings'));
    }

    // Allowed: GET
    // Returns the create.blade.php (The store form)
    public function create(Request $request): View
    {
        $colleges = College::orderBy('name')->get();

        return view('admin.buildings.create', compact('colleges'));
    }

    // Allowed: GET
    // Returns the edit.blade.php with corresponding necessary data
    public function edit($building_id): View
    {
        $building = Building::findOrFail($building_id);
        $colleges = College::orderBy('name')->get();

        return view('admin.buildings.edit', compact('building', 'colleges'));
    }

    // Allowed: POST
    // Responsible for post request of storing of buildings
    public function store(StoreBuildingRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $building = Building::create([
                'college_id' => $validated['college_id'],
                'name'       => $validated['name'],
                'code'       => $validated['code'],
                'start_time' => $validated['start_time'],
                'end_time'   => $validated['end_time'],
            ]);

            for ($i = 1; $i <= $validated['floors_count']; $i++) {
                $building->floors()->create([
                    'name' => "Floor {$i}",
                    'code' => "F{$i}"
                ]);
            }
        });

        return back()->with('success', 'Building created successfully!');
    }
    
    public function show($building_id): View
    {
        $building = Building::with(['college', 'floors.rooms'])->findOrFail($building_id);

        return view('admin.buildings.show', compact('building'));
    }

    public function update(UpdateBuildingRequest $request, $building_id): RedirectResponse
    {
        $building = Building::findOrFail($building_id);
        $building->update($request->validated());

        return redirect()->route('admin.buildings.show', $building->id)->with('success', 'Building updated successfully!');
    }

    public function destroy($building_id): RedirectResponse
    {
        $building = Building::findOrFail($building_id);
        $building->delete();

        return back()->with('success', 'Building and its floors and rooms deleted successfully!');
    }

    public function toggleAvailability($building_id): RedirectResponse
    {
        $building = Building::findOrFail($building_id);
        $building->is_active = ! $building->is_active;
        $building->save();

        $message = $building->is_active
            ? 'Building availability enabled successfully!'
            : 'Building availability disabled successfully!';

        return redirect()->route('admin.buildings.show', $building->id)->with('success', $message);
    }
}
