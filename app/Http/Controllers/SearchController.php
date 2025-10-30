<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Recruitment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function globalSearch(Request $request): JsonResponse
    {
        try {
            $query = $request->get('q', '');
            $limit = $request->get('limit', 10);

            // Si la requête est trop courte, retourner des résultats vides
            if (empty($query) || strlen($query) < 2) {
                return response()->json([
                    'success' => true,
                    'data' => []
                ]);
            }

            $results = [];

            // Recherche dans les employés
            try {
                $employees = Employee::where(function($q) use ($query) {
                        $q->where('first_name', 'like', "%{$query}%")
                          ->orWhere('last_name', 'like', "%{$query}%")
                          ->orWhere('email', 'like', "%{$query}%")
                          ->orWhere('position', 'like', "%{$query}%");
                    })
                    ->where('status', 'Active')
                    ->limit($limit)
                    ->get(['id', 'first_name', 'last_name', 'email', 'position', 'department']);

                foreach ($employees as $employee) {
                    $results[] = [
                        'type' => 'employee',
                        'id' => $employee->id,
                        'title' => "{$employee->first_name} {$employee->last_name}",
                        'subtitle' => $employee->position,
                        'description' => $employee->department,
                        'icon' => 'fas fa-user',
                        'color' => 'text-blue-600',
                        'url' => '/employees'
                    ];
                }
            } catch (\Exception $e) {
                // Log l'erreur mais continue avec les autres recherches
                Log::error('Employee search error: ' . $e->getMessage());
            }

            // Recherche dans les départements
            try {
                $departments = Department::where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->limit($limit)
                    ->get(['id', 'name', 'description']);

                foreach ($departments as $department) {
                    $results[] = [
                        'type' => 'department',
                        'id' => $department->id,
                        'title' => $department->name,
                        'subtitle' => 'Département',
                        'description' => $department->description,
                        'icon' => 'fas fa-building',
                        'color' => 'text-green-600',
                        'url' => '/departments'
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Department search error: ' . $e->getMessage());
            }

            // Recherche dans les recrutements
            try {
                $recruitments = Recruitment::where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->where('status', 'Open')
                    ->limit($limit)
                    ->get(['id', 'title', 'description', 'status']);

                foreach ($recruitments as $recruitment) {
                    $results[] = [
                        'type' => 'recruitment',
                        'id' => $recruitment->id,
                        'title' => $recruitment->title,
                        'subtitle' => 'Offre d\'emploi',
                        'description' => $recruitment->description,
                        'icon' => 'fas fa-user-plus',
                        'color' => 'text-purple-600',
                        'url' => '/recruitments'
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Recruitment search error: ' . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'data' => array_slice($results, 0, $limit)
            ]);

        } catch (\Exception $e) {
            Log::error('Global search error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur interne du serveur',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}