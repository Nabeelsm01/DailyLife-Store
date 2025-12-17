<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ShippingController extends Controller
{
    // หน้าสำหรับขนส่งค้นหาพัสดุ
    public function index()
    {
        return view('shipping.index');
    }

    // ค้นหาพัสดุ
    public function search(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string'
        ]);

        $order = Order::whereHas('shipping', function($query) use ($request) {
            $query->where('tracking_number', $request->tracking_number);
        })
        ->with(['items', 'shipping'])
        ->first();

        if (!$order) {
            return back()->with('error', 'ไม่พบหมายเลขพัสดุนี้');
        }

        return view('shipping.detail', compact('order'));
    }

    // อัปเดทเป็นส่งสำเร็จ
    public function markDelivered($id)
    {
        $order = Order::with('shipping')->findOrFail($id);

        // เช็คว่าสถานะเป็น shipped แล้วหรือยัง
        if ($order->status != 'shipped') {
            return back()->with('error', 'พัสดุยังไม่ได้อยู่ในสถานะจัดส่ง');
        }

        // อัปเดทสถานะ
        $order->update(['status' => 'delivered']);
        
        $order->shipping->update([
            'status' => 'delivered',
            'delivered_at' => now()
        ]);

        return back()->with('success', 'อัปเดทสถานะส่งสำเร็จแล้ว');
    }

public function index_detail()
{
    $user = Auth::user();

    $order = Order::where('user_id', $user->id)
        ->latest()
        ->firstOrFail();

    return view('shipping.detail', compact('order'));
}

}