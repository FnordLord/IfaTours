<?php
// Modules/IfaTours/Services/TourService.php

namespace Modules\IfaTours\Services;

use Modules\IfaTours\Models\Tour;
use App\Models\User;
use App\Models\UserAward;

class TourService
{
    public function checkAndAwardTourCompletion(Tour $tour, User $user)
    {
        $all_legs_completed = $tour->legs->every(function($leg) use ($user) {
            $has_pirep = $leg->flight->pireps()
                ->where('user_id', $user->id)
                ->where('status', 'accepted')
                ->exists();
            return $has_pirep;
        });

        if ($all_legs_completed && $tour->award) {
            $this->assignAward($user, $tour->award->id);
        }
    }

    protected function assignAward(User $user, $award_id)
    {
        if (!UserAward::where('user_id', $user->id)->where('award_id', $award_id)->exists()) {
            UserAward::create([
                'user_id' => $user->id,
                'award_id' => $award_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
