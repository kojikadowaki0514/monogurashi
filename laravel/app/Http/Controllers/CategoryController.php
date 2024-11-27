<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Models\Tag;

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
             ->with('tags') // tagsリレーションをロード
             ->paginate(5); // ページネーション

        return view('categories.items', compact('category', 'items'));
    }

    // タグの値で検索する
    public function filterItems(Request $request, $categoryId)
    {
        $tagId = $request->input('tag_id'); // 選択されたタグID

        $items = Item::where('category_id', $categoryId)
            ->where('user_id', auth()->id())
            ->when($tagId, function ($query) use ($tagId) {
                $query->whereHas('tags', function ($query) use ($tagId) {
                    $query->where('tags.id', $tagId);
                });
            })
            ->paginate(5); // ページネーション

        $category = Category::findOrFail($categoryId);

        return view('categories.items', compact('items', 'category'));
    }
}