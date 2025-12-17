@extends('layouts.app')
@section('title', 'ยืนยันการสั่งซื้อ')

@section('content')
<div class="container my-5">
    <div class="text-center mb-4">
        <div class="mb-3">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
        </div>
        <h2 class="fw-bold text-success">สั่งซื้อสำเร็จ!</h2>
        <p class="text-muted">ขอบคุณที่ใช้บริการ DailyLife Store</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- ข้อมูลคำสั่งซื้อ -->
            <div class="bg-white rounded-3 p-4 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">รายละเอียดคำสั่งซื้อ</h5>
                    <span class="badge bg-warning text-dark">รอดำเนินการ</span>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>หมายเลขคำสั่งซื้อ:</strong></p>
                        <p class="text-primary">{{ $order->order_number }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>วันที่สั่งซื้อ:</strong></p>
                        <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <hr>

                <!-- ข้อมูลผู้รับ -->
                <h6 class="fw-bold mb-3">ข้อมูลผู้รับสินค้า</h6>
                <p class="mb-1"><strong>ชื่อ:</strong> {{ $order->customer_name }}</p>
                <p class="mb-1"><strong>เบอร์โทร:</strong> {{ $order->customer_phone }}</p>
                <p class="mb-3"><strong>ที่อยู่:</strong> {{ $order->shipping_address }}</p>

                <hr>

                <!-- รายการสินค้า -->
                <h6 class="fw-bold mb-3">รายการสินค้า</h6>
                @foreach($order->items as $item)
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('storage/' . $item->product->img_prd) }}" 
                         alt="{{ $item->product_name }}" 
                         class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $item->product_name }}</h6>
                        <p class="text-muted mb-0">฿{{ number_format($item->price, 2) }} x {{ $item->quantity }}</p>
                    </div>
                    <p class="fw-bold mb-0">฿{{ number_format($item->subtotal, 2) }}</p>
                </div>
                @endforeach

                <hr>

                <!-- สรุปยอด -->
                <div class="d-flex justify-content-between mb-2">
                    <span>ยอดรวมสินค้า</span>
                    <span>฿{{ number_format($order->items->sum('subtotal'), 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>ค่าจัดส่ง</span>
                    <span>฿{{ number_format($order->shipping->shipping_cost, 2) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <h5 class="fw-bold">ยอดรวมทั้งหมด</h5>
                    <h5 class="fw-bold text-danger">฿{{ number_format($order->total_amount, 2) }}</h5>
                </div>
            </div>

            <!-- วิธีการชำระเงิน -->
            <div class="bg-white rounded-3 p-4 mb-3">
                <h6 class="fw-bold mb-3">วิธีการชำระเงิน</h6>
                <p class="mb-0">
                    @if($order->payment->payment_method == 'cash_on_delivery')
                        <span class="badge bg-info">เก็บเงินปลายทาง</span>
                    @elseif($order->payment->payment_method == 'bank_transfer')
                        <span class="badge bg-success">โอนเงินผ่านธนาคาร</span>
                    @elseif($order->payment->payment_method == 'promptpay')
                        <span class="badge bg-primary">พร้อมเพย์</span>
                    @endif
                </p>

                @if($order->payment->payment_proof)
                <div class="mt-3">
                    <p class="mb-2"><strong>หลักฐานการโอนเงิน:</strong></p>
                    <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" 
                         alt="หลักฐานการโอน" class="img-fluid rounded" style="max-width: 300px;">
                </div>
                @endif
            </div>

            <!-- ปุ่มดำเนินการ -->
            <div class="d-flex gap-2">
                <a href="{{ route('order.receipt', $order->id) }}" class="btn btn-primary flex-fill">
                    <i class="bi bi-receipt"></i> ดูใบเสร็จ
                </a>
                <a href="{{ route('order.tracking', $order->id) }}" class="btn btn-outline-primary flex-fill">
                    <i class="bi bi-truck"></i> ติดตามพัสดุ
                </a>
                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary flex-fill">
                    <i class="bi bi-house"></i> กลับหน้าแรก
                </a>
            </div>
        </div>
    </div>
</div>
@endsection