<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\store;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // แสดงตะกร้าสินค้า
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        
        // คำนวณเฉพาะที่เลือก
        $selectedCarts = $carts->where('selected', true);
        $total = $selectedCarts->sum(function($cart) {
            return $cart->product->price_prd * $cart->quantity;
        });
        
        return view('cart', compact('carts', 'total'));
    }

    // เพิ่มสินค้าลงตะกร้า
    public function add(Request $request, $productId)
    {
        $product = store::findOrFail($productId);
        
        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

        if ($cart) {
            $cart->quantity += $request->quantity ?? 1;
            $cart->save();
            $message = 'เพิ่มจำนวนสินค้าในตะกร้าแล้ว';
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $request->quantity ?? 1,
                'selected' => false
            ]);
            $message = 'เพิ่มสินค้าลงตะกร้าแล้ว';
        }

        return redirect()->back()->with('cart_success', $message); // เปลี่ยนเป็น cart_success
    }

    // อัพเดทจำนวนสินค้า
    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->quantity = $request->quantity;
        $cart->save();

        return redirect()->back()->with('cart_success', 'อัพเดทจำนวนสินค้าแล้ว');
    }

    // เลือก/ยกเลิกเลือกสินค้า
    public function toggleSelect($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->selected = !$cart->selected;
        $cart->save();

        return redirect()->back();
    }

    // เลือกทั้งหมด
    public function selectAll()
    {
        Cart::where('user_id', Auth::id())->update(['selected' => true]);
        return redirect()->back();
    }

    // ยกเลิกเลือกทั้งหมด
    public function unselectAll()
    {
        Cart::where('user_id', Auth::id())->update(['selected' => false]);
        return redirect()->back();
    }

    // ลบสินค้าออกจากตะกร้า
    public function remove($id)
    {
        Cart::findOrFail($id)->delete();
        return redirect()->back()->with('cart_success', 'ลบสินค้าออกจากตะกร้าแล้ว');
    }

    // ซื้อเลย (ไม่เกี่ยวกับตะกร้า)
    public function buyNow(Request $request, $productId)
    {
        $product = store::findOrFail($productId);
        
        // เก็บข้อมูลใน Session (ไม่ใส่ Database)
        session([
            'buy_now' => [
                'product_id' => $productId,
                'quantity' => $request->quantity ?? 1
            ]
        ]);

        return redirect()->route('checkout.buyNow');
    }
}