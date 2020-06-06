<?php

namespace App\Http\Controllers;

use App\Components\Cart\SessionCart;
use App\Http\Requests\ProductsAddRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public $cart;

    public function __construct(SessionCart $cart)
    {
        $this->cart = $cart;
        view()->share('cart', $cart);
    }

    public function index(Request $request)
    {
        Product::addSorting($request->query('sorting'));
        $products = Product::getAll();
        return view('products', [
            'products' => $products,
        ]);
    }

    public function form()
    {
        return view('products-add');
    }

    public function add(ProductsAddRequest $request)
    {

        $product = new Product();
        if ($request->file('image')) {
            $imagePath = $request->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $request->file('image')->storeAs('uploads', $imageName, 'public');
            $product->image = $imageName;
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->availability = $request->availability === 'on' ? 1 : 0;
        $product->save();

        return redirect()->route('products-form');
    }
}
