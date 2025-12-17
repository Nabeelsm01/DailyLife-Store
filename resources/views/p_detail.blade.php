@extends('layouts.app')
@section('title', $product->name_prd)

@section('content')
<div class="container my-4">
    <!-- ปุ่มย้อนกลับ -->
    <a href="{{ route('welcome') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> กลับหน้าแรก
    </a>

    <div class="row bg-white rounded-3 p-4">
        <!-- รูปสินค้า -->
        <div class="col-md-5">
            <img src="{{ asset('storage/' . $product->img_prd) }}" 
                 alt="{{ $product->name_prd }}" 
                 class="img-fluid rounded-3 border">
        </div>

        <!-- รายละเอียดสินค้า -->
        <div class="col-md-7">
            <h2 class="fw-bold mb-3">{{ $product->name_prd }}</h2>
            
            <!-- ราคา -->
            <div class="mb-3">
                <h3 class="text-danger fw-bold">฿{{ number_format($product->price_prd, 2) }}</h3>
            </div>

            <!-- ⭐ เรทติ้งและยอดขาย -->
            <div class="mb-3">
                <span class="badge bg-warning text-dark me-2">
                    <i class="bi bi-star-fill"></i> {{ number_format($product->averageRating(), 1) }}/5
                </span>
                <span class="text-muted">
                    ({{ $product->reviewsCount() }} รีวิว)
                </span>
                <span class="text-muted ms-2">
                    | ขายแล้ว {{ $product->totalSold() }} ชิ้น
                </span>
            </div>

            <hr>

            <!-- รายละเอียดสินค้า -->
            <div class="mb-4">
                <h5 class="fw-semibold">รายละเอียดสินค้า</h5>
                <p class="text-muted">
                    {{ $product->detail_prd ?? 'ไม่มีรายละเอียดเพิ่มเติม' }}
                </p>
            </div>

            <!-- สต็อก -->
            <div class="mb-4">
                <p class="mb-0">
                    <i class="bi bi-box-seam"></i> 
                    สต็อก: <strong>{{ $product->stock_prd ?? 0 }}</strong> ชิ้น
                </p>
            </div>

            <!-- จำนวนสินค้า -->
            <div class="mb-4">
                <h5 class="fw-semibold mb-3">จำนวน</h5>
                <div class="input-group" style="width: 150px;">
                    <button class="btn btn-outline-secondary" type="button" id="decreaseBtn">-</button>
                    <input type="number" class="form-control text-center" value="1" min="1" id="quantity">
                    <button class="btn btn-outline-secondary" type="button" id="increaseBtn">+</button>
                </div>
            </div>

            <!-- ปุ่มสั่งซื้อ -->
            <div class="d-flex gap-2">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-fill">
                    @csrf
                    <input type="hidden" name="quantity" id="quantityValue" value="1">
                    <button type="submit" class="btn btn-outline-primary btn-lg w-100">
                        <i class="bi bi-cart-plus"></i> เพิ่มลงตะกร้า
                    </button>
                </form>
                <form action="{{ route('cart.buyNow', $product->id) }}" method="POST" class="flex-fill">
                    @csrf
                    <input type="hidden" name="quantity" id="quantityValue2" value="1">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-lightning-charge-fill"></i> ซื้อเลย
                    </button>
                </form>
            </div>

            <!-- ข้อมูลร้านค้า -->
            <div class="mt-4 p-3 bg-light rounded-3">
                <h6 class="fw-semibold mb-2">ข้อมูลร้านค้า</h6>
                <p class="mb-1"><i class="bi bi-shop"></i> {{ $product->shop->shop_name ?? 'DailyLife Store' }}</p>
                <p class="mb-0 text-muted"><i class="bi bi-geo-alt"></i> กรุงเทพมหานคร</p>
            </div>
        </div>
    </div>

    <!-- ⭐ ส่วนรีวิว -->
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-semibold">
                <i class="bi bi-chat-left-text"></i> รีวิวสินค้า ({{ $product->reviewsCount() }})
            </h4>
            
            @auth
                @php
                    $hasPurchased = \App\Models\Order::where('user_id', Auth::id())
                                     ->whereHas('items', function($query) use ($product) {
                                         $query->where('product_id', $product->id);
                                     })
                                     ->whereIn('status', ['delivered'])
                                     ->exists();
                    
                    $hasReviewed = \App\Models\Review::where('user_id', Auth::id())
                                                     ->where('product_id', $product->id)
                                                     ->exists();
                @endphp
                
                @if($hasPurchased && !$hasReviewed)
                    <a href="{{ route('review.create', $product->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> เขียนรีวิว
                    </a>
                @endif
            @endauth
        </div>

        <!-- แสดงรีวิว -->
        <div class="bg-white rounded-3 p-4">
            @forelse($product->reviews()->latest()->get() as $review)
            <div class="border-bottom pb-3 mb-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">{{ $review->user->name }}</h6>
                        <div class="mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-muted"></i>
                                @endif
                            @endfor
                            <small class="text-muted ms-2">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        @if($review->comment)
                            <p class="mb-0">{{ $review->comment }}</p>
                        @endif
                    </div>
                    
                    @if(Auth::check() && Auth::id() == $review->user_id)
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('review.edit', $review->id) }}">
                                        <i class="bi bi-pencil"></i> แก้ไข
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('review.destroy', $review->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" 
                                                onclick="return confirm('ต้องการลบรีวิวนี้?')">
                                            <i class="bi bi-trash"></i> ลบ
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-chat-left-text" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">ยังไม่มีรีวิว</p>
            </div>
            @endforelse
        </div>
    </div>
    <!-- สินค้าแนะนำ -->
    <div class="mt-5">
        <h4 class="fw-semibold mb-3">สินค้าที่คุณอาจสนใจ</h4>
        <div class="row">
            @foreach($products->take(4) as $relatedProduct)
            <div class="col-md-3 mb-3">
                <a href="{{ route('p_detail.show', $relatedProduct->id) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="{{ asset('storage/' . $relatedProduct->img_prd) }}" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <p class="card-text text-dark">{{ $relatedProduct->name_prd }}</p>
                            <p class="text-danger fw-bold mb-0">฿{{ number_format($relatedProduct->price_prd, 2) }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decreaseBtn');
    const increaseBtn = document.getElementById('increaseBtn');

    decreaseBtn.addEventListener('click', () => {
        if (quantityInput.value > 1) {
            quantityInput.value = parseInt(quantityInput.value) - 1;
            updateQuantityValues();
        }
    });

    increaseBtn.addEventListener('click', () => {
        quantityInput.value = parseInt(quantityInput.value) + 1;
        updateQuantityValues();
    });

    function updateQuantityValues() {
        document.getElementById('quantityValue').value = quantityInput.value;
        document.getElementById('quantityValue2').value = quantityInput.value;
    }
</script>
@endsection