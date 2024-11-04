<?php

namespace Modules\IfaTours\Listeners;
use App\Events\PirepAccepted;
use Modules\IfaTours\Models\CompletedTourFlight;
use Modules\IfaTours\Models\TourLeg;
use Illuminate\Support\Facades\Log;

class MarkTourFlightAsCompleted
{

    /**
     * Handle the event.
     */
    public function handle(PirepAccepted $event)
    {
        Log::info('MarkTourFlightAsCompleted listener triggered', ['pirep_id' => $event->pirep->id]);
        $pirep = $event->pirep;
        $user = $pirep->user;
        $flightId = $pirep->flight_id;

        $tourLeg = TourLeg::where('flight_id', $flightId)->first();

        if ($tourLeg) {
            CompletedTourFlight::updateOrCreate([
                'user_id' => $user->id,
                'tour_id' => $tourLeg->tour_id,
                'flight_id' => $flightId,
                'pirep_id' => $pirep->id,
            ], [
                'completed_at' => now(),
            ]);
        }
    }
}
