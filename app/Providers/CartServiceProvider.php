<?php
/**
 * Created by PhpStorm.
 * User: nightracer
 * Date: 05.06.2020
 * Time: 21:04
 */

namespace App\Providers;


use App\Components\Cart\SessionCart;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SessionCart::class, function ($app) {
            return new SessionCart();
        });
    }


}