<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'is_active',
        'points_required',
        'redeemable',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'redeemable' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ใช้ต่อกับระบบแต้มได้ตามเดิม
    public function pointTransactions()
    {
        return $this->morphMany(PointTransaction::class, 'source');
    }
    protected static function booted()
{
    static::addGlobalScope('active_category', function (Builder $builder) {
        $builder->whereHas('category', function ($q) {
            $q->where('is_active', true);
        });
    });
}
}
