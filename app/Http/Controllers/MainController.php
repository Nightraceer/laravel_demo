<?php

namespace App\Http\Controllers;

use App\Components\Cart\SessionCart;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public $cart;

    public function __construct(SessionCart $cart)
    {
        $this->cart = $cart;
        view()->share('cart', $cart);
    }

    public function home()
    {
        return view('home');
    }
}
