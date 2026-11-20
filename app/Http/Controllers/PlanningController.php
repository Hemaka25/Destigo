<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlanningController extends Controller
{
    private function resolveCoverImage(?string $area): string
{
    $coverImages = [
        'ella' => asset('images/trips/ella.jpg'),
        'kandy' => asset('images/trips/kandy.jpg'),
        'galle' => asset('images/trips/galle.jpg'),
        'sigiriya' => asset('images/trips/sigiriya.jpg'),
        'mirissa' => asset('images/trips/mirissa.jpg'),
        'nuwara eliya' => asset('images/trips/nuwara-eliya.jpg'),
        'colombo' => asset('images/trips/colombo.jpg'),
        'trincomalee' => asset('images/trips/trincomalee.jpg'),
    ];

    $key = strtolower(trim($area ?? 'ella'));

    return $coverImages[$key] ?? $coverImages['ella'];
}

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
            $area = $meta['area'] ?? 'Ella';

            return (object) [
                'id' => $row->id,
                'trip_name' => $row->trip_name,
                'area' => $area,
                'start_date_formatted' => $start->format('d M Y'),
                'end_date_formatted' => $end->format('d M Y'),
                'days_count' => $daysCount,
                'places_count' => $placesCount,
                'travelers' => $meta['travelers'] ?? '2',
                'cover_img' => $meta['cover_img'] ?? $this->resolveCoverImage($area),
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
        $coverImg = $this->resolveCoverImage($area);

        $descriptionPayload = json_encode([
            'area' => $area,
            'travelers' => $validated['travelers'] ?? '2',
            'places' => $places,
            'days' => $days,
            'cover_img' => $coverImg,
        ]);

        $userId = auth()->id();
        if (!$userId) {
            $user = DB::table('users')->first();
            if (!$user) {
                $userId = DB::table('users')->insertGetId([
                    'full_name' => 'Tharusha Nimneth',
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

        if (empty($meta['cover_img'])) {
            $meta['cover_img'] = $this->resolveCoverImage($meta['area'] ?? 'Ella');
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