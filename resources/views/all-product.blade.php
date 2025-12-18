@extends('layouts.app')
@section('title', 'หน้าแรกของเว็บไซต์')
@section('head')

@endsection
@section('content')
    <div class="d-flex flex-row p-3 bg-white rounded-3 ">
        <h3 class="fw-semibold my-auto text-secondary">หน้าร้าน DailyLife Store</h3>
        <form class="d-flex ms-auto w-25" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    <hr class="border border-white border-2 rounded ">

 <div class="container my-4">
    <div class="row">
        <!-- ⭐ Sidebar Filters (ซ้าย) -->
        <div class="col-lg-3 mb-4">
            <div class="bg-white rounded-3 shadow-sm p-4 sticky-top" style="top: 20px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-funnel"></i> ตัวกรอง
                    </h5>
                    @if(request()->hasAny(['category', 'price_min', 'price_max', 'price_range', 'stock', 'rating']))
                        <a href="{{ route('all-product') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-x"></i> ล้าง
                        </a>
                    @endif
                </div>

                <form action="{{ route('all-product') }}" method="GET" id="filterForm">
                    <!-- คงค่า sort ไว้ -->
                    <input type="hidden" name="sort" value="{{ request('sort', 'latest') }}">

                    <!-- ⭐ หมวดหมู่ -->
                    <div class="filter-section mb-4">
                        <h6 class="fw-semibold mb-3">หมวดหมู่</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="category" value="" 
                                   id="cat_all" {{ !request('category') ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label" for="cat_all">
                                ทั้งหมด
                            </label>
                        </div>
                        @foreach($categories as $cat)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="category" 
                                   value="{{ $cat }}" id="cat_{{ $loop->index }}"
                                   {{ request('category') == $cat ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label" for="cat_{{ $loop->index }}">
                                {{ $cat }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    <!-- ⭐ ช่วงราคา (Quick Select) -->
                    <div class="filter-section mb-4">
                        <h6 class="fw-semibold mb-3">ช่วงราคา</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="price_range" value="" 
                                   id="price_all" {{ !request('price_range') ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label" for="price_all">
                                ทั้งหมด
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="price_range" value="under_100"
                                   id="price_under_100" {{ request('price_range') == 'under_100' ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label" for="price_under_100">
                                ต่ำกว่า ฿100
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="price_range" value="100_500"
                                   id="price_100_500" {{ request('price_range') == '100_500' ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label" for="price_100_500">
                                ฿100 - ฿500
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="price_range" value="500_1000"
                                   id="price_500_1000" {{ request('price_range') == '500_1000' ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label" for="price_500_1000">
                                ฿500 - ฿1,000
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="price_range" value="over_1000"
                                   id="price_over_1000" {{ request('price_range') == 'over_1000' ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label" for="price_over_1000">
                                มากกว่า ฿1,000
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- ⭐ ราคากำหนดเอง -->
                    <div class="filter-section mb-4">
                        <h6 class="fw-semibold mb-3">กำหนดราคา</h6>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" name="price_min" class="form-control form-control-sm" 
                                       placeholder="ต่ำสุด" value="{{ request('price_min') }}">
                            </div>
                            <div class="col-6">
                                <input type="number" name="price_max" class="form-control form-control-sm" 
                                       placeholder="สูงสุด" value="{{ request('price_max') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">
                            ตกลง
                        </button>
                    </div>

                    <hr>

                    <!-- ⭐ เรตติ้ง -->
                    <div class="filter-section mb-4">
                        <h6 class="fw-semibold mb-3">คะแนนขั้นต่ำ</h6>
                        @for($i = 5; $i >= 1; $i--)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="rating" 
                                   value="{{ $i }}" id="rating_{{ $i }}"
                                   {{ request('rating') == $i ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label" for="rating_{{ $i }}">
                                @for($j = 1; $j <= 5; $j++)
                                    <i class="bi bi-star-fill {{ $j <= $i ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                                <span class="ms-1">ขึ้นไป</span>
                            </label>
                        </div>
                        @endfor
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="rating" value=""
                                   id="rating_all" {{ !request('rating') ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label" for="rating_all">
                                ทั้งหมด
                            </label>
                        </div>
                    </div>

                    <hr>

                    <!-- ⭐ มีสต็อก -->
                    <div class="filter-section">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="stock" 
                                   value="available" id="stock_available"
                                   {{ request('stock') == 'available' ? 'checked' : '' }}
                                   onchange="document.getElementById('filterForm').submit()">
                            <label class="form-check-label" for="stock_available">
                                มีสินค้าพร้อมส่ง
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- ⭐ รายการสินค้า (ขวา) -->
        <div class="col-lg-9">
            <!-- Header + Sort -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">สินค้าทั้งหมด</h2>
                    <p class="text-muted mb-0">
                        พบ {{ $products->total() }} รายการ
                        @if(request('category'))
                            ใน <strong>{{ request('category') }}</strong>
                        @endif
                    </p>
                </div>

                <!-- ⭐ เรียงลำดับ -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-sort-down"></i> 
                        @php
                            $sortLabels = [
                                'latest' => 'ใหม่ล่าสุด',
                                'popular' => 'ขายดี',
                                'price_low' => 'ราคาต่ำ-สูง',
                                'price_high' => 'ราคาสูง-ต่ำ',
                                'rating' => 'เรตติ้งสูงสุด',
                                'name' => 'ชื่อ A-Z'
                            ];
                            $currentSort = request('sort', 'latest');
                        @endphp
                        {{ $sortLabels[$currentSort] ?? 'เรียงตาม' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach($sortLabels as $value => $label)
                        <li>
                            <a class="dropdown-item {{ $currentSort == $value ? 'active' : '' }}" 
                               href="{{ route('all-product', array_merge(request()->except('sort'), ['sort' => $value])) }}">
                                {{ $label }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- ⭐ แสดง Active Filters (Tags) -->
            @if(request()->hasAny(['category', 'price_range', 'price_min', 'price_max', 'rating', 'stock']))
            <div class="mb-3 d-flex flex-wrap gap-2">
                <span class="text-muted small">กำลังกรอง:</span>
                
                @if(request('category'))
                    <span class="badge bg-primary rounded-pill">
                        {{ request('category') }}
                        <a href="{{ route('all-product', request()->except('category')) }}" class="text-white ms-1">
                            <i class="bi bi-x"></i>
                        </a>
                    </span>
                @endif

                @if(request('price_range'))
                    @php
                        $priceRanges = [
                            'under_100' => '< ฿100',
                            '100_500' => '฿100-500',
                            '500_1000' => '฿500-1,000',
                            'over_1000' => '> ฿1,000'
                        ];
                    @endphp
                    <span class="badge bg-success rounded-pill">
                        {{ $priceRanges[request('price_range')] }}
                        <a href="{{ route('all-product', request()->except('price_range')) }}" class="text-white ms-1">
                            <i class="bi bi-x"></i>
                        </a>
                    </span>
                @endif

                @if(request('price_min') || request('price_max'))
                    <span class="badge bg-success rounded-pill">
                        ฿{{ request('price_min', 0) }} - ฿{{ request('price_max', '∞') }}
                        <a href="{{ route('all-product', request()->except(['price_min', 'price_max'])) }}" class="text-white ms-1">
                            <i class="bi bi-x"></i>
                        </a>
                    </span>
                @endif

                @if(request('rating'))
                    <span class="badge bg-warning text-dark rounded-pill">
                        ⭐ {{ request('rating') }}+ ดาว
                        <a href="{{ route('all-product', request()->except('rating')) }}" class="text-dark ms-1">
                            <i class="bi bi-x"></i>
                        </a>
                    </span>
                @endif

                @if(request('stock'))
                    <span class="badge bg-info rounded-pill">
                        มีสต็อก
                        <a href="{{ route('all-product', request()->except('stock')) }}" class="text-white ms-1">
                            <i class="bi bi-x"></i>
                        </a>
                    </span>
                @endif
            </div>
            @endif

            <!-- ⭐ Grid สินค้า -->
            <div class="row g-3 g-md-4">
                @forelse($products as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('p_detail.show', $product->id) }}" class="product-link">
                            <div class="product-card-modern">
                                <!-- รูปภาพ -->
                                <div class="product-image-wrapper">
                                    <img src="{{ asset('storage/' . $product->img_prd) }}"
                                         alt="{{ $product->name_prd }}"
                                         class="product-image">
                                    
                                    @if($product->created_at->diffInDays(now()) <= 7)
                                        <span class="badge-new">ใหม่</span>
                                    @endif

                                    @if($product->totalSold() >= 50)
                                        <span class="badge-bestseller">ขายดี</span>
                                    @endif
                                </div>

                                <!-- ข้อมูลสินค้า -->
                                <div class="product-details">
                                    <h6 class="product-title">
                                        {{ Str::limit($product->name_prd, 40) }}
                                    </h6>

                                    <div class="product-price-section">
                                        <span class="product-price">
                                            ฿{{ number_format($product->price_prd) }}
                                        </span>
                                    </div>

                                    <div class="product-meta">
                                        <div class="product-rating">
                                            <i class="bi bi-star-fill"></i>
                                            <span>{{ number_format($product->averageRating(), 1) }}</span>
                                        </div>
                                        <div class="product-sold">
                                            ขาย {{ $product->totalSold() }}
                                        </div>
                                    </div>

                                    @if($product->stock_prd <= 0)
                                        <div class="out-of-stock">สินค้าหมด</div>
                                    @elseif($product->stock_prd <= 5)
                                        <div class="low-stock">เหลือ {{ $product->stock_prd }} ชิ้น</div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                        <h5 class="text-muted mt-3">ไม่พบสินค้าตามเงื่อนไขที่กรอง</h5>
                        <a href="{{ route('all-product') }}" class="btn btn-primary mt-2">
                            ดูสินค้าทั้งหมด
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
/* Sticky Sidebar */
@media (min-width: 992px) {
    .sticky-top {
        max-height: calc(100vh - 40px);
        overflow-y: auto;
    }
}

/* Filter Sections */
.filter-section h6 {
    font-size: 0.95rem;
    color: #2d3748;
}

.form-check-label {
    font-size: 0.9rem;
    cursor: pointer;
}

.form-check-input:checked {
    background-color: #3B82F6;
    border-color: #3B82F6;
}

/* Active Filters Badges */
.badge a {
    text-decoration: none;
}

.badge a:hover {
    opacity: 0.8;
}

/* Product Card Styles (เหมือนเดิม) */
.product-link {
    text-decoration: none;
    color: inherit;
    display: block;
    height: 100%;
}

.product-card-modern {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.product-image-wrapper {
    position: relative;
    width: 100%;
    padding-top: 100%;
    overflow: hidden;
    background: #f8f9fa;
}

.product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card-modern:hover .product-image {
    transform: scale(1.05);
}

.badge-new,
.badge-bestseller {
    position: absolute;
    top: 8px;
    left: 8px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 1;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.badge-new {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.badge-bestseller {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    top: 38px;
}

.product-details {
    padding: 12px;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.product-title {
    font-size: 0.9rem;
    font-weight: 500;
    color: #2d3748;
    margin-bottom: 8px;
    line-height: 1.4;
    min-height: 2.8em;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #e53e3e;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8rem;
    color: #718096;
    margin-top: auto;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 4px;
}

.product-rating i {
    color: #fbbf24;
    font-size: 0.85rem;
}

.out-of-stock,
.low-stock {
    margin-top: 8px;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-align: center;
}

.out-of-stock {
    background: #fee;
    color: #c53030;
}

.low-stock {
    background: #fef5e7;
    color: #d97706;
}
</style>
@endsection
