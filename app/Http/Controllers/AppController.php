<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomAssignment;
use App\Models\ProfessorAbsence;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppController extends Controller
{
    public function home(Request $request): View|RedirectResponse
    {
        if ($request->user()->role === 'professor') {
            return redirect()->route('app.schedule');
        }

        return $this->rooms($request);
    }

    public function rooms(Request $request): View
    {
        $filters = $request->validate([
            'date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:today'],
            'time' => ['nullable', 'date_format:H:i'],
            'status' => ['nullable', 'in:all,free,occupied'],
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $date = $filters['date'] ?? today()->toDateString();
        $time = $filters['time'] ?? now()->format('H:i');
        $status = $filters['status'] ?? 'all';
        $search = trim($filters['search'] ?? '');
        $weekday = Carbon::createFromFormat('Y-m-d', $date)->dayOfWeek;

        $rooms = Room::query()
            ->with(['floor.building.college'])
            ->where('for_use', true)
            ->whereHas('floor.building', fn (Builder $query) => $query->where('is_active', true))
            ->whereHas('floor.building.college', fn (Builder $query) => $query->where('is_active', true))
            ->orderBy('code')
            ->get();

        $assignmentsByRoom = RoomAssignment::query()
            ->where('is_active', true)
            ->where('day_of_week', $weekday)
            ->where('start_time', '<=', $time)
            ->where('end_time', '>', $time)
            ->with(['professor.absences' => fn (Builder $query) => $query
                ->whereDate('starts_on', '<=', $date)
                ->whereDate('ends_on', '>=', $date)])
            ->get()
            ->groupBy('room_id');

        $roomRows = $rooms->map(function (Room $room) use ($assignmentsByRoom) {
            $currentAssignments = $assignmentsByRoom->get($room->id, collect());
            $isOccupied = $currentAssignments->contains(function (RoomAssignment $assignment) {
                $professor = $assignment->professor;

                return ! $professor || $professor->absences->isEmpty();
            });
            $isFree = ! $isOccupied && (
                $currentAssignments->isNotEmpty() || $room->is_available
            );

            return [
                'room' => $room,
                'is_free' => $isFree,
                'status' => $isFree ? 'free' : 'occupied',
            ];
        });

        $stats = [
            'total' => $roomRows->count(),
            'free' => $roomRows->where('status', 'free')->count(),
            'occupied' => $roomRows->where('status', 'occupied')->count(),
        ];

        $filteredRooms = $roomRows
            ->filter(function (array $row) use ($search, $status) {
                if ($status !== 'all' && $row['status'] !== $status) {
                    return false;
                }

                if ($search === '') {
                    return true;
                }

                $room = $row['room'];
                $floor = $room->floor;
                $building = $floor->building;
                $college = $building->college;

                foreach ([
                    $room->code,
                    $room->name,
                    $room->room_type,
                    $floor->name,
                    $building->code,
                    $building->name,
                    $college->code,
                    $college->name,
                ] as $value) {
                    if (stripos($value, $search) !== false) {
                        return true;
                    }
                }

                return false;
            })
            ->values();

        return view('app.rooms', compact(
            'date',
            'time',
            'status',
            'search',
            'stats',
            'filteredRooms',
        ));
    }

    public function schedule(Request $request): View
    {
        abort_unless($request->user()->role === 'professor', 403);

        $assignments = RoomAssignment::query()
            ->where('professor_id', $request->user()->id)
            ->where('is_active', true)
            ->with('room.floor.building.college')
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        $absences = $request->user()->absences()
            ->whereDate('ends_on', '>=', today())
            ->orderBy('starts_on')
            ->get();

        return view('app.schedule', compact('assignments', 'absences'));
    }

    public function settings(Request $request): View
    {
        return view('app.settings', ['user' => $request->user()]);
    }

    public function createAbsence(Request $request): RedirectResponse
    {
        abort_unless($request->user()->role === 'professor', 403);

        $data = $request->validate([
            'starts_on' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'ends_on' => ['required', 'date_format:Y-m-d', 'after_or_equal:starts_on'],
        ]);

        $overlapExists = $request->user()->absences()
            ->whereDate('starts_on', '<=', $data['ends_on'])
            ->whereDate('ends_on', '>=', $data['starts_on'])
            ->exists();

        if ($overlapExists) {
            return back()
                ->withErrors(['starts_on' => 'These dates overlap an existing leave period.'])
                ->withInput();
        }

        $request->user()->absences()->create($data);

        return back()->with('success', 'All your assigned rooms are free during your scheduled classes on these dates.');
    }

    public function cancelAbsence(Request $request, int $absenceId): RedirectResponse
    {
        abort_unless($request->user()->role === 'professor', 403);

        $absence = ProfessorAbsence::query()
            ->where('professor_id', $request->user()->id)
            ->findOrFail($absenceId);
        $absence->delete();

        return back()->with('success', 'The leave period has been removed.');
    }
}
