<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $employees = Employee::with('department')->paginate(5);

        return response()->json([
            'success' => true,
            'data' => $employees->map(function ($e) {
                return [
                    'id' => $e->id,
                    'first_name' => $e->first_name,
                    'last_name' => $e->last_name,
                    'email' => $e->email,
                    'department' => $e->department ? $e->department->name : '—',
                    'position' => $e->position,
                    'status' => $e->status,
                ];
            }),
            'pagination' => [
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'total' => $employees->total(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:Active,On Leave,Inactive',
        ]);

        $employee = Employee::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Employee added successfully!',
            'data' => $employee,
        ]);
    }

    public function show($id): JsonResponse
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $employee]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => "required|email|unique:employees,email,{$id}",
            'phone' => 'nullable|string|max:20',
            'position' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'gender' => 'required|in:Male,Female',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:Active,On Leave,Inactive',
        ]);

        $employee->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully!',
            'data' => $employee,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }

        $employee->delete();

        return response()->json(['success' => true, 'message' => 'Employee deleted successfully!']);
    }
}
