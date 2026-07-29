@php
    $imagePath = $entry->image;
    // Если путь уже содержит 'storage/', не добавляем
    if (!str_starts_with($imagePath, 'storage/')) {
        $imagePath = 'storage/' . $imagePath;
    }
@endphp

<style>
    body.crud-list .delete-image-btn {
        display: none !important;
    }
</style>

@if ($entry->image)
    <div style="position: relative; display: inline-block; margin-bottom: 15px;">
        <img src="{{ asset($imagePath) }}"
             alt="Текущее изображение"
             style="max-width: 220px; max-height: 220px; object-fit: contain; border-radius: 8px; box-shadow: 0 3px 10px rgba(0,0,0,0.15);">
    </div>
@else
    <p class="text-muted mb-3">Изображение отсутствует</p>
@endif
