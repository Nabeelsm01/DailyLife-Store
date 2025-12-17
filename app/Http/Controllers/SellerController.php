<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\store;

class SellerController extends Controller
{
    // หน้าสมัครเป็นผู้ขาย
    public function register()
    {
        // ถ้ามีร้านแล้ว
        if (Auth::user()->hasShop()) {
            return redirect()->route('seller.dashboard')->with('info', 'คุณมีร้านค้าอยู่แล้ว');
        }

        return view('seller.register');
    }

    // บันทึกข้อมูลร้าน
    public function store(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255|unique:shops,shop_name',
            'shop_description' => 'nullable|string',
            'shop_address' => 'required|string',
            'shop_phone' => 'nullable|string|max:20',
            'shop_logo' => 'nullable|image|max:2048'
        ], [
            'shop_name.required' => 'กรุณากรอกชื่อร้านค้า',
            'shop_name.unique' => 'ชื่อร้านนี้ถูกใช้แล้ว',
            'shop_address.required' => 'กรุณากรอกที่อยู่ร้านค้า',
        ]);

        $user = Auth::user();

        // อัปโหลดโลโก้ (ถ้ามี)
        $logoPath = null;
        if ($request->hasFile('shop_logo')) {
            $logoPath = $request->file('shop_logo')->store('shop_logos', 'public');
        }

        // สร้างร้านค้า
        Shop::create([
            'user_id' => $user->id,
            'shop_name' => $request->shop_name,
            'shop_description' => $request->shop_description,
            'shop_address' => $request->shop_address,
            'shop_phone' => $request->shop_phone,
            'shop_logo' => $logoPath,
            'is_active' => true
        ]);

        // อัปเดท role เป็น seller
        $user->update(['role' => 'seller']);

        return redirect()->route('seller.dashboard')->with('success', 'สร้างร้านค้าเรียบร้อยแล้ว');
    }

    // Dashboard ผู้ขาย
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user->hasShop()) {
            return redirect()->route('seller.register')->with('error', 'กรุณาสร้างร้านค้าก่อน');
        }

        $shop = $user->shop;
        $products = store::where('shop_id', $shop->id)->paginate(10);

        return view('seller.dashboard', compact('shop', 'products'));
    }

    // แก้ไขข้อมูลร้าน
    public function editShop()
    {
        $shop = Auth::user()->shop;
        return view('seller.edit_shop', compact('shop'));
    }

    // อัปเดทข้อมูลร้าน
    public function updateShop(Request $request)
    {
        $shop = Auth::user()->shop;

        $request->validate([
            'shop_name' => 'required|string|max:255|unique:shops,shop_name,' . $shop->id,
            'shop_description' => 'nullable|string',
            'shop_address' => 'required|string',
            'shop_phone' => 'nullable|string|max:20',
            'shop_logo' => 'nullable|image|max:2048'
        ]);

        $data = $request->only(['shop_name', 'shop_description', 'shop_address', 'shop_phone']);

        // อัปโหลดโลโก้ใหม่ (ถ้ามี)
        if ($request->hasFile('shop_logo')) {
            // ลบโลโก้เก่า
            if ($shop->shop_logo) {
                \Storage::disk('public')->delete($shop->shop_logo);
            }
            $data['shop_logo'] = $request->file('shop_logo')->store('shop_logos', 'public');
        }

        $shop->update($data);

        return redirect()->route('seller.dashboard')->with('success', 'อัปเดทข้อมูลร้านเรียบร้อยแล้ว');
    }
}