<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trip;
use App\Models\Itinerary;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Global App Stats
        $stats = [
            'users' => User::count(),
            'trips' => Trip::count(),
            'itineraries' => Itinerary::count(),
            'notes' => Note::count(),
        ];

        // Fetch popular locations mimicking 'SELECT location, COUNT(*) AS count FROM activities_catalog...'
        $popularLocations = DB::table('activities_catalog')
            ->select('location', DB::raw('COUNT(*) as count'))
            ->groupBy('location')
            ->orderByDesc('count')
            ->limit(3)
            ->get();

        // Fetch top recent users alongside their trip counts
        $recentUsers = User::withCount('trips')
            ->orderByDesc('updated_at')
            ->limit(20)
            ->get();

        return view('admin.dashboard', compact('stats', 'popularLocations', 'recentUsers'));
    }

    public function deleteUser($id)
    {
        if ($id == auth()->id()) {
            return back()->with('error', 'You cannot delete your own account from admin.');
        }
        
        User::destroy($id);
        
        return back()->with('success', 'User deleted successfully.');
    }
}