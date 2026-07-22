<!-- resources/views/components/header.blade.php -->

<style>
    /* Стили для header - темная тема как в основном layout */
    .header {
        background: #1a202c;
        padding: 12px 0;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    /* Логотип */
    .header-logo {
        color: #fff;
        font-size: 24px;
        font-weight: 800;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
        flex: 0 0 auto;
    }

    .header-logo:hover {
        color: #63b3ed;
    }

    .header-logo i {
        color: #63b3ed;
        font-size: 28px;
    }

    .header-logo__img {
        width: 40px;
        height: 40px;
        background: #0d6efd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 20px;
        flex-shrink: 0;
    }

    .header-logo__text {
        font-size: 24px;
        font-weight: 700;
        color: #63b3ed;
    }

    /* Поиск */
    .header-search {
        flex: 1;
        max-width: 500px;
        position: relative;
        min-width: 200px;
    }

    .header-search__form {
        display: flex;
        position: relative;
        width: 100%;
    }

    .header-search__wrapper {
        display: flex;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        background: #2d3748;
    }

    .header-search__category {
        padding: 10px 15px;
        border: none;
        background: #2d3748;
        color: #a0aec0;
        font-size: 14px;
        cursor: pointer;
        outline: none;
        min-width: 140px;
        transition: background 0.3s;
    }

    .header-search__category:hover,
    .header-search__category:focus {
        background: #374151;
    }

    .header-search__input {
        flex: 1;
        padding: 10px 15px;
        border: none;
        outline: none;
        background: #2d3748;
        color: #fff;
        font-size: 14px;
        min-width: 100px;
    }

    .header-search__input::placeholder {
        color: #a0aec0;
    }

    .header-search__input:focus {
        background: #374151;
    }

    .header-search__button {
        padding: 10px 18px;
        background: transparent;
        color: #a0aec0;
        border: none;
        cursor: pointer;
        transition: color 0.3s;
        font-size: 16px;
    }

    .header-search__button:hover {
        color: #63b3ed;
    }

    .header-search__results {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        display: none;
        max-height: 400px;
        overflow-y: auto;
        padding: 8px 0;
        z-index: 1001;
    }

    .search-result__item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        text-decoration: none;
        color: #1a202c;
        transition: background 0.2s ease;
        border-bottom: 1px solid #f7fafc;
    }

    .search-result__item:last-child {
        border-bottom: none;
    }

    .search-result__item:hover {
        background: #f7fafc;
    }

    .search-result__item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 8px;
        background: #f7fafc;
        flex-shrink: 0;
    }

    .search-result__item .info {
        flex: 1;
    }

    .search-result__item .name {
        font-weight: 500;
        font-size: 14px;
        color: #1a202c;
    }

    .search-result__item .price {
        font-size: 13px;
        color: #2b6cb0;
        font-weight: 600;
    }

    .search-result__item .category {
        font-size: 11px;
        color: #a0aec0;
    }

    .search-result__empty {
        padding: 30px;
        text-align: center;
        color: #718096;
    }

    .search-result__empty i {
        font-size: 24px;
        display: block;
        margin-bottom: 8px;
        color: #a0aec0;
    }

    /* Корзина */
    .header-actions {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
    }

    .header-actions__cart {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 16px;
        background: transparent;
        color: #e2e8f0;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 14px;
        position: relative;
        text-decoration: none;
    }

    .header-actions__cart:hover {
        background: #2d3748;
        color: #fff;
    }

    .header-actions__cart i {
        font-size: 20px;
        color: #63b3ed;
    }

    .header-actions__cart-text {
        color: #e2e8f0;
    }

    .header-actions__cart-badge {
        background: #e53e3e;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
        margin-left: 5px;
        min-width: 20px;
        text-align: center;
    }

    /* ========== СТИЛИ ДЛЯ СЕЛЕКТОРА ЯЗЫКА ========== */
    .header-language {
        position: relative;
        flex: 0 0 auto;
    }

    .header-language__button {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 8px 10px;
        background: transparent;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #e2e8f0;
        font-size: 14px;
        font-weight: 500;
    }

    .header-language__button:hover {
        background: #2d3748;
        color: #fff;
    }

    .header-language__button .flag {
        font-size: 20px;
        line-height: 1;
    }

    .header-language__button .lang-code {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: #a0aec0;
    }

    .header-language__button .arrow {
        font-size: 10px;
        color: #718096;
        transition: transform 0.3s;
    }

    .header-language__button.active .arrow {
        transform: rotate(180deg);
    }

    .header-language__dropdown {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 180px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        padding: 6px 0;
        display: none;
        z-index: 1001;
        overflow: hidden;
    }

    .header-language__dropdown.active {
        display: block;
    }

    .header-language__option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        color: #1a202c;
        text-decoration: none;
        transition: background 0.3s ease;
        font-size: 14px;
        border: none;
        background: none;
        width: 100%;
        cursor: pointer;
        text-align: left;
    }

    .header-language__option:hover {
        background: #f7fafc;
    }

    .header-language__option.active {
        background: #ebf4ff;
        color: #2b6cb0;
        font-weight: 600;
    }

    .header-language__option .flag {
        font-size: 20px;
    }

    .header-language__option .lang-name {
        flex: 1;
    }

    .header-language__option .check {
        color: #2b6cb0;
        font-size: 14px;
        display: none;
    }

    .header-language__option.active .check {
        display: inline;
    }

    /* Профиль пользователя */
    .header-user {
        position: relative;
        display: flex;
        align-items: center;
    }

    .header-user__button {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 12px;
        background: transparent;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #e2e8f0;
        text-decoration: none;
    }

    .header-user__button:hover {
        background: #2d3748;
        color: #fff;
    }

    .header-user__avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }

    .header-user__avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .header-user__name {
        font-size: 14px;
        font-weight: 500;
        white-space: nowrap;
        color: #e2e8f0;
    }

    .header-user__dropdown {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 220px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        padding: 8px 0;
        display: none;
        z-index: 1001;
    }

    .header-user__dropdown.active {
        display: block;
    }

    .header-user__dropdown-header {
        padding: 12px 16px;
        border-bottom: 1px solid #f7fafc;
        margin-bottom: 4px;
    }

    .header-user__dropdown-header .name {
        font-weight: 600;
        color: #1a202c;
        font-size: 14px;
    }

    .header-user__dropdown-header .email {
        font-size: 12px;
        color: #718096;
        margin-top: 2px;
    }

    .header-user__dropdown-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        color: #1a202c;
        text-decoration: none;
        transition: background 0.3s ease;
        font-size: 14px;
        border: none;
        background: none;
        width: 100%;
        cursor: pointer;
        text-align: left;
    }

    .header-user__dropdown-link:hover {
        background: #f7fafc;
    }

    .header-user__dropdown-link i {
        width: 18px;
        color: #2b6cb0;
        font-size: 16px;
        text-align: center;
    }

    .header-user__dropdown-link.danger {
        color: #e53e3e;
    }

    .header-user__dropdown-link.danger i {
        color: #e53e3e;
    }

    .header-user__dropdown-divider {
        height: 1px;
        background: #f7fafc;
        margin: 4px 0;
    }

    /* Гостевые кнопки */
    .header-guest {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .header-guest__btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .header-guest__btn--login {
        background: transparent;
        color: #e2e8f0;
        border: 1px solid #4a5568;
    }

    .header-guest__btn--login:hover {
        background: #2d3748;
        color: #fff;
        border-color: #63b3ed;
    }

    .header-guest__btn--register {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
    }

    .header-guest__btn--register:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: #fff;
    }

    /* Корзина дропдаун */
    .header-cart-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        min-width: 340px;
        padding: 16px;
        display: none;
        z-index: 1001;
    }

    .header-cart-dropdown.active {
        display: block;
    }

    .header-cart-dropdown__items {
        max-height: 320px;
        overflow-y: auto;
    }

    .header-cart-dropdown__items::-webkit-scrollbar {
        width: 4px;
    }

    .header-cart-dropdown__items::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 4px;
    }

    .header-cart-dropdown__items::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 4px;
    }

    .cart-dropdown-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f7fafc;
    }

    .cart-dropdown-item:last-child {
        border-bottom: none;
    }

    .cart-dropdown-item__image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
        background: #f7fafc;
        flex-shrink: 0;
    }

    .cart-dropdown-item__info {
        flex: 1;
    }

    .cart-dropdown-item__name {
        font-weight: 500;
        font-size: 14px;
        color: #1a202c;
        margin-bottom: 2px;
    }

    .cart-dropdown-item__price {
        font-size: 13px;
        color: #2b6cb0;
        font-weight: 600;
    }

    .cart-dropdown-item__remove {
        background: none;
        border: none;
        color: #e53e3e;
        cursor: pointer;
        font-size: 16px;
        padding: 4px 8px;
        transition: transform 0.3s;
        flex-shrink: 0;
    }

    .cart-dropdown-item__remove:hover {
        transform: scale(1.2);
    }

    .cart-dropdown__empty {
        text-align: center;
        padding: 20px 0;
        color: #718096;
    }

    .cart-dropdown__empty i {
        font-size: 36px;
        color: #e2e8f0;
        display: block;
        margin-bottom: 10px;
    }

    .cart-dropdown__footer {
        padding-top: 12px;
        border-top: 2px solid #f7fafc;
        margin-top: 8px;
    }

    .cart-dropdown__total {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        font-weight: 600;
        color: #1a202c;
        margin-bottom: 12px;
    }

    .cart-dropdown__button {
        display: block;
        padding: 10px;
        background: #2b6cb0;
        color: #fff;
        text-align: center;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.3s;
        border: none;
        width: 100%;
        cursor: pointer;
        font-size: 14px;
    }

    .cart-dropdown__button:hover {
        background: #1a4f7a;
        color: #fff;
    }

    /* Меню навигации */
    .header-nav {
        background: transparent;
        border-top: 1px solid rgba(255,255,255,0.08);
        margin-top: 8px;
        padding-top: 8px;
        width: 100%;
    }

    .header-nav__list {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 5px;
        flex-wrap: wrap;
    }

    .header-nav__item {
        position: relative;
    }

    .header-nav__item--catalog {
        position: relative;
    }

    .header-nav__link {
        display: block;
        padding: 8px 16px;
        color: #e2e8f0;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s;
        border-radius: 8px;
    }

    .header-nav__link i {
        margin-right: 6px;
    }

    .header-nav__link:hover,
    .header-nav__link.active {
        background: #2d3748;
        color: #fff;
    }

    .header-nav__catalog-toggle {
        padding: 8px 16px;
        background: #2d3748;
        color: #e2e8f0;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .header-nav__catalog-toggle:hover {
        background: #374151;
        color: #fff;
    }

    .header-nav__catalog-toggle i {
        color: #63b3ed;
    }

    .header-nav__dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 240px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        padding: 8px 0;
        list-style: none;
        display: none;
        z-index: 1000;
    }

    .header-nav__dropdown.active {
        display: block;
    }

    .header-nav__dropdown-item {
        position: relative;
    }

    .header-nav__dropdown-item:hover > .header-nav__subdropdown {
        display: block;
    }

    .header-nav__dropdown-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 16px;
        color: #1a202c;
        text-decoration: none;
        transition: background 0.3s;
        font-size: 14px;
    }

    .header-nav__dropdown-link:hover {
        background: #f7fafc;
    }

    .header-nav__dropdown-link i {
        margin-right: 10px;
        width: 18px;
        color: #2b6cb0;
        text-align: center;
    }

    .header-nav__subdropdown {
        position: absolute;
        top: 0;
        left: 100%;
        min-width: 200px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        padding: 8px 0;
        list-style: none;
        display: none;
        z-index: 1000;
    }

    .header-nav__subdropdown li a {
        display: block;
        padding: 10px 16px;
        color: #1a202c;
        text-decoration: none;
        transition: background 0.3s;
        font-size: 14px;
    }

    .header-nav__subdropdown li a:hover {
        background: #f7fafc;
    }

    /* Анимация бейджа */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }

    .badge-pulse {
        animation: pulse 0.3s ease;
    }

    /* Адаптивность */
    @media (max-width: 991px) {
        .header .container {
            flex-wrap: wrap;
            gap: 12px;
        }

        .header-search {
            order: 3;
            flex: 1 1 100%;
            max-width: 100%;
        }

        .header-actions__cart-text {
            display: none;
        }

        .header-actions__cart {
            padding: 8px 12px;
        }

        .header-user__name {
            display: none;
        }

        .header-user__button {
            padding: 6px 10px;
        }

        .header-guest__btn span {
            display: none;
        }

        .header-guest__btn {
            padding: 6px 10px;
        }

        .header-language__button .lang-code {
            display: none;
        }

        .header-language__button {
            padding: 6px 8px;
        }

        .header-nav__list {
            overflow-x: auto;
            flex-wrap: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .header-nav__list .header-nav__item--catalog {
            flex: 0 0 auto;
        }

        .header-nav__link {
            white-space: nowrap;
            padding: 6px 12px;
            font-size: 13px;
        }

        .header-nav__catalog-toggle {
            padding: 6px 12px;
            font-size: 13px;
        }

        .header-cart-dropdown {
            min-width: 300px;
            right: -20px;
        }

        .header-user__dropdown {
            right: -10px;
        }

        .header-language__dropdown {
            right: -10px;
        }
    }

    @media (max-width: 576px) {
        .header-logo {
            font-size: 20px;
        }

        .header-logo__text {
            font-size: 20px;
        }

        .header-logo__img {
            width: 32px;
            height: 32px;
            font-size: 16px;
        }

        .header-search__category {
            min-width: 100px;
            font-size: 12px;
            padding: 8px 10px;
        }

        .header-search__input {
            font-size: 13px;
            padding: 8px 10px;
        }

        .header-search__button {
            padding: 8px 12px;
        }

        .header-actions {
            gap: 4px;
        }

        .header-actions__cart i {
            font-size: 18px;
        }

        .header-actions__cart {
            padding: 6px 8px;
        }

        .header-language__button .flag {
            font-size: 16px;
        }

        .header-language__button {
            padding: 6px 6px;
        }

        .header-cart-dropdown {
            min-width: 280px;
            right: -40px;
            padding: 12px;
        }

        .header-nav__link {
            font-size: 12px;
            padding: 4px 10px;
        }

        .header-guest__btn {
            font-size: 12px;
            padding: 4px 8px;
        }

        .header-language__dropdown {
            min-width: 160px;
            right: -20px;
        }

        .header-language__option {
            padding: 8px 12px;
            font-size: 13px;
        }
    }
</style>
<!-- resources/views/components/header.blade.php -->

<header class="header">
    <div class="container">
        <!-- Логотип -->
        <a href="{{ route('home') }}" class="header-logo">
            <div class="header-logo__img">S</div>
            <span class="header-logo__text">ShopName</span>
        </a>

        <!-- Поиск -->
        <div class="header-search">
            <form action="#" method="GET" class="header-search__form" id="search-form">
                <div class="header-search__wrapper">
                    <select name="category" class="header-search__category" aria-label="Категория">
                        <option value="">Все категории</option>
                        <option value="1">Электроника</option>
                        <option value="2">Одежда</option>
                        <option value="3">Дом и сад</option>
                        <option value="4">Красота</option>
                        <option value="5">Спорт</option>
                    </select>
                    <input
                        type="text"
                        name="query"
                        class="header-search__input"
                        placeholder="Поиск товаров..."
                        value=""
                        autocomplete="off"
                        id="search-input"
                    >
                    <button type="submit" class="header-search__button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div id="search-results" class="header-search__results"></div>
            </form>
        </div>

        <!-- Правая часть: язык + корзина + профиль -->
        <div class="header-actions">
            <!-- ========== СЕЛЕКТОР ЯЗЫКА ========== -->
            @php
                $locales = [
                    'ru' => ['flag' => '🇷🇺', 'name' => 'Русский', 'code' => 'RU'],
                    'en' => ['flag' => '🇬🇧', 'name' => 'English', 'code' => 'EN'],
                ];
                $currentLocale = app()->getLocale();
                // Получаем данные текущего языка
                $currentLocaleData = $locales[$currentLocale] ?? $locales['ru'];
            @endphp

            <div class="header-language">
                <button class="header-language__button" id="language-toggle" type="button">
                    <span class="flag">{{ $currentLocaleData['flag'] }}</span>
                    <span class="lang-code">{{ $currentLocaleData['code'] }}</span>
                    <span class="arrow">▼</span>
                </button>

                <div class="header-language__dropdown" id="language-dropdown">
                    @foreach($locales as $locale => $data)
                        <button
                            class="header-language__option {{ $locale === $currentLocale ? 'active' : '' }}"
                            data-locale="{{ $locale }}"
                            data-flag="{{ $data['flag'] }}"
                            data-code="{{ $data['code'] }}"
                            type="button"
                        >
                            <span class="flag">{{ $data['flag'] }}</span>
                            <span class="lang-name">{{ $data['name'] }}</span>
                            <span class="check">✓</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Корзина -->
            <button class="header-actions__cart" id="cart-toggle" type="button">
                <i class="fas fa-shopping-cart"></i>
                <span class="header-actions__cart-text">Корзина</span>
                <span class="header-actions__cart-badge" id="cart-count">0</span>
            </button>

            <!-- Профиль пользователя / Гость -->
            @auth
                <!-- Авторизованный пользователь -->
                <div class="header-user">
                    <button class="header-user__button" id="user-dropdown-toggle" type="button">
                        <div class="header-user__avatar">
                            @if(Auth::user()->avatar)
                                <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                            @else
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            @endif
                        </div>
                        <span class="header-user__name">{{ Auth::user()->name }}</span>
                        <i class="fas fa-chevron-down" style="font-size: 12px; color: #718096;"></i>
                    </button>

                    <div class="header-user__dropdown" id="user-dropdown">
                        <div class="header-user__dropdown-header">
                            <div class="name">{{ Auth::user()->name }}</div>
                            <div class="email">{{ Auth::user()->email }}</div>
                        </div>

                        <a href="{{ route('profile') }}" class="header-user__dropdown-link">
                            <i class="fas fa-user"></i> Мой профиль
                        </a>
                        <a href="{{ route('profile.orders') }}" class="header-user__dropdown-link">
                            <i class="fas fa-shopping-bag"></i> Мои заказы
                        </a>
                        <a href="{{ route('profile.wishlist') }}" class="header-user__dropdown-link">
                            <i class="fas fa-heart"></i> Избранное
                        </a>
                        <a href="{{ route('profile.settings') }}" class="header-user__dropdown-link">
                            <i class="fas fa-cog"></i> Настройки
                        </a>

                        <div class="header-user__dropdown-divider"></div>

                        <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                            @csrf
                            <button type="submit" class="header-user__dropdown-link danger">
                                <i class="fas fa-sign-out-alt"></i> Выйти
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Гость -->
                <div class="header-guest">
                    <a href="{{ route('login') }}" class="header-guest__btn header-guest__btn--login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Вход</span>
                    </a>
                    <a href="{{ route('register') }}" class="header-guest__btn header-guest__btn--register">
                        <i class="fas fa-user-plus"></i>
                        <span>Регистрация</span>
                    </a>
                </div>
            @endauth

            <!-- Корзина дропдаун -->
            <div class="header-cart-dropdown" id="cart-dropdown">
                <div class="header-cart-dropdown__items" id="cart-items">
                    <div class="cart-dropdown__empty">
                        <i class="fas fa-shopping-cart"></i>
                        Корзина пуста
                    </div>
                </div>
            </div>
        </div>

        <!-- Навигация -->
        <nav class="header-nav">
            <ul class="header-nav__list">
                <li class="header-nav__item header-nav__item--catalog">
                    <button class="header-nav__catalog-toggle" id="catalog-toggle" type="button">
                        <i class="fas fa-bars"></i> @lang('header.catalog')
                    </button>
                    <ul class="header-nav__dropdown" id="catalog-dropdown">
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-laptop"></i> Электроника
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <ul class="header-nav__subdropdown">
                                <li><a href="#">Смартфоны</a></li>
                                <li><a href="#">Ноутбуки</a></li>
                                <li><a href="#">Планшеты</a></li>
                                <li><a href="#">Аксессуары</a></li>
                            </ul>
                        </li>
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-tshirt"></i> Одежда
                                <i class="fas fa-chevron-right"></i>
                            </a>
                            <ul class="header-nav__subdropdown">
                                <li><a href="#">Мужская</a></li>
                                <li><a href="#">Женская</a></li>
                                <li><a href="#">Детская</a></li>
                            </ul>
                        </li>
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-home"></i> Дом и сад
                            </a>
                        </li>
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-heart"></i> Красота
                            </a>
                        </li>
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-running"></i> Спорт
                            </a>
                        </li>
                        <li class="header-nav__dropdown-item">
                            <a href="#" class="header-nav__dropdown-link">
                                <i class="fas fa-gamepad"></i> Игрушки
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="header-nav__item">
                    <a href="{{ route('home') }}" class="header-nav__link active">
                        <i class="fas fa-home"></i> @lang('header.main')
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="#" class="header-nav__link">
                        <i class="fas fa-box"></i> @lang('header.product')
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="#" class="header-nav__link">
                        <i class="fas fa-tags"></i> Акции
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="#" class="header-nav__link">
                        <i class="fas fa-newspaper"></i> Блог
                    </a>
                </li>
                <li class="header-nav__item">
                    <a href="#" class="header-nav__link">
                        <i class="fas fa-phone"></i> Контакты
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========== ЯЗЫКОВОЙ СЕЛЕКТОР ==========
        const langToggle = document.getElementById('language-toggle');
        const langDropdown = document.getElementById('language-dropdown');
        const langOptions = document.querySelectorAll('.header-language__option');
        const currentFlag = document.getElementById('current-flag');
        const currentLangCode = document.getElementById('current-lang-code');

        // Обновление активного языка в интерфейсе
        function updateActiveLanguage(locale) {
            langOptions.forEach(option => {
                option.classList.remove('active');
                if (option.dataset.locale === locale) {
                    option.classList.add('active');
                    // Обновляем флаг и код в кнопке
                    if (currentFlag) {
                        currentFlag.textContent = option.dataset.flag;
                    }
                    if (currentLangCode) {
                        currentLangCode.textContent = option.dataset.code;
                    }
                }
            });
        }

        // Функция переключения языка
        function switchLanguage(locale) {
            // Отправляем запрос на сервер для смены языка
            fetch('{{ route("set-locale") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ locale: locale })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Обновляем интерфейс
                        updateActiveLanguage(locale);
                        // Перезагружаем страницу для применения переводов
                        location.reload();
                    }
                })
                .catch(() => {
                    // Fallback: перезагрузка с параметром
                    const url = new URL(window.location.href);
                    url.searchParams.set('lang', locale);
                    window.location.href = url.toString();
                });
        }

        // Toggle языкового дропдауна
        if (langToggle && langDropdown) {
            langToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                langDropdown.classList.toggle('active');
                langToggle.classList.toggle('active');

                // Закрываем другие дропдауны
                document.getElementById('user-dropdown')?.classList.remove('active');
                document.getElementById('cart-dropdown')?.classList.remove('active');
                document.getElementById('catalog-dropdown')?.classList.remove('active');
            });
        }

        // Выбор языка
        langOptions.forEach(option => {
            option.addEventListener('click', function(e) {
                e.stopPropagation();
                const locale = this.dataset.locale;
                switchLanguage(locale);
            });
        });

        // ========== ПРОФИЛЬ ПОЛЬЗОВАТЕЛЯ ==========
        const userToggle = document.getElementById('user-dropdown-toggle');
        const userDropdown = document.getElementById('user-dropdown');

        if (userToggle && userDropdown) {
            userToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('active');

                // Закрываем другие дропдауны
                document.getElementById('cart-dropdown')?.classList.remove('active');
                document.getElementById('catalog-dropdown')?.classList.remove('active');
                langDropdown?.classList.remove('active');
                langToggle?.classList.remove('active');
            });
        }

        // ========== КОРЗИНА ==========
        const cartToggle = document.getElementById('cart-toggle');
        const cartDropdown = document.getElementById('cart-dropdown');

        if (cartToggle && cartDropdown) {
            cartToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                cartDropdown.classList.toggle('active');

                // Закрываем другие дропдауны
                userDropdown?.classList.remove('active');
                document.getElementById('catalog-dropdown')?.classList.remove('active');
                langDropdown?.classList.remove('active');
                langToggle?.classList.remove('active');
            });
        }

        // ========== КАТАЛОГ ==========
        const catalogToggle = document.getElementById('catalog-toggle');
        const catalogDropdown = document.getElementById('catalog-dropdown');

        if (catalogToggle && catalogDropdown) {
            catalogToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                catalogDropdown.classList.toggle('active');

                // Закрываем другие дропдауны
                userDropdown?.classList.remove('active');
                cartDropdown?.classList.remove('active');
                langDropdown?.classList.remove('active');
                langToggle?.classList.remove('active');
            });
        }

        // ========== ЗАКРЫТИЕ ПРИ КЛИКЕ СНАРУЖИ ==========
        document.addEventListener('click', function() {
            userDropdown?.classList.remove('active');
            cartDropdown?.classList.remove('active');
            catalogDropdown?.classList.remove('active');
            langDropdown?.classList.remove('active');
            langToggle?.classList.remove('active');
        });

        // ========== ПРЕДОТВРАЩЕНИЕ ЗАКРЫТИЯ ПРИ КЛИКЕ ВНУТРИ ==========
        document.querySelectorAll(
            '.header-user__dropdown, ' +
            '.header-cart-dropdown, ' +
            '.header-nav__dropdown, ' +
            '.header-language__dropdown'
        ).forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });
</script>
