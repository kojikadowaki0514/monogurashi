<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;

class CategoryController extends Controller
{
    public function index()
    {   
        // ログインユーザーの持ち物に関連するカテゴリーを取得
        $categories = Category::whereHas('items', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        // 持ち物データが存在するか確認
        $itemsExist = Item::where('user_id', auth()->id())->exists();

        return view('dashboard', compact('categories', 'itemsExist'));
    }

    public function showCategoryItems($categoryId)
    {
        // 指定されたカテゴリーを取得
        $category = Category::findOrFail($categoryId);

        // ログインユーザーが登録したそのカテゴリーに属するアイテムを取得
        $items = Item::where('category_id', $categoryId)
                     ->where('user_id', auth()->id()) // ログインユーザー限定
                     ->paginate(5); // ページネーション

        return view('categories.items', compact('category', 'items'));
    }
}