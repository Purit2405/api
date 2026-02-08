<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PromotionUsage;
use App\Models\PointTransaction;

class Promotion extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'points_value',
        'max_total',
        'max_per_user',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /* =======================
     | Relationships
     ======================= */

    public function usages()
    {
        return $this->hasMany(PromotionUsage::class);
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class, 'source_id')
            ->where('source_type', PointTransaction::SOURCE_PROMOTION);
    }

    /* =======================
     | Business Logic
     ======================= */

    public function canRedeem(User $user): bool
    {
        if (! $this->is_active) {
            return false;
        }

        // จำกัดจำนวนใช้รวม
        if (!is_null($this->max_total)) {
            $totalUsed = PromotionUsage::where('promotion_id', $this->id)->count();

            if ($totalUsed >= $this->max_total) {
                return false;
            }
        }

        // จำกัดจำนวนใช้ต่อคน
        if (!is_null($this->max_per_user)) {
            $usedByUser = PromotionUsage::where('promotion_id', $this->id)
                ->where('user_id', $user->id)
                ->count();

            if ($usedByUser >= $this->max_per_user) {
                return false;
            }
        }

        return true;
    }
}
