<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Affiche la vue principale du module des plannings.
     */
    public function index()
    {
        try {
            $schedules = Schedule::with('employee')
                ->orderBy('start_time', 'asc')
                ->paginate(4);

            return response()->json([
                'success' => true,
                'data' => $schedules->items(),
                'pagination' => [
                    'current_page' => $schedules->currentPage(),
                    'last_page' => $schedules->lastPage(),
                    'total' => $schedules->total(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Enregistre un nouveau planning.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'employee_id' => 'nullable|exists:employees,id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'notes' => 'nullable|string',
        ]);

        $schedule = Schedule::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Schedule created successfully',
            'data' => $schedule
        ]);
    }

    /**
     * Affiche un planning spécifique.
     */
    public function show($id)
    {
        $schedule = Schedule::with('employee')->find($id);

        if (!$schedule) {
            return response()->json(['success' => false, 'message' => 'Schedule not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $schedule]);
    }

    /**
     * Met à jour un planning existant.
     */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response()->json(['success' => false, 'message' => 'Schedule not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'employee_id' => 'nullable|exists:employees,id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'notes' => 'nullable|string',
        ]);

        $schedule->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Schedule updated successfully',
            'data' => $schedule
        ]);
    }

    /**
     * Supprime un planning.
     */
    public function destroy($id)
    {
        $schedule = Schedule::find($id);
        if (!$schedule) {
            return response()->json(['success' => false, 'message' => 'Schedule not found'], 404);
        }

        $schedule->delete();

        return response()->json(['success' => true, 'message' => 'Schedule deleted successfully']);
    }
}
