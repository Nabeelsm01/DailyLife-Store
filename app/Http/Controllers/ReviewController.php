<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\store;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // แสดงฟอร์มรีวิว
    public function create($productId)
    {
        $product = store::findOrFail($productId);
        
        // ⭐ เช็คว่าซื้อสินค้านี้หรือยัง
        $hasPurchased = Order::where('user_id', Auth::id())
                             ->whereHas('items', function($query) use ($productId) {
                                 $query->where('product_id', $productId);
                             })
                             ->whereIn('status', ['delivered'])
                             ->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'คุณต้องซื้อสินค้านี้ก่อนจึงจะรีวิวได้');
        }

        // ⭐ เช็คว่ารีวิวแล้วหรือยัง
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $productId)
                                ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'คุณรีวิวสินค้านี้แล้ว');
        }

        return view('review.create', compact('product'));
    }

    // บันทึกรีวิว
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ], [
            'rating.required' => 'กรุณาให้คะแนน',
            'rating.min' => 'คะแนนต้องอยู่ระหว่าง 1-5',
            'rating.max' => 'คะแนนต้องอยู่ระหว่าง 1-5',
        ]);

        // เช็คว่าซื้อสินค้านี้หรือยัง
        $hasPurchased = Order::where('user_id', Auth::id())
                             ->whereHas('items', function($query) use ($productId) {
                                 $query->where('product_id', $productId);
                             })
                             ->whereIn('status', ['delivered'])
                             ->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'คุณต้องซื้อสินค้านี้ก่อนจึงจะรีวิวได้');
        }

        // เช็คว่ารีวิวแล้วหรือยัง
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $productId)
                                ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'คุณรีวิวสินค้านี้แล้ว');
        }

        Review::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('p_detail.show', $productId)->with('success', 'ขอบคุณสำหรับรีวิว');
    }

    // แก้ไขรีวิว
    public function edit($id)
    {
        $review = Review::where('user_id', Auth::id())->findOrFail($id);
        return view('review.edit', compact('review'));
    }

    // อัปเดทรีวิว
    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $review = Review::where('user_id', Auth::id())->findOrFail($id);
        
        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('product.show', $review->product_id)->with('success', 'แก้ไขรีวิวเรียบร้อยแล้ว');
    }

    // ลบรีวิว
    public function destroy($id)
    {
        $review = Review::where('user_id', Auth::id())->findOrFail($id);
        $productId = $review->product_id;
        $review->delete();

        return redirect()->route('product.show', $productId)->with('success', 'ลบรีวิวเรียบร้อยแล้ว');
    }
}