<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // แสดงคำสั่งซื้อของร้าน
    public function index()
    {
        $shop = Auth::user()->shop;

        $orders = Order::whereHas('items.product', function($query) use ($shop) {
            $query->where('shop_id', $shop->id);
        })
        ->with(['items' => function($query) use ($shop) {
            $query->whereHas('product', function($q) use ($shop) {
                $q->where('shop_id', $shop->id);
            });
        }, 'user', 'payment', 'shipping'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('seller.orders', compact('orders'));
    }

    // รายละเอียดคำสั่งซื้อ
    public function show($id)
    {
        $shop = Auth::user()->shop;

        $order = Order::whereHas('items.product', function($query) use ($shop) {
            $query->where('shop_id', $shop->id);
        })
        ->with(['items.product', 'user', 'payment', 'shipping'])
        ->findOrFail($id);

        return view('seller.order_detail', compact('order'));
    }

    // อัปเดทสถานะคำสั่งซื้อ (เฉพาะร้านตัวเอง)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:confirmed,pending,processing,shipped,cancel_requested,cancelled'
        ]);

        $shop = Auth::user()->shop;

        $order = Order::whereHas('items.product', function($query) use ($shop) {
            $query->where('shop_id', $shop->id);
        })->findOrFail($id);

        $order->update(['status' => $request->status]);

        if ($request->status == 'shipped') {
            $order->shipping->update([
                'status' => 'in_transit',
                'shipped_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'อัปเดทสถานะเรียบร้อยแล้ว');
    }

    // อัปเดทหมายเลขพัสดุ
    public function updateTracking(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
            'shipping_company' => 'nullable|string|max:255'
        ]);

        $shop = Auth::user()->shop;

        $order = Order::whereHas('items.product', function($query) use ($shop) {
            $query->where('shop_id', $shop->id);
        })->findOrFail($id);

        $order->shipping->update([
            'tracking_number' => $request->tracking_number,
            'shipping_company' => $request->shipping_company ?? 'Kerry Express',
            'status' => 'in_transit',
            'shipped_at' => now()
        ]);

        $order->update(['status' => 'shipped']);

        return redirect()->back()->with('success', 'อัปเดทหมายเลขพัสดุเรียบร้อยแล้ว');
    }

    // แสดงหน้ายืนยันการส่งสำเร็จ
    public function confirmDelivery($id)
    {
        $shop = Auth::user()->shop;

        $order = Order::whereHas('items.product', function($query) use ($shop) {
            $query->where('shop_id', $shop->id);
        })
        ->with(['items.product', 'user', 'shipping'])
        ->findOrFail($id);

        return view('seller.confirm_delivery', compact('order'));
    }

    // อัปเดทเป็นส่งสำเร็จ
    public function markAsDelivered($id)
    {
        $shop = Auth::user()->shop;

        $order = Order::whereHas('items.product', function($query) use ($shop) {
            $query->where('shop_id', $shop->id);
        })->findOrFail($id);

        // อัปเดทสถานะ
        $order->update(['status' => 'delivered']);
        
        $order->shipping->update([
            'status' => 'delivered',
            'delivered_at' => now()
        ]);

        return redirect()->route('seller.orders')
                    ->with('success', 'อัปเดทสถานะเป็นส่งสำเร็จแล้ว');
    }
}