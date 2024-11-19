<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // カテゴリー一覧を取得
        $categories = Category::all();
        return view('dashboard', compact('categories'));
    }
}