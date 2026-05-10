<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TripController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        // Fetch trips belonging to the authenticated user
        $trips = $request->user()->trips()->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'trips' => $trips
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'destination' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'travelers' => 'integer|min:1',
            'budget' => 'numeric|min:0',
            'description' => 'nullable|string',
            'cover_photo' => 'nullable|string',
            'status' => 'string|in:Upcoming,Completed'
        ]);

        $trip = $request->user()->trips()->create($validated);

        return response()->json([
            'success' => true,
            'trip' => $trip
        ], 201);
    }

    public function show(Request $request, Trip $trip): JsonResponse
    {
        // Ensure user owns this trip
        if ($trip->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json(['success' => true, 'trip' => $trip]);
    }

    public function destroy(Request $request, Trip $trip): JsonResponse
    {
        if ($trip->user_id !== $request->user()->id) abort(403);
        $trip->delete();
        return response()->json(['success' => true, 'message' => 'Trip deleted']);
    }
}