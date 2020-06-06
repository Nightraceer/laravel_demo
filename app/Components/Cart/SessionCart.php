<?php

namespace App\Components\Cart;


use App\Models\Product;

class SessionCart extends Cart
{
    public $key = "CART_ITEMS";
    public $defaultItemClass = Product::class;

    /**
     * @return Item[]
     */
    public function getItems()
    {
        $serialized = session($this->key);

        if ($serialized) {
            return unserialize($serialized);
        }
        return [];
    }

    public function getTotal()
    {
        return $this->getSum();
    }

    /**
     * @param Item[] $items
     */
    public function setItems($items = [])
    {
        $serialized = serialize($items);
        session([$this->key => $serialized]);
        session()->save();
    }

    public function buildJsonData()
    {
        $data = [
            'sum' => $this->getSum(),
            'amount' => $this->getQuantity(),
        ];
        $items = [];

        foreach ($this->getItems() as $item) {
            $quantity = $item->getQuantity();

            $itemData = [
                'quantity' => $quantity,
                'sum' => $item->getSum(),
                'price' => $item->getPrice(),
            ];

            $items[] = $itemData;
        }
        $data['items'] = $items;
        return $data;
    }
}