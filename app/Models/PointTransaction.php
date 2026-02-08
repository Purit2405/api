<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
use App\Models\Promotion;

class PointTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'source_type',
        'source_id',
        'points',
        'description',
    ];

    /* =======================
     | CONSTANTS
     ======================= */

    public const TYPE_REWARD = 'reward';
    public const TYPE_REDEEM = 'redeem';
    public const TYPE_ADJUST = 'adjust';

    public const SOURCE_PRODUCT   = 'product';
    public const SOURCE_PROMOTION = 'promotion';
    public const SOURCE_MANUAL    = 'manual';

    /* =======================
     | RELATIONSHIPS
     ======================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* =======================
     | ACCESSORS (สำคัญ)
     ======================= */

    /**
     * ใช้เป็น $transaction->source
     */
    public function getSourceAttribute()
    {
        return match ($this->source_type) {
            self::SOURCE_PRODUCT =>
                Product::find($this->source_id),

            self::SOURCE_PROMOTION =>
                Promotion::find($this->source_id),

            default => null,
        };
    }

    public function getSourceNameAttribute(): string
    {
        if (! $this->source) return '-';

        return match ($this->source_type) {
            self::SOURCE_PRODUCT   => $this->source->name,
            self::SOURCE_PROMOTION => $this->source->title,
            default => 'ปรับแต้มโดยระบบ',
        };
    }
}
