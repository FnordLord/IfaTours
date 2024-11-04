<?php

namespace Modules\IfaTours\Models;

use App\Models\Airport;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\Model;

/**
 * Class TourLeg
 * @package Modules\IfaTours\Models
 */
class TourLeg extends Model
{
    use HasFactory;

    protected $table = 'ifatours_legs';

    protected $fillable = [
        'tour_id',
        'flight_id',
        'order',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class, 'flight_id');
    }

    public function airport()
    {
        return $this->belongsTo(Airport::class, 'id');
    }
}
