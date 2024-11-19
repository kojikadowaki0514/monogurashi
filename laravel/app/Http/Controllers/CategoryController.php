<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;

class CategoryController extends Controller
{
    public function index()
    {   
        // カテゴリー一覧を取得
        $categories = Category::all();
        // カテゴリーとアイテムの存在確認
        $categoriesExist = $categories->isNotEmpty(); // カテゴリーデータが存在するか
        $itemsExist = Item::exists(); // 持ち物データが存在するか

        return view('dashboard', compact('categories', 'categoriesExist', 'itemsExist'));

    }
}