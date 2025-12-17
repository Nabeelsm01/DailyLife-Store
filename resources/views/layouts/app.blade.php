<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @yield('head')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=National+Park:wght@200..800&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts -->
    <!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
    @vite([
    'resources/sass/app.scss',
    'resources/js/app.js',
    'resources/css/product-slider.css',
])

    <script src="https://cdn.ckeditor.com/ckeditor5/47.2.0/ckeditor5.umd.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <style>
        body {
            background: #f0fcff;
            background: linear-gradient(132deg, rgba(240, 252, 255, 1) 0%, rgba(214, 255, 253, 1) 24%, rgba(219, 241, 255, 1) 100%);
            min-height: 100vh;

            font-family: "Prompt", sans-serif;
            font-weight: 400;
            font-style: Medium;
            color: gray;
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand text-secondary" href="{{ route('welcome') }}">
                    DailyLife Store
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a href="{{route('welcome')}}" class="nav-link"><i class="bi bi-house"></i> หน้าแรก</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link"><i class="bi bi-info-circle"></i> เกี่ยวกับ</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="{{route('order.history')}}" class="nav-link"><i class="bi bi-clock-history"></i> ประวัติการสั่งซื้อ</a>
                            </li>
                            </li>
                            <!-- ตรงส่วน Navbar ให้เพิ่ม Badge ที่ปุ่มตะกร้า -->
                            <li class="nav-item">
                                <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                                    <i class="bi bi-cart3"></i> ตะกร้า
                                    @auth
                                        @php
                                            $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum(
                                                'quantity',
                                            );
                                        @endphp
                                        @if ($cartCount > 0)
                                            <span
                                                class="position-absolute bottom-5 start-90 translate-middle badge rounded-pill px-1 fs-7" style="background-color: rgb(255, 137, 59);">
                                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                                                <span class="visually-hidden ">สินค้าในตะกร้า</span>
                                            </span>
                                        @endif
                                    @endauth
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- ใน Navbar เพิ่มเมนู -->
                                    @auth
                                        @if(Auth::user()->isSeller())
              
                                                <a class="dropdown-item" href="{{ route('seller.dashboard') }}">
                                                    <i class="bi bi-shop"></i> ร้านของฉัน
                                                </a>
                         
                                        @else
                            
                                                <a class="dropdown-item" href="{{ route('seller.register') }}">
                                                    <i class="bi bi-shop"></i> สมัครเป็นผู้ขาย
                                                </a>
                         
                                        @endif
                                    @endauth
                                    <a class="dropdown-item" href="{{ route('p_form') }}"><i class="bi bi-cloud-upload"></i> ลงทะเบียนสินค้า</a>
                                    <a class="dropdown-item" href="{{ route('shipping.index') }}"><i class="bi bi-truck"></i> ระบบขนส่ง</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        ออกจากระบบ
                                    </a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container p-2">
            @yield('content')
        </main>

        <!-- เพิ่มก่อนปิด </body> -->
        @include('components.alert')

    </div>
    <footer class="text-body-secondary py-5 bg-secondary">
        <div class="container text-white">
            <p class="float-end mb-1 ">
                <a href="#" class="text-white text-decoration-none">Back to top</a>
            </p>
            <p class="mb-1">© 2025 Company, Inc.</p>
        </div>
    </footer>
</body>

</html>
