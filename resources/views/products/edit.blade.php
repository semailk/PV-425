@extends('layouts.main')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Редактирование продукта
                        </h3>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Ошибка!</strong> Пожалуйста, исправьте следующие ошибки:
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Левая колонка - Информация о продукте -->
                                <div class="col-lg-7">
                                    <!-- Категория -->
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label fw-bold">
                                            <i class="fas fa-tag me-1 text-primary"></i> Категория <span class="text-danger">*</span>
                                        </label>
                                        <select
                                            name="category_id"
                                            id="category_id"
                                            class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                                            required
                                        >
                                            <option value="">📂 Выберите категорию</option>
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}
                                                >
                                                    {{ $category->name }}
                                                    @if($category->children && $category->children->count() > 0)
                                                        <span class="text-muted">({{ $category->children->count() }} подкатегорий)</span>
                                                    @endif
                                                </option>
                                                @if($category->children && $category->children->count() > 0)
                                                    @foreach($category->children as $child)
                                                        <option
                                                            value="{{ $child->id }}"
                                                            {{ old('category_id', $product->category_id) == $child->id ? 'selected' : '' }}
                                                            style="padding-left: 30px;"
                                                        >
                                                            &nbsp;&nbsp;&nbsp;└─ {{ $child->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Название продукта -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">
                                            <i class="fas fa-box me-1 text-primary"></i> Название продукта <span class="text-danger">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            name="name"
                                            id="name"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            value="{{ old('name', $product->name) }}"
                                            placeholder="Введите название продукта"
                                            required
                                        >
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Описание -->
                                    <div class="mb-3">
                                        <label for="description" class="form-label fw-bold">
                                            <i class="fas fa-align-left me-1 text-primary"></i> Описание
                                        </label>
                                        <textarea
                                            name="description"
                                            id="description"
                                            class="form-control @error('description') is-invalid @enderror"
                                            rows="6"
                                            placeholder="Введите описание продукта"
                                        >{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle"></i> Максимум 1000 символов
                                        </small>
                                    </div>

                                    <!-- Цена -->
                                    <div class="mb-3">
                                        <label for="price" class="form-label fw-bold">
                                            <i class="fas fa-dollar-sign me-1 text-primary"></i> Цена <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text">₸</span>
                                            <input
                                                type="number"
                                                name="price"
                                                id="price"
                                                class="form-control @error('price') is-invalid @enderror"
                                                value="{{ old('price', $product->price) }}"
                                                placeholder="0.00"
                                                step="0.01"
                                                min="0"
                                                required
                                            >
                                        </div>
                                        @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Количество -->
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label fw-bold">
                                            <i class="fas fa-cubes me-1 text-primary"></i> Количество
                                        </label>
                                        <input
                                            type="number"
                                            name="quantity"
                                            id="quantity"
                                            class="form-control form-control-lg @error('quantity') is-invalid @enderror"
                                            value="{{ old('quantity', $product->quantity) }}"
                                            placeholder="0"
                                            min="0"
                                            step="1"
                                        >
                                        @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle"></i> Укажите количество товара на складе
                                        </small>
                                    </div>
                                </div>

                                <!-- Правая колонка - Загрузка изображения -->
                                <div class="col-lg-5">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-image me-1 text-primary"></i> Изображение продукта
                                        </label>

                                        <!-- Полноэкранная зона загрузки -->
                                        <div class="image-upload-container">
                                            <div
                                                class="dropzone-wrapper border-2 border-dashed rounded-3 p-4 text-center @error('image') border-danger @enderror"
                                                style="background: #f8f9fa; min-height: 350px; display: flex; align-items: center; justify-content: center; position: relative; transition: all 0.3s ease;"
                                            >
                                                <!-- Предпросмотр изображения -->
                                                <div id="image-preview" style="{{ $product->image ? 'display: block;' : 'display: none;' }} width: 100%;">
                                                    <div class="position-relative">
                                                        <img
                                                            id="preview-img"
                                                            src="{{ $product->image ? asset($product->image) : '#' }}"
                                                            alt="Preview"
                                                            class="img-fluid rounded-3"
                                                            style="max-height: 300px; width: 100%; object-fit: contain;"
                                                        >
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle"
                                                            onclick="removeImage()"
                                                            style="width: 35px; height: 35px;"
                                                        >
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <div class="mt-2">
                                                        <small class="text-muted" id="file-name">
                                                            @if($product->image)
                                                                <i class="fas fa-file-image me-1"></i> {{ basename($product->image) }}
                                                            @endif
                                                        </small>
                                                        <br>
                                                        <small class="text-muted" id="file-size"></small>
                                                    </div>
                                                    <div class="mt-2">
                                                        <small class="text-warning">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            Загрузите новое изображение, чтобы заменить текущее
                                                        </small>
                                                    </div>
                                                </div>

                                                <!-- Интерфейс загрузки -->
                                                <div id="image-upload" style="{{ $product->image ? 'display: none;' : 'display: block;' }} width: 100%;">
                                                    <div class="upload-icon-wrapper">
                                                        <i class="fas fa-cloud-upload-alt fa-5x text-primary mb-3"></i>
                                                    </div>
                                                    <h5 class="mb-2">Перетащите изображение сюда</h5>
                                                    <p class="text-muted mb-2">или</p>
                                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('image').click()">
                                                        <i class="fas fa-folder-open me-1"></i> Выбрать файл
                                                    </button>
                                                    <div class="mt-3">
                                                        <small class="text-muted d-block">
                                                            <i class="fas fa-check-circle text-success me-1"></i>
                                                            Поддерживаемые форматы: JPEG, PNG, JPG, GIF, WEBP
                                                        </small>
                                                        <small class="text-muted d-block">
                                                            <i class="fas fa-check-circle text-success me-1"></i>
                                                            Максимальный размер: 2MB
                                                        </small>
                                                        <small class="text-muted d-block">
                                                            <i class="fas fa-check-circle text-success me-1"></i>
                                                            Рекомендуемое разрешение: 800x800px
                                                        </small>
                                                        @if($product->image)
                                                            <small class="text-warning d-block mt-2">
                                                                <i class="fas fa-info-circle me-1"></i>
                                                                Текущее изображение будет заменено
                                                            </small>
                                                        @endif
                                                    </div>
                                                    <input
                                                        type="file"
                                                        name="image"
                                                        id="image"
                                                        class="form-control @error('image') is-invalid @enderror"
                                                        accept="image/*"
                                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;"
                                                        onchange="previewImage(this)"
                                                    >
                                                </div>
                                            </div>
                                            @error('image')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                            @if($product->image)
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-check-circle text-success me-1"></i>
                                                        Текущее изображение: <strong>{{ basename($product->image) }}</strong>
                                                        <br>
                                                        <span class="text-muted">Оставьте поле пустым, чтобы сохранить текущее изображение</span>
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Дополнительная информация -->
                                    <div class="card bg-light mt-3">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="fas fa-info-circle me-1 text-primary"></i> Информация о продукте
                                            </h6>
                                            <ul class="list-unstyled mb-0 small">
                                                <li class="mb-1">
                                                    <i class="fas fa-hashtag text-muted me-1"></i>
                                                    ID: <strong>#{{ $product->id }}</strong>
                                                </li>
                                                <li class="mb-1">
                                                    <i class="far fa-calendar-alt text-muted me-1"></i>
                                                    Создан: <strong>{{ $product->created_at->format('d.m.Y H:i') }}</strong>
                                                </li>
                                                <li class="mb-1">
                                                    <i class="far fa-clock text-muted me-1"></i>
                                                    Обновлен: <strong>{{ $product->updated_at->format('d.m.Y H:i') }}</strong>
                                                </li>
                                                @if($product->quantity !== null)
                                                    <li class="mb-1">
                                                        <i class="fas fa-cubes text-muted me-1"></i>
                                                        На складе: <strong>{{ $product->quantity }} шт.</strong>
                                                    </li>
                                                @endif
                                                <li class="mb-1">
                                                    <i class="fas fa-tag text-muted me-1"></i>
                                                    Категория: <strong>{{ $product->category->name ?? 'Без категории' }}</strong>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Кнопки -->
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-times me-1"></i> Отмена
                                    </a>
                                    <!-- Кнопка удаления -->
                                    <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="fas fa-trash me-1"></i> Удалить
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-save me-2"></i> Обновить продукт
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно подтверждения удаления -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                        Подтверждение удаления
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center py-3">
                        <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                        <h5>Вы уверены, что хотите удалить продукт?</h5>
                        <p class="text-muted mb-0">
                            <strong>"{{ $product->name }}"</strong>
                        </p>
                        <p class="text-muted small mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Это действие невозможно отменить. Все данные продукта будут безвозвратно удалены.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Отмена
                    </button>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Да, удалить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .dropzone-wrapper {
                border: 2px dashed #dee2e6;
                transition: all 0.3s ease;
                min-height: 350px;
            }

            .dropzone-wrapper:hover {
                border-color: #0d6efd;
                background: #f0f8ff !important;
            }

            .dropzone-wrapper.dragover {
                border-color: #0d6efd;
                background: #e7f1ff !important;
                transform: scale(1.02);
            }

            .upload-icon-wrapper {
                animation: float 3s ease-in-out infinite;
            }

            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-10px);
                }
            }

            .image-upload-container {
                position: relative;
            }

            .form-control-lg {
                font-size: 1.1rem;
            }

            .input-group-lg .form-control {
                font-size: 1.1rem;
            }

            #preview-img {
                transition: all 0.3s ease;
            }

            .btn-lg {
                padding: 0.75rem 1.5rem;
            }

            .btn-danger {
                background: rgba(220, 53, 69, 0.9);
                border: none;
                backdrop-filter: blur(4px);
            }

            .btn-danger:hover {
                background: #dc3545;
                transform: scale(1.1);
            }

            @media (max-width: 992px) {
                .dropzone-wrapper {
                    min-height: 250px;
                }
            }

            /* Стили для подсветки ошибок */
            .is-invalid {
                border-color: #dc3545;
            }

            .is-invalid:focus {
                border-color: #dc3545;
                box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            }

            .invalid-feedback {
                display: block;
            }

            /* Анимация появления */
            .card {
                animation: slideDown 0.4s ease;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .dropzone-wrapper {
                transition: all 0.3s ease;
            }

            /* Модальное окно */
            .modal-content {
                border: none;
                border-radius: 16px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
                animation: modalSlideIn 0.3s ease;
            }

            @keyframes modalSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(-30px) scale(0.95);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            .modal-header {
                border-bottom: 1px solid #eef2f6;
                padding: 20px 24px;
            }

            .modal-body {
                padding: 24px;
            }

            .modal-footer {
                border-top: 1px solid #eef2f6;
                padding: 16px 24px;
            }

            .modal .btn {
                padding: 8px 24px;
                border-radius: 8px;
            }

            .modal .btn-danger {
                background: #dc3545;
                border: none;
                transition: all 0.3s ease;
            }

            .modal .btn-danger:hover {
                background: #c82333;
                transform: scale(1.05);
            }

            .modal .btn-secondary {
                background: #e2e8f0;
                color: #2d3748;
                border: none;
                transition: all 0.3s ease;
            }

            .modal .btn-secondary:hover {
                background: #cbd5e0;
            }

            /* Кнопка удаления в карточке */
            .btn-outline-danger {
                border-color: #dc3545;
                color: #dc3545;
            }

            .btn-outline-danger:hover {
                background: #dc3545;
                color: #fff;
            }

            @media (max-width: 576px) {
                .d-flex.justify-content-between {
                    flex-direction: column;
                    gap: 12px;
                }

                .d-flex.justify-content-between .d-flex {
                    width: 100%;
                }

                .d-flex.justify-content-between .d-flex .btn {
                    flex: 1;
                }

                .d-flex.justify-content-between .btn-primary {
                    width: 100%;
                }

                .modal-dialog {
                    margin: 10px;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function previewImage(input) {
                const preview = document.getElementById('image-preview');
                const upload = document.getElementById('image-upload');
                const previewImg = document.getElementById('preview-img');
                const fileName = document.getElementById('file-name');
                const fileSize = document.getElementById('file-size');

                if (input.files && input.files[0]) {
                    const file = input.files[0];

                    // Валидация размера файла (максимум 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Размер файла не должен превышать 2MB');
                        input.value = '';
                        return;
                    }

                    // Валидация типа файла
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Поддерживаются только форматы: JPEG, PNG, JPG, GIF, WEBP');
                        input.value = '';
                        return;
                    }

                    // Показываем имя файла
                    fileName.textContent = '📄 ' + file.name;

                    // Показываем размер файла
                    const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                    fileSize.textContent = '📦 ' + sizeInMB + ' MB';

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        preview.style.display = 'block';
                        upload.style.display = 'none';
                    };

                    reader.readAsDataURL(file);
                }
            }

            function removeImage() {
                const input = document.getElementById('image');
                const preview = document.getElementById('image-preview');
                const upload = document.getElementById('image-upload');
                const previewImg = document.getElementById('preview-img');

                // Если есть текущее изображение, показываем его снова
                @if($product->image)
                    previewImg.src = "{{ asset($product->image) }}";
                preview.style.display = 'block';
                upload.style.display = 'none';
                document.getElementById('file-name').textContent = '📄 {{ basename($product->image) }}';
                document.getElementById('file-size').textContent = '';
                @else
                    preview.style.display = 'none';
                upload.style.display = 'block';
                @endif

                    input.value = '';
            }

            // Drag and drop functionality
            const dropzone = document.querySelector('.dropzone-wrapper');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            dropzone.addEventListener('drop', function(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                const input = document.getElementById('image');
                input.files = files;
                previewImage(input);
                this.classList.remove('dragover');
            });

            dropzone.addEventListener('dragover', function() {
                this.classList.add('dragover');
            });

            dropzone.addEventListener('dragleave', function() {
                this.classList.remove('dragover');
            });

            // Подсветка при наведении на input
            document.getElementById('image').addEventListener('mouseenter', function() {
                this.closest('.dropzone-wrapper').classList.add('hover');
            });

            document.getElementById('image').addEventListener('mouseleave', function() {
                this.closest('.dropzone-wrapper').classList.remove('hover');
            });

            // Валидация формы перед отправкой
            document.querySelector('form').addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                const price = document.getElementById('price').value;
                const category = document.getElementById('category_id').value;

                if (!name) {
                    e.preventDefault();
                    alert('Пожалуйста, введите название продукта');
                    document.getElementById('name').focus();
                    return false;
                }

                if (!price || parseFloat(price) < 0) {
                    e.preventDefault();
                    alert('Пожалуйста, введите корректную цену');
                    document.getElementById('price').focus();
                    return false;
                }

                if (!category) {
                    e.preventDefault();
                    alert('Пожалуйста, выберите категорию');
                    document.getElementById('category_id').focus();
                    return false;
                }

                return true;
            });

            // Подтверждение удаления через модальное окно (дополнительная защита)
            document.querySelector('#deleteModal form').addEventListener('submit', function(e) {
                // Здесь можно добавить дополнительную логику перед удалением
                // Например, проверку, не используется ли продукт в заказах
                console.log('Удаление продукта: {{ $product->name }}');
            });
        </script>
    @endpush
@endsection
