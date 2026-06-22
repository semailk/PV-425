@extends('layouts.main')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i>Создание продукта
                        </h3>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Назад
                        </a>
                    </div>
                    <div class="card-body">
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

                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

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
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}
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
                                                            {{ old('category_id') == $child->id ? 'selected' : '' }}
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
                                            value="{{ old('name') }}"
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
                                        >{{ old('description') }}</textarea>
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
                                                value="{{ old('price') }}"
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
                                                <div id="image-preview" style="display: none; width: 100%;">
                                                    <div class="position-relative">
                                                        <img
                                                            id="preview-img"
                                                            src="#"
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
                                                        <small class="text-muted" id="file-name"></small>
                                                        <br>
                                                        <small class="text-muted" id="file-size"></small>
                                                    </div>
                                                </div>

                                                <!-- Интерфейс загрузки -->
                                                <div id="image-upload" style="width: 100%;">
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
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Кнопки -->
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times me-1"></i> Отмена
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-save me-2"></i> Создать продукт
                                </button>
                            </div>
                        </form>
                    </div>
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

            @media (max-width: 992px) {
                .dropzone-wrapper {
                    min-height: 250px;
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

                input.value = '';
                preview.style.display = 'none';
                upload.style.display = 'block';
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
        </script>
    @endpush
@endsection
