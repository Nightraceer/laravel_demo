@extends('layouts.app')

@section('content')
    <h1>Товары</h1>

    <div class="products-page">
        <div class="sorting">
            Сортировать по:
            <a href="?sorting=name">названию</a> или
            <a href="?sorting=price">цене</a>
        </div>
        @foreach($products as $product)
            <div class="product-row">
                <div class="product">
                    <div class="left-block">
                        <img src="{{ asset("storage/uploads/{$product->image}") }}" alt="">
                    </div>

                    <div class="right-block">
                        <div class="label @if ($product->availability) green @else red @endif">
                            @if ($product->availability)
                                В наличии
                            @else
                                Нет в наличии
                            @endif
                        </div>
                        <div class="name">
                            {{ $product->name }}
                        </div>
                        <div class="price">
                            Цена: {{ $product->price }} руб.
                        </div>
                        <div class="description">
                            {{ $product->description }}
                        </div>
                        <div class="button">
                            <a href="#"
                               data-toggle-cart
                               data-id="{{ $product->id }}"
                               class="toggle-link btn btn-success @if ($cart->getItemPositionByObjectId($product->id) === false) add @else remove @endif">
                                <span class="add-text">
                                     Добавить в корзину
                                </span>
                                <span class="remove-text">
                                    Удалить из корзины
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

        {{ $products->appends(request()->query())->links() }}
    </div>
@endsection()
