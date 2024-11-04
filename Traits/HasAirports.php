<?php


namespace Modules\IfaTours\Traits;

use App\Models\Airport;

trait HasAirports
{
    public function dpt_airport()
    {
        return $this->belongsTo(Airport::class, 'dpt_airport_id');
    }

    public function arr_airport()
    {
        return $this->belongsTo(Airport::class, 'arr_airport_id');
    }
}
