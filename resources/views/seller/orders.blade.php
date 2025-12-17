@extends('layouts.app')
@section('title', 'คำสั่งซื้อ')

@section('content')
<div class="container my-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-receipt"></i> คำสั่งซื้อของร้าน
    </h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="text-center py-5 bg-white rounded-3">
            <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
            <h5 class="text-muted mt-3">ยังไม่มีคำสั่งซื้อ</h5>
        </div>
    @else
        <div class="bg-white rounded-3 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>เลขคำสั่งซื้อ</th>
                            <th>วันที่</th>
                            <th>ลูกค้า</th>
                            <th>ยอดรวม</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td><strong class="text-danger">฿{{ number_format($order->total_amount, 2) }}</strong></td>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="badge bg-warning text-dark">รอดำเนินการ</span>
                                @elseif($order->status == 'confirmed')
                                    <span class="badge bg-info">ยืนยันแล้ว</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge bg-primary">กำลังเตรียมสินค้า</span>
                                @elseif($order->status == 'shipped')
                                    <span class="badge bg-secondary">จัดส่งแล้ว</span>
                                @elseif($order->status == 'delivered')
                                    <span class="badge bg-success">ส่งสำเร็จ</span>
                                @else
                                    <span class="badge bg-danger">ยกเลิก</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('seller.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> ดูรายละเอียด
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection