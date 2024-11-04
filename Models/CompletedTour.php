<?php

namespace Modules\IfaTours\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedTour extends Model
{
    use HasFactory;

    protected $table = 'ifatours_completedtours';
    protected $fillable = ['user_id', 'tour_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
