@extends('layouts.app')
@section('title', 'ยืนยันการส่งสำเร็จ')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="bg-white rounded-3 shadow p-4">
                <!-- ไอคอน -->
                <div class="text-center mb-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 100px; height: 100px;">
                        <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="fw-bold">ยืนยันการส่งสำเร็จ</h3>
                    <p class="text-muted">กรุณายืนยันว่าสินค้าถึงมือลูกค้าเรียบร้อยแล้ว</p>
                </div>

                <!-- ข้อมูลคำสั่งซื้อ -->
                <div class="bg-light rounded-3 p-3 mb-4">
                    <h6 class="fw-bold mb-3">ข้อมูลคำสั่งซื้อ</h6>
                    
                    <div class="mb-2">
                        <small class="text-muted">เลขคำสั่งซื้อ:</small>
                        <p class="mb-0 fw-bold">{{ $order->order_number }}</p>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">ลูกค้า:</small>
                        <p class="mb-0">{{ $order->customer_name }}</p>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">เบอร์โทร:</small>
                        <p class="mb-0">{{ $order->customer_phone }}</p>
                    </div>

                    @if($order->shipping->tracking_number)
                    <div class="mb-2">
                        <small class="text-muted">หมายเลขพัสดุ:</small>
                        <p class="mb-0">{{ $order->shipping->tracking_number }}</p>
                    </div>
                    @endif

                    <div>
                        <small class="text-muted">ที่อยู่จัดส่ง:</small>
                        <p class="mb-0">{{ $order->shipping_address }}</p>
                    </div>
                </div>

                <!-- สินค้าในคำสั่งซื้อ -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3">รายการสินค้า</h6>
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('storage/' . $item->product->img_prd) }}" 
                             alt="{{ $item->product_name }}"
                             class="rounded me-2" 
                             style="width: 50px; height: 50px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <p class="mb-0 small">{{ $item->product_name }}</p>
                            <small class="text-muted">x{{ $item->quantity }}</small>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- คำเตือน -->
                <div class="alert alert-warning mb-4">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>คำเตือน:</strong> เมื่อยืนยันแล้วจะไม่สามารถแก้ไขสถานะได้
                </div>

                <!-- ปุ่ม -->
                <form action="{{ route('seller.orders.markDelivered', $order->id) }}" method="POST">
                    @csrf
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg" 
                                onclick="return confirm('ยืนยันว่าสินค้าถึงมือลูกค้าเรียบร้อยแล้ว?')">
                            <i class="bi bi-check-circle"></i> ยืนยันส่งสำเร็จ
                        </button>
                        <a href="{{ route('seller.orders.show', $order->id) }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> ยกเลิก
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection