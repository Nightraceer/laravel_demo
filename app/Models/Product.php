<?php

namespace App\Models;

use App\Components\Cart\CartItemInterface;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements CartItemInterface
{
    protected $fillable = ['id', 'name', 'description', 'price', 'availability', 'image', 'created_at', 'updated_at'];
    static private $defaultSorting = ['availability' => 'desc'];
    static private $sorting = [];
    static private $paginate = 10;

    public static function getAll()
    {
        $query = self::query();

        foreach (self::$defaultSorting as $field => $type) {
            $query->orderBy($field, $type);
        }
        foreach (self::$sorting as $field => $type) {
            $query->orderBy($field, $type);
        }
        $query->get();

        return $query->paginate(self::$paginate);
    }

    static function addSorting($field, $type = 'asc') {
        if (!empty($field)) {
            self::$sorting[$field] = $type;
        }
    }

    public function getCartPrice($quantity, $data)
    {
       return $this->price;
    }

    public function getDataFields()
    {
        return $this->toArray();
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        $data = $this->toArray();
        return serialize($data);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->fill($data);
        $this->syncOriginal();
    }
}
