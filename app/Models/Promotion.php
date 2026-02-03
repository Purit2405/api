<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function usages()
    {
        return $this->hasMany(PromotionUsage::class);
    }

    // ✅ เช็กสิทธิ์การแลก
    public function canRedeem(User $user): bool
    {
        if (!$this->is_active) return false;

        // จำกัดทั้งระบบ
        if (!is_null($this->max_total)) {
            if ($this->usages()->count() >= $this->max_total) {
                return false;
            }
        }

        // จำกัดต่อคน
        if (!is_null($this->max_per_user)) {
            $used = $this->usages()
                ->where('user_id', $user->id)
                ->count();

            if ($used >= $this->max_per_user) {
                return false;
            }
        }

        return true;
    }
}
