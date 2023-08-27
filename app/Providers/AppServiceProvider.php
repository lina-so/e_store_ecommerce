<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        View::composer('*', function ($view) {
            $products = Product::paginate(request()->page_size);
            if(Auth::id()){
                $customer_id = Auth::id();
            }
            else {
                 $customer_id = 0;
            }

            $view->with([
                'products' => $products,
                'customer_id' => $customer_id,
            ]);
        });
    }
}
