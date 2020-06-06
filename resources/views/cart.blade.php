@extends('layouts.app')

@section('content')
    <h1>
        Корзина
    </h1>

    <div class="cart-page">
        <div data-cart-block="list">
            @if ($cart->count() > 0)
                <table>
                    <tbody>
                    @foreach($cart->getItems() as $position => $item)
                        <tr>
                            @php
                                $product = $item->getObject()
                            @endphp

                            <td class="image">
                                <img src="{{ asset("storage/uploads/{$product->image}") }}" alt="">
                            </td>
                            <td class="name">
                                {{ $product->name }}
                            </td>
                            <td class="price">
                                {{ $item->getPrice() }} руб.
                            </td>
                            <td class="other">
                                <div class="inner">
                                    <div class="quantity">
                                       Кол-во: {{ $item->getQuantity() }}
                                    </div>

                                    <div class="buttons">
                                        <button class="btn btn-success" data-cart-dec="{{ $position }}">
                                            -
                                        </button>

                                        <button class="btn btn-success" data-cart-inc="{{ $position }}">
                                            +
                                        </button>
                                    </div>
                                    <div class="link">
                                        <a href="#" data-cart-remove="{{ $position }}">Удалить</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="spacer">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="total">
                    Итого: {{ $cart->getTotal() }} руб.
                </div>

            @else
                <div class="empty">
                    В корзине нет товаров
                </div>
            @endif

        </div>
    </div>

@endsection()
