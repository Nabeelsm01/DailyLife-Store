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

    {{-- ภาพสไลด์ --}}
    <div id="myCarousel" class="carousel slide rounded-4 overflow-hidden" data-bs-ride="carousel" data-bs-interval="3000">

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="market.jpg" class="d-block w-100" style="height:150px; object-fit:cover;">
            </div>

            <div class="carousel-item">
                <img src="store2.jpg" class="d-block w-100" style="height:150px; object-fit:cover;">
            </div>

            <div class="carousel-item">
                <img src="clothes.jpg" class="d-block w-100" style="height:150px; object-fit:cover;">
            </div>

            <div class="carousel-item">
                <img src="sofa.jpg" class="d-block w-100" style="height:150px; object-fit:cover;">
            </div>

            <div class="carousel-item">
                <img src="it.jpg" class="d-block w-100" style="height:150px; object-fit:cover;">
            </div>

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="3"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="4"></button>
            </div>

            <div class="carousel-inner">

            </div>
        </div>

    </div>

    <p class="p-2 fs-5 my-0 fw-medium">หมวดหมู่สินค้า</p>
    <hr class="border border-white border-2 rounded my-0">

    {{-- catagori --}}
<div class="p-1 bg-white rounded-3 my-2">
    <div class="d-flex flex-row flex-wrap pb-1 justify-content-start">

        <a href="{{ route('all-product', ['category' => 'food']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="vegetable1.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">ผักสด</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'general']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="grocery-basket1.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">ของทั่วไป</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'cloth']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="cloth.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">เสื้อผ้า</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'bag']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="bag.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">กระเป๋า</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'electric']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="electric.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text-small">เครื่องใช้ไฟฟ้า</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'toy']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="toy.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">ของเล่น</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'it']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="device.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">ไอที</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'sport']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="sport.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">กีฬา</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'bike']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="bike.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">จักรยาน</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'shoe']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="shoe.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">รองเท้า</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'tool']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="tool.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">เครื่องมือ</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'furniture']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="furniture.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">เฟอร์นิเจอร์</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'cosmice']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="cosmice.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">สำอาง</p>
        </div>
        </a>

        <a href="{{ route('all-product', ['category' => 'accessory']) }}" style="text-decoration:none; color:gray;" class="category-item">
        <div class="rounded-3 text-center category-box" style="background-color:rgb(230, 245, 255);">
            <div class="d-flex justify-content-center">
                <img src="accessory.gif" alt="" class="mb-0 category-icon">
            </div>
            <p class="category-text">ประดับ</p>
        </div>
        </a>

    </div>
