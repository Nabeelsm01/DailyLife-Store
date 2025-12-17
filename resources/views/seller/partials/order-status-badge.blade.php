@switch($status)
    @case('pending')
        <span class="badge bg-warning text-dark">รอดำเนินการ</span>
    @break

    @case('confirmed')
        <span class="badge bg-info">ยืนยันแล้ว</span>
    @break

    @case('processing')
        <span class="badge bg-primary">กำลังเตรียมสินค้า</span>
    @break

    @case('shipped')
        <span class="badge bg-secondary">จัดส่งแล้ว</span>
    @break

    @case('delivered')
        <span class="badge bg-success">ส่งสำเร็จ</span>
    @break

    @case('cancel_requested')
        <span class="badge bg-warning text-dark">ลูกค้าขอยกเลิก</span>
    @break

    @case('cancelled')
        <span class="badge bg-danger">ยกเลิกแล้ว</span>
    @break

    @default
        <span class="badge bg-danger">ยกเลิก</span>
@endswitch
