<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        if (Schema::hasTable('categories')) {
            $parentCategories = Category::query()
                ->whereNull('parent_id')
                ->where('active', true)
                ->get();
        }else{
            $parentCategories = [];
        }


        View::composer('*', function ($view) use ($parentCategories) {
            $view->with([
                'parentCategories' => $parentCategories
            ]);
        });
    }
}
