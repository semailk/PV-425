<?php

namespace App\Http\Controllers;

use App\Mail\UserWelcomeMail;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(Request $request): View
    {
        User::query()->get()->map(function (User $user) {
            \Mail::to($user)->queue(new UserWelcomeMail($user));
        });

        $query = Product::query()->with([
            'category',
            'tags'
        ]);

        $categories = Category::query()->orderBy('name')->get();

        list($column, $direction) = explode('-', $request->input('sort', 'created_at-desc'));

        if ($request->input('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('description', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->input('price_from')) {
            $query->where('price', '>=', $request->input('price_from'));
        }
        if ($request->input('price_to')) {
            $query->where('price', '<=', $request->input('price_to'));
        }
        if ($request->input('category')) {
            $query->where('category_id', $request->input('category'));
        }

        return view('welcome', [
            'categories' => $categories,
            'products' => $query
                ->orderBy($column, $direction)
                ->paginate(50)
                ->withQueryString(),
        ]);
    }
}
