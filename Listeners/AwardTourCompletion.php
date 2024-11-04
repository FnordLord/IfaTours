<?php

namespace Modules\IfaTours\Listeners;

use App\Events\PirepAccepted;
use Modules\IfaTours\Models\CompletedTour;
use Modules\IfaTours\Models\Tour;
use App\Models\UserAward;
use App\Models\Pirep;

class AwardTourCompletion
{
    public function handle(PirepAccepted $event)
    {
        $user = $event->pirep->user;
        $flight_id = $event->pirep->flight_id;

        $tours = Tour::whereHas('legs.flight', function ($query) use ($flight_id) {
            $query->where('id', $flight_id);
        })->get();

        foreach ($tours as $tour) {

            $all_legs_completed = $tour->legs->every(function ($leg) use ($user) {
                return Pirep::where('flight_id', $leg->flight_id)
                    ->where('user_id', $user->id)
                    ->where('state', 2) // Assuming '2' means 'accepted'
                    ->exists();
            });

            if ($all_legs_completed) {
                CompletedTour::firstOrCreate([
                    'user_id' => $user->id,
                    'tour_id' => $tour->id,
                ]);

                if ($tour->award && !UserAward::where('user_id', $user->id)->where('award_id', $tour->award->id)->exists()) {
                    UserAward::create([
                        'user_id' => $user->id,
                        'award_id' => $tour->award->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
