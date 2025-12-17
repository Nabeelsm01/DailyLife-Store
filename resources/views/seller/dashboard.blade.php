@extends('layouts.app')
@section('title', 'Dashboard ผู้ขาย')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            @if($shop->shop_logo)
                <img src="{{ asset('storage/' . $shop->shop_logo) }}" 
                     alt="Logo" 
                     class="rounded-circle me-3" 
                     style="width: 60px; height: 60px; object-fit: cover;">
            @else
                <div class="bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" 
                     style="width: 60px; height: 60px;">
                    <i class="bi bi-shop fs-3"></i>
                </div>
            @endif
            <div>
                <h2 class="fw-bold mb-0">{{ $shop->shop_name }}</h2>
                <p class="text-muted mb-0">
                    <i class="bi bi-geo-alt"></i> {{ Str::limit($shop->shop_address, 50) }}
                </p>
            </div>
        </div>
        <div>
            <a href="{{ route('seller.orders') }}" class="btn btn-info me-2 text-light">
                <i class="bi bi-receipt-cutoff"></i> คนสั่งซื้อแล้ว
            </a>
            
            <a href="{{ route('seller.editShop') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-gear"></i> ตั้งค่าร้าน
            </a>
            <a href="{{ route('p_form') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> เพิ่มสินค้า
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- สถิติ -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">สินค้าทั้งหมด</p>
                            <h3 class="fw-bold mb-0">{{ $products->total() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="bi bi-box text-primary fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">ยอดขายวันนี้</p>
                            <h3 class="fw-bold mb-0 text-success">฿0</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="bi bi-cash-stack text-success fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">คำสั่งซื้อใหม่</p>
                            <h3 class="fw-bold mb-0 text-warning">0</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="bi bi-cart-check text-warning fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">ผู้เข้าชม</p>
                            <h3 class="fw-bold mb-0 text-info">0</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded p-3">
                            <i class="bi bi-eye text-info fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- รายการสินค้า -->
    <div class="bg-white rounded-3 shadow-sm p-4">
        <h5 class="fw-bold mb-3">รายการสินค้า</h5>

        @if($products->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-box" style="font-size: 4rem; color: #ccc;"></i>
                <h5 class="text-muted mt-3">ยังไม่มีสินค้าในร้าน</h5>
                <a href="{{ route('p_form') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> เพิ่มสินค้าแรก
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">รูป</th>
                            <th>ชื่อสินค้า</th>
                            <th>ราคา</th>
                            <th>สต็อก</th>
                            <th>หมวดหมู่</th>
                            <th style="width: 150px;">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $product->img_prd) }}" 
                                     alt="{{ $product->name_prd }}" 
                                     class="rounded" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            </td>
                            <td>
                                <h6 class="mb-0">{{ $product->name_prd }}</h6>
                                <small class="text-muted">{{ Str::limit($product->detail_prd, 50) }}</small>
                            </td>
                            <td><strong class="text-danger">฿{{ number_format($product->price_prd, 2) }}</strong></td>
                            <td>
                                @if($product->stock_prd > 10)
                                    <span class="badge bg-success">{{ $product->stock_prd ?? 0 }}</span>
                                @elseif($product->stock_prd > 0)
                                    <span class="badge bg-warning">{{ $product->stock_prd ?? 0 }}</span>
                                @else
                                    <span class="badge bg-danger">หมด</span>
                                @endif
                            </td>
                            <td>{{ $product->category_prd ?? '-' }}</td>
                            <!-- ในตาราง -->
                                <td>
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    
                                    <form action="{{ route('product.delete', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('ต้องการลบสินค้า {{ $product->name_prd }} หรือไม่?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
