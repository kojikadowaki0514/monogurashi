<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Item;

class CategoryTagController extends Controller
{
    // カテゴリーとタグの登録画面
    public function create()
    {
        // categoriesテーブルの全データを取得
        $categories = Category::all();

        return view('category-tag.category-tag-create', compact('categories'));
    }

    // セッションに入力データを保存
    public function saveToSession(Request $request)
    {   
        // ファイルアップロードがある場合に処理
        if ($request->hasFile('category_image')) {
            $path = $request->file('category_image')->store('uploads/category_images', 'public');
            Session::put('category_image', $path);
        } else {
            Session::put('category_image', $request->input('category_image', asset('images/categories/no_image.jpg')));
        }

        // 他のデータもセッションに保存
        Session::put('category_name', $request->input('category_name', ''));
        Session::put('other_category_name', $request->input('other_category_name', ''));
        Session::put('tag_name', $request->input('tag_name', ''));
        // dd($request->all()); 
        return redirect()->route('items.create');
    }

    // カテゴリーとタグを保存
    public function store(Request $request)
    {
        $categoryId = null;

        if ($request->category_name === "その他") {
            // 「その他」の場合、新しいカテゴリーを作成
            $newCategory = new Category();
            $newCategory->category_name = $request->other_category_name;

            // ファイルアップロード処理
            if ($request->hasFile('category_image')) {
                $path = $request->file('category_image')->store('categories', 'public');
                $newCategory->category_image = $path; // アップロードされた画像を保存
            } else {
                $newCategory->category_image = 'images/categories/no_image.jpg'; // デフォルト画像
            }

            $newCategory->save();
            $categoryId = $newCategory->id; // 登録したカテゴリーの ID を取得
        } else {
            // 既存カテゴリーの場合
            $existingCategory = Category::where('category_name', $request->category_name)->first();

            if ($existingCategory) {
                $categoryId = $existingCategory->id; // 既存カテゴリーの ID を取得
            } else {
                return redirect()->back()->withErrors(['category_name' => '指定されたカテゴリーが見つかりません。']);
            }
        }

        // タグの登録
        if (!empty($request->tag_name)) {
            $newTag = new Tag();
            $newTag->tag_name = $request->tag_name;
            $newTag->save();
        }

        // アイテムの登録
        $item = new Item();
        $item->user_id = Auth::id();
        $item->item_name = session('product_name', '');
        
        if (session('item_image')) {
            $item->item_image = session('item_image'); // セッションの画像を登録
        } else {
            $item->item_image = 'images/items/no_image.jpg'; // デフォルト画像
        }
        
        $item->location = session('location', '');
        $item->description = session('notes', '');
        $item->category_id = $categoryId; // 取得した category_id を設定
        $item->save();

        
        // フラッシュメッセージをセッションに保存
        session()->flash('registration_success', true);
        return view('category-tag.category-tag-create', ['categories' => Category::all()]);
    }
    

    // 登録済みカテゴリーとタグを表示
    public function showCreatePage()
    {
        $user = Auth::user(); // ログイン中のユーザー

        // ログインユーザーが所持しているカテゴリーを取得
        $categories = $user->categories; // hasManyThroughを利用

        // タグを取得する場合（適宜リレーションを定義する必要あり）
        $tags = Tag::all(); // 必要なら変更

        return view('items.create', compact('categories', 'tags'));
    }
}
