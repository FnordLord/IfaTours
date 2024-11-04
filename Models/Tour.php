<?php

namespace Modules\IfaTours\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Contracts\Model;
use App\Models\Award;

/**
 * Class Tour
 * @package Modules\IfaTours\Models
 */

class Tour extends Model
{
    use HasFactory;

    protected $table = 'ifatours_tours';

    protected $fillable = [
        'name',
        'teaser_img',
        'teaser_txt',
        'description',
        'award_id',
    ];

    public function award()
    {
        return $this->belongsTo(Award::class, 'award_id');
    }

    public function legs()
    {
        return $this->hasMany(TourLeg::class, 'tour_id');
    }

    public function progress()
    {
        return $this->hasMany(TourProgress::class, 'tour_id');
    }
}
