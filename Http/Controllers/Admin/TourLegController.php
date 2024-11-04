<?php

namespace Modules\IfaTours\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Models\Flight;
use Illuminate\Http\Request;
use Modules\IfaTours\Models\Tour;
use Modules\IfaTours\Models\TourLeg;

/**
 * Class TourLegController
 */
class TourLegController extends Controller
{
    public function index(Tour $tour)
    {
        $legs = $tour->legs()->orderBy('order')->get();
        $flights = Flight::all();

        return view('ifatours::admin.legs', compact('tour', 'legs', 'flights'));
    }

    public function store(Request $request, Tour $tour)
    {
        $request->validate([
            'flight_id' => 'required|string|exists:flights,id',
            'order' => 'nullable|integer',
        ]);

        $tour->legs()->create([
            'flight_id' => $request->flight_id,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('ifatours.admin.tours.legs.index', $tour->id)->with('success', 'Abschnitt erfolgreich hinzugefügt.');
    }

    public function destroy(Tour $tour, TourLeg $leg)
    {
        $leg->delete();

        return redirect()->route('ifatours.admin.tours.legs.index', $tour->id)->with('success', 'Abschnitt erfolgreich entfernt.');
    }
}
