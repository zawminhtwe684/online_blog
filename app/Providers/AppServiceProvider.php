<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
        Paginator::useBootstrap();


//        DB::listen(fn($q)=>logger($q->sql));

        //@zmh
        Blade::directive('zmh',function(){
            return "<h1>Zaw Min Htwe</h1>";
        });


        //$myName နေရာတိုင်းကို ဖော်ပြပေးလို့ အဆင်မပြေပါ
//        View::share("myName",(object)"Zaw Min Htwe");
//        View::share("cat",Category::all());

        //တိကျတဲ့နေရာကိုပဲ ဖော်ပြပေးခြင်းပါ
//        View::composer('home',function(){
//            View::share("cat",Category::all());
//        });

    }
}
