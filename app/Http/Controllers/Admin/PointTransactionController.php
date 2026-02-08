<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointTransaction;
use App\Models\PointWallet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointTransactionController extends Controller
{
    /**
     * แสดงประวัติแต้ม
     */
    public function index()
    {
        $transactions = PointTransaction::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.point-transactions.index', compact('transactions'));
    }

    /**
     * หน้าเพิ่มแต้ม
     */
    public function create()
    {
        return view('admin.point-transactions.create');
    }

    /**
     * 🔍 ค้นหาผู้ใช้จากเบอร์ (AJAX)
     */
    public function findUser(Request $request)
    {
        $phone = $request->query('phone');

        if (! $phone) {
            return response()->json([
                'found' => false
            ]);
        }

        $user = User::where('phone', $phone)->first();

        if (! $user) {
            return response()->json([
                'found' => false
            ]);
        }

        return response()->json([
            'found' => true,
            'id'    => $user->id,
            'name'  => $user->name,
        ]);
    }

    /**
     * บันทึกการเพิ่มแต้ม
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone'  => 'required',
            'points' => 'required|integer|min:1',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (! $user) {
            return back()->withErrors([
                'phone' => 'ไม่พบผู้ใช้เบอร์นี้',
            ]);
        }

        DB::transaction(function () use ($user, $request) {

            // wallet
            $wallet = PointWallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0]
            );

            // เพิ่มแต้ม
            $wallet->increment('balance', $request->points);

            // log
            PointTransaction::create([
                'user_id'     => $user->id,
                'type'        => PointTransaction::TYPE_REWARD,
                'source_type' => PointTransaction::SOURCE_MANUAL,
                'source_id'   => null,
                'points'      => $request->points,
                'description' => $request->description ?: 'เพิ่มแต้มโดยแอดมิน',
            ]);
        });

        return redirect()
            ->route('admin.point-transactions.index')
            ->with('success', 'เพิ่มแต้มเรียบร้อยแล้ว');
    }
}
