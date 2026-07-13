<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Получить полную информацию о корзине с товарами
     */
    private function getCartWithProducts()
    {
        if (!Session::has('cart')) {
            return [
                'items' => [],
                'total' => 0,
                'count' => 0
            ];
        }

        $cart = json_decode(Session::get('cart'), true);
        $productIds = array_keys($cart);

        // Получаем все товары из корзины
        $products = Product::with('category')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $items = [];
        $total = 0;
        $count = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $products->get($productId);
            if ($product) {
                $items[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'category' => $product->category?->name,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
                $count += $quantity;
            }
        }

        return [
            'items' => $items,
            'total' => $total,
            'count' => $count
        ];
    }

    /**
     * Добавить товар в корзину
     */
    public function addToCart(Product $product)
    {
        if (Session::has('cart')) {
            $cart = json_decode(Session::get('cart'), true);
            $cart[$product->id] = ($cart[$product->id] ?? 0) + 1;
        } else {
            $cart = [$product->id => 1];
        }

        Session::put('cart', json_encode($cart));

        // Возвращаем полную информацию о корзине
        $cartData = $this->getCartWithProducts();

        return response()->json([
            'status' => 'success',
            'message' => 'Товар добавлен в корзину',
            'data' => $cartData
        ]);
    }

    /**
     * Получить корзину с полной информацией о товарах
     */
    public function getCart()
    {
        $cartData = $this->getCartWithProducts();

        return response()->json([
            'status' => 'success',
            'data' => $cartData
        ]);
    }

    /**
     * Удалить товар из корзины
     */
    public function removeFromCart(Product $product)
    {
        if (Session::has('cart')) {
            $cart = json_decode(Session::get('cart'), true);
            unset($cart[$product->id]);

            if (empty($cart)) {
                Session::forget('cart');
            } else {
                Session::put('cart', json_encode($cart));
            }

            $cartData = $this->getCartWithProducts();

            return response()->json([
                'status' => 'success',
                'message' => 'Товар удален из корзины',
                'data' => $cartData
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Корзина пуста',
        ], 404);
    }

    /**
     * Обновить количество товара в корзине
     */
    public function updateQuantity(Product $product, Request $request)
    {
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            return $this->removeFromCart($product);
        }

        if (Session::has('cart')) {
            $cart = json_decode(Session::get('cart'), true);
            $cart[$product->id] = $quantity;
            Session::put('cart', json_encode($cart));
        } else {
            $cart = [$product->id => $quantity];
            Session::put('cart', json_encode($cart));
        }

        $cartData = $this->getCartWithProducts();

        return response()->json([
            'status' => 'success',
            'message' => 'Количество обновлено',
            'data' => $cartData
        ]);
    }

    /**
     * Очистить корзину
     */
    public function clearCart()
    {
        Session::forget('cart');

        return response()->json([
            'status' => 'success',
            'message' => 'Корзина очищена',
            'data' => [
                'items' => [],
                'total' => 0,
                'count' => 0
            ]
        ]);
    }
}
