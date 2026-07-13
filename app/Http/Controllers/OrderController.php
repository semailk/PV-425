<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Отображение страницы оформления заказа
     */
    public function index()
    {
        return view('checkout.index');
    }

    /**
     * Обработка оформления заказа
     */
    public function store(Request $request)
    {
        // Валидация данных
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:500',
            'comment' => 'nullable|string|max:1000',
            'delivery_method' => 'required|in:courier,pickup,post',
            'total_amount' => 'required|numeric|min:0',
            'cart_data' => 'required|json',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Проверьте правильность заполнения полей',
                'errors' => $validator->errors()
            ], 422);
        }

        // Получаем данные корзины
        $cartData = json_decode($request->cart_data, true);

        if (empty($cartData['items'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Корзина пуста'
            ], 400);
        }

        // Проверяем актуальность цен (защита от подмены)
        $productIds = array_column($cartData['items'], 'id');
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $totalCheck = 0;
        foreach ($cartData['items'] as $item) {
            $product = $products->get($item['id']);
            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Товар не найден'
                ], 404);
            }
            // Проверяем цену
            if ($product->price != $item['price']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Цена товара изменилась. Обновите корзину.'
                ], 409);
            }
            $totalCheck += $product->price * $item['quantity'];
        }

        // Добавляем стоимость доставки в зависимости от метода
        $deliveryPrice = $this->getDeliveryPrice($request->delivery_method);
        $totalWithDelivery = $totalCheck + $deliveryPrice;

//        // Проверяем итоговую сумму
//        if (abs($totalWithDelivery - $request->total_amount) > 0.01) {
//            return response()->json([
//                'status' => 'error',
//                'message' => 'Итоговая сумма не совпадает. Обновите страницу.'
//            ], 409);
//        }

        // Сохраняем заказ
        $order = Order::create([
            'user_id' => auth()->id(), // если пользователь авторизован
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'comment' => $request->comment,
            'delivery_method' => $request->delivery_method,
            'delivery_price' => $deliveryPrice,
            'subtotal' => $totalCheck,
            'total_amount' => $totalWithDelivery,
            'items' => $cartData['items'],
            'status' => 'pending',
        ]);

        // Очищаем корзину
        Session::forget('cart');

        return response()->json([
            'status' => 'success',
            'message' => 'Заказ успешно оформлен!',
            'order_id' => $order->id,
            'redirect' => route('orders.show', $order->id)
        ]);
    }

    /**
     * Получение стоимости доставки
     */
    private function getDeliveryPrice($method)
    {
        return match($method) {
            'courier' => 500,
            'post' => 1000,
            'pickup' => 0,
            default => 0,
        };
    }

    public function show($id)
    {
        $order = Order::with('user')->findOrFail($id);

        // Проверяем, что заказ принадлежит текущему пользователю
        // или пользователь является администратором
        if (auth()->check() && auth()->id() !== $order->user_id) {
            // Если заказ не принадлежит пользователю и он не админ
            if (!auth()->user()->isAdmin()) {
                abort(403, 'У вас нет доступа к этому заказу');
            }
        }

        // Декодируем товары для отображения
        $items = $order->items ?? [];
        $statuses = Order::STATUSES;
        $statusColors = $this->getStatusColors();

        return view('orders.show', compact('order', 'items', 'statuses', 'statusColors'));
    }

    private function getStatusColors(): array
    {
        return [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
        ];
    }
}
