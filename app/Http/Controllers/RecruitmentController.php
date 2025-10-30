<?php

namespace App\Http\Controllers;

use App\Models\Recruitment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RecruitmentController extends Controller
{
    /**
     * GET /api/recruitments
     * Retourne liste paginée (paramètres: page, per_page)
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $perPage = $perPage > 0 ? $perPage : 10;

        $paginator = Recruitment::select('id','title','description','positions_needed','status','start_date','end_date')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ]
        ]);
    }

    /**
     * POST /api/recruitments
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'positions_needed' => 'required|integer|min:1',
            'status' => 'required|string|in:Open,Closed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $recruitment = Recruitment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Job Opening created successfully!',
            'data' => $recruitment
        ], 201);
    }

    /**
     * GET /api/recruitments/{id}
     */
    public function show($id): JsonResponse
    {
        $recruitment = Recruitment::find($id);
        if (!$recruitment) {
            return response()->json(['success' => false, 'message' => 'Job opening not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $recruitment]);
    }

    /**
     * PUT /api/recruitments/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $recruitment = Recruitment::find($id);
        if (!$recruitment) {
            return response()->json(['success' => false, 'message' => 'Job opening not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'positions_needed' => 'required|integer|min:1',
            'status' => 'required|string|in:Open,Closed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $recruitment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Job Opening updated successfully!',
            'data' => $recruitment
        ]);
    }

    /**
     * DELETE /api/recruitments/{id}
     */
    public function destroy($id): JsonResponse
    {
        $recruitment = Recruitment::find($id);
        if (!$recruitment) {
            return response()->json(['success' => false, 'message' => 'Job opening not found'], 404);
        }

        $recruitment->delete();

        return response()->json(['success' => true, 'message' => 'Job Opening deleted successfully!']);
    }
}
