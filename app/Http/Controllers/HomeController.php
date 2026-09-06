<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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
