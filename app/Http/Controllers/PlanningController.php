<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlanningController extends Controller
{
    public function index()
    {
        $loggedInUserId = auth()->id();

        $query = DB::table('trips')->orderByDesc('id');
        if ($loggedInUserId) {
            $query->where('user_id', $loggedInUserId);
        }

        $rows = $query->get();

        $trips = $rows->map(function ($row) {
            $meta = json_decode($row->description ?? '{}', true);
            if (!is_array($meta)) {
                $meta = [];
            }

            $start = Carbon::parse($row->start_date);
            $end = Carbon::parse($row->end_date);
            $daysCount = max(1, $start->diffInDays($end) + 1);
            $placesList = $meta['places'] ?? [];
            $placesCount = is_array($placesList) ? count($placesList) : 0;

            return (object) [
                'id' => $row->id,
                'trip_name' => $row->trip_name,
                'area' => $meta['area'] ?? 'Ella',
                'start_date_formatted' => $start->format('d M Y'),
                'end_date_formatted' => $end->format('d M Y'),
                'days_count' => $daysCount,
                'places_count' => $placesCount,
                'travelers' => $meta['travelers'] ?? '2',
                'cover_img' => $meta['cover_img'] ?? 'https://images.unsplash.com/photo-1586016413664-864c0dd76f53?auto=format&fit=crop&w=600&q=80',
            ];
        });

        return view('planning.index', compact('trips'));
    }

    public function create(Request $request)
    {
        return view('planning.create');
    }

    public function suggestedPlaces(Request $request)
    {
        return view('planning.suggested-places');
    }

    public function suggestedTimeline(Request $request)
    {
        return view('planning.suggested-timeline');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_name' => 'required|string|max:255',
            'area' => 'nullable|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'travelers' => 'nullable|string|max:50',
            'places_json' => 'nullable|string',
            'days_json' => 'nullable|string',
        ]);

        $places = json_decode($validated['places_json'] ?? '[]', true);
        if (!is_array($places)) {
            $places = [];
        }

        $days = json_decode($validated['days_json'] ?? '[]', true);
        if (!is_array($days)) {
            $days = [];
        }

        $area = $validated['area'] ?? 'Ella';
        $coverImages = [
            'Ella' => 'https://images.unsplash.com/photo-1586016413664-864c0dd76f53?auto=format&fit=crop&w=700&q=80',
            'Kandy' => 'https://images.unsplash.com/photo-1546708973-b339540b5162?auto=format&fit=crop&w=700&q=80',
            'Galle' => 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?auto=format&fit=crop&w=700&q=80',
            'Sigiriya' => 'https://images.unsplash.com/photo-1588598198321-9735fd52df0c?auto=format&fit=crop&w=700&q=80',
            'Mirissa' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=700&q=80',
            'Nuwara Eliya' => 'https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?auto=format&fit=crop&w=700&q=80',
            'Colombo' => 'https://images.unsplash.com/photo-1578469645742-46cae010e5d4?auto=format&fit=crop&w=700&q=80',
            'Trincomalee' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=700&q=80',
        ];

        $descriptionPayload = json_encode([
            'area' => $area,
            'travelers' => $validated['travelers'] ?? '2',
            'places' => $places,
            'days' => $days,
            'cover_img' => $coverImages[$area] ?? $coverImages['Ella'],
        ]);

        $userId = auth()->id();
        if (!$userId) {
            $user = DB::table('users')->first();
            if (!$user) {
                $userId = DB::table('users')->insertGetId([
                    'name' => 'Tharusha Nimneth',
                    'email' => 'tharusha@example.com',
                    'password' => bcrypt('password123'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $userId = $user->id;
            }
        }

        DB::table('trips')->insert([
            'user_id' => $userId,
            'trip_name' => $validated['trip_name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'description' => $descriptionPayload,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('planning.index')->with('success', 'Trip saved successfully!');
    }

    public function show($id)
    {
        $row = DB::table('trips')->where('id', $id)->first();

        if (!$row) {
            return view('planning.show', ['tripRecord' => null, 'tripMeta' => null, 'tripId' => $id]);
        }

        $meta = json_decode($row->description ?? '{}', true);
        if (!is_array($meta)) {
            $meta = [];
        }

        return view('planning.show', [
            'tripRecord' => $row,
            'tripMeta' => $meta,
            'tripId' => $id,
        ]);
    }

    public function destroy($id)
    {
        DB::table('trips')->where('id', $id)->delete();

        return redirect()->route('planning.index')->with('success', 'Trip deleted.');
    }
}