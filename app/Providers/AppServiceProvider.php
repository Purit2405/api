<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\PointWallet;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ สร้างกระเป๋าแต้มอัตโนมัติ เมื่อมีผู้ใช้ใหม่
        User::created(function ($user) {
            PointWallet::create([
                'user_id' => $user->id,
                'balance' => 0,
            ]);
        });
    }
}
