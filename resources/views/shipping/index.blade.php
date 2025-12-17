@extends('layouts.app')
@section('title', 'ระบบขนส่ง')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="bg-white rounded-3 shadow p-4">
                <!-- Logo/Icon -->
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width: 100px; height: 100px;">
                        <i class="bi bi-truck text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="fw-bold">ระบบขนส่ง</h3>
                    <p class="text-muted">ค้นหาและอัปเดทสถานะพัสดุ</p>
                </div>

                <!-- Alert -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- ฟอร์มค้นหา -->
                <form action="{{ route('shipping.search') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">หมายเลขพัสดุ</label>
                        <input type="text" 
                               name="tracking_number" 
                               class="form-control form-control-lg" 
                               placeholder="กรอกหมายเลขพัสดุ"
                               required
                               autofocus>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-search"></i> ค้นหา
                    </button>
                </form>

                <!-- คำแนะนำ -->
                <div class="mt-4 p-3 bg-light rounded">
                    <h6 class="fw-bold mb-2">
                        <i class="bi bi-info-circle"></i> วิธีใช้งาน
                    </h6>
                    <ol class="mb-0 small">
                        <li>กรอกหมายเลขพัสดุ</li>
                        <li>ระบบจะแสดงข้อมูลคำสั่งซื้อ</li>
                        <li>กดปุ่ม "ยืนยันส่งสำเร็จ" เมื่อส่งถึงลูกค้าแล้ว</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection