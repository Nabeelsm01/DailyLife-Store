<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // หน้าชำระเงินจากตะกร้า (เฉพาะที่เลือก)
    public function index()
    {
        $carts = Cart::with('product')
                     ->where('user_id', Auth::id())
                     ->where('selected', true) // เฉพาะที่เลือก
                     ->get();
        
        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'กรุณาเลือกสินค้าที่ต้องการซื้อ');
        }

        $subtotal = $carts->sum(function($cart) {
            return $cart->product->price_prd * $cart->quantity;
        });
        
        $shippingCost = 50;
        $total = $subtotal + $shippingCost;

        return view('checkout', compact('carts', 'subtotal', 'shippingCost', 'total'));
    }

    // หน้าชำระเงินสำหรับ "ซื้อเลย"
    public function buyNow()
    {
        if (!session()->has('buy_now')) {
            return redirect()->route('welcome')->with('error', 'ไม่พบข้อมูลสินค้า');
        }

        $buyNowData = session('buy_now');
        $product = store::findOrFail($buyNowData['product_id']);
        
        // สร้าง object คล้าย cart
        $carts = collect([
            (object)[
                'product' => $product,
                'quantity' => $buyNowData['quantity']
            ]
        ]);

        $subtotal = $product->price_prd * $buyNowData['quantity'];
        $shippingCost = 50;
        $total = $subtotal + $shippingCost;

        return view('checkout', compact('carts', 'subtotal', 'shippingCost', 'total'));
    }

    // ประมวลผลการสั่งซื้อ
    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cash_on_delivery,bank_transfer,credit_card,promptpay',
            'payment_proof' => 'nullable|image|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // เช็คว่าเป็น Buy Now หรือจากตะกร้า
            if (session()->has('buy_now')) {
                // กรณี Buy Now
                $buyNowData = session('buy_now');
                $product = store::findOrFail($buyNowData['product_id']);

                 // ⭐ เช็คสต็อก
                if ($product->stock_prd < $buyNowData['quantity']) {
                    throw new \Exception('สินค้ามีไม่เพียงพอ (เหลือ ' . $product->stock_prd . ' ชิ้น)');
                }
                
                $items = collect([
                    (object)[
                        'product' => $product,
                        'product_id' => $product->id,
                        'quantity' => $buyNowData['quantity']
                    ]
                ]);

                $subtotal = $product->price_prd * $buyNowData['quantity'];
            } else {
                // กรณีจากตะกร้า
                $items = Cart::with('product')
                             ->where('user_id', Auth::id())
                             ->where('selected', true)
                             ->get();
                
                if ($items->isEmpty()) {
                    throw new \Exception('ไม่พบสินค้าที่เลือก');
                }

                // ⭐ เช็คสต็อกทุกรายการ
                foreach ($items as $item) {
                    if ($item->product->stock_prd < $item->quantity) {
                        throw new \Exception('สินค้า ' . $item->product->name_prd . ' มีไม่เพียงพอ (เหลือ ' . $item->product->stock_prd . ' ชิ้น)');
                    }
                }

                $subtotal = $items->sum(function($cart) {
                    return $cart->product->price_prd * $cart->quantity;
                });
            }

            $shippingCost = 50;
            $total = $subtotal + $shippingCost;

            // สร้างคำสั่งซื้อ
            $order = Order::create([
                'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'pending',
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address
            ]);

             // สร้างรายการสินค้า และ ⭐ ลดสต็อก
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id ?? $item->product->id,
                    'product_name' => $item->product->name_prd,
                    'price' => $item->product->price_prd,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->price_prd * $item->quantity
                ]);

                // ⭐ ลดสต็อกสินค้า
                $product = store::find($item->product_id ?? $item->product->id);
                $product->decrement('stock_prd', $item->quantity);
            }

            // บันทึกการชำระเงิน
            $paymentProof = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProof = $request->file('payment_proof')->store('payments', 'public');
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $total,
                'status' => 'pending',
                'payment_proof' => $paymentProof
            ]);

            // สร้างข้อมูลการจัดส่ง
            Shipping::create([
                'order_id' => $order->id,
                'shipping_company' => 'Kerry Express',
                'shipping_cost' => $shippingCost,
                'status' => 'pending'
            ]);

            // ลบสินค้าที่เลือกออกจากตะกร้า (ถ้าซื้อจากตะกร้า)
            if (!session()->has('buy_now')) {
                Cart::where('user_id', Auth::id())
                    ->where('selected', true)
                    ->delete();
            } else {
                // ลบ session buy_now
                session()->forget('buy_now');
            }

            DB::commit();

            return redirect()->route('order.confirmation', $order->id)
                           ->with('success', 'สั่งซื้อสินค้าเรียบร้อยแล้ว');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
}