@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>คำสั่งซื้อ #{{ $order->order_number }}</h4>
            <a href="{{ route('seller.orders') }}" class="btn btn-sm btn-outline-secondary">
                ← กลับหน้ารายการ
            </a>
        </div>

        {{-- ข้อมูลหลัก --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">ข้อมูลลูกค้า</div>
                    <div class="card-body">
                        <p><strong>ชื่อ:</strong> {{ $order->user->name }}</p>
                        <p><strong>อีเมล:</strong> {{ $order->user->email }}</p>
                        <p><strong>วันที่สั่งซื้อ:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                        <p>
                            <strong>สถานะ:</strong>
                            @include('seller.partials.order-status-badge', ['status' => $order->status])
                        </p>
                    </div>
                </div>
            </div>

            {{-- การชำระเงิน --}}
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">การชำระเงิน</div>
                    <div class="card-body">
                        <p><strong>วิธีชำระ:</strong> {{ $order->payment->method ?? '-' }}</p>
                        <p><strong>สถานะ:</strong> {{ $order->payment->status ?? '-' }}</p>
                        <p class="text-danger fw-bold">
                            ยอดรวม ฿{{ number_format($order->total_amount, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- รายการสินค้า --}}
        <div class="card mb-3">
            <div class="card-header">รายการสินค้าในคำสั่งซื้อ</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>สินค้า</th>
                            <th class="text-center">จำนวน</th>
                            <th class="text-end">ราคา</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">
                                    ฿{{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- อัปเดทสถานะ --}}
        <div class="card mb-3">
            <div class="card-header">จัดการสถานะคำสั่งซื้อ</div>

                {{-- กรณีถูกยกเลิกแล้ว --}}
                @if ($order->status === 'cancelled')
                    <div class="alert alert-secondary mb-0">
                        คำสั่งซื้อนี้ถูกยกเลิกแล้ว ไม่สามารถแก้ไขสถานะได้
                    </div>

                    {{-- กรณีลูกค้าขอยกเลิก --}}
                @elseif($order->status === 'cancel_requested')
                    @if ($order->status === 'cancel_requested' && $order->cancel_reason)
                        <div class="alert alert-warning">
                            <strong>เหตุผลที่ลูกค้าส่งคำขอยกเลิก: {{ $order->cancel_reason }}</strong><br>
                        </div>
                    @endif

                    <button class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#cancelDecisionModal{{ $order->id }}">
                        ยืนยันการยกเลิกคำสั่งซื้อ
                    </button>

                    <div class="modal fade" id="cancelDecisionModal{{ $order->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('seller.orders.updateStatus', $order->id) }}">
            @csrf

            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        พิจารณาคำขอยกเลิกคำสั่งซื้อ
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p>
                        คำสั่งซื้อเลขที่ <strong>#{{ $order->order_number }}</strong>
                    </p>

                    @if($order->cancel_reason)
                        <div class="alert alert-warning">
                            <strong>เหตุผลจากลูกค้า:</strong><br>
                            {{ $order->cancel_reason }}
                        </div>
                    @endif

                    <p class="mb-0 text-muted">
                        กรุณาเลือกว่าจะยืนยันการยกเลิกหรือให้ดำเนินการต่อ
                    </p>
                </div>

                <div class="modal-footer">
                    {{-- ❌ ไม่ยอมยกเลิก --}}
                    <button type="submit"
                            name="status"
                            value="pending"
                            class="btn btn-secondary">
                        ไม่ยกเลิก ดำเนินการต่อ
                    </button>

                    {{-- ✅ ยืนยันยกเลิก --}}
                    <button type="submit"
                            name="status"
                            value="cancelled"
                            class="btn btn-danger">
                        ยืนยันการยกเลิก
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
                    
                    {{-- สถานะปกติ --}}
                @else
                    <form method="POST" action="{{ route('seller.orders.updateStatus', $order->id) }}">
                        @csrf

                        <select name="status" class="form-select mb-2" required>
                            <option value="">-- เลือกสถานะ --</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>
                                ยืนยันคำสั่งซื้อ
                            </option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                กำลังเตรียมสินค้า
                            </option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                จัดส่งแล้ว
                            </option>
                        </select>

                        <button class="btn btn-primary">
                            อัปเดทสถานะ
                        </button>
                    </form>
                @endif

            </div>
        </div>


        {{-- ข้อมูลจัดส่ง --}}
        <div class="card">
            <div class="card-header">ข้อมูลการจัดส่ง</div>
            <div class="card-body">
                <form method="POST" action="{{ route('seller.orders.updateTracking', $order->id) }}">
                    @csrf

                    <div class="mb-2">
                        <label class="form-label">บริษัทขนส่ง</label>
                        <input type="text" name="shipping_company"
                            value="{{ $order->shipping->shipping_company ?? '' }}" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">หมายเลขพัสดุ</label>
                        <input type="text" name="tracking_number" value="{{ $order->shipping->tracking_number ?? '' }}"
                            class="form-control" required>
                    </div>

                    <button class="btn btn-success">
                        บันทึกเลขพัสดุ
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
