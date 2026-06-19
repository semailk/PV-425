@extends('layouts.main')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Редактирование категории</h3>
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
                        @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                        @endif

                        <form action="{{ route('categories.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Название категории <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $category->name) }}"
                                    required
                                >
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Статус</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="is_active"
                                            id="active"
                                            value="1"
                                            {{ old('is_active', $category->is_active) == 1 ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="active">Активная</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="radio"
                                            name="is_active"
                                            id="inactive"
                                            value="0"
                                            {{ old('is_active', $category->is_active) == 0 ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="inactive">Неактивная</label>
                                    </div>
                                </div>
                                @error('is_active')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Отмена</a>
                                <div class="d-flex gap-2">
                                    <!-- Кнопка удаления с подтверждением через JS -->
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                          onsubmit="return confirm('Вы уверены, что хотите удалить категорию &quot;{{ $category->name }}&quot;? Это действие невозможно отменить.')"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Удалить
                                        </button>
                                    </form>
                                    <button type="submit" class="btn btn-primary">Обновить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
