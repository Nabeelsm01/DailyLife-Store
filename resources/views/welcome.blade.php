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
    <div class="p-1 py-3 bg-white rounded-3 my-2">
        <div class="d-flex flex-row pb-3">

            <a href="{{ route('all-product', ['category' => 'food']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="vegetable1.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">ผักสด</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'general']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="grocery-basket1.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">ของทั่วไป</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'cloth']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="cloth.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">เสื้อผ้า</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'bag']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="bag.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">กระเป๋า</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'electric']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="electric.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class=" " style="font-size: 12.5px; margin-top:18px;">เครื่องใช้ไฟฟ้า</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'toy']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="toy.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">ของเล่น</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'it']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="device.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">ไอที</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'sport']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="sport.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">กีฬา</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'bike']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="bike.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">จักรยาน</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'shoe']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="shoe.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">รองเท้า</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'tool']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="tool.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">เครื่องมือ</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'furniture']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="furniture.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">เฟอร์นิเจอร์</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'cosmice']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="cosmice.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">สำอาง</p>
            </div>
            </a>

            <a href="{{ route('all-product', ['category' => 'accessory']) }}" style="text-decoration:none; color:gray;">
            <div class=" rounded-3 text-center mx-2" style="width:5vw; height:10vh; background-color:rgb(230, 245, 255);">
                <div class="d-flex justify-content-center">
                    <img src="accessory.gif" alt="" class="mb-0"
                        style="width:60px; height:60px; object-fit:contain;">
                </div>
                <p class="mt-3 mb-0">ประดับ</p>
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
@endsection
