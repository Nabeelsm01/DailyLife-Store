@extends('layouts.app')
@section('title', 'ประวัติการสั่งซื้อ')
@section('content')
<div class="container my-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-clock-history"></i> ประวัติการสั่งซื้อ
    </h2>
@if($orders->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-bag-x" style="font-size: 5rem; color: #ccc;"></i>
        <h4 class="mt-3 text-muted">ยังไม่มีประวัติการสั่งซื้อ</h4>
        <a href="{{ route('welcome') }}" class="btn btn-primary mt-3">เลือกซื้อสินค้า</a>
    </div>
@else
    @foreach($orders as $order)
    <div class="bg-white rounded-3 p-4 mb-3">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h6 class="fw-bold mb-1">คำสั่งซื้อ: {{ $order->order_number }}</h6>
                <p class="text-muted small mb-0">
                    <i class="bi bi-calendar"></i> {{ $order->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            <div class="text-end">
                @if($order->status == 'pending')
                    <span class="badge bg-warning">รอดำเนินการ</span>
                @elseif($order->status == 'confirmed')
                    <span class="badge bg-info">ยืนยันแล้ว</span>
                @elseif($order->status == 'processing')
                    <span class="badge bg-primary">กำลังเตรียมสินค้า</span>
                @elseif($order->status == 'shipped')
                    <span class="badge bg-secondary">จัดส่งแล้ว</span>
                @elseif($order->status == 'delivered')
                    <span class="badge bg-success">ส่งสำเร็จ</span>
                @elseif($order->status == 'cancel_requested')
                    <span class="badge bg-warning text-dark">ส่งคำขอยเลิกแล้ว</span>
                @elseif($order->status == 'cancelled')
                    <span class="badge bg-danger">ยกเลิกแล้ว</span>
                @endif
            </div>
        </div>

        <!-- รายการสินค้าแบบย่อ -->
        <div class="mb-3">
            @foreach($order->items->take(3) as $item)
            <div class="d-flex align-items-center mb-2">
                <img src="{{ asset('storage/' . $item->product->img_prd) }}" 
                     alt="{{ $item->product_name }}" 
                     class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">
                <div class="flex-grow-1">
                    <p class="mb-0 small">{{ $item->product_name }}</p>
                    <p class="mb-0 text-muted small">x{{ $item->quantity }}</p>
                </div>
                <p class="mb-0 small">฿{{ number_format($item->subtotal, 2) }}</p>
            </div>
            @endforeach
            
            @if($order->items->count() > 3)
            <p class="text-muted small mb-0">และอีก {{ $order->items->count() - 3 }} รายการ</p>
            @endif
        </div>

        <hr>

        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p class="mb-0">ยอดรวม: <strong class="text-danger">฿{{ number_format($order->total_amount, 2) }}</strong></p>
            </div>
            <div class="d-flex gap-2">
                <!-- ⭐ ปุ่มรีวิว - แสดงเฉพาะเมื่อสถานะ delivered -->
                        @if($order->status == 'delivered')
                            @php
                                $hasReviewed = \App\Models\Review::where('user_id', Auth::id())
                                                                 ->where('product_id', $item->product_id)
                                                                 ->exists();
                            @endphp
                            
                            @if($hasReviewed)
                                <span class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle"></i> รีวิวแล้ว
                                </span>    
                            @else
                                <a href="{{ route('review.create', $item->product_id) }}" 
                                   class="btn btn-sm btn-outline-warning mt-1">
                                    <i class="bi bi-star"></i> รีวิว
                                </a>
                            @endif
                        @endif
                <a href="{{ route('order.receipt', $order->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-receipt"></i> ใบเสร็จ
                </a>
                <a href="{{ route('order.tracking', $order->id) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-truck"></i> ติดตาม
                </a>
                {{-- ปุ่มขอยกเลิก --}}
                @if(in_array($order->status, ['pending', 'confirmed']))
                    <button class="btn btn-outline-danger btn-sm "
                        data-bs-toggle="modal"
                        data-bs-target="#cancelOrderModal{{ $order->id }}">
                        <i class="bi bi-x-circle"></i> ขอยกเลิกคำสั่งซื้อ
                    </button>
                    
                @endif
                
            </div>
        </div>
    </div>
@if(in_array($order->status, ['pending', 'confirmed','processing','shipped']))
<div class="modal fade" id="cancelOrderModal{{ $order->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('orders.cancel.request', $order->id) }}">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        ยืนยันการขอยกเลิกคำสั่งซื้อ
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-2">
                        คุณต้องการยกเลิกคำสั่งซื้อ
                        <strong>#{{ $order->id }}</strong> ใช่หรือไม่
                    </p>

                    <label class="form-label">
                        หมายเหตุ / เหตุผล (ไม่บังคับ)
                    </label>
                    <textarea name="cancel_reason"
                              class="form-control"
                              rows="3"
                              placeholder="เช่น สั่งผิด, เปลี่ยนใจ, รอของไม่ทัน"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        ปิด
                    </button>

                    <button type="submit" class="btn btn-danger">
                        ยืนยันขอยกเลิก
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

    
    @endforeach

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
@endif
</div>
@endsection