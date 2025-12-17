@extends('layouts.app')
@section('title', 'หน้าลงทะเบียนสินค้า')
@section('content')
    <div class="d-flex flex-row p-3 bg-white rounded-3 ">
        <h3 class="fw-semibold my-auto text-secondary">หน้าร้าน DailyLife Store / ลงทะเบียนสินค้า</h3>
    </div>
    <hr class="border border-white border-2 rounded ">

    <div class="p-3 bg-white rounded-3 my-2">
        <h4 class="p-2">ลงทะเบียนสินค้า</h4>
        <!-- ทำงานกับ Bootstrap 5 -->
        <form action="{{ route('product.insert') }}" method="POST" enctype="multipart/form-data" class="needs-validation"
            novalidate>
            @csrf

            <div class="card mb-3" style="background-color:rgb(247, 252, 255);">
                <div class="card-body">
                    <h5 class="card-title mb-3">เพิ่มสินค้าของคุณ</h5>

                    <div class="row g-3">
                        <!-- ชื่อสินค้า -->
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label">ชื่อสินค้า *พร้อมรายละเอียดสั้นๆ<span class="text-danger">*</span></label>
                            <input id="name" name="name" type="text" class="form-control" required>
                            <div class="invalid-feedback">กรุณากรอกชื่อสินค้า</div>
                        </div>

                        <!-- ราคา -->
                        <div class="col-12 col-md-3">
                            <label for="price" class="form-label">ราคา (บาท) <span class="text-danger">*</span></label>
                            <input id="price" name="price" type="number" min="0" class="form-control"
                                required>
                            <div class="invalid-feedback">กรุณากรอกราคาที่ถูกต้อง</div>
                        </div>

                        <!-- หมวดหมู่ -->
                        <div class="col-12 col-md-3">
                            <label for="category" class="form-label">หมวดหมู่</label>
                            <select name="category" class="form-select" required>
                                <option value="" disabled selected>-- เลือกหมวดหมู่ --</option>
                                <option value="selected">selected</option>
                                <option value="food">ผักสด</option>
                                <option value="general">ของทั่วไป</option>
                                <option value="cloth">เสื้อผ้า</option>
                                <option value="bag">กระเป๋า</option>
                                <option value="electric">เครื่องใช้ไฟฟ้า</option>
                                <option value="toy">ของเล่น</option>
                                <option value="it">ไอที</option>
                                <option value="sport">กีฬา</option>
                                <option value="bike">จักรยาน</option>
                                <option value="shoe">รองเท้า</option>
                                <option value="tool">เครื่องมือ</option>
                                <option value="furniture">เฟอร์นิเจอร์</option>
                                <option value="cosmice">สำอาง</option>
                                <option value="accessory">ประดับ</option>
                            </select>

                        </div>

                        <!-- คำอธิบาย -->
                        <div class="col-12">
                            <label for="description" class="form-label">รายละเอียดสินค้า</label>
                            <textarea id="description" name="description" class="form-control" rows="2"></textarea>
                        </div>

                        <!-- รูปภาพสินค้า -->
                        <div class="col-12 col-md-6">
                            <label for="image" class="form-label">รูปภาพสินค้า</label>

                            <!-- ตัวเลือกอัปโหลดสวย ๆ -->
                            <div class="input-group">
                                <input id="image" name="image" type="file" accept="image/*" class="form-control"
                                    onchange="previewImage(event)" required>
                            </div>
                            <div class="form-text">แนะนำขนาดภาพขั้นต่ำ 800x800px เพื่อแสดงผลสวยบนหน้าร้าน</div>

                            <!-- preview -->
                            <div class="mt-2">
                                <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded d-none"
                                    style="max-height:200px; object-fit:cover;">
                            </div>
                        </div>

                        <!-- สถานะสต็อก (optional) -->
                        <div class="col-12 col-md-3">
                            <label for="stock" class="form-label">สต็อก (ไม่จำเป็น)</label>
                            <input id="stock" name="stock" type="number" min="0" class="form-control"
                                placeholder="จำนวนคงเหลือ">
                        </div>

                        <!-- โปรโมชั่น: มี toggle เลือกว่าจะใส่หรือไม่ -->
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="hasPromotion"
                                    onchange="togglePromotion()">
                                <label class="form-check-label" for="hasPromotion">มีโปรโมชั่น
                                    (เลือกใส่หรือไม่ใส่ก็ได้)</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 d-none" id="promotionWrapper">
                            <div class="card card-body py-2">
                                <div class="row g-2 align-items-end">
                                
                                <!-- promotion type -->
                                <div class="col-6">
                                    <label class="form-label">ประเภทโปรโมชั่น</label>
                                    <select id="promotionType" name="promotion_type" class="form-select">
                                    <option value="percent" selected>ลดเป็น %</option>
                                    <option value="fixed">ลดเป็น บาท</option>
                                    </select>
                                </div>

                                <!-- promotion value -->
                                <div class="col-6">
                                    <label class="form-label">จำนวน</label>
                                    <div class="input-group">
                                    <input id="promotionValue" name="promotion_value" type="number" min="0" class="form-control" value="0">
                                    <span class="input-group-text" id="promotionSuffix">%</span>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>

                    </div> <!-- /.row -->

                </div> <!-- /.card-body -->

                <div class="card-footer d-flex justify-content-end gap-2">
                    <a href="{{ route('seller.dashboard')}}" class="btn btn-outline-secondary">ยกเลิก</a>
                    <button type="submit" class="btn btn-primary">บันทึกสินค้า</button>
                </div>
            </div> <!-- /.card -->
        </form>

        <!-- --- JS: image preview + toggle promotion + bootstrap validation --- -->
        <script>
            // preview รูปภาพ
            function previewImage(event) {
                const input = event.target;
                const preview = document.getElementById('imagePreview');

                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    const url = URL.createObjectURL(file);
                    preview.src = url;
                    preview.classList.remove('d-none');
                } else {
                    preview.src = '#';
                    preview.classList.add('d-none');
                }
            }

            // toggle promotion field /เปลี่ยน suffix ตามประเภทโปรโมชั่น
            // toggle promotion field
            function togglePromotion() {
                const chk = document.getElementById('hasPromotion');
                const wrap = document.getElementById('promotionWrapper');
                const promotionValueEl = document.getElementById('promotionValue');

                if (chk.checked) {
                wrap.classList.remove('d-none');
                } else {
                wrap.classList.add('d-none');
                promotionValueEl.value = '';
                }
            }

            // เปลี่ยน suffix ตามประเภทโปรโมชั่น (ทำงานตลอดเวลา)
            const promotionTypeEl = document.getElementById('promotionType');
            const promotionSuffixEl = document.getElementById('promotionSuffix');

            promotionTypeEl.addEventListener('change', function() {
                promotionSuffixEl.textContent = this.value === 'percent' ? '%' : '฿';
            });

            // Bootstrap form validation (optional)
            (function() {
                'use strict'
                const forms = document.querySelectorAll('.needs-validation')
                Array.from(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })()
        </script>


    </div>

    </div>

@endsection
