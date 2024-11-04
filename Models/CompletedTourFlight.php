<?php

namespace Modules\IfaTours\Models;

use App\Models\Flight;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CompletedTourFlight
 * @package Modules\IfaTours\Models
 */
class CompletedTourFlight extends Model
{
    use HasFactory;
    protected $table = 'ifatours_completedlegs';
    protected $fillable = ['user_id', 'tour_id', 'flight_id', 'pirep_id', 'completed_at'];

    protected $casts = [

    ];

    public static $rules = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
