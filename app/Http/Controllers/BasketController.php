<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class BasketController extends Controller
{
    public function index()
    {
        return view('checkout.index');
    }
}
