<?php

namespace App\Http\Controllers;

use App\Models\Room;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:all,free,occupied,disabled'],
        ]);
        $search = trim($validated['search'] ?? '');
        $status = $validated['status'] ?? 'all';

        $roomRows = Room::with('floor.building.college')
            ->orderBy('code')
            ->get()
            ->map(function (Room $room) {
                $floor = $room->floor;
                $building = $floor->building;
                $college = $building->college;
                $isDisabled = ! $college->is_active || ! $building->is_active || ! $room->for_use;
                $roomStatus = $isDisabled
                    ? 'Disabled'
                    : ($room->is_available ? 'Free' : 'Occupied');

                return compact('room', 'floor', 'building', 'college') + ['status' => $roomStatus];
            });

        $stats = [
            'total' => $roomRows->count(),
            'free' => $roomRows->where('status', 'Free')->count(),
            'occupied' => $roomRows->where('status', 'Occupied')->count(),
            'disabled' => $roomRows->where('status', 'Disabled')->count(),
        ];

        $filteredRooms = $roomRows->filter(function (array $row) use ($search, $status) {
            if ($status !== 'all' && strtolower($row['status']) !== $status) {
                return false;
            }

            if ($search === '') {
                return true;
            }

            foreach ([
                $row['room']->code,
                $row['room']->name,
                $row['room']->room_type,
                $row['floor']->name,
                $row['building']->code,
                $row['building']->name,
                $row['college']->code,
                $row['college']->name,
            ] as $value) {
                if (stripos($value, $search) !== false) {
                    return true;
                }
            }

            return false;
        })->values();

        return view('admin.rooms.index', compact('filteredRooms', 'search', 'status', 'stats'));
    }

    public function toggleAvailability($room_id): RedirectResponse
    {
        $room = Room::findOrFail($room_id);
        $room->for_use = ! $room->for_use;
        $room->save();

        $message = $room->for_use
            ? 'Room availability enabled successfully!'
            : 'Room availability disabled successfully!';

        return back()->with('success', $message);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}
