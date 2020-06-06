<?php

namespace App\Components\Cart;

use Serializable;

interface CartItemInterface extends Serializable
{
    /**
     * Single item price
     * @param $quantity
     * @param $data
     * @return mixed
     */
    public function getCartPrice($quantity, $data);

    /**
     * @return array
     */
    public function getDataFields();
}