<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Мой магазин')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        .navbar-custom .navbar-brand {
            font-weight: 700;
            color: #fff;
            font-size: 1.5rem;
        }
        .navbar-custom .navbar-brand:hover {
            color: #e94560;
        }
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.8) !important;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .navbar-custom .nav-link:hover {
            color: #e94560 !important;
            transform: translateY(-2px);
        }
        .navbar-custom .btn-outline-light {
            border-color: rgba(255,255,255,0.3);
            color: #fff;
            transition: all 0.3s ease;
        }
        .navbar-custom .btn-outline-light:hover {
            background: #e94560;
            border-color: #e94560;
            transform: translateY(-2px);
        }
        .navbar-custom .btn-primary {
            background: #e94560;
            border-color: #e94560;
            transition: all 0.3s ease;
        }
        .navbar-custom .btn-primary:hover {
            background: #c73652;
            border-color: #c73652;
            transform: translateY(-2px);
        }
        .dropdown-menu {
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            border: none;
            padding: 0.5rem 0;
        }
        .dropdown-item {
            padding: 0.5rem 1.5rem;
            transition: all 0.2s ease;
        }
        .dropdown-item:hover {
            background: #f8f9fa;
            color: #e94560;
        }
        .dropdown-item i {
            width: 20px;
            margin-right: 8px;
            color: #e94560;
        }
        .category-dropdown .dropdown-toggle::after {
            display: none;
        }
        .category-dropdown .dropdown-menu {
            min-width: 250px;
            padding: 0.8rem 0;
        }
        .category-dropdown .dropdown-item {
            padding: 0.6rem 1.8rem;
            font-weight: 500;
        }
        .category-dropdown .dropdown-submenu {
            position: relative;
        }
        .category-dropdown .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
            border-radius: 10px;
        }
        .footer-custom {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: rgba(255,255,255,0.8);
            padding: 3rem 0 1.5rem;
            margin-top: auto;
        }
        .footer-custom h5 {
            color: #fff;
            font-weight: 600;
            margin-bottom: 1.2rem;
        }
        .footer-custom a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            margin-bottom: 0.5rem;
        }
        .footer-custom a:hover {
            color: #e94560;
            transform: translateX(5px);
        }
        .footer-custom .social-icons a {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        .footer-custom .social-icons a:hover {
            background: #e94560;
            transform: translateY(-5px);
        }
        .footer-custom .border-top {
            border-color: rgba(255,255,255,0.1) !important;
        }
        .breadcrumb-custom {
            background: #f8f9fa;
            padding: 0.8rem 0;
            margin-bottom: 2rem;
            border-radius: 0;
        }
        @media (max-width: 991.98px) {
            .category-dropdown .dropdown-submenu .dropdown-menu {
                left: 0;
                margin-top: 0;
            }
        }
    </style>
</head>
<body>
<!-- ШАПКА -->
<header>
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <!-- Логотип -->
            <a class="navbar-brand" href="#">
                <i class="fas fa-store me-2"></i>ShopName
            </a>

            <!-- Кнопка для мобильных -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
                    aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Основное меню -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Главная -->
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-home me-1"></i>Главная</a>
                    </li>

                    <!-- Категории с подкатегориями -->
                    <li class="nav-item dropdown category-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-th-list me-1"></i>Категории
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Электроника -->
                            @foreach($parentCategories as $parentCategory)
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#">
                                   {{ $parentCategory->title }}
                                </a>
                                @if($parentCategory->children->isNotEmpty())
                                <ul class="dropdown-menu">
                                    @foreach($parentCategory->children as $subCategory)
                                    <li><a class="dropdown-item" href="#">{{ $subCategory->title }}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach

                        </ul>
                    </li>

                    <!-- О нас -->
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-info-circle me-1"></i>О нас</a>
                    </li>

                    <!-- Контакты -->
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-envelope me-1"></i>Контакты</a>
                    </li>
                </ul>

                @auth
                    <!-- Dropdown профиля -->
                    <div class="dropdown profile-dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <div class="avatar-circle">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="avatar">
                                @else
                                    <span>{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <span class="d-none d-lg-inline text-white fw-500">
                {{ auth()->user()->name }}
            </span>
                            <i class="fas fa-chevron-down ms-1" style="font-size: 0.7rem;"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end profile-menu">
                            <!-- Шапка дропдауна -->
                            <li class="profile-header">
                                <div class="d-flex align-items-center gap-3 p-3">
                                    <div class="avatar-circle avatar-lg">
                                        @if(auth()->user()->avatar)
                                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="avatar">
                                        @else
                                            <span>{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fw-bold text-truncate">{{ auth()->user()->name }}</div>
                                        <small class="text-muted text-truncate d-block">{{ auth()->user()->email }}</small>
                                    </div>
                                </div>
                            </li>

                            <li><hr class="dropdown-divider my-1"></li>

                            <!-- Мой профиль -->
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user-circle"></i>
                                    <span>Мой профиль</span>
                                </a>
                            </li>

                            <!-- Мои заказы -->
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span>Мои заказы</span>
                                    <span class="badge bg-danger rounded-pill ms-auto">3</span>
                                </a>
                            </li>

                            <!-- Избранное -->
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-heart"></i>
                                    <span>Избранное</span>
                                </a>
                            </li>

                            <!-- Корзина -->
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Корзина</span>
                                </a>
                            </li>

                            <li><hr class="dropdown-divider my-1"></li>

                            <!-- Настройки -->
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog"></i>
                                    <span>Настройки</span>
                                </a>
                            </li>

                            <!-- Безопасность -->
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Безопасность</span>
                                </a>
                            </li>

                            <!-- Админ-панель (только для админа) -->
                            @if(auth()->user()->is_admin ?? false)
                                <li>
                                    <a class="dropdown-item text-warning" href="#">
                                        <i class="fas fa-user-shield"></i>
                                        <span>Админ-панель</span>
                                    </a>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider my-1"></li>

                            <!-- Выход -->
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger logout-btn">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Выйти из аккаунта</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <!-- Кнопки входа и регистрации -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm px-3">
                            <i class="fas fa-sign-in-alt me-1"></i>Вход
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-3">
                            <i class="fas fa-user-plus me-1"></i>Регистрация
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
</header>

<!-- Хлебные крошки (опционально) -->
@if (isset($breadcrumbs) && count($breadcrumbs) > 0)
    <div class="breadcrumb-custom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Главная</a></li>
                    @foreach($breadcrumbs as $item)
                        @if($loop->last)
                            <li class="breadcrumb-item active" aria-current="page">{{ $item }}</li>
                        @else
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none">{{ $item }}</a></li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
@endif

<!-- ОСНОВНОЙ КОНТЕНТ -->
<main class="main-content">
    <div class="container py-4">
        @yield('content')
    </div>
</main>

<!-- ФУТЕР -->
<footer class="footer-custom">
    <div class="container">
        <div class="row g-4">
            <!-- О магазине -->
            <div class="col-lg-4 col-md-6">
                <h5><i class="fas fa-store me-2"></i>О магазине</h5>
                <p class="text-white-50" style="font-size: 0.95rem;">
                    Лучший интернет-магазин с широким ассортиментом товаров.
                    Качество и надежность — наши главные приоритеты.
                </p>
                <div class="social-icons mt-3">
                    <a href="#"><i class="fab fa-vk"></i></a>
                    <a href="#"><i class="fab fa-telegram"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Быстрые ссылки -->
            <div class="col-lg-2 col-md-6">
                <h5><i class="fas fa-link me-2"></i>Быстро</h5>
                <a href="#"><i class="fas fa-chevron-right me-1" style="font-size: 10px;"></i>Главная</a><br>
                <a href="#"><i class="fas fa-chevron-right me-1" style="font-size: 10px;"></i>Каталог</a><br>
                <a href="#"><i class="fas fa-chevron-right me-1" style="font-size: 10px;"></i>О нас</a><br>
                <a href="#"><i class="fas fa-chevron-right me-1" style="font-size: 10px;"></i>Контакты</a>
            </div>

            <!-- Категории -->
            <div class="col-lg-2 col-md-6">
                <h5><i class="fas fa-th-list me-2"></i>Категории</h5>
                <a href="#"><i class="fas fa-chevron-right me-1" style="font-size: 10px;"></i>Электроника</a><br>
            </div>

            <!-- Контакты -->
            <div class="col-lg-4 col-md-6">
                <h5><i class="fas fa-address-card me-2"></i>Контакты</h5>
                <p class="text-white-50 mb-1">
                    <i class="fas fa-map-marker-alt me-2" style="color: #e94560;"></i>
                    г. Москва, ул. Примерная, д. 1
                </p>
                <p class="text-white-50 mb-1">
                    <i class="fas fa-phone me-2" style="color: #e94560;"></i>
                    +7 (999) 123-45-67
                </p>
                <p class="text-white-50 mb-3">
                    <i class="fas fa-envelope me-2" style="color: #e94560;"></i>
                    info@shopname.ru
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-headset"></i> Поддержка
                    </a>
                    <a href="#" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-question-circle"></i> FAQ
                    </a>
                </div>
            </div>
        </div>

        <!-- Копирайт -->
        <div class="border-top pt-3 mt-4 text-center text-white-50" style="border-color: rgba(255,255,255,0.1) !important;">
            <p class="mb-0" style="font-size: 0.9rem;">
                &copy; {{ date('Y') }} ShopName. Все права защищены.
            </p>
        </div>
    </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Дополнительный скрипт для подменю на hover -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Для десктопов: открытие подменю при наведении
        if (window.innerWidth > 991) {
            const dropdowns = document.querySelectorAll('.dropdown-submenu');
            dropdowns.forEach(function(dropdown) {
                dropdown.addEventListener('mouseenter', function(e) {
                    const menu = this.querySelector('.dropdown-menu');
                    if (menu) {
                        menu.classList.add('show');
                    }
                });
                dropdown.addEventListener('mouseleave', function(e) {
                    const menu = this.querySelector('.dropdown-menu');
                    if (menu) {
                        menu.classList.remove('show');
                    }
                });
            });
        }
    });
</script>
@stack('scripts')
</body>
</html>
