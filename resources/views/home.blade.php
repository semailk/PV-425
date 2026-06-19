@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center text-3xl shadow-lg shadow-blue-100">
                            📱
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Категории</h1>
                            <p class="text-gray-500 text-lg">Управление категориями электроники</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 md:mt-0 flex items-center gap-4">
                    <!-- Статистика -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-3 flex items-center gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-medium uppercase tracking-wider">Всего</div>
                                <div class="text-2xl font-bold text-gray-900">{{ count($categories) }}</div>
                            </div>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-green-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-medium uppercase tracking-wider">Активных</div>
                                <div class="text-2xl font-bold text-green-600">{{ count(array_filter($categories->toArray(), function($c) { return $c['is_active']; })) }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Кнопка добавления -->
                    <button onclick="addNewCategory()"
                            class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-2xl font-medium transition-all shadow-lg shadow-blue-200 flex items-center gap-2 whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Добавить
                    </button>
                </div>
            </div>

            @if(count($categories) > 0)
                <!-- Сетка категорий -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($categories as $category)
                        <div class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <!-- Цветная полоса сверху -->
                            <div class="h-1.5 bg-gradient-to-r
                                @if($category->is_active)
                                    from-green-400 to-emerald-500
                                @else
                                    from-gray-300 to-gray-400
                                @endif">
                            </div>

                            <div class="p-6">
                                <!-- Верхняя часть с ID и статусом -->
                                <div class="flex justify-between items-start mb-4">
                                    <span class="text-xs font-mono bg-gray-50 text-gray-400 px-3 py-1 rounded-lg border border-gray-100">
                                        #{{ str_pad($category->id, 3, '0', STR_PAD_LEFT) }}
                                    </span>

                                    <span class="px-3 py-1 text-xs font-medium rounded-full transition-all duration-300 flex items-center gap-1.5
                                        @if($category->is_active)
                                            bg-emerald-50 text-emerald-700
                                            shadow-sm shadow-emerald-100
                                        @else
                                            bg-gray-100 text-gray-500
                                        @endif">
                                        <span class="w-1.5 h-1.5 rounded-full inline-block
                                            @if($category->is_active) bg-emerald-500 @else bg-gray-400 @endif">
                                        </span>
                                        {{ $category->is_active ? 'Активна' : 'Неактивна' }}
                                    </span>
                                </div>

                                <!-- Название категории с иконкой -->
                                <div class="mb-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center text-xl flex-shrink-0">
                                            📂
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800 line-clamp-2 leading-tight">
                                                {{ $category->name }}
                                            </h3>
                                            @if(isset($category->slug))
                                                <span class="text-xs text-gray-400 font-mono">/{{ $category->slug }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Дополнительная информация -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                    <div class="flex items-center gap-1.5 text-sm text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($category->created_at)->format('d.m.Y') }}</span>
                                    </div>

                                    <!-- Действия -->
                                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button onclick="editCategory({{ $category->id }})"
                                                class="p-2 hover:bg-blue-50 rounded-lg transition-colors text-blue-600 hover:text-blue-700"
                                                title="Редактировать">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <button onclick="deleteCategory({{ $category->id }})"
                                                class="p-2 hover:bg-red-50 rounded-lg transition-colors text-red-400 hover:text-red-600"
                                                title="Удалить">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Пагинация (если нужна) -->
                @if(isset($categories) && method_exists($categories, 'links'))
                    <div class="mt-12">
                        {{ $categories->links() }}
                    </div>
                @endif

            @else
                <!-- Пустое состояние -->
                <div class="text-center py-20 bg-white rounded-3xl border border-gray-100">
                    <div class="inline-block p-6 bg-gradient-to-br from-blue-50 to-purple-50 rounded-full mb-6">
                        <div class="text-7xl">📦</div>
                    </div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-3">Категории не найдены</h2>
                    <p class="text-gray-500 max-w-sm mx-auto">
                        В базе данных пока нет ни одной категории.<br>
                        Начните с добавления первой!
                    </p>
                    <button onclick="addNewCategory()"
                            class="mt-8 inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-2xl font-medium transition-all shadow-lg shadow-blue-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Добавить категорию
                    </button>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Анимация появления карточек */
        .group {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .group:nth-child(1) { animation-delay: 0.05s; }
        .group:nth-child(2) { animation-delay: 0.1s; }
        .group:nth-child(3) { animation-delay: 0.15s; }
        .group:nth-child(4) { animation-delay: 0.2s; }
        .group:nth-child(5) { animation-delay: 0.25s; }
        .group:nth-child(6) { animation-delay: 0.3s; }
        .group:nth-child(7) { animation-delay: 0.35s; }
        .group:nth-child(8) { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Обрезка текста в 2 строки */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Плавный переход для статуса */
        .status {
            transition: all 0.3s ease;
        }

        /* Стили для пагинации (если используется) */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        .pagination .page-item .page-link {
            padding: 8px 16px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
        }
        .pagination .page-item .page-link:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }
        .pagination .page-item.active .page-link {
            background: #2563eb;
            border-color: #2563eb;
            color: white;
        }
        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
            pointer-events: none;
        }
    </style>

    <script>
        function addNewCategory() {
            // Заглушка для добавления
            alert('Открыть форму добавления категории');
        }

        function editCategory(id) {
            // Заглушка для редактирования
            alert('Редактирование категории #' + id);
        }

        function deleteCategory(id) {
            // Заглушка для удаления
            if (confirm('Вы уверены, что хотите удалить категорию #' + id + '?')) {
                alert('Удаление категории #' + id);
            }
        }
    </script>

@endsection
