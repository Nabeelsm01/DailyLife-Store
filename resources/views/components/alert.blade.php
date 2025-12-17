@if(session('cart_success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'สำเร็จ!',
        text: '{{ session('cart_success') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 500,
        timerProgressBar: true
    });
</script>
@endif

@if(session('cart_error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'เกิดข้อผิดพลาด!',
        text: '{{ session('cart_error') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 500,
        timerProgressBar: true
    });
</script>
@endif