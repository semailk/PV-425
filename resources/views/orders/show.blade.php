@extends('layouts.main')

@section('title', 'Заказ #' . $order->id)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Главная</a></li>
                        @if(auth()->check())
{{--                            <li class="breadcrumb-item"><a href="{{ route('orders.user') }}">Мои заказы</a></li>--}}
                            <li class="breadcrumb-item"><a href="#">Мои заказы</a></li>
                        @endif
                        <li class="breadcrumb-item active" aria-current="page">Заказ #{{ $order->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Информация о заказе -->
                <div class="card mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-bag me-2 text-primary"></i>
                            Заказ #{{ $order->id }}
                        </h5>
                        <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} fs-6 px-3 py-2">
                        {{ $statuses[$order->status] ?? $order->status }}
                    </span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Дата заказа:</p>
                                <p class="fw-bold">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Способ доставки:</p>
                                <p class="fw-bold">
                                    @switch($order->delivery_method)
                                        @case('courier')
                                            <i class="fas fa-truck text-primary me-1"></i>Курьером
                                            @break
                                        @case('pickup')
                                            <i class="fas fa-store text-primary me-1"></i>Самовывоз
                                            @break
                                        @case('post')
                                            <i class="fas fa-mail-bulk text-primary me-1"></i>Почтой
                                            @break
                                        @default
                                            {{ $order->delivery_method }}
                                    @endswitch
                                </p>
                            </div>
                        </div>

                        <hr>

                        <!-- Товары в заказе -->
                        <h6 class="fw-bold mb-3">Товары в заказе</h6>
                        <div class="list-group list-group-flush">
                            @foreach($items as $item)
                                <div class="list-group-item px-0 py-3">
                                    <div class="row align-items-center">
                                        <div class="col-3 col-md-2">
                                            <img src="/{{ $item['image'] ?? 'ps5i.webp' }}"
                                                 alt="{{ $item['name'] }}"
                                                 class="product-image-sm w-100">
                                        </div>
                                        <div class="col-9 col-md-10">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-5 mb-2 mb-md-0">
                                                    <h6 class="mb-1 fw-bold">{{ $item['name'] }}</h6>
                                                    <small class="text-muted">{{ $item['category'] ?? 'Без категории' }}</small>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <span class="text-muted">Количество: </span>
                                                    <span class="fw-bold">{{ $item['quantity'] }} шт.</span>
                                                </div>
                                                <div class="col-6 col-md-4 text-end">
                                                <span class="fw-bold text-primary">
                                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} ₸
                                                </span>
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ number_format($item['price'], 0, ',', ' ') }} ₸ / шт.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Информация о доставке -->
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Информация о доставке</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Получатель:</p>
                                <p class="fw-bold">{{ $order->full_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Телефон:</p>
                                <p class="fw-bold">{{ $order->phone }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Email:</p>
                                <p class="fw-bold">{{ $order->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-1">Адрес доставки:</p>
                                <p class="fw-bold">{{ $order->address ?: 'Не указан' }}</p>
                            </div>
                        </div>
                        @if($order->comment)
                            <div class="row mt-2">
                                <div class="col-12">
                                    <p class="text-muted mb-1">Комментарий к заказу:</p>
                                    <p class="fw-bold">{{ $order->comment }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- История изменений статуса -->
                <div class="card mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-history me-2 text-primary"></i>Статус заказа</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @php
                                $statusFlow = [
                                    'pending' => 'Заказ оформлен',
                                    'processing' => 'Заказ в обработке',
                                    'shipped' => 'Заказ отправлен',
                                    'delivered' => 'Заказ доставлен',
                                    'cancelled' => 'Заказ отменен'
                                ];
                                $currentStatus = $order->status;
                                $statusKeys = array_keys($statusFlow);
                                $currentIndex = array_search($currentStatus, $statusKeys);
                            @endphp

                            @foreach($statusFlow as $key => $label)
                                @php
                                    $isCompleted = array_search($key, $statusKeys) <= $currentIndex;
                                    $isActive = $key === $currentStatus;
                                    $isCancelled = $currentStatus === 'cancelled';
                                @endphp

                                @if(!$isCancelled || ($isCancelled && $key === 'cancelled'))
                                    <div class="timeline-item {{ $isCompleted ? 'completed' : '' }} {{ $isActive ? 'active' : '' }}">
                                        <div class="timeline-marker {{ $isCompleted ? 'bg-success' : 'bg-secondary' }}">
                                            @if($isCompleted)
                                                <i class="fas fa-check"></i>
                                            @else
                                                <i class="fas fa-circle"></i>
                                            @endif
                                        </div>
                                        <div class="timeline-content">
                                            <h6 class="mb-0">{{ $label }}</h6>
                                            @if($isActive)
                                                <small class="text-primary fw-bold">Текущий статус</small>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
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
                        <div class="summary-row">
                            <span>Товары:</span>
                            <span>{{ number_format($order->subtotal, 0, ',', ' ') }} ₸</span>
                        </div>
                        <div class="summary-row">
                            <span>Доставка:</span>
                            <span>{{ number_format($order->delivery_price, 0, ',', ' ') }} ₸</span>
                        </div>
                        <div class="summary-row summary-total">
                            <span>Итого:</span>
                            <span class="total-price">{{ number_format($order->total_amount, 0, ',', ' ') }} ₸</span>
                        </div>

                        <hr>

                        <div class="d-grid gap-2">
                            @if($order->isCancellable())
                                <button class="btn btn-danger" id="cancelOrderBtn" data-order-id="{{ $order->id }}">
                                    <i class="fas fa-times-circle me-2"></i>Отменить заказ
                                </button>
                            @endif

                            <button class="btn btn-primary" id="reorderBtn" data-order-id="{{ $order->id }}">
                                <i class="fas fa-redo me-2"></i>Повторить заказ
                            </button>

                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Вернуться к покупкам
                            </a>

                            @if(auth()->user()?->isAdmin())
                                <hr>
                                <h6 class="fw-bold mb-3">Управление статусом (Админ)</h6>
                                <div class="dropdown">
                                    <button class="btn btn-warning dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-edit me-2"></i>Изменить статус
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        @foreach($statuses as $key => $label)
                                            <li>
                                                <button class="dropdown-item update-status-btn"
                                                        data-order-id="{{ $order->id }}"
                                                        data-status="{{ $key }}">
                                                    {{ $label }}
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .product-image-sm {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            background: #f7fafc;
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

        /* Timeline styles */
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            padding: 10px 0;
            display: flex;
            align-items: flex-start;
        }

        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: -19px;
            top: 30px;
            width: 2px;
            height: calc(100% - 10px);
            background: #e2e8f0;
        }

        .timeline-item.completed:not(:last-child)::before {
            background: #48bb78;
        }

        .timeline-marker {
            position: absolute;
            left: -24px;
            top: 12px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #fff;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #e2e8f0;
        }

        .timeline-item.completed .timeline-marker {
            box-shadow: 0 0 0 2px #48bb78;
        }

        .timeline-item.active .timeline-marker {
            box-shadow: 0 0 0 3px rgba(43, 108, 176, 0.3);
            animation: pulse 1.5s infinite;
        }

        .timeline-content {
            flex: 1;
            padding-left: 5px;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(43, 108, 176, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(43, 108, 176, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(43, 108, 176, 0);
            }
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
            // Отмена заказа
            $('#cancelOrderBtn').on('click', function() {
                const orderId = $(this).data('order-id');

                if (!confirm('Вы уверены, что хотите отменить этот заказ?')) {
                    return;
                }

                $.ajax({
                    url: `/orders/${orderId}/cancel`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showNotification('Заказ отменен', 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON;
                        showNotification(error?.message || 'Ошибка при отмене заказа', 'error');
                    }
                });
            });

            // Повторный заказ
            $('#reorderBtn').on('click', function() {
                const orderId = $(this).data('order-id');

                $.ajax({
                    url: `/orders/${orderId}/reorder`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showNotification('Товары добавлены в корзину', 'success');
                            setTimeout(function() {
                                window.location.href = '{{ route("basket.index") }}';
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON;
                        showNotification(error?.message || 'Ошибка при повторном заказе', 'error');
                    }
                });
            });

            // Обновление статуса (для администратора)
            $('.update-status-btn').on('click', function() {
                const orderId = $(this).data('order-id');
                const status = $(this).data('status');
                const statusLabel = $(this).text().trim();

                if (!confirm(`Изменить статус заказа на "${statusLabel}"?`)) {
                    return;
                }

                $.ajax({
                    url: `/orders/${orderId}/status`,
                    type: 'PUT',
                    data: {
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showNotification('Статус заказа обновлен', 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        const error = xhr.responseJSON;
                        showNotification(error?.message || 'Ошибка при обновлении статуса', 'error');
                    }
                });
            });

            // Уведомления
            function showNotification(message, type = 'info') {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
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
        });
    </script>
@endpush
