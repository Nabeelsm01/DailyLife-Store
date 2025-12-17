<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // หน้ายืนยันการสั่งซื้อ
    public function confirmation($id)
    {
        $order = Order::with(['items.product', 'payment', 'shipping'])
                      ->where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        return view('order_confirmation', compact('order'));
    }

    // หน้าใบเสร็จ/รายละเอียดคำสั่งซื้อ
    public function receipt($id)
    {
        $order = Order::with(['items.product', 'payment', 'shipping'])
                      ->where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        return view('order_receipt', compact('order'));
    }

    // ประวัติการสั่งซื้อ
    public function history()
    {
        $orders = Order::with(['items', 'payment', 'shipping'])
                       ->where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        return view('order_history', compact('orders'));
    }

    // ติดตามพัสดุ
    public function tracking($id)
    {
        $order = Order::with(['shipping'])
                      ->where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        return view('order_tracking', compact('order'));
    }

public function cancelRequest(Request $request, $id)
{
    $order = Order::where('id', $id)
        ->where('user_id', auth()->id())
        ->whereIn('status', ['pending', 'confirmed'])
        ->firstOrFail();

    $order->update([
        'status' => 'cancel_requested',
        'cancel_reason' => $request->cancel_reason,
    ]);

    return redirect()->back()->with('success', 'ส่งคำขอยกเลิกเรียบร้อยแล้ว');
}



}