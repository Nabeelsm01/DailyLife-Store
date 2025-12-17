<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    // แสดงรายการคำสั่งซื้อทั้งหมด
    public function index()
    {
        $orders = Order::with(['user', 'items', 'payment', 'shipping'])
                       ->orderBy('created_at', 'desc')
                       ->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    // แสดงรายละเอียดคำสั่งซื้อ
    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'payment', 'shipping'])
                      ->findOrFail($id);

        return view('admin.order_detail', compact('order'));
    }

    // อัปเดทสถานะคำสั่งซื้อ
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        // อัปเดทสถานะการจัดส่งตามสถานะคำสั่งซื้อ
        if ($request->status == 'confirmed') {
            $order->shipping->update(['status' => 'processing']);
        } elseif ($request->status == 'shipped') {
            $order->shipping->update([
                'status' => 'in_transit',
                'shipped_at' => now()
            ]);
        } elseif ($request->status == 'delivered') {
            $order->shipping->update([
                'status' => 'delivered',
                'delivered_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'อัปเดทสถานะเรียบร้อยแล้ว');
    }

    // อัปเดทหมายเลขพัสดุ
    public function updateTracking(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
            'shipping_company' => 'required|string|max:255'
        ]);

        $order = Order::findOrFail($id);
        
        $order->shipping->update([
            'tracking_number' => $request->tracking_number,
            'shipping_company' => $request->shipping_company,
            'status' => 'in_transit',
            'shipped_at' => now()
        ]);

        $order->update(['status' => 'shipped']);

        return redirect()->back()->with('success', 'อัปเดทหมายเลขพัสดุเรียบร้อยแล้ว');
    }

    // ยกเลิกคำสั่งซื้อ (คืนสต็อก)
    public function cancel($id)
    {
        $order = Order::with('items')->findOrFail($id);

        if ($order->status == 'delivered') {
            return redirect()->back()->with('error', 'ไม่สามารถยกเลิกคำสั่งซื้อที่ส่งสำเร็จแล้ว');
        }

        DB::beginTransaction();
        try {
            // ⭐ คืนสต็อกสินค้า
            foreach ($order->items as $item) {
                $product = store::find($item->product_id);
                if ($product) {
                    $product->increment('stock_prd', $item->quantity);
                }
            }

            // อัปเดทสถานะ
            $order->update(['status' => 'cancelled']);
            $order->payment->update(['status' => 'failed']);

            DB::commit();

            return redirect()->back()->with('success', 'ยกเลิกคำสั่งซื้อและคืนสต็อกเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
}