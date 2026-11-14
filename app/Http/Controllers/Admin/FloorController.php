<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFloorRequest;
use App\Models\Floor;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function store(StoreFloorRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        Floor::create($validated);

        return back()->with('success', 'Floor created successfully!');
    }
}