</div>

    {{-- โชว์สินค้ายอดนิยม --}}
    <div class="d-flex flex-row align-items-center">
        <p class="p-2 fs-5 my-0 me-auto fw-medium">สินค้ายอดนิยม <i class="bi bi-1-circle-fill text-orange" style="color: rgb(255, 183, 0);"></i></p>
        <a href="{{'all-product'}}" class="px-3 py-1 fs-6 text-decoration-none lh-lg text-secondary btn btn-light rounded-5 fw-medium">ดูทั้งหมด ></a>
    </div>
    <hr class="border border-white border-2 rounded my-0">

    <div class="product-slider-container">
        <!-- ปุ่มเลื่อนซ้าย -->
        <button class="slider-nav-btn slider-nav-prev" onclick="scrollSlider(this, 'prev')">
            ‹
        </button>
        
        <div class="product-slider-scroll"> <!-- ⭐ ลบ id="productSlider" ออก -->
            @foreach (
                $products
                    ->sortByDesc(fn($product) =>
                        ($product->averageRating() * 10) + $product->totalSold()
                    )
                    ->take(14)
                as $product
            )
             <a href="{{ route('p_detail.show', $product->id) }}" class="product-card-link" style="text-decoration:none; color:gray;">
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->img_prd) }}" alt="product" class="product-card-img">

                    <div class="product-info">
                        <p class="product-name">
                            {{ $product->name_prd }}
                        </p>
                        <p class="product-price">
                            <strong>฿ {{ $product->price_prd }}.-</strong>
                        </p>
                        <p class="product-rating">
                            {{ number_format($product->averageRating(), 1) }}/5 <i class="bi bi-star-fill"></i>
                            <span class="text-muted">({{ $product->reviewsCount() }})</span>
                            | ขาย {{ $product->totalSold() }} ชิ้น
                        </p>
                    </div>
                </div>
                </a>
            @endforeach

            <!-- Block "ดูเพิ่มเติม" -->
            <a href="{{ route('all-product') }}" class="product-view-more">
                <span>99+ ดูเพิ่มเติม</span>
            </a>
        </div>

        <!-- ปุ่มเลื่อนขวา -->
        <button class="slider-nav-btn slider-nav-next" onclick="scrollSlider(this, 'next')">
            ›
        </button>
    </div>


    {{-- สินค้าทั้งหมด --}}
    <div class="d-flex flex-row align-items-center">
        <p class="p-2 fs-5 my-0 me-auto fw-medium">สินค้าทั้งหมด</p>
        <a href="{{'all-product'}}" class="px-3 py-1 fs-6 text-decoration-none lh-lg text-secondary btn btn-light rounded-5 fw-medium">ดูทั้งหมด ></a>
    </div>
    <hr class="border border-white border-2 rounded my-0">

    <div class="product-slider-container">
        <!-- ปุ่มเลื่อนซ้าย -->
        <button class="slider-nav-btn slider-nav-prev" onclick="scrollSlider(this, 'prev')">
            ‹
        </button>

        <div class="product-slider-scroll"> <!-- ⭐ ลบ id="productSlider" ออก -->
            @foreach ($products->sortByDesc('created_at')->take(14) as $product)

             <a href="{{ route('p_detail.show', $product->id) }}" class="product-card-link" style="text-decoration:none; color:gray;">
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->img_prd) }}" alt="product" class="product-card-img">

                    <div class="product-info">
                        <p class="product-name">
                            {{ $product->name_prd }}
                        </p>
                        <p class="product-price">
                            <strong>฿ {{ $product->price_prd }}.-</strong>
                        </p>
                        <p class="product-rating">
                            {{ number_format($product->averageRating(), 1) }}/5 <i class="bi bi-star-fill"></i>
                            <span class="text-muted">({{ $product->reviewsCount() }})</span>
                            | ขาย {{ $product->totalSold() }} ชิ้น
                        </p>
                    </div>
                </div>
                </a>
            @endforeach

            <!-- Block "ดูเพิ่มเติม" -->
            <a href="{{ route('all-product') }}" class="product-view-more">
                <span>99+ ดูเพิ่มเติม</span>
            </a>
        </div>

        <!-- ปุ่มเลื่อนขวา -->
        <button class="slider-nav-btn slider-nav-next" onclick="scrollSlider(this, 'next')">
            ›
        </button>
    </div>

    <script>
        // ฟังก์ชันเช็คว่าเลื่อนสุดหรือยัง
        function updateNavButtons(slider) {
            const container = slider.closest('.product-slider-container');
            const prevBtn = container.querySelector('.slider-nav-prev');
            const nextBtn = container.querySelector('.slider-nav-next');

            // เช็คว่าเลื่อนสุดซ้ายหรือยัง
            if (slider.scrollLeft <= 0) {
                prevBtn.classList.add('hidden');
                container.classList.add('hide-left-shadow');
            } else {
                prevBtn.classList.remove('hidden');
                container.classList.remove('hide-left-shadow');
            }

            // เช็กว่าเลื่อนสุดขวาหรือยัง
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            if (slider.scrollLeft >= maxScroll - 5) {
                nextBtn.classList.add('hidden');
                container.classList.add('hide-right-shadow');
            } else {
                nextBtn.classList.remove('hidden');
                container.classList.remove('hide-right-shadow');
            }
        }

        // ฟังก์ชันเลื่อน Slider
        function scrollSlider(button, direction) {
            const container = button.closest('.product-slider-container');
            const slider = container.querySelector('.product-slider-scroll');
            const scrollAmount = 340;

            if (direction === 'next') {
                slider.scrollLeft += scrollAmount;
            } else {
                slider.scrollLeft -= scrollAmount;
            }

            setTimeout(() => updateNavButtons(slider), 300);
        }

        // เริ่มต้นเมื่อโหลดหน้า
        document.addEventListener('DOMContentLoaded', function() {
            // หาทุก slider ในหน้า
            const sliders = document.querySelectorAll('.product-slider-scroll');

            sliders.forEach(slider => {
                // เช็คสถานะปุ่มตอนเริ่มต้น
                updateNavButtons(slider);

                // เช็คสถานะปุ่มทุกครั้งที่เลื่อน
                slider.addEventListener('scroll', () => updateNavButtons(slider));
            });
        });
    </script>


<style>
    /* Product Slider Container */
.product-slider-container {
    background-color: rgb(151, 172, 186);
    padding: 0.5rem 0.7rem;
    border-radius: 1rem;
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
    position: relative;
}

/* Scrollable Product List */
.product-slider-scroll {
    display: flex;
    flex-direction: row;
    overflow-x: auto;
    overflow-y: hidden;
    gap: 8px;
    white-space: nowrap;
    scroll-behavior: smooth;
    padding: 10px 0;
    
    /* ซ่อน scrollbar แต่ยังเลื่อนได้ */
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE/Edge */
}

.product-slider-scroll::-webkit-scrollbar {
    display: none; /* Chrome/Safari/Opera */
}

/* เงาฟุ้งๆ ขอบซ้าย-ขวา */
.product-slider-container::before,
.product-slider-container::after {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 60px;
    pointer-events: none;
    z-index: 2;
    transition: opacity 0.3s ease; /* ⭐ เพิ่มบรรทัดนี้ */
}

