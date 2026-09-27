<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->where('active', true)
            ->get();

        return view('home',
            [
                'parentCategories' => $parentCategories,
            ]
        );
    }
}
