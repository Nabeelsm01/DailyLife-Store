<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\store;
use Illuminate\Support\Facades\Log;      // ⭐ เพิ่มบรรทัดนี้
use Illuminate\Support\Facades\Storage; // ⭐ เพิ่มบรรทัดนี้ (ถ้ายังไม่มี)


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except([
            'welcome',
            'show',
            'all_product'
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function indexs(){
        $users=DB::table('users')->get();
        return view('home', compact('users'));
    }
    public function product_form(){
        $user = auth()->user(); // ← รับ User object

        // ⭐ เช็คว่ามีร้านหรือไม่
        if (!$user->hasShop()) {
            return redirect()->route('seller.register')->with('error', 'กรุณาสร้างร้านค้าก่อนเพิ่มสินค้า');
        }
        return view('p_form');
    }
    
public function p_insert(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|integer',
        'stock' => 'nullable|integer',
        'promotion_type' => 'nullable|string',
        'promotion_value' => 'nullable|integer',
        'image' => 'nullable|image|max:5120',
        'category' => 'nullable|string',
    ]);

    try {
        // ⭐ เปลี่ยนจาก auth()->id() เป็น auth()->user()
        $user = auth()->user(); // ← รับ User object

        // ⭐ เช็คว่ามีร้านหรือไม่
        if (!$user->hasShop()) {
            return redirect()->route('seller.register')->with('error', 'กรุณาสร้างร้านค้าก่อนเพิ่มสินค้า');
        }
       
        $imgPath = null;
        if ($request->hasFile('image')) {
            $imgPath = $request->file('image')->store('products', 'public');
        }

        $data = [
            'user_id' => $user->id,           // ⭐ ใช้ $user->id
            'shop_id' => $user->shop->id,     // ⭐ ใช้ $user->shop->id
            'name_prd' => $request->name,
            'detail_prd' => $request->description,
            'price_prd' => $request->price,
            'stock_prd' => $request->stock ?? 0,
            'promotion_type' => $request->promotion_type,
            'promotion_value' => $request->promotion_value,
            'img_prd' => $imgPath,
            'category_prd' => $request->category,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('products')->insert($data);

        return redirect()->route('seller.dashboard')->with('success', 'เพิ่มสินค้าสำเร็จ!');
        
    } catch (\Throwable $e) {
        Log::error('p_insert failed: '.$e->getMessage());
        return back()->withErrors(['msg' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
    }
}

public function welcome(){
    $products = store::all();// ดึงสินค้าทั้งหมด
    return view('welcome', compact('products')); // ส่งตัวแปร $products ไป Blade
}

public function show($id)
{
    $product = store::findOrFail($id);
    $products = store::where('id', '!=', $id)->take(4)->get(); // สินค้าแนะนำ
    
    return view('p_detail', compact('product', 'products'));
}

// หน้าแก้ไขสินค้า
    public function product_edit($id)
    {
        $product = store::findOrFail($id);
        
        // ⭐ เช็คว่าเป็นของร้านตัวเองหรือไม่
        if ($product->shop_id !== auth()->user()->shop->id) {
            return redirect()->route('seller.dashboard')->with('error', 'คุณไม่มีสิทธิ์แก้ไขสินค้านี้');
        }

        return view('p_edit', compact('product'));
    }

    // อัปเดทสินค้า
    public function product_update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer',
            'stock' => 'nullable|integer',
            'promotion_type' => 'nullable|string',
            'promotion_value' => 'nullable|integer',
            'image' => 'nullable|image|max:5120',
            'category' => 'nullable|string',
        ]);

        try {
            $product = store::findOrFail($id);
            
            // ⭐ เช็คว่าเป็นของร้านตัวเองหรือไม่
            if ($product->shop_id !== auth()->user()->shop->id) {
                return redirect()->route('seller.dashboard')->with('error', 'คุณไม่มีสิทธิ์แก้ไขสินค้านี้');
            }

            $data = [
                'name_prd' => $request->name,
                'detail_prd' => $request->description,
                'price_prd' => $request->price,
                'stock_prd' => $request->stock ?? 0,
                'promotion_type' => $request->promotion_type,
                'promotion_value' => $request->promotion_value,
                'category_prd' => $request->category,
            ];

            // ถ้ามีอัปโหลดรูปใหม่
            if ($request->hasFile('image')) {
                // ลบรูปเก่า
                if ($product->img_prd) {
                    Storage::disk('public')->delete($product->img_prd);
                }
                // อัปโหลดรูปใหม่
                $data['img_prd'] = $request->file('image')->store('products', 'public');
            }

            $product->update($data);

            return redirect()->route('seller.dashboard')->with('success', 'แก้ไขสินค้าเรียบร้อยแล้ว');
            
        } catch (\Throwable $e) {
            Log::error('product_update failed: '.$e->getMessage());
            return back()->withErrors(['msg' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
        }
    }

    // ลบสินค้า
    public function product_delete($id)
    {
        try {
            $product = store::findOrFail($id);
            
            // ⭐ เช็คว่าเป็นของร้านตัวเองหรือไม่
            if ($product->shop_id !== auth()->user()->shop->id) {
                return redirect()->route('seller.dashboard')->with('error', 'คุณไม่มีสิทธิ์ลบสินค้านี้');
            }

            // ลบรูปภาพ
            if ($product->img_prd) {
                Storage::disk('public')->delete($product->img_prd);
            }

            $product->delete();

            return redirect()->route('seller.dashboard')->with('success', 'ลบสินค้าเรียบร้อยแล้ว');
            
        } catch (\Throwable $e) {
            Log::error('product_delete failed: '.$e->getMessage());
            return back()->withErrors(['msg' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()]);
        }
    }
    //    public function all_product(){
    //      $products = store::all();// ดึงสินค้าทั้งหมด
    //      return view('all-product', compact('products')); // ส่งตัวแปร $products ไป Blade
    // } 
    public function all_product(Request $request){
        
        $query = store::query();

        // ⭐ Filter ตามหมวดหมู่
        if ($request->has('category') && $request->category != '') {
            $query->where('category_prd', $request->category);
        }

        // ⭐ Filter ตามราคา
        if ($request->has('price_min') && $request->price_min != '') {
            $query->where('price_prd', '>=', $request->price_min);
        }
        if ($request->has('price_max') && $request->price_max != '') {
            $query->where('price_prd', '<=', $request->price_max);
        }

        // ⭐ Filter ตามช่วงราคา (Quick filters)
        if ($request->has('price_range')) {
            switch($request->price_range) {
                case 'under_100':
                    $query->where('price_prd', '<', 100);
                    break;
                case '100_500':
                    $query->whereBetween('price_prd', [100, 500]);
                    break;
                case '500_1000':
                    $query->whereBetween('price_prd', [500, 1000]);
                    break;
                case 'over_1000':
                    $query->where('price_prd', '>', 1000);
                    break;
            }
        }

        // ⭐ Filter ตามสต็อก
        if ($request->has('stock') && $request->stock == 'available') {
            $query->where('stock_prd', '>', 0);
        }

        // ⭐ Filter ตามเรตติ้ง
        if ($request->has('rating') && $request->rating != '') {
            $query->whereHas('reviews', function($q) use ($request) {
                $q->havingRaw('AVG(rating) >= ?', [$request->rating]);
            });
        }

        // ⭐ เรียงลำดับ
        $sort = $request->get('sort', 'latest');
        switch($sort) {
            case 'price_low':
                $query->orderBy('price_prd', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_prd', 'desc');
                break;
            case 'popular':
                $query->withSum(
                    ['orderItems as total_sold' => function ($q) {
                        $q->whereHas('order', function ($order) {
                            $order->whereIn('status', ['delivered', 'shipped', 'processing']);
                        });
                    }],
                    'quantity'
                )->orderByDesc('total_sold');
                break;
            case 'rating':
                // เรียงตามเรตติ้ง
                $query->withAvg('reviews as avg_rating', 'rating')
                    ->orderByDesc('avg_rating');
                break;
            case 'name':
                $query->orderBy('name_prd', 'asc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(24);

        // ดึงหมวดหมู่ทั้งหมดที่มีในฐานข้อมูล
        $categories = store::select('category_prd')
                        ->whereNotNull('category_prd')
                        ->where('category_prd', '!=', '')
                        ->distinct()
                        ->pluck('category_prd');

        return view('all-product', compact('products', 'categories'));
    }

}