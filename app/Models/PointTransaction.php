<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',          // reward | redeem | adjust
        'source_type',   // App\Models\Product | App\Models\Promotion | null
        'source_id',
        'points',        // + / -
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // polymorphic relation (สินค้า / โปร / อนาคต)
    public function source()
    {
        return $this->morphTo();
    }
}
