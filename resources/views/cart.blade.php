@extends('layouts.app')
@section('title', 'ตะกร้าสินค้า')

@section('content')
<div class="container my-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-cart3"></i> ตะกร้าสินค้า
    </h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($carts->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 5rem; color: #ccc;"></i>
            <h4 class="mt-3 text-muted">ตะกร้าสินค้าว่างเปล่า</h4>
            <a href="{{ route('welcome') }}" class="btn btn-primary mt-3">เลือกซื้อสินค้า</a>
        </div>
    @else
        <div class="row">
            <!-- รายการสินค้า -->
            <div class="col-lg-8">
                <div class="bg-white rounded-3 p-3 mb-3">
                    <!-- เลือกทั้งหมด -->
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAllCheckbox">
                            <label class="form-check-label" for="selectAllCheckbox">
                                เลือกทั้งหมด ({{ $carts->count() }} รายการ)
                            </label>
                        </div>
                    </div>

                    @foreach($carts as $cart)
                    <div class="row align-items-center border-bottom py-3">
                        <!-- Checkbox เลือก -->
                        <div class="col-auto">
                            <form action="{{ route('cart.toggleSelect', $cart->id) }}" method="POST" class="cart-item-form">
                                @csrf
                                <input class="form-check-input cart-item-checkbox" 
                                       type="checkbox" 
                                       data-cart-id="{{ $cart->id }}"
                                       {{ $cart->selected ? 'checked' : '' }}
                                       onchange="this.form.submit()">
                            </form>
                        </div>

                        <!-- รูปสินค้า -->
                        <div class="col-md-2">
                            <img src="{{ asset('storage/' . $cart->product->img_prd) }}" 
                                 alt="{{ $cart->product->name_prd }}" 
                                 class="img-fluid rounded">
                        </div>

                        <!-- ชื่อสินค้า -->
                        <div class="col-md-3">
                            <h6 class="mb-1">{{ $cart->product->name_prd }}</h6>
                            <p class="text-danger mb-0 fw-bold">฿{{ number_format($cart->product->price_prd, 2) }}</p>
                        </div>

                        <!-- จำนวน -->
                        <div class="col-md-3">
                            <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                @method('PATCH')
                                <div class="input-group" style="width: 130px;">
                                    <button class="btn btn-outline-secondary btn-sm" type="button" 
                                            onclick="this.parentElement.querySelector('input').stepDown(); this.form.submit();">
                                        -
                                    </button>
                                    <input type="number" name="quantity" class="form-control form-control-sm text-center" 
                                           value="{{ $cart->quantity }}" min="1" readonly>
                                    <button class="btn btn-outline-secondary btn-sm" type="button" 
                                            onclick="this.parentElement.querySelector('input').stepUp(); this.form.submit();">
                                        +
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- ราคารวม -->
                        <div class="col-md-2 text-end">
                            <p class="fw-bold mb-0 text-danger">
                                ฿{{ number_format($cart->product->price_prd * $cart->quantity, 2) }}
                            </p>
                        </div>

                        <!-- ปุ่มลบ -->
                        <div class="col-md-1 text-end">
                            <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                        onclick="return confirm('ต้องการลบสินค้านี้?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- สรุปยอดชำระ -->
            <div class="col-lg-4">
                <div class="bg-white rounded-3 p-4 sticky-top" style="top: 20px;">
                    <h5 class="fw-bold mb-3">สรุปยอดชำระ</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>สินค้าที่เลือก ({{ $carts->where('selected', true)->count() }} รายการ)</span>
                        <span>฿{{ number_format($total, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>ค่าจัดส่ง</span>
                        <span>฿50.00</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="fw-bold">ยอดรวมทั้งหมด</h5>
                        <h5 class="fw-bold text-danger">฿{{ number_format($total + 50, 2) }}</h5>
                    </div>

                    @if($carts->where('selected', true)->count() > 0)
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 btn-lg">
                            ดำเนินการชำระเงิน ({{ $carts->where('selected', true)->count() }})
                        </a>
                    @else
                        <button class="btn btn-secondary w-100 btn-lg" disabled>
                            กรุณาเลือกสินค้า
                        </button>
                    @endif
                    
                    <a href="{{ route('welcome') }}" class="btn btn-outline-secondary w-100 mt-2">
                        เลือกซื้อสินค้าต่อ
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const itemCheckboxes = document.querySelectorAll('.cart-item-checkbox');

        // ตรวจสอบสถานะเริ่มต้นของ "เลือกทั้งหมด"
        function updateSelectAllCheckbox() {
            const checkedCount = document.querySelectorAll('.cart-item-checkbox:checked').length;
            const totalCount = itemCheckboxes.length;
            
            selectAllCheckbox.checked = (checkedCount === totalCount && totalCount > 0);
            selectAllCheckbox.indeterminate = (checkedCount > 0 && checkedCount < totalCount);
        }

        // เมื่อกด checkbox "เลือกทั้งหมด"
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // เลือกทั้งหมด
                    fetch('{{ route("cart.selectAll") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    // ยกเลิกทั้งหมด
                    fetch('{{ route("cart.unselectAll") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }

        // อัพเดทสถานะเมื่อโหลดหน้า
        updateSelectAllCheckbox();
    });
</script>
@endsection