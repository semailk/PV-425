@extends('layouts.main')

@section('title', 'Оформление заказа')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Главная</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('basket.index') }}">Корзина</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Оформление заказа</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Информация о заказе -->
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-shopping-bag me-2 text-primary"></i>Товары в заказе</h5>
                    </div>
                    <div class="card-body">
                        <div id="cartItems">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Загрузка...</span>
                                </div>
                                <p class="mt-3 text-muted">Загрузка корзины...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Способ доставки -->
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-truck me-2 text-primary"></i>Способ доставки</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="delivery-option p-3 border rounded" data-delivery="courier">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="delivery" id="deliveryCourier" value="courier" checked>
                                        <label class="form-check-label fw-bold" for="deliveryCourier">
                                            <i class="fas fa-truck text-primary me-2"></i>Курьером
                                        </label>
                                    </div>
                                    <small class="text-muted d-block mt-2">Доставка по городу в течение 1-2 дней</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="delivery-option p-3 border rounded" data-delivery="pickup">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="delivery" id="deliveryPickup" value="pickup">
                                        <label class="form-check-label fw-bold" for="deliveryPickup">
                                            <i class="fas fa-store text-primary me-2"></i>Самовывоз
                                        </label>
                                    </div>
                                    <small class="text-muted d-block mt-2">Бесплатный самовывоз из магазина</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="delivery-option p-3 border rounded" data-delivery="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="delivery" id="deliveryPost" value="post">
                                        <label class="form-check-label fw-bold" for="deliveryPost">
                                            <i class="fas fa-mail-bulk text-primary me-2"></i>Почтой
                                        </label>
                                    </div>
                                    <small class="text-muted d-block mt-2">Доставка по всей стране 3-5 дней</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Информация о покупателе -->
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>Контактная информация</h5>
                    </div>
                    <div class="card-body">
                        <form id="orderForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fullName" class="form-label fw-bold">ФИО <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fullName" name="full_name" placeholder="Иванов Иван Иванович" required>
                                    <div class="invalid-feedback">Пожалуйста, укажите ваше ФИО</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-bold">Телефон <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="+7 (777) 123-45-67" required>
                                    <div class="invalid-feedback">Пожалуйста, укажите номер телефона</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="your@email.com" required>
                                <div class="invalid-feedback">Пожалуйста, укажите корректный email</div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label fw-bold">Адрес доставки</label>
                                <textarea class="form-control" id="address" name="address" rows="2" placeholder="г. Город, ул. Улица, д. 1, кв. 1"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label fw-bold">Комментарий к заказу</label>
                                <textarea class="form-control" id="comment" name="comment" rows="2" placeholder="Дополнительная информация для курьера..."></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Итоговая информация -->
                <div class="card position-sticky" style="top: 90px;">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2 text-primary"></i>Итог заказа</h5>
                    </div>
                    <div class="card-body">
                        <div id="cartSummary">
                            <div class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Загрузка...</span>
                                </div>
                                <p class="mt-2 text-muted">Расчет стоимости...</p>
                            </div>
                        </div>

                        <hr>

                        <form id="checkoutForm" action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="cart_data" id="cartData" value="">
                            <input type="hidden" name="delivery_method" id="deliveryMethod" value="courier">
                            <input type="hidden" name="total_amount" id="totalAmount" value="0">

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg" id="placeOrderBtn">
                                    <i class="fas fa-check-circle me-2"></i>Оформить заказ
                                </button>
                                <a href="{{ route('basket.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Вернуться в корзину
                                </a>
                            </div>
                        </form>

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-lock me-1"></i>
                                Ваши данные защищены и не передаются третьим лицам
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .delivery-option {
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fff;
        }

        .delivery-option:hover {
            border-color: #63b3ed !important;
            background: #f7fafc;
        }

        .delivery-option.active {
            border-color: #2b6cb0 !important;
            background: #ebf8ff;
            box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.1);
        }

        .cart-item {
            transition: background 0.2s ease;
        }

        .cart-item:hover {
            background: #f7fafc;
        }

        .product-image-sm {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            background: #f7fafc;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quantity-btn:hover {
            background: #edf2f7;
            border-color: #a0aec0;
        }

        .quantity-btn:active {
            transform: scale(0.95);
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 4px 0;
            font-weight: 500;
        }

        .quantity-input:focus {
            outline: none;
            border-color: #63b3ed;
            box-shadow: 0 0 0 2px rgba(99, 179, 237, 0.2);
        }

        .remove-item-btn {
            color: #e53e3e;
            background: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 5px 10px;
            border-radius: 6px;
        }

        .remove-item-btn:hover {
            background: #fff5f5;
            color: #c53030;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .summary-total {
            border-top: 2px solid #e2e8f0;
            padding-top: 12px;
            margin-top: 8px;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .summary-total .total-price {
            color: #2b6cb0;
        }

        @media (max-width: 768px) {
            .position-sticky {
                position: relative !important;
                top: 0 !important;
            }

            .product-image-sm {
                width: 50px;
                height: 50px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Загрузка корзины
            function loadCart() {
                $.ajax({
                    url: '{{ route("api.cart.get") }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            renderCart(response.data);
                        } else {
                            showEmptyCart();
                        }
                    },
                    error: function() {
                        showEmptyCart();
                    }
                });
            }

            function renderCart(data) {
                const items = data.items || [];
                const total = data.total || 0;
                const count = data.count || 0;

                // Проверяем, пуста ли корзина
                if (items.length === 0) {
                    showEmptyCart();
                    return;
                }

                // Рендерим товары
                let itemsHtml = '<div class="list-group list-group-flush">';
                items.forEach(function(item) {
                    itemsHtml += `
                <div class="list-group-item cart-item px-0 py-3" data-product-id="${item.id}">
                    <div class="row align-items-center">
                        <div class="col-3 col-md-2">
                            <img src="/${item.image}" alt="${item.name}" class="product-image-sm w-100">
                        </div>
                        <div class="col-9 col-md-10">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-5 mb-2 mb-md-0">
                                    <h6 class="mb-1 fw-bold">${item.name}</h6>
                                    <small class="text-muted">${item.category || 'Без категории'}</small>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="quantity-control">
                                        <button class="quantity-btn qty-minus" data-id="${item.id}">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" class="quantity-input" value="${item.quantity}" min="1" data-id="${item.id}" readonly>
                                        <button class="quantity-btn qty-plus" data-id="${item.id}">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-4 col-md-2">
                                    <span class="fw-bold text-primary">${formatPrice(item.subtotal)} ₸</span>
                                </div>
                                <div class="col-2 col-md-2 text-end">
                                    <button class="remove-item-btn" data-id="${item.id}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                });
                itemsHtml += '</div>';

                $('#cartItems').html(itemsHtml);

                // Рендерим итоговую информацию
                let summaryHtml = `
            <div class="summary-row">
                <span>Товары (${count} шт.)</span>
                <span>${formatPrice(total)} ₸</span>
            </div>
            <div class="summary-row">
                <span>Доставка</span>
                <span id="deliveryPrice">0 ₸</span>
            </div>
            <div class="summary-row summary-total">
                <span>Итого</span>
                <span class="total-price" id="totalPrice">${formatPrice(total)} ₸</span>
            </div>
        `;

                $('#cartSummary').html(summaryHtml);

                // Обновляем скрытые поля
                $('#cartData').val(JSON.stringify(data));
                $('#totalAmount').val(total);

                // Проверяем, что корзина не пуста перед оформлением
                updateOrderButton();

                // Пересчитываем итог при изменении доставки
                recalculateTotal();

                // Привязываем обработчики
                attachEventHandlers();
            }

            function showEmptyCart() {
                $('#cartItems').html(`
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart" style="font-size: 48px; color: #e2e8f0;"></i>
                <h5 class="mt-3">Корзина пуста</h5>
                <p class="text-muted">Добавьте товары в корзину, чтобы оформить заказ</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-arrow-left me-2"></i>Вернуться к покупкам
                </a>
            </div>
        `);

                $('#cartSummary').html(`
            <div class="text-center py-4">
                <i class="fas fa-info-circle" style="font-size: 32px; color: #e2e8f0;"></i>
                <p class="text-muted mt-2">Нет товаров для оформления</p>
            </div>
        `);

                // Отключаем кнопку оформления
                $('#placeOrderBtn').prop('disabled', true);
                $('#placeOrderBtn').html('<i class="fas fa-times-circle me-2"></i>Корзина пуста');
            }

            function attachEventHandlers() {
                // Удаление товара
                $('.remove-item-btn').on('click', function() {
                    const productId = $(this).data('id');
                    removeFromCart(productId);
                });

                // Изменение количества
                $('.qty-plus').on('click', function() {
                    const productId = $(this).data('id');
                    updateQuantity(productId, 1);
                });

                $('.qty-minus').on('click', function() {
                    const productId = $(this).data('id');
                    updateQuantity(productId, -1);
                });

                // Выбор способа доставки
                $('.delivery-option').on('click', function() {
                    $('.delivery-option').removeClass('active');
                    $(this).addClass('active');
                    $(this).find('input[type="radio"]').prop('checked', true);

                    const deliveryMethod = $(this).find('input[type="radio"]').val();
                    $('#deliveryMethod').val(deliveryMethod);
                    recalculateTotal();
                });
            }

            function updateQuantity(productId, change) {
                const input = $(`.quantity-input[data-id="${productId}"]`);
                let currentQty = parseInt(input.val()) || 0;
                let newQty = currentQty + change;

                if (newQty < 1) return;

                $.ajax({
                    url: `/api/cart/update/${productId}`,
                    type: 'PUT',
                    data: {
                        quantity: newQty,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Обновляем корзину
                            loadCart();
                            // Обновляем счетчик в хедере
                            updateCartBadge(response.data.count);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            loadCart();
                        }
                    }
                });
            }

            function removeFromCart(productId) {
                if (!confirm('Вы уверены, что хотите удалить этот товар из корзины?')) {
                    return;
                }

                $.ajax({
                    url: `/api/cart/remove/${productId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            loadCart();
                            updateCartBadge(response.data.count);
                            showNotification('Товар удален из корзины', 'success');
                        }
                    }
                });
            }

            function recalculateTotal() {
                const deliveryMethod = $('#deliveryMethod').val();
                let deliveryPrice = 0;

                // Стоимость доставки в зависимости от метода
                switch(deliveryMethod) {
                    case 'courier':
                        deliveryPrice = 500; // 500 ₸
                        break;
                    case 'pickup':
                        deliveryPrice = 0;
                        break;
                    case 'post':
                        deliveryPrice = 1000; // 1000 ₸
                        break;
                }

                // Получаем текущую сумму товаров
                const subtotalText = $('.summary-total .total-price').text();
                const subtotal = parseFloat(subtotalText.replace(/[^0-9.]/g, '')) || 0;

                // Обновляем стоимость доставки
                $('#deliveryPrice').text(deliveryPrice + ' ₸');

                // Обновляем итоговую сумму
                const total = subtotal + deliveryPrice;
                $('.summary-total .total-price').text(formatPrice(total) + ' ₸');

                // Обновляем скрытое поле
                $('#totalAmount').val(total);
            }

            function updateOrderButton() {
                const itemCount = $('#cartItems .cart-item').length;
                if (itemCount === 0) {
                    $('#placeOrderBtn').prop('disabled', true);
                    $('#placeOrderBtn').html('<i class="fas fa-times-circle me-2"></i>Корзина пуста');
                } else {
                    $('#placeOrderBtn').prop('disabled', false);
                    $('#placeOrderBtn').html('<i class="fas fa-check-circle me-2"></i>Оформить заказ');
                }
            }

            function formatPrice(price) {
                return Math.round(price).toLocaleString('ru-KZ');
            }

            function updateCartBadge(count) {
                const badge = $('#cartBadge');
                if (count > 0) {
                    badge.text(count).show();
                } else {
                    badge.hide();
                }
            }

            function showNotification(message, type = 'info') {
                // Можно использовать Bootstrap Toasts или Alert
                // Простая реализация
                const alertClass = type === 'success' ? 'alert-success' : 'alert-info';
                const html = `
            <div class="alert ${alertClass} alert-dismissible fade show position-fixed"
                 style="top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
                $('body').append(html);
                setTimeout(function() {
                    $('.alert').fadeOut(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            // Валидация формы перед отправкой
            $('#checkoutForm').on('submit', function(e) {
                e.preventDefault();

                // Проверяем, не пуста ли корзина
                const items = $('#cartItems .cart-item').length;
                if (items === 0) {
                    showNotification('Корзина пуста. Добавьте товары для оформления заказа.', 'info');
                    return false;
                }

                // Валидация формы
                const form = document.getElementById('orderForm');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return false;
                }

                // Собираем данные формы
                const formData = new FormData(form);
                const orderData = {
                    full_name: formData.get('full_name'),
                    phone: formData.get('phone'),
                    email: formData.get('email'),
                    address: formData.get('address'),
                    comment: formData.get('comment'),
                    delivery_method: $('#deliveryMethod').val(),
                    cart_data: $('#cartData').val(),
                    total_amount: $('#totalAmount').val()
                };

                // Отправляем заказ
                $.ajax({
                    url: '{{ route("orders.store") }}',
                    type: 'POST',
                    data: orderData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $('#placeOrderBtn').prop('disabled', true);
                        $('#placeOrderBtn').html('<span class="spinner-border spinner-border-sm me-2"></span>Оформление...');
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showNotification('Заказ успешно оформлен!', 'success');
                            // Очищаем корзину
                            $.ajax({
                                url: '/api/cart/clear',
                                type: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                success: function() {
                                    updateCartBadge(0);
                                    // Перенаправляем на страницу заказа
                                    setTimeout(function() {
                                        window.location.href = response.redirect || '/orders';
                                    }, 1500);
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON;
                        showNotification(error?.message || 'Ошибка при оформлении заказа', 'error');
                        $('#placeOrderBtn').prop('disabled', false);
                        $('#placeOrderBtn').html('<i class="fas fa-check-circle me-2"></i>Оформить заказ');
                    }
                });
            });

            // Загружаем корзину при загрузке страницы
            loadCart();
        });
    </script>
@endpush
