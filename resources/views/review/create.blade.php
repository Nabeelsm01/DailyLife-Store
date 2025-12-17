@extends('layouts.app')
@section('title', 'รีวิวสินค้า')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="bg-white rounded-3 shadow p-4">
                <h2 class="fw-bold mb-4 text-center">
                    <i class="bi bi-star"></i> รีวิวสินค้า
                </h2>

                <!-- แสดงสินค้า -->
                <div class="d-flex align-items-center mb-4 p-3 bg-light rounded">
                    <img src="{{ asset('storage/' . $product->img_prd) }}" 
                         alt="{{ $product->name_prd }}" 
                         class="rounded me-3" 
                         style="width: 80px; height: 80px; object-fit: cover;">
                    <div>
                        <h6 class="mb-1">{{ $product->name_prd }}</h6>
                        <p class="text-danger mb-0 fw-bold">฿{{ number_format($product->price_prd, 2) }}</p>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('review.store', $product->id) }}" method="POST">
                    @csrf

                    <!-- ให้คะแนน -->
                    <div class="mb-4">
                        <label class="form-label">ให้คะแนน <span class="text-danger">*</span></label>
                        <div class="rating-stars text-center p-3">
                            <input type="hidden" name="rating" id="ratingValue" value="0">
                            <i class="bi bi-star rating-star" data-rating="1" style="font-size: 2.5rem; cursor: pointer; color: #ddd;"></i>
                            <i class="bi bi-star rating-star" data-rating="2" style="font-size: 2.5rem; cursor: pointer; color: #ddd;"></i>
                            <i class="bi bi-star rating-star" data-rating="3" style="font-size: 2.5rem; cursor: pointer; color: #ddd;"></i>
                            <i class="bi bi-star rating-star" data-rating="4" style="font-size: 2.5rem; cursor: pointer; color: #ddd;"></i>
                            <i class="bi bi-star rating-star" data-rating="5" style="font-size: 2.5rem; cursor: pointer; color: #ddd;"></i>
                        </div>
                        <p class="text-center text-muted" id="ratingText">กรุณาเลือกคะแนน</p>
                    </div>

                    <!-- คอมเมนต์ -->
                    <div class="mb-4">
                        <label class="form-label">ความคิดเห็น</label>
                        <textarea name="comment" class="form-control" rows="5" 
                                  placeholder="แบ่งปันประสบการณ์ของคุณ...">{{ old('comment') }}</textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-send"></i> ส่งรีวิว
                        </button>
                        <a href="{{ route('p_detail.show', $product->id) }}" class="btn btn-outline-secondary">
                            ยกเลิก
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // ระบบให้ดาว
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.rating-star');
        const ratingValue = document.getElementById('ratingValue');
        const ratingText = document.getElementById('ratingText');
        
        const ratingTexts = {
            1: 'แย่มาก',
            2: 'ไม่ดี',
            3: 'ปานกลาง',
            4: 'ดี',
            5: 'ดีมาก'
        };

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.getAttribute('data-rating');
                ratingValue.value = rating;
                ratingText.textContent = ratingTexts[rating];
                
                // อัปเดทสี
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.remove('bi-star');
                        s.classList.add('bi-star-fill');
                        s.style.color = '#ffc107';
                    } else {
                        s.classList.remove('bi-star-fill');
                        s.classList.add('bi-star');
                        s.style.color = '#ddd';
                    }
                });
            });

            // Hover effect
            star.addEventListener('mouseenter', function() {
                const rating = this.getAttribute('data-rating');
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.style.color = '#ffc107';
                    }
                });
            });

            star.addEventListener('mouseleave', function() {
                const currentRating = ratingValue.value;
                stars.forEach((s, index) => {
                    if (index < currentRating) {
                        s.style.color = '#ffc107';
                    } else {
                        s.style.color = '#ddd';
                    }
                });
            });
        });
    });
</script>
@endsection