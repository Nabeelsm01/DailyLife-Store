@extends('layouts.app')
@section('title', 'แก้ไขสินค้า')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bg-white rounded-3 shadow p-4">
                <h2 class="fw-bold mb-4">
                    <i class="bi bi-pencil-square"></i> แก้ไขสินค้า
                </h2>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- ชื่อสินค้า -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">ชื่อสินค้า <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ old('name', $product->name_prd) }}" required>
                        </div>

                        <!-- รายละเอียด -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">รายละเอียดสินค้า</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $product->detail_prd) }}</textarea>
                        </div>

                        <!-- ราคา -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ราคา (บาท) <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" 
                                   value="{{ old('price', $product->price_prd) }}" required>
                        </div>

                        <!-- สต็อก -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">จำนวนสต็อก</label>
                            <input type="number" name="stock" class="form-control" 
                                   value="{{ old('stock', $product->stock_prd) }}">
                        </div>

                        <!-- หมวดหมู่ -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">หมวดหมู่</label>
                            <input type="text" name="category" class="form-control" 
                                   value="{{ old('category', $product->category_prd) }}" 
                                   placeholder="เช่น อาหาร, เครื่องดื่ม">
                        </div>

                        <!-- โปรโมชั่น -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ประเภทโปรโมชั่น</label>
                            <select name="promotion_type" class="form-select">
                                <option value="">ไม่มีโปรโมชั่น</option>
                                <option value="discount" {{ old('promotion_type', $product->promotion_type) == 'discount' ? 'selected' : '' }}>ลดราคา</option>
                                <option value="buy1get1" {{ old('promotion_type', $product->promotion_type) == 'buy1get1' ? 'selected' : '' }}>ซื้อ 1 แถม 1</option>
                            </select>
                        </div>

                        <!-- ค่าโปรโมชั่น -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ค่าโปรโมชั่น</label>
                            <input type="number" name="promotion_value" class="form-control" 
                                   value="{{ old('promotion_value', $product->promotion_value) }}" 
                                   placeholder="เช่น 10 (สำหรับลด 10 บาท)">
                        </div>

                        <!-- รูปภาพเดิม -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">รูปภาพปัจจุบัน</label>
                            <div class="mb-2">
                                @if($product->img_prd)
                                    <img src="{{ asset('storage/' . $product->img_prd) }}" 
                                         alt="{{ $product->name_prd }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 200px;">
                                @else
                                    <p class="text-muted">ไม่มีรูปภาพ</p>
                                @endif
                            </div>
                        </div>

                        <!-- อัปโหลดรูปใหม่ -->
                        <div class="col-md-12 mb-3">
                            <label class="form-label">เปลี่ยนรูปภาพ (ถ้าต้องการ)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">รองรับไฟล์ JPG, PNG ขนาดไม่เกิน 5MB</small>
                        </div>
                    </div>

                    <!-- ปุ่ม -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> บันทึกการแก้ไข
                        </button>
                        <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle"></i> ยกเลิก
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection