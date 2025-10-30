<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Vue principale
     */
    public function page()
    {
        return view('departments.index');
    }

    /**
     * Liste paginée (API)
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 4);

        $departments = Department::with('employees')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $departments->items(),
            'pagination' => [
                'current_page' => $departments->currentPage(),
                'last_page' => $departments->lastPage(),
                'total' => $departments->total(),
            ],
        ]);
    }

    /**
     * Création
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $department = Department::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Department created successfully!',
            'data' => $department
        ]);
    }

    /**
     * Afficher un département avec employés
     */
    public function show($id): JsonResponse
    {
        $department = Department::with('employees')->find($id);

        if (!$department) {
            return response()->json(['success' => false, 'message' => 'Department not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $department]);
    }

    /**
     * Mise à jour
     */
    public function update(Request $request, $id): JsonResponse
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['success' => false, 'message' => 'Department not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $department->update($validated);

        return response()->json(['success' => true, 'message' => 'Department updated', 'data' => $department]);
    }

    /**
     * Suppression
     */
    public function destroy($id): JsonResponse
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['success' => false, 'message' => 'Department not found'], 404);
        }

        $department->delete();

        return response()->json(['success' => true, 'message' => 'Department deleted successfully']);
    }
}
