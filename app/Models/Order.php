<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{

    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'email',
        'address',
        'comment',
        'delivery_method',
        'delivery_price',
        'subtotal',
        'total_amount',
        'items',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
        'subtotal' => 'decimal:2',
        'delivery_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    /**
     * Статусы заказа
     */
    const STATUSES = [
        'pending' => 'Ожидает обработки',
        'processing' => 'В обработке',
        'shipped' => 'Отправлен',
        'delivered' => 'Доставлен',
        'cancelled' => 'Отменен',
    ];

    /**
     * Связь с пользователем
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получение статуса на русском
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /**
     * Проверка, можно ли отменить заказ
     */
    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }
}
