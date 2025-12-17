@extends('layouts.app')
@section('title', 'ใบเสร็จ')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- ปุ่มพิมพ์ -->
            <div class="text-end mb-3">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer"></i> พิมพ์ใบเสร็จ
                </button>
            </div>

            <!-- ใบเสร็จ -->
            <div class="bg-white rounded-3 p-5 border" id="receipt">
                <!-- หัวใบเสร็จ -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold">DailyLife Store</h2>
                    <p class="text-muted mb-0">ใบเสร็จรับเงิน / Receipt</p>
                </div>

                <hr>

                <!-- ข้อมูลคำสั่งซื้อ -->
                <div class="row mb-4">
                    <div class="col-6">
                        <p class="mb-1"><strong>หมายเลขคำสั่งซื้อ:</strong></p>
                        <p>{{ $order->order_number }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <p class="mb-1"><strong>วันที่:</strong></p>
                        <p>{{ $order->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>

                <!-- ข้อมูลลูกค้า -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-2">ข้อมูลลูกค้า</h6>
                    <p class="mb-1">ชื่อ: {{ $order->customer_name }}</p>
                    <p class="mb-1">เบอร์โทร: {{ $order->customer_phone }}</p>
                    <p class="mb-0">ที่อยู่: {{ $order->shipping_address }}</p>
                </div>

                <hr>

                <!-- ตารางรายการสินค้า -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>รายการ</th>
                            <th class="text-center">จำนวน</th>
                            <th class="text-end">ราคา/หน่วย</th>
                            <th class="text-end">รวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product_name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">฿{{ number_format($item->price, 2) }}</td>
                            <td class="text-end">฿{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <hr>

                <!-- สรุปยอด -->
                <div class="row">
                    <div class="col-6 offset-6">
                        <div class="d-flex justify-content-between mb-2">
                            <span>ยอดรวมสินค้า:</span>
                            <span>฿{{ number_format($order->items->sum('subtotal'), 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>ค่าจัดส่ง:</span>
                            <span>฿{{ number_format($order->shipping->shipping_cost, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>ยอดรวมทั้งสิ้น:</strong>
                            <strong class="text-danger">฿{{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- ข้อมูลการชำระเงิน -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-2">วิธีการชำระเงิน</h6>
                    <p class="mb-0">
                        @if($order->payment->payment_method == 'cash_on_delivery')
                            เก็บเงินปลายทาง (COD)
                        @elseif($order->payment->payment_method == 'bank_transfer')
                            โอนเงินผ่านธนาคาร
                        @elseif($order->payment->payment_method == 'promptpay')
                            พร้อมเพย์
                        @endif
                    </p>
                    <p class="mb-0">สถานะ: 
                        @if($order->payment->status == 'paid')
                            <span class="badge bg-success">ชำระแล้ว</span>
                        @else
                            <span class="badge bg-warning">รอชำระเงิน</span>
                        @endif
                    </p>
                </div>

                <!-- ข้อมูลการจัดส่ง -->
                @if($order->shipping->tracking_number)
                <div class="mb-4">
                    <h6 class="fw-bold mb-2">ข้อมูลการจัดส่ง</h6>
                    <p class="mb-1">บริษัทขนส่ง: {{ $order->shipping->shipping_company }}</p>
                    <p class="mb-0">หมายเลขพัสดุ: {{ $order->shipping->tracking_number }}</p>
                </div>
                @endif

                <!-- Footer -->
                <div class="text-center mt-5 pt-4 border-top">
                    <p class="text-muted mb-0">ขอบคุณที่ใช้บริการ</p>
                    <p class="text-muted small">DailyLife Store | www.dailylife-store.com</p>
                </div>
            </div>

            <!-- ปุ่มกลับ -->
            <div class="mt-3 d-print-none">
                <a href="{{ route('order.history') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> กลับไปยังประวัติการสั่งซื้อ
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .d-print-none {
            display: none !important;
        }
        body {
            background: white;
        }
        #receipt {
            box-shadow: none !important;
            border: none !important;
        }
    }
</style>
@endsection