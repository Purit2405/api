<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PointWallet extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'integer',
    ];

    /* =======================
     | Relationships
     ======================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(PointTransaction::class, 'user_id', 'user_id');
    }

    /* =======================
     | Static Helper
     ======================= */

    /**
     * ดึง wallet ของ user (ถ้าไม่มีจะสร้างให้)
     */
    public static function ofUser(int $userId): self
    {
        return self::firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0]
        );
    }

    /* =======================
     | Business Logic
     ======================= */

    /**
     * เพิ่มแต้ม
     */
    public function addPoints(
        int $points,
        string $type = 'earn',
        ?string $sourceType = null,
        ?int $sourceId = null,
        ?string $description = null
    ): void {
        DB::transaction(function () use ($points, $type, $sourceType, $sourceId, $description) {

            $this->increment('balance', $points);

            PointTransaction::create([
                'user_id'     => $this->user_id,
                'type'        => $type,
                'source_type' => $sourceType,
                'source_id'   => $sourceId,
                'points'      => $points,
                'description' => $description,
            ]);
        });
    }

    /**
     * ใช้แต้ม (แลกสินค้า / โปรโมชั่น)
     */
    public function spendPoints(
        int $points,
        string $type = 'redeem',
        ?string $sourceType = null,
        ?int $sourceId = null,
        ?string $description = null
    ): void {
        if ($this->balance < $points) {
            throw new \Exception('แต้มไม่เพียงพอ');
        }

        DB::transaction(function () use ($points, $type, $sourceType, $sourceId, $description) {

            $this->decrement('balance', $points);

            PointTransaction::create([
                'user_id'     => $this->user_id,
                'type'        => $type,
                'source_type' => $sourceType,
                'source_id'   => $sourceId,
                'points'      => -$points,
                'description' => $description,
            ]);
        });
    }
}
