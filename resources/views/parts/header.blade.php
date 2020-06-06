<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm header">
    <h5 class="my-0 mr-md-auto font-weight-normal">Test</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="{{ route('home') }}">Главная</a>
        <a class="p-2 text-dark" href="{{ route('products') }}">Товары</a>
        <a class="p-2 text-dark" href="{{ route('products-form') }}">Добавить товар</a>
        <a class="p-2 text-dark cart-link" data-cart-block="cart-link" href="{{ route('cart') }}">
            @if ($cart->count() > 0)
                <span class="count">{{ $cart->count() }}</span>
            @endif
            <span>Корзина</span>
        </a>
    </nav>
</div>