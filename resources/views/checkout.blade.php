@extends('layouts.app')
@section('title', 'ชำระเงิน')

@section('content')
<div class="container my-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-credit-card"></i> ชำระเงิน
    </h2>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- ฟอร์มข้อมูลลูกค้า -->
            <div class="col-lg-7">
                <!-- ข้อมูลผู้รับสินค้า -->
                <div class="bg-white rounded-3 p-4 mb-3">
                    <h5 class="fw-bold mb-3">ข้อมูลผู้รับสินค้า</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">ชื่อ-นามสกุล <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control" 
                               value="{{ old('customer_name', Auth::user()->name) }}" required>
                        @error('customer_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                        <input type="text" name="customer_phone" class="form-control" 
                               value="{{ old('customer_phone') }}" required>
                        @error('customer_phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ที่อยู่จัดส่ง <span class="text-danger">*</span></label>
                        <textarea name="shipping_address" class="form-control" rows="4" required>{{ old('shipping_address') }}</textarea>
                        @error('shipping_address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- วิธีการชำระเงิน -->
                <div class="bg-white rounded-3 p-4 mb-3">
                    <h5 class="fw-bold mb-3">วิธีการชำระเงิน</h5>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" 
                               id="cod" value="cash_on_delivery" checked>
                        <label class="form-check-label" for="cod">
                            <strong>เก็บเงินปลายทาง (COD)</strong>
                            <p class="text-muted mb-0 small">ชำระเงินเมื่อได้รับสินค้า</p>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" 
                               id="bank" value="bank_transfer">
                        <label class="form-check-label" for="bank">
                            <strong>โอนเงินผ่านธนาคาร</strong>
                            <p class="text-muted mb-0 small">โอนเงินและแนบหลักฐานการโอน</p>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="payment_method" 
                               id="promptpay" value="promptpay">
                        <label class="form-check-label" for="promptpay">
                            <strong>พร้อมเพย์</strong>
                            <p class="text-muted mb-0 small">สแกน QR Code และแนบหลักฐาน</p>
                        </label>
                    </div>

                    <!-- แสดงเมื่อเลือกโอนเงิน -->
                    <div id="bankDetails" class="mt-3 p-3 bg-light rounded d-none">
                        <h6 class="fw-bold">บัญชีสำหรับโอนเงิน</h6>
                        <p class="mb-1"><strong>ธนาคาร:</strong> ไทยพาณิชย์</p>
                        <p class="mb-1"><strong>เลขที่บัญชี:</strong> 123-456-7890</p>
                        <p class="mb-3"><strong>ชื่อบัญชี:</strong> DailyLife Store</p>

                        <label class="form-label">แนบหลักฐานการโอนเงิน</label>
                        <input type="file" name="payment_proof" class="form-control" accept="image/*">
                        @error('payment_proof')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- แสดงเมื่อเลือก PromptPay -->
                    <div id="promptpayDetails" class="mt-3 p-3 bg-light rounded d-none">
                        <h6 class="fw-bold text-center">สแกน QR Code</h6>
                        <div class="text-center mb-3">
                            <img src="https://via.placeholder.com/200x200?text=QR+Code" 
                                 alt="PromptPay QR" class="img-fluid" style="max-width: 200px;">
                        </div>
                        <p class="text-center text-muted small">เบอร์พร้อมเพย์: 0XX-XXX-XXXX</p>

                        <label class="form-label">แนบหลักฐานการโอนเงิน</label>
                        <input type="file" name="payment_proof" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <!-- สรุปคำสั่งซื้อ -->
            <div class="col-lg-5">
                <div class="bg-white rounded-3 p-4 sticky-top" style="top: 20px;">
                    <h5 class="fw-bold mb-3">สรุปคำสั่งซื้อ</h5>

                    <!-- รายการสินค้า -->
                    <div class="mb-3" style="max-height: 300px; overflow-y: auto;">
                        @foreach($carts as $cart)
                        <div class="d-flex mb-3">
                            <img src="{{ asset('storage/' . $cart->product->img_prd) }}" 
                                 alt="{{ $cart->product->name_prd }}" 
                                 class="rounded me-2" style="width: 60px; height: 60px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <p class="mb-1 small">{{ $cart->product->name_prd }}</p>
                                <p class="mb-0 small text-muted">x{{ $cart->quantity }}</p>
                            </div>
                            <p class="mb-0 fw-bold">฿{{ number_format($cart->product->price_prd * $cart->quantity, 2) }}</p>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    <!-- สรุปราคา -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>ยอดรวมสินค้า</span>
                        <span>฿{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>ค่าจัดส่ง</span>
                        <span>฿{{ number_format($shippingCost, 2) }}</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="fw-bold">ยอดรวมทั้งหมด</h5>
                        <h5 class="fw-bold text-danger">฿{{ number_format($total, 2) }}</h5>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                        ยืนยันการสั่งซื้อ
                    </button>

                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                        ย้อนกลับ
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    // แสดง/ซ่อน ฟอร์มการชำระเงิน
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('bankDetails').classList.add('d-none');
            document.getElementById('promptpayDetails').classList.add('d-none');

            if (this.value === 'bank_transfer') {
                document.getElementById('bankDetails').classList.remove('d-none');
            } else if (this.value === 'promptpay') {
                document.getElementById('promptpayDetails').classList.remove('d-none');
            }
        });
    });
</script>
@endsection