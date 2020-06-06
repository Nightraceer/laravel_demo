<?php

namespace App\Http\Controllers;

use App\Components\Cart\SessionCart;
use App\Models\Product;

class CartController extends Controller
{
    public $cart;

    public function __construct(SessionCart $cart)
    {
        $this->cart = $cart;
        view()->share('cart', $cart);
    }

    public function index()
    {
        return view('cart', [
            'cart' => $this->cart
        ]);
    }

    public function toggle($id)
    {
        $result = $this->cart->getItemAndPositionByObjectId($id);

        if (isset($result['item']) && isset($result['position'])) {
            $this->cart->removeItem($result['position']);
            $response = [
                'status' => 'success',
                'message' => 'Товар успешно удален из корзины',
                'addClass' => 'add',
                'removeClass' => 'remove'
            ];
        } else {
            $item = null;
            /** @var Product $itemClass */
            if ($id && ($itemClass = $this->cart->defaultItemClass)) {
                $item = $itemClass::query()->find($id);
            }
            $response = [
                'status' => 'success',
                'message' => 'Товар успешно добавлен в корзину',
                'addClass' => 'remove',
                'removeClass' => 'add'
            ];
            if ($item) {
                $this->cart->add($item);
            } else {
                $response['status'] = 'error';
                $response['message'] = 'При добавлении товара в корзину произошла ошибка';
            }
        }

        return response()->json($response);
    }

    public function inc($position)
    {
        $this->cart->incQuantity($position);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function dec($position)
    {
        $this->cart->decQuantity($position);
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function remove($position)
    {
        $this->cart->removeItem($position);
        return response()->json([
            'status' => 'success'
        ]);
    }
}