.product-slider-container::before {
    left: 0;
    background: linear-gradient(to right, 
        rgba(151, 172, 186, 0.9) 0%, 
        rgba(151, 172, 186, 0) 100%);
}

.product-slider-container::after {
    right: 0;
    background: linear-gradient(to left, 
        rgba(151, 172, 186, 0.9) 0%, 
        rgba(151, 172, 186, 0) 100%);
}

/* ⭐ เพิ่มส่วนนี้ - ซ่อนเงาเมื่อปุ่มหาย */
.product-slider-container.hide-left-shadow::before {
    opacity: 0;
}

.product-slider-container.hide-right-shadow::after {
    opacity: 0;
}

/* ปุ่มเลื่อน */
.slider-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    z-index: 3;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    opacity: 1;
    pointer-events: auto;
}

.slider-nav-btn:hover {
    background: white;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.slider-nav-btn.hidden {
    opacity: 0;
    pointer-events: none;
}

.slider-nav-prev {
    left: 10px;
}

.slider-nav-next {
    right: 10px;
}

/* Product Card */
.product-card {
    width: 160px;
    flex: 0 0 auto;
    padding-top: 0.5rem;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    background-color: #f8f9fa;
    border-radius: 0.75rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Product Image */
.product-card-img {
    display: block;
    width: 100%;
    height: 100px;
    object-fit: cover;
    border: 1px;
    border-radius: 0.5rem;
    transition: transform 0.2s ease;
}

.product-card:hover .product-card-img {
    transform: scale(1.05);
}

/* Product Info Container */
.product-info {
    padding: 0.25rem;
    line-height: 1.7;
    font-size: 14px;
    height: 100px;
}

/* Product Name */
.product-name {
    margin-top: 0;
    margin-bottom: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal; /* ⭐ เพิ่มบรรทัดนี้ */
    line-height: 1.5;
}

/* Product Price */
.product-price {
    margin-top: 0;
    margin-bottom: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    color: rgb(224, 82, 0);
    font-size: 16px;
}

/* Product Rating */
.product-rating {
    margin-top: 0;
    margin-bottom: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 12px;
    color: rgb(224, 161, 0);
}

/* View More Link */
.product-view-more {
    width: 160px;
    flex: 0 0 auto;
    padding-top: 0.5rem;
    padding-left: 0.5rem;
    padding-right: 0.5rem;
    background-color: #212529;
    color: white;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: background-color 0.2s ease, transform 0.2s ease;
}

.product-view-more:hover {
    background-color: #000;
    transform: translateY(-5px);
}

.link-product{
    text-decoration: none;
    color:gray;
}

/* Base styles for category items */
.category-item {
    margin: 0.5rem;
    flex: 0 0 auto;
}

.category-box {
    width: 80px;
    height: 100px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 0.5rem;
}

.category-icon {
    width: 50px;
    height: 50px;
    object-fit: contain;
}

.category-text {
    margin-top: 0.5rem;
    margin-bottom: 0;
    font-size: 13px;
}

.category-text-small {
    margin-top: 0.5rem;
    margin-bottom: 0;
    font-size: 11px;
}

/* Mobile (xs) - 4 items per row */
@media (max-width: 575.98px) {
    .category-item {
        flex: 0 0 calc(25% - 1rem);
        margin: 0.5rem;
    }
    
    .category-box {
        width: 100%;
        height: 90px;
    }
    
    .category-icon {
        width: 40px;
        height: 40px;
    }
    
    .category-text {
        font-size: 11px;
    }
    
    .category-text-small {
        font-size: 9px;
    }
}

/* Small tablets (sm) - 5 items per row */
@media (min-width: 576px) and (max-width: 767.98px) {
    .category-item {
        flex: 0 0 calc(20% - 1rem);
    }
    
    .category-box {
        width: 100%;
        height: 95px;
    }
    
    .category-icon {
        width: 45px;
        height: 45px;
    }
    
    .category-text {
        font-size: 12px;
    }
    
    .category-text-small {
        font-size: 10px;
    }
}

/* Tablets (md) - 7 items per row */
@media (min-width: 768px) and (max-width: 991.98px) {
    .category-item {
        flex: 0 0 calc(14.28% - 1rem);
    }
    
    .category-box {
        width: 100%;
        height: 100px;
    }
    
    .category-icon {
        width: 50px;
        height: 50px;
    }
}

/* Desktop (lg) - 10 items per row */
@media (min-width: 992px) and (max-width: 1199.98px) {
    .category-item {
        flex: 0 0 calc(10% - 1rem);
    }
    
    .category-box {
        width: 100%;
        height: 100px;
    }
}

/* Large Desktop (xl) - keep original 14 items visible */
@media (min-width: 1200px) {
    .category-item {
        flex: 0 0 calc(7.14% - 1rem);
    }
    
    .category-box {
        width: 100%;
        min-width: 80px;
    }
}
</style>
@endsection
