@extends('layouts.app')
@section('title', 'ติดตามพัสดุ')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="fw-bold mb-4">
                <i class="bi bi-truck"></i> ติดตามพัสดุ
            </h2>

            <!-- ข้อมูลคำสั่งซื้อ -->
            <div class="bg-white rounded-3 p-4 mb-3">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted small">หมายเลขคำสั่งซื้อ</p>
                        <p class="fw-bold">{{ $order->order_number }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1 text-muted small">วันที่สั่งซื้อ</p>
                        <p class="fw-bold">{{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                @if($order->shipping->tracking_number)
                <div class="alert alert-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1"><strong>หมายเลขพัสดุ:</strong></p>
                            <h5 class="mb-0">{{ $order->shipping->tracking_number }}</h5>
                        </div>
                        <div>
                            <p class="mb-1 small text-muted">บริษัทขนส่ง</p>
                            <p class="mb-0 fw-bold">{{ $order->shipping->shipping_company }}</p>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i> 
                    ยังไม่มีหมายเลขพัสดุ กำลังเตรียมสินค้าอยู่
                </div>
                @endif
            </div>

            <!-- สถานะการจัดส่ง -->
            <div class="bg-white rounded-3 p-4">
                <h5 class="fw-bold mb-4">สถานะการจัดส่ง</h5>

                <div class="tracking-timeline">
                    <!-- รอดำเนินการ -->
                    <div class="tracking-step {{ in_array($order->shipping->status, ['pending', 'processing', 'in_transit', 'delivered']) ? 'completed' : '' }}">
                        <div class="tracking-icon">
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <div class="tracking-content">
                            <h6 class="mb-1">รับคำสั่งซื้อแล้ว</h6>
                            <p class="text-muted small mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- กำลังเตรียมสินค้า -->
                    <div class="tracking-step {{ in_array($order->shipping->status, ['processing', 'in_transit', 'delivered']) ? 'completed' : '' }}">
                        <div class="tracking-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="tracking-content">
                            <h6 class="mb-1">กำลังเตรียมสินค้า</h6>
                            @if(in_array($order->shipping->status, ['processing', 'in_transit', 'delivered']))
                                <p class="text-muted small mb-0">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                            @else
                                <p class="text-muted small mb-0">รอดำเนินการ</p>
                            @endif
                        </div>
                    </div>

                    <!-- จัดส่งแล้ว -->
                    <div class="tracking-step {{ in_array($order->shipping->status, ['in_transit', 'delivered']) ? 'completed' : '' }}">
                        <div class="tracking-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="tracking-content">
                            <h6 class="mb-1">อยู่ระหว่างจัดส่ง</h6>
                            @if($order->shipping->shipped_at)
                                <p class="text-muted small mb-0">{{ $order->shipping->shipped_at->format('d/m/Y H:i') }}</p>
                            @else
                                <p class="text-muted small mb-0">รอดำเนินการ</p>
                            @endif
                        </div>
                    </div>

                    <!-- ส่งสำเร็จ -->
                    <div class="tracking-step {{ $order->shipping->status == 'delivered' ? 'completed' : '' }}">
                        <div class="tracking-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="tracking-content">
                            <h6 class="mb-1">ส่งสำเร็จ</h6>
                            @if($order->shipping->delivered_at)
                                <p class="text-muted small mb-0">{{ $order->shipping->delivered_at->format('d/m/Y H:i') }}</p>
                            @else
                                <p class="text-muted small mb-0">รอดำเนินการ</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ที่อยู่จัดส่ง -->
                <div class="mt-4 p-3 bg-light rounded">
                    <h6 class="fw-bold mb-2">ที่อยู่จัดส่ง</h6>
                    <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
                    <p class="mb-1">{{ $order->customer_phone }}</p>
                    <p class="mb-0">{{ $order->shipping_address }}</p>
                </div>
            </div>

            <!-- ปุ่มกลับ -->
            <div class="mt-3">
                <a href="{{ route('order.history') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> กลับไปยังประวัติการสั่งซื้อ
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .tracking-timeline {
        position: relative;
        padding-left: 50px;
    }

    .tracking-step {
        position: relative;
        padding-bottom: 40px;
    }

    .tracking-step:last-child {
        padding-bottom: 0;
    }

    .tracking-step::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 40px;
        bottom: 0;
        width: 2px;
        background: #e0e0e0;
    }

    .tracking-step:last-child::before {
        display: none;
    }

    .tracking-step.completed::before {
        background: #28a745;
    }

    .tracking-icon {
        position: absolute;
        left: -42px;
        top: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.2rem;
        border: 3px solid white;
    }

    .tracking-step.completed .tracking-icon {
        background: #28a745;
    }

    .tracking-content h6 {
        font-weight: 600;
    }
</style>
@endsection