@extends('layouts.app')
@section('title', 'รายละเอียดพัสดุ')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <!-- Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- รายละเอียดพัสดุ -->
            <div class="bg-white rounded-3 shadow p-4 mb-3">
                <div class="text-center mb-4">
                    @if($order->status == 'delivered')
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-check-circle text-success" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="fw-bold text-success">ส่งสำเร็จแล้ว</h4>
                    @else
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-truck text-warning" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="fw-bold">กำลังจัดส่ง</h4>
                    @endif
                </div>

                <!-- ข้อมูลพัสดุ -->
                <div class="mb-3">
                    <h6 class="fw-bold mb-3">ข้อมูลพัสดุ</h6>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">หมายเลขพัสดุ:</div>
                        <div class="col-7"><strong>{{ $order->shipping->tracking_number }}</strong></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">เลขคำสั่งซื้อ:</div>
                        <div class="col-7">{{ $order->order_number }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">บริษัทขนส่ง:</div>
                        <div class="col-7">{{ $order->shipping->shipping_company }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5 text-muted">สถานะ:</div>
                        <div class="col-7">
                            @if($order->status == 'delivered')
                                <span class="badge bg-success">ส่งสำเร็จ</span>
                            @elseif($order->status == 'shipped')
                                <span class="badge bg-warning text-dark">กำลังจัดส่ง</span>
                            @else
                                <span class="badge bg-secondary">{{ $order->status }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <hr>

                <!-- ข้อมูลผู้รับ -->
                <div class="mb-3">
                    <h6 class="fw-bold mb-3">ข้อมูลผู้รับ</h6>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">ชื่อ:</div>
                        <div class="col-7">{{ $order->customer_name }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted">เบอร์โทร:</div>
                        <div class="col-7">{{ $order->customer_phone }}</div>
                    </div>
                    <div class="row">
                        <div class="col-5 text-muted">ที่อยู่:</div>
                        <div class="col-7">{{ $order->shipping_address }}</div>
                    </div>
                </div>

                <hr>

                <!-- รายการสินค้า -->
                <div class="mb-3">
                    <h6 class="fw-bold mb-3">รายการสินค้า ({{ $order->items->count() }} รายการ)</h6>
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
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

                <!-- เวลา -->
                @if($order->shipping->shipped_at)
                <div class="mb-3">
                    <small class="text-muted">วันที่จัดส่ง: {{ $order->shipping->shipped_at->format('d/m/Y H:i') }}</small>
                </div>
                @endif

                @if($order->shipping->delivered_at)
                <div class="mb-3">
                    <small class="text-success">✓ ส่งสำเร็จเมื่อ: {{ $order->shipping->delivered_at->format('d/m/Y H:i') }}</small>
                </div>
                @endif

                <!-- ปุ่มดำเนินการ -->
                @if($order->status == 'shipped')
                    <form action="{{ route('shipping.delivered', $order->id) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" 
                                class="btn btn-success btn-lg w-100"
                                onclick="return confirm('ยืนยันว่าส่งพัสดุถึงลูกค้าเรียบร้อยแล้ว?')">
                            <i class="bi bi-check-circle-fill"></i> ยืนยันส่งสำเร็จ
                        </button>
                    </form>
                @endif

                <a href="{{ route('shipping.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-arrow-left"></i> ค้นหาพัสดุอื่น
                </a>
            </div>
        </div>
    </div>
</div>
@endsection