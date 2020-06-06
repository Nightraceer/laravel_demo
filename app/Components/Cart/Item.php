<?php

namespace App\Components\Cart;


use Serializable;

class Item implements Serializable
{

    /**
     * Quantity
     *
     * @var int
     */
    public $quantity = 1;

    /**
     * Custom options
     *
     * @var array
     */
    public $data = [];

    /** @var CartItemInterface */
    public $object;

    public function __construct($object, $quantity = 1, $data = [])
    {
        $this->setObject($object);
        $this->quantity = $quantity;
        $this->data = $data;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function setObject(CartItemInterface $object)
    {
        $this->object = $object;
    }

    public function getSum()
    {
        return $this->getPrice() * $this->quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Price of single item
     *
     * @return mixed
     */
    public function getPrice()
    {
        return $this->getObject()->getCartPrice($this->quantity, $this->data);
    }


    /**
     * Get unique key for compare
     * @return mixed
     */
    public function getUniqueKey()
    {
        $data = serialize([
            'data' => $this->data,
            'fields' => $this->getObject()->getDataFields()
        ]);

        return md5($data);
    }

    /**
     * @return array
     */
    public function getSerializableData()
    {
        return [
            'quantity' => $this->quantity,
            'data' => $this->data,
            'object' => $this->getObject()
        ];
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize($this->getSerializableData());
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}