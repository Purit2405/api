<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\PointTransaction;

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
        return $this->hasMany(PointTransaction::class, 'user_id', 'user_id')
            ->latest();
    }

    /* =======================
     | Static Helper
     ======================= */

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
        string $type = PointTransaction::TYPE_REWARD,
        string $sourceType = PointTransaction::SOURCE_MANUAL,
        ?int $sourceId = null,
        ?string $description = null
    ): void {
        DB::transaction(function () use (
            $points, $type, $sourceType, $sourceId, $description
        ) {
            $wallet = self::where('id', $this->id)
                ->lockForUpdate()
                ->first();

            $wallet->increment('balance', $points);

            PointTransaction::create([
                'user_id'     => $wallet->user_id,
                'type'        => $type,
                'source_type' => $sourceType, // ✅ string enum เท่านั้น
                'source_id'   => $sourceId,
                'points'      => $points,
                'description' => $description,
            ]);
        });
    }

    /**
     * ใช้แต้ม
     */
    public function spendPoints(
        int $points,
        string $type = PointTransaction::TYPE_REDEEM,
        string $sourceType = PointTransaction::SOURCE_MANUAL,
        ?int $sourceId = null,
        ?string $description = null
    ): void {
        DB::transaction(function () use (
            $points, $type, $sourceType, $sourceId, $description
        ) {
            $wallet = self::where('id', $this->id)
                ->lockForUpdate()
                ->first();

            if ($wallet->balance < $points) {
                throw new \Exception('แต้มไม่เพียงพอ');
            }

            $wallet->decrement('balance', $points);

            PointTransaction::create([
                'user_id'     => $wallet->user_id,
                'type'        => $type,
                'source_type' => $sourceType, // ✅
                'source_id'   => $sourceId,
                'points'      => -$points,
                'description' => $description,
            ]);
        });
    }
}
