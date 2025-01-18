<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use Illuminate\Support\Facades\View;

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
        Paginator::useBootstrapFive();
        
        View::composer('layouts.partials.footer', function ($view) {
            $view->with('categories', Category::withCount('articles')
                ->orderByDesc('articles_count')
                ->get());
        });

        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }
}
