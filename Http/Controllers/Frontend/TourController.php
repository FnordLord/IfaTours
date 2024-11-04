<?php

namespace Modules\IfaTours\Http\Controllers\Frontend;

use App\Contracts\Controller;
use Modules\IfaTours\Models\CompletedTour;
use Modules\IfaTours\Models\CompletedTourFlight;
use Modules\IfaTours\Models\Tour;

class TourController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $tours = Tour::all();

        if ($user) {
            $completedTourIds = CompletedTour::where('user_id', $user->id)
                ->pluck('tour_id')
                ->toArray();

            $tours->each(function ($tour) use ($completedTourIds, $user) {
                $tour->completed = in_array($tour->id, $completedTourIds);

                $completedLegCount = CompletedTourFlight::where('user_id', $user->id)
                    ->where('tour_id', $tour->id)
                    ->count();
                $totalLegCount = $tour->legs()->count();

                $tour->in_progress = !$tour->completed && $completedLegCount > 0 && $completedLegCount < $totalLegCount;
            });
        }

        return view('ifatours::frontend.index', compact('tours', 'user'));
    }

    public function show(Tour $tour)
    {
        $user = auth()->user();

        $tour->load('legs.flight', 'award');

        $completedFlightIds = $user ? CompletedTourFlight::where('user_id', $user->id)
            ->where('tour_id', $tour->id)
            ->pluck('flight_id')
            ->toArray() : [];

        $totalLegCount = $tour->legs()->count();
        $completedLegCount = count($completedFlightIds);

        $tour->completed = ($completedLegCount === $totalLegCount && $totalLegCount > 0);
        $tour->in_progress = ($completedLegCount > 0 && $completedLegCount < $totalLegCount);

        $saved = $user ? $user->bids->pluck('flight_id')->toArray() : [];

        return view('ifatours::frontend.show', compact('tour', 'user', 'saved', 'completedFlightIds'));
    }


}
