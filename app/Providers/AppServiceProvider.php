<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //
        view()->composer('layouts._header', function ($view) {
            $category = Category::get();
            $view->with('categories',$category);
        });

//        view()->composer('admin.nav', function ($view) {
//            $user=auth()->guard('admin')->user();
//            $view->with('user',$user);
//        });
    }
}
