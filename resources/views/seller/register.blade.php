@extends('layouts.app')
@section('title', 'สร้างร้านค้า')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="bg-white rounded-3 shadow p-4">
                <div class="text-center mb-4">
                    <i class="bi bi-shop text-primary" style="font-size: 3rem;"></i>
                    <h2 class="fw-bold mt-3">สร้างร้านค้าของคุณ</h2>
                    <p class="text-muted">กรอกข้อมูลร้านค้าเพื่อเริ่มต้นขายสินค้า</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('seller.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">ชื่อร้านค้า <span class="text-danger">*</span></label>
                        <input type="text" name="shop_name" 
                               class="form-control @error('shop_name') is-invalid @enderror" 
                               value="{{ old('shop_name') }}" 
                               placeholder="เช่น ร้านขายของชำยิ้ม" required>
                        @error('shop_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">รายละเอียดร้าน</label>
                        <textarea name="shop_description" 
                                  class="form-control @error('shop_description') is-invalid @enderror" 
                                  rows="3" 
                                  placeholder="บอกเล่าเกี่ยวกับร้านของคุณ">{{ old('shop_description') }}</textarea>
                        @error('shop_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ที่อยู่ร้านค้า <span class="text-danger">*</span></label>
                        <textarea name="shop_address" 
                                  class="form-control @error('shop_address') is-invalid @enderror" 
                                  rows="3" 
                                  placeholder="กรอกที่อยู่ร้านค้าแบบละเอียด" required>{{ old('shop_address') }}</textarea>
                        @error('shop_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">เบอร์โทรศัพท์</label>
                        <input type="text" name="shop_phone" 
                               class="form-control @error('shop_phone') is-invalid @enderror" 
                               value="{{ old('shop_phone') }}" 
                               placeholder="08X-XXX-XXXX">
                        @error('shop_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">โลโก้ร้าน (ถ้ามี)</label>
                        <input type="file" name="shop_logo" 
                               class="form-control @error('shop_logo') is-invalid @enderror" 
                               accept="image/*">
                        @error('shop_logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">รองรับไฟล์ JPG, PNG ขนาดไม่เกิน 2MB</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle"></i> สร้างร้านค้า
                        </button>
                        <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> ย้อนกลับ
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection