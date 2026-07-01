@extends('layouts.main')

@section('content')
    <div class="container py-5">
        <!-- Hero Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="bg-gradient-primary rounded-4 p-5 text-white position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 opacity-10 d-none d-md-block">
                        <i class="bi bi-laptop fs-1" style="font-size: 15rem;"></i>
                    </div>
                    <div class="position-relative" style="z-index: 1;">
                        <h1 class="display-4 fw-bold mb-3">Техника для жизни</h1>
                        <p class="fs-5 mb-4 opacity-75" style="max-width: 500px;">
                            Откройте мир современных технологий с лучшими брендами по выгодным ценам
                        </p>
                        <div class="d-flex flex-wrap gap-3">
                            <a href="#products" class="btn btn-light btn-lg rounded-3 px-4">
                                <i class="bi bi-grid-3x3-gap-fill me-2"></i>
                                Все товары
                            </a>
                            <a href="#" class="btn btn-outline-light btn-lg rounded-3 px-4">
                                <i class="bi bi-tags me-2"></i>
                                Акции
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <form action="{{ route('home') }}" method="GET" id="filterForm">
                            <div class="row g-3 align-items-end">
                                <!-- Поиск -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-muted small text-uppercase">
                                        <i class="bi bi-search me-1"></i> Поиск
                                    </label>
                                    <div class="input-group">
                                        <input name="search" type="text" class="form-control form-control-lg border-end-0"
                                               value="{{ request()->input('search') }}" placeholder="Найти товар...">
                                        <button class="btn btn-primary btn-lg" type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Категория -->
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-muted small text-uppercase">
                                        <i class="bi bi-tag me-1"></i> Категория
                                    </label>
                                    <select name="category" class="form-select form-select-lg" onchange="this.form.submit()">
                                        <option value="">Все категории</option>
                                        @foreach($categories ?? [] as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Цена от -->
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-muted small text-uppercase">
                                        <i class="bi bi-currency-ruble me-1"></i> Цена от
                                    </label>
                                    <input name="price_from" type="number" class="form-control form-control-lg"
                                           value="{{ request('price_from') }}" placeholder="0" min="0"
                                           onchange="this.form.submit()">
                                </div>

                                <!-- Цена до -->
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-muted small text-uppercase">
                                        <i class="bi bi-currency-ruble me-1"></i> Цена до
                                    </label>
                                    <input name="price_to" type="number" class="form-control form-control-lg"
                                           value="{{ request('price_to') }}" placeholder="999999" min="0"
                                           onchange="this.form.submit()">
                                </div>

                                <!-- Сортировка -->
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold text-muted small text-uppercase">
                                        <i class="bi bi-arrow-up-down me-1"></i> Сортировка
                                    </label>
                                    <select name="sort" class="form-select form-select-lg" onchange="this.form.submit()">
                                        <option value="created_at-asc" {{ request('sort') == 'created_at-desc' ? 'selected' : '' }}>Новинки</option>
                                        <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Цена ↑</option>
                                        <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Цена ↓</option>
                                        <option value="created_at-asc" {{ request('sort') == 'created_at-asc' ? 'selected' : '' }}>Сначала старые</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Дополнительная строка с кнопками -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-funnel me-2"></i>
                                            Применить фильтры
                                        </button>
                                        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                                            <i class="bi bi-arrow-counterclockwise me-2"></i>
                                            Сбросить все
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Filters -->
        @if(request()->hasAny(['search', 'category', 'price_from', 'price_to', 'sort']))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="text-muted small">Активные фильтры:</span>
                        @if(request('search'))
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                <i class="bi bi-search me-1"></i> {{ request('search') }}
                                <a href="{{ route('home', array_merge(request()->except(['search', 'page']))) }}" class="text-white text-decoration-none ms-1">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </span>
                        @endif
                        @if(request('category'))
                            @php
                                $categoryName = $categories->firstWhere('id', request('category'))->name ?? 'Категория';
                            @endphp
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                <i class="bi bi-tag me-1"></i> {{ $categoryName }}
                                <a href="{{ route('home', array_merge(request()->except(['category', 'page']))) }}" class="text-white text-decoration-none ms-1">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </span>
                        @endif
                        @if(request('price_from') || request('price_to'))
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                <i class="bi bi-currency-ruble me-1"></i>
                                {{ request('price_from') ? number_format(request('price_from'), 0, ',', ' ') : '0' }} ₽
                                -
                                {{ request('price_to') ? number_format(request('price_to'), 0, ',', ' ') : '∞' }} ₽
                                <a href="{{ route('home', array_merge(request()->except(['price_from', 'price_to', 'page']))) }}" class="text-dark text-decoration-none ms-1">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </span>
                        @endif
                        @if(request('sort') && request('sort') != 'newest')
                            <span class="badge bg-info rounded-pill px-3 py-2">
                                <i class="bi bi-arrow-up-down me-1"></i>
                                @switch(request('sort'))
                                    @case('price_asc') Цена ↑ @break
                                    @case('price_desc') Цена ↓ @break
                                    @case('popular') Популярные @break
                                    @case('oldest') Сначала старые @break
                                    @default Новинки
                                @endswitch
                                <a href="{{ route('home', array_merge(request()->except(['sort', 'page']))) }}" class="text-white text-decoration-none ms-1">
                                    <i class="bi bi-x-circle"></i>
                                </a>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Products Grid -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h4 fw-bold text-dark mb-0" id="products">
                        <i class="bi bi-grid-3x3-gap-fill text-primary me-2"></i>
                        Товары
                        <span class="badge bg-primary rounded-pill ms-2">{{ $products->total() ?? count($products) }}</span>
                    </h2>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary rounded-3" id="viewGrid" title="Сетка">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary rounded-3" id="viewList" title="Список">
                            <i class="bi bi-list-ul"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if(count($products) > 0)
            <!-- Products Grid View -->
            <div class="row g-4" id="productsGrid">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 product-card" data-category="{{ $product->category_id }}"
                         data-price="{{ $product->price }}" data-created="{{ $product->created_at->timestamp }}">
                        <div
                            class="card h-100 border-0 shadow-sm hover-shadow transition-all rounded-4 overflow-hidden">
                            <!-- Product Image -->
                            <div class="position-relative bg-light" style="height: 220px; overflow: hidden;">
                                <img src="{{ asset($product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="img-fluid w-100 h-100 object-fit-cover transition-all"
                                     style="object-fit: cover;">

                                <!-- Badges -->
                                <div class="position-absolute top-0 start-0 p-2">
                                    @if($product->created_at->diffInDays(now()) < 7)
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                            <i class="bi bi-star-fill me-1"></i> Новинка
                                        </span>
                                    @endif
                                    @if($product->price < 10000)
                                        <span class="badge bg-danger rounded-pill px-3 py-2 ms-1">
                                            <i class="bi bi-tags me-1"></i> Скидка
                                        </span>
                                    @endif
                                    <span class="badge bg-info rounded-pill px-3 py-2 ms-1">
                                        <i class="bi bi-calendar me-1"></i>
                                        {{ $product->created_at->format('d.m.Y') }}
                                    </span>
                                </div>

                                <!-- Wishlist Button -->
                                <button
                                    class="position-absolute top-0 end-0 m-2 btn btn-sm btn-white rounded-circle shadow-sm"
                                    style="width: 36px; height: 36px; padding: 0;">
                                    <i class="bi bi-heart"></i>
                                </button>

                                <!-- Quick View Button -->
                                <button
                                    class="position-absolute bottom-0 start-50 translate-middle-x mb-2 btn btn-dark btn-sm rounded-3 px-3 opacity-0-hover transition-all"
                                    onclick="quickView({{ $product->id }})">
                                    <i class="bi bi-eye me-1"></i> Быстрый просмотр
                                </button>
                            </div>

                            <div class="card-body p-3">
                                <!-- Category Badge -->
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 mb-2">
                                    <i class="bi bi-folder me-1"></i>
                                    {{ $product->category->name ?? 'Без категории' }}
                                </span>

                                <!-- Product Name -->
                                <h5 class="card-title fw-semibold text-dark mb-2 text-truncate-2"
                                    style="font-size: 1rem; height: 2.8rem;">
                                    {{ $product->name }}
                                </h5>

                                <!-- Tags -->
                                @if($product->tags->isNotEmpty())
                                    <div class="d-flex flex-wrap gap-1 mb-2">
                                        @foreach($product->tags as $tag)
                                            <span class="badge rounded-pill px-2 py-1" style="
                                                background: {{ $tag->color ?? '#6c757d' }};
                                                color: white;
                                                font-size: 0.65rem;
                                                font-weight: 500;
                                                opacity: 0.9;
                                            ">
                                                <i class="bi bi-tag-fill me-1" style="font-size: 0.5rem;"></i>
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Rating -->
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="text-warning">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                    </div>
                                    <small class="text-muted">(128)</small>
                                </div>

                                <!-- Price -->
                                <div class="d-flex align-items-center justify-content-between mt-2">
                                    <div>
                                        <span class="h5 fw-bold text-primary mb-0">
                                            {{ number_format($product->price, 0, ',', ' ') }} ₽
                                        </span>
                                        @if($product->price > 20000)
                                            <span class="text-muted text-decoration-line-through ms-2 small">
                                                {{ number_format($product->price * 1.2, 0, ',', ' ') }} ₽
                                            </span>
                                        @endif
                                    </div>
                                    <button onclick="addToCart({{ $product->id }})"
                                            class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px; padding: 0;">
                                        <i class="bi bi-cart-plus fs-5"></i>
                                    </button>
                                </div>

                                <!-- Дата создания -->
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Добавлен: {{ $product->created_at->format('d.m.Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(isset($products) && method_exists($products, 'links'))
                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="text-center py-5 my-5">
                <div class="bg-gradient-soft d-inline-block rounded-circle p-5 mb-4">
                    <i class="bi bi-box-seam fs-1 text-primary" style="font-size: 4rem;"></i>
                </div>
                <h3 class="fw-bold text-dark mb-3">Товары не найдены</h3>
                <p class="text-muted mx-auto" style="max-width: 400px;">
                    Попробуйте изменить параметры поиска или сбросьте все фильтры.
                </p>
                <a href="{{ route('home') }}" class="btn btn-primary btn-lg rounded-3 shadow-sm px-5 mt-3">
                    <i class="bi bi-arrow-counterclockwise me-2"></i>
                    Сбросить все фильтры
                </a>
            </div>
        @endif
    </div>

    <!-- Quick View Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-0">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <img src="" alt="" class="img-fluid rounded-3" id="quickViewImage">
                        </div>
                        <div class="col-md-6">
                            <h3 class="fw-bold mb-2" id="quickViewName">Название товара</h3>
                            <div class="mb-3">
                                <span class="badge bg-primary bg-opacity-10 text-primary" id="quickViewCategory">Категория</span>
                            </div>

                            <!-- Tags in Quick View -->
                            <div class="mb-3" id="quickViewTags">
                                <span class="badge bg-secondary rounded-pill px-2 py-1 me-1">
                                    <i class="bi bi-tag-fill me-1"></i> Теги
                                </span>
                            </div>

                            <p class="text-muted" id="quickViewDescription">Описание товара</p>
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <span class="h2 fw-bold text-primary mb-0" id="quickViewPrice">0 ₽</span>
                                <span class="text-muted text-decoration-line-through" id="quickViewOldPrice">0 ₽</span>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted" id="quickViewDate">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Добавлен:
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary btn-lg flex-grow-1 rounded-3"
                                        onclick="addToCartFromQuickView()">
                                    <i class="bi bi-cart-plus me-2"></i>
                                    Добавить в корзину
                                </button>
                                <button class="btn btn-outline-secondary btn-lg rounded-3">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom Styles */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
        }

        .bg-gradient-soft {
            background: linear-gradient(135deg, #e7f1ff, #f0e7ff);
        }

        .hover-shadow {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-shadow:hover {
            transform: translateY(-8px);
            box-shadow: 0 1.5rem 3rem rgba(0, 0, 0, .15) !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .opacity-0-hover {
            opacity: 0;
            transition: all 0.3s ease;
        }

        .product-card:hover .opacity-0-hover {
            opacity: 1;
        }

        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .btn-white {
            background: white;
            border: none;
            color: #6c757d;
        }

        .btn-white:hover {
            background: white;
            color: #dc3545;
            transform: scale(1.1);
        }

        /* Tag Animation */
        .badge {
            transition: all 0.2s ease;
        }

        .badge:hover {
            transform: scale(1.05);
            opacity: 1 !important;
        }

        /* Product Image Hover */
        .product-card .card img {
            transition: transform 0.5s ease;
        }

        .product-card:hover .card img {
            transform: scale(1.05);
        }

        /* Animation */
        .product-card {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .product-card:nth-child(1) { animation-delay: 0.05s; }
        .product-card:nth-child(2) { animation-delay: 0.1s; }
        .product-card:nth-child(3) { animation-delay: 0.15s; }
        .product-card:nth-child(4) { animation-delay: 0.2s; }
        .product-card:nth-child(5) { animation-delay: 0.25s; }
        .product-card:nth-child(6) { animation-delay: 0.3s; }
        .product-card:nth-child(7) { animation-delay: 0.35s; }
        .product-card:nth-child(8) { animation-delay: 0.4s; }
        .product-card:nth-child(9) { animation-delay: 0.45s; }
        .product-card:nth-child(10) { animation-delay: 0.5s; }
        .product-card:nth-child(11) { animation-delay: 0.55s; }
        .product-card:nth-child(12) { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .display-4 {
                font-size: 2.2rem;
            }

            .bg-gradient-primary {
                padding: 2rem !important;
            }

            .product-card .card img {
                height: 180px !important;
            }
        }

        /* Loader */
        .loading-spinner {
            display: none;
            width: 3rem;
            height: 3rem;
        }

        /* Price input styling */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            opacity: 1;
        }
    </style>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
        // View toggle
        let isGridView = true;
        document.getElementById('viewGrid')?.addEventListener('click', function () {
            if (!isGridView) {
                const grid = document.getElementById('productsGrid');
                grid.className = 'row g-4';
                grid.querySelectorAll('.product-card').forEach(card => {
                    card.className = 'col-lg-3 col-md-4 col-sm-6 product-card';
                });
                isGridView = true;
            }
        });

        document.getElementById('viewList')?.addEventListener('click', function () {
            if (isGridView) {
                const grid = document.getElementById('productsGrid');
                grid.className = 'row g-3';
                grid.querySelectorAll('.product-card').forEach(card => {
                    card.className = 'col-12 product-card';
                });
                isGridView = false;
            }
        });

        // Quick View
        function quickView(productId) {
            // In real implementation, fetch product data via AJAX
            const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));

            // Demo data - replace with actual AJAX call
            document.getElementById('quickViewImage').src = '{{ asset("storage/ps5i.webp") }}';
            document.getElementById('quickViewName').textContent = 'Игровая консоль PlayStation 5';
            document.getElementById('quickViewCategory').textContent = 'Игровые консоли';

            // Demo tags
            const tagsHtml = `
                <span class="badge bg-primary rounded-pill px-2 py-1 me-1">
                    <i class="bi bi-tag-fill me-1"></i> Игровая
                </span>
                <span class="badge bg-success rounded-pill px-2 py-1 me-1">
                    <i class="bi bi-tag-fill me-1"></i> 4K
                </span>
                <span class="badge bg-warning text-dark rounded-pill px-2 py-1 me-1">
                    <i class="bi bi-tag-fill me-1"></i> Новинка
                </span>
                <span class="badge bg-info rounded-pill px-2 py-1 me-1">
                    <i class="bi bi-tag-fill me-1"></i> Беспроводная
                </span>
            `;
            document.getElementById('quickViewTags').innerHTML = tagsHtml;

            document.getElementById('quickViewDescription').textContent = 'Мощная игровая консоль нового поколения с поддержкой 4K и трассировкой лучей.';
            document.getElementById('quickViewPrice').textContent = '49 990 ₽';
            document.getElementById('quickViewOldPrice').textContent = '59 990 ₽';
            document.getElementById('quickViewDate').textContent = 'Добавлен: 15.01.2024';

            modal.show();
        }

        // Add to cart
        function addToCart(productId) {
            // In real implementation, add to cart via AJAX
            alert('Товар добавлен в корзину!');
        }

        function addToCartFromQuickView() {
            alert('Товар добавлен в корзину!');
            bootstrap.Modal.getInstance(document.getElementById('quickViewModal')).hide();
        }

        // Автоматическая отправка формы при изменении фильтров
        document.addEventListener('DOMContentLoaded', function() {
            // Все select и input с атрибутом onchange="this.form.submit()" уже работают
            // Добавляем debounce для поля поиска
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                let timeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        this.form.submit();
                    }, 500);
                });
            }
        });
    </script>
@endsection
